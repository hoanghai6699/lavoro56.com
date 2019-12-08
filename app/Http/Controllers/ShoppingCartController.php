<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB,Cart,Auth,Mail;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderDetail;
use App\Models\Size;
use App\Models\ProductProperties;
use App\Models\SaleProduct;
use App\Models\Coupon;
use Carbon\Carbon;
use App\Notifications\checkoutNoti;

class ShoppingCartController extends Controller
{
    
    public function giohang(){
        $discount = session()->get('coupon')['discount'] ?? 0;
        $newtotal = (Cart::total() - $discount);
    	$content = Cart::content();
    	$total = Cart::total();
    	return view('frontend.shoppingcart',compact('content','total'))->with([
            'discount' =>$discount,
            'newtotal' =>$newtotal
        ]);
    }
    public function xoahang($key){
    	Cart::remove($key);
    	return redirect()->route('shoppingcart.get.giohang');
    }
    public function thanhtoannhanhang(){                       
        $couponId = session()->get('coupon')['couponId'] ?? 0;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $newtotal = (Cart::total() - $discount);
    	$content = Cart::content();
    	$total = Cart::total();
    	return view('frontend.checkout',compact('content','total'))->with([
            'couponId' => $couponId,
            'discount' => $discount,
            'newtotal' => $newtotal
        ]);
    }

    public function thanhtoanatm(){                       
        $couponId = session()->get('coupon')['couponId'] ?? 0;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $newtotal = (Cart::total() - $discount);
        $content = Cart::content();
        $total = Cart::total();
        return view('frontend.vnpay_index',compact('content','total'))->with([
            'couponId' => $couponId,
            'discount' => $discount,
            'newtotal' => $newtotal
        ]);
    }

    public function luuthanhtoan(Request $req){

        $this->validate($req,[
            'address' => 'required',
            'city' => 'required',
            'district' => 'required'

        ],[
            'address.required' => 'Vui lòng nhập địa chỉ',
            'city.required' => 'Vui lòng chọn thành phố',
            'district.required' => 'Vui lòng chọn quận, huyện'
        ]);
        $totalMoney = str_replace('.', '', Cart::total());
        $orderId = Order::insertGetId([
            'email' => $req->email,
            'user_id' => Auth::user()->id,
            'total' => ((int)$totalMoney - $discount = session()->get('coupon')['discount']) ?? (int)$totalMoney,
            'note' => $req->note,
            'phone' => $req->phone,
            'address' => $req->address,
            'city_id' => $req->city,
            'district_id' => $req->district,
            'payment_method' => 'cod',
            'payment' => 'Chưa thanh toán',
            'coupon_id' => $couponId = session()->get('coupon')['couponId'] ?? NULL,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]); 
        
        if ($orderId) {
            $content = Cart::content();
            foreach ($content as $item)
            {
                OrderDetail::insert([
                'order_id' => $orderId,
                'product_id' => $item->id,
                'qty' => $item->qty,
                'size_id' => $item->options->size,
                'price' => $item->options->price_old,
                'price_sale' => $item->options->sale,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                ]);
            } 
        }
        $order = Order::find($orderId);
        $email = $order->email;
        $data['info'] = $order;
        $data['total'] = Cart::total();
        $data['cart'] = Cart::content();
        Mail::send('frontend.email', $data, function($message) use ($email){
            $message ->from('nghhai2712@gmail.com','Larovo');
            $message ->to($email,$email);
            $message ->cc('nghhai2712@gmail.com','Hoàng Hải');
            $message ->subject('Xác nhận hóa đơn mua hàng');
        });
        // send notifications
        $users = User::where('level', 1)->get();
        
        $when = Carbon::now()->addSeconds(10);

        $order = Order::find($orderId);
        
        // send notification
        \Notification::send($users, (new checkoutNoti($order))->delay($when));

        Cart::destroy();
        session()->forget('coupon');
        return redirect()->route('complete');
    }
    public function complete(){
        return view('frontend.complete');
    }

    public function capnhat(Request $req){
        Cart::update($req->rowId,$req->qty);
    }
    public function xoagiohang(){
        session()->forget('coupon');
        Cart::destroy();
        return redirect()->route('shoppingcart.get.giohang');
    }

    //ajax mua hang
    public function ajaxMuaHang(Request $req)
    {
        $productId = $req->productId;
        if ($req->qty <= 0 || $req->qty == NULL) {
            $qty = 1;
        }else{
            $qty = $req->qty;
        }
        $size_id = $req->size;
        $product_buy = Product::find($productId);
        $sale_product = DB::table('sale_products')->select('start_date','end_date','sale')->where('product_id',$product_buy->id)->first();
        if(isset($product_buy))
        {
            $price = $product_buy->price;
            $sale = 0;
            if(isset($sale_product)){
                if($sale_product->sale && $sale_product->start_date <= Carbon::now() && $sale_product->end_date >= Carbon::now()){
                    $sale = $sale_product->sale;
                    $price = $price * (100 - $sale_product->sale)/100;
                }
            }
        }
        $valid = array('success' => false, 'messages' => array());
        
        if(isset($size_id)){
            $pro_per = ProductProperties::where('product_id',$productId)->where('size_id',$size_id)->select('qty')->first();
            $quantity = $pro_per->qty;
        }else{
            $valid['success'] = false;
            $valid['messages'] = "Vui lòng chọn size";
            return json_encode(array(
                'valid' => $valid
            ));
        }
        if($qty > $quantity)
        {
            $valid['success'] = false;
            $valid['messages'] = "Vui lòng chọn lại số lượng";
            return json_encode(array(
                'valid' => $valid
            ));
        }
        else
        {
            Cart::add(array('id'=>$productId,'name'=>$product_buy->name,'qty'=>$qty,'price'=>$price,'options'=>array('img'=>$product_buy->image,'sale'=>$sale,'price_old'=>$product_buy->price,'size'=>$size_id)));
            $valid['success'] = true;
            $valid['messages'] = "Thêm vào giỏ hàng thành công";
            return json_encode(array(
                'valid' => $valid
            ));
        }
    }

    public function store(Request $req){
        $coupon = Coupon::where('code',$req->coupon)->first();
        if(!$coupon || $coupon->qty == 0){
            echo "error";
            $notification = array(
                'message' => 'Mã giảm giá không tồn tại hoặc đã hết số lần sử dụng!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        session()->put('coupon',[
            'couponId' => $coupon->id,
            'name' => $coupon->code,
            'discount' => $coupon->discount(Cart::total()),
        ]);
        $coupon_qty = $coupon->qty - 1;
        $coupon = Coupon::where('code',$req->coupon)->update(['qty'=>$coupon_qty]);
        echo "success";
            $notification = array(
                'message' => 'Mã giảm giá hợp lệ!',
                'alert-type' => 'success'
            );
        return redirect()->back()->with($notification);
    }

    public function destroy(){
        $couponId = session()->get('coupon')['couponId'] ?? 0;
        $coupon = Coupon::where('id',$couponId)->first();
        session()->forget('coupon');
        $coupon_qty = $coupon->qty + 1;
        $coupon = Coupon::where('id',$couponId)->update(['qty'=>$coupon_qty]);
        echo "warning";
            $notification = array(
                'message' => 'Bạn đã hủy mã giảm giá!',
                'alert-type' => 'warning'
            );
        return redirect()->back()->with($notification);
    }
}