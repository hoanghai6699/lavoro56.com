<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductProperties;
use App\Models\Size;
use App\Models\Coupon;
use DB,Cart;

class AdminOrderController extends Controller
{
    public function list(){
    	$order = Order::all();
    	return view('admin.order.index',compact('order'));
    }
    public function view($id){
        $order = Order::find($id);
	 	$order_detail = OrderDetail::with('product')->where('order_id',$order->id)->get();
        
        return view('admin.order.order',compact('order','order_detail')); 
    }
    public function post_view($id,Request $req){
        $order = Order::find($id);

        $order_detail = OrderDetail::where('order_id',$id)->get();
        $order->status = $req->status;
        if ($req->status==2) {
            foreach($order_detail as $orderdetails)
            {
                $pro_per = ProductProperties::where('product_id',$orderdetails->product_id)->where('size_id',$orderdetails->size_id)->select('qty')->get()->first();
                $pro_per = $pro_per->qty - $orderdetails->qty;
                $pro_per = ProductProperties::where('product_id',$orderdetails->product_id)->where('size_id',$orderdetails->size_id)->update(['qty'=>$pro_per]);
                $product = Product::find($orderdetails->product_id);
                $product->pay ++;
                $product->save();

            }
            $order->payment = 'Đã thanh toán';
        }

        $order->save();
        return redirect()->route('admin.get.list.order')->with(['level'=>'success','success'=>'Xử lý đơn hàng thành công']);
    }
    public function chuaxuly(){
        $pending = Order::all();
        return view('admin.order.pending',compact('pending'));
    }

    public function danggiaohang(){
        $delivery = Order::all();
        return view('admin.order.delivery',compact('delivery'));
    }

    public function delete($id){
        $order_detail = OrderDetail::find($id);
        $order_detail->delete($id);
        return redirect()->back()->with(['level'=>'success','success'=>'Xóa sản phẩm chi tiết đơn hàng thành công']);
    }
}
