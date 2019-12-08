<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class AdminCouponController extends Controller
{
    public function list(){
    	$coupon = Coupon::all();
    	return view('admin.coupon.index',compact('coupon'));
    }

    public function add(){
        $type = Coupon::all();
    	return view('admin.coupon.add',compact('type'));
    }

    public function create(Request $req){
    	$this->validate($req,[
            'qty' => 'required',
    		'input' => 'required|numeric'
    	],[
    		'qty.required' => 'Bạn phải nhập vào số lượng',
            'input.required' => 'Bạn phải nhập vào giá trị',
    		'input.numeric' => 'Bạn phải nhập số'
    	]);
    	$coupon = new Coupon();
        $coupon->qty = $req->qty;
    	$coupon->code = mt_rand();
        $coupon->type = $req->type;
        if ($coupon->type == 'fixed') {
            $coupon->value = $req->input;
        }elseif($coupon->type == 'percent'){
            $coupon->percent_off = $req->input;
        }
    	$coupon->save();
    	return redirect()->route('admin.get.list.coupon')->with(['level'=>'success','success'=>'Thêm mã giảm giá thành công']);
    }

    public function delete($id){
    	$coupon = Coupon::find($id);
    	$coupon->delete($id);
    	return redirect()->back()->with(['level'=>'success','success'=>'Xóa mã giảm giá thành công']);
    }
}
