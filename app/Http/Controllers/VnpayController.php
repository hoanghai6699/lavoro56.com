<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart,Auth,Mail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Vnpay;
use App\Notifications\checkoutNoti;
use Carbon\Carbon;

class VnpayController extends Controller
{
    public function vnpay(){
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
    public function create_vnpay(Request $req){
        $valid = array('code' => false, 'messages' => array());
        if($req->city==NULL){
            $valid['code'] = false;
            $valid['messages'] = "Vui lòng nhập thành phố";
            return json_encode(array(
                'valid' => $valid
            ));
        }
        if($req->district==NULL){
            $valid['code'] = false;
            $valid['messages'] = "Vui lòng nhập quận huyện";
            return json_encode(array(
                'valid' => $valid
            ));
        }
        if($req->address==NULL){
            $valid['code'] = false;
            $valid['messages'] = "Vui lòng nhập địa chỉ";
            return json_encode(array(
                'valid' => $valid
            ));
        }
        if($req->note==NULL){
            $valid['code'] = false;
            $valid['messages'] = "Vui lòng nhập nội dung thanh toán";
            return json_encode(array(
                'valid' => $valid
            ));
        }
        
        $totalMoney = str_replace('.', '', Cart::total());
        $orderId = Order::insertGetId([
            'email' => $req->email,
            'user_id' => Auth::user()->id,
            'total' => ((int)$totalMoney - $discount = session()->get('coupon')['discount']) ?? (int)$totalMoney,
            'note' => $req->note,
            'phone' => $req->phone,
            'city_id' => $req->city,
            'district_id' => $req->district,
            'address' => $req->address,
            'payment_method' => 'atm',
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
        //Sau khi xu ly xong
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        /**
         * Description of vnpay_ajax
         *
         * @author xonv
         */
        $vnp_TmnCode = "5D66ZPLT"; //Mã website tại VNPAY 
        $vnp_HashSecret = "RHYDNWTIITNTANIQLMYLHZIMRNCXMIOM"; //Chuỗi bí mật
        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://lavoro56.com/gio-hang/thanh-toan-atm/vnpay-return";

        //$vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        //$vnp_OrderInfo = $_POST['order_desc'];
        $vnp_OrderType = $_POST['order_type'];

        $vnp_Amount = (((int)$totalMoney - $discount = session()->get('coupon')['discount']) ?? (int)$totalMoney) *100;
        
        $vnp_Locale = $_POST['language'];
        $vnp_BankCode = $_POST['bank_code'];
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $req->note,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $orderId
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
           // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
        echo json_encode($returnData);
    }

    public function vnpay_ipn(){

        /*
         * IPN URL: Ghi nhận kết quả thanh toán từ VNPAY
         * Các bước thực hiện:
         * Kiểm tra checksum 
         * Tìm giao dịch trong database
         * Kiểm tra tình trạng của giao dịch trước khi cập nhật
         * Cập nhật kết quả vào Database
         * Trả kết quả ghi nhận lại cho VNPAY
         */

        $vnp_TmnCode = "UDOPNWS1"; //Mã website tại VNPAY 
        //dd($vnp_TmnCode);
        $vnp_HashSecret = "EBAHADUGCOEWYXCMYZRMTMLSHGKNRPBN"; //Chuỗi bí mật
        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://lavoro56.com/gio-hang/thanh-toan-atm/vnpay-return";
        $inputData = array();
        $returnData = array();
        $data = $_REQUEST;
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }
        //$vnpayEmail = $inputData['vnp_Email'];
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        //$secureHash = md5($vnp_HashSecret . $hashData);
        $secureHash = hash('sha256',$vnp_HashSecret . $hashData);
        $Status = 0;
        $orderId = $inputData['vnp_TxnRef'];

        try {
            //Check Orderid    
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);   
                $order = NULL;
                if ($order != NULL) {
                    if ($order["Status"] != NULL && $order["Status"] == 0) {
                        if ($inputData['vnp_ResponseCode'] == '00') {
                            $Status = 1;
                        } else {
                            $Status = 2;
                        }
                        //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
                        //
                        //
                        //
                        //Trả kết quả về cho VNPAY: Website TMĐT ghi nhận yêu cầu thành công                
                        $returnData['RspCode'] = '00';
                        $returnData['Message'] = 'Confirm Success';
                    } else {
                        $returnData['RspCode'] = '02';
                        $returnData['Message'] = 'Order already confirmed';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Chu ky khong hop le';
            }
        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        //Trả lại VNPAY theo định dạng JSON
        echo json_encode($returnData);
    }

    public function vnpay_return(Request $req){
        if ($req->vnp_ResponseCode == '00') {
            $orderId = $req->vnp_TxnRef;
            Vnpay::insert([
                'order_id' => $orderId,
                'bank_code' => $req->vnp_BankCode,
                'content' => $req->vnp_OrderInfo,
                'vnp_code' => $req->vnp_TransactionNo,
                'created_at' => $req->vnp_PayDate,
                'updated_at' => $req->vnp_PayDate
                ]);
            $order = Order::find($orderId);
            if ($order) {
                $order->status = 0;
                $order->payment = 'Đã thanh toán';
                $order->save();
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
                return view('frontend.complete');
            }
        }else{
            $orderId = $req->vnp_TxnRef;
            $order = Order::find($orderId);
            $order->delete($orderId);
            Cart::destroy();
            session()->forget('coupon');
            return redirect()->route('frontend.get.home');
        }
        
    }
}

// Ngân hàng: NCB
// Số thẻ: 9704198526191432198
// Tên chủ thẻ:NGUYEN VAN A
// Ngày phát hành:07/15
// Mật khẩu OTP:123456