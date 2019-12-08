<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Auth,DB,Excel;
use Carbon\Carbon;
use App\Exports\ReportOrdersExport;

class AdminController extends Controller
{
    public function index(){
        //doanh thu
        $moneyDay = Order::whereDay('updated_at',date('d'))->where('status','!=',3)->where('payment','=','Đã thanh toán')->sum('total');
        $moneyMonth = Order::whereMonth('updated_at',date('m'))->where('status','!=',3)->where('payment','=','Đã thanh toán')->sum('total');
        $moneyYear = Order::whereYear('updated_at',date('Y'))->where('status','!=',3)->where('payment','=','Đã thanh toán')->sum('total');

        
    	return view('admin.index',compact('moneyDay','moneyMonth','moneyYear'));
    }

    public function login(){
    	return view('admin.login');
    }
    public function post_login(Request $req){
        $this->validate($req,[
            'email' => 'required',
            'password' => 'required'
        ],[
            'email.required' => 'Bạn phải nhập email',
            'password.required' => 'Bạn phải nhập password'
        ]);
        $login = array(
            'email' => $req->email,
            'password' => $req->password,
            'level' => 1
        );
        if (Auth::attempt($login)) {
            return redirect()->route('admin');
        }else{
            return redirect()->back()->with(['level'=>'danger','success'=>'Tài khoản không hợp lệ']);
        }
    }

    public function logout(){
		Auth::logout();
		return redirect()->route('login')->with(['level'=>'success','success'=>'Thoát tài khoản thành công']);
	}

    public function report(){
        //$report = Order::where('status','!=',3)->where('payment','=','Đã thanh toán')->get();
        return view('admin.report.index');
    }
    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            if($request->from_date != '' && $request->to_date != '')
            {
                $from_date = Carbon::parse($request->from_date);
                $to_date = Carbon::parse($request->to_date);
                $data = DB::table('orders')
                ->join('users','orders.user_id','=','users.id')
                ->where('status','!=',3)->where('payment','=','Đã thanh toán')
                ->whereBetween('orders.created_at', array($from_date, $to_date))
                ->select('orders.id','users.name','orders.created_at','orders.total','orders.status','orders.payment')
                ->get();
            }
            else
            {
                $data = DB::table('orders')->join('users','orders.user_id','=','users.id')->orderBy('orders.created_at','DESC')->where('status','!=',3)->where('payment','=','Đã thanh toán')->select('orders.id','users.name','orders.created_at','orders.total','orders.status','orders.payment')->get();
            }
            echo json_encode($data);
        }
    }
    public function export(){
        return Excel::download(new ReportOrdersExport, 'reportorders.xlsx');
    }
}
