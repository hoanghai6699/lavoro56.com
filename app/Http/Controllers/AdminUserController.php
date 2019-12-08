<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash,Auth;

class AdminUserController extends Controller
{
    public function list(){
    	$user = User::select('id','name','email','phone','level')->get();
    	return view('admin.user.index',compact('user'));
    }
    public function add(){
    	return view('admin.user.add');
    }
    public function create(Request $req){
    	$this->validate($req,[
    		'name' => 'required',
    		'email' => 'required|unique:users,email|email',
    		'password' => 'required|min:6',
    		're_password' => 'same:password'
    	],[
    		'name.required' => 'Họ tên không được để trống',
    		'email.required' => 'Email không được để trống',
    		'email.unique' => 'Email đã tồn tại',
    		'email.email' => 'Email phải đúng định dạng (demo@gmail.com)',
    		'password.required' => 'Mật khẩu không được để trống',
    		'password.min' => 'Mật khẩu ít nhất 6 ký tự',
    		're_password.same' => 'Mật khẩu nhập lại không đúng'
    	]);

    	$user = new User();
    	$user->name = $req->name;
    	$user->email = $req->email;
    	$user->password = Hash::make($req->password);
    	$user->remember_token = $req->_token;
    	$user->phone = $req->phone;
    	$user->level = $req->rdoLevel;
    	$user->save();
    	return redirect()->route('admin.get.list.user')->with(['level'=>'success','success'=>'Thêm mới thành viên thành công']);
    }
    public function edit($id){
    	$users = User::find($id);
        if ((Auth::user()->id != 1) && ($id==1 || ($users['level']==1 && Auth::user()->id != $id))) {
            return redirect()->route('admin.get.list.user')->with(['level'=>'danger','success'=>'Bạn không được phép sửa tài khoản cùng cấp hoặc hơn cấp']);
        }
    	return view('admin.user.edit',compact('users','id'));
    }
    public function update(Request $req,$id){
    	$user = User::find($id);
        if ($req->input('password')) {
            $this->validate($req,[
                're_password' => 'same:password'
            ],[
                're_password.same' => 'Mật khẩu nhập lại không đúng'
            ]);
            $pass = $req->input('password');
            $user->password = Hash::make($pass);
        }
    	$user->name = $req->name;
    	$user->email = $req->email;
    	$user->remember_token = $req->_token;
    	$user->phone = $req->phone;
        if(isset($req->rdoLevel))
    	   $user->level = $req->rdoLevel;
    	$user->save();
    	return redirect()->route('admin.get.list.user')->with(['level'=>'success','success'=>'Sửa thành viên thành công']);
    }

    public function delete($id){
        $user_current_login = Auth::user()->id;
        $user = User::find($id);
        if (($id==1) || ($user_current_login != 1 && $user["level"]==1)) {
            return redirect()->route('admin.get.list.user')->with(['level'=>'danger','success'=>'Bạn không được phép xóa tài khoản cùng hoặc hơn cấp']);
        }else{
            $user->delete($id);
            return redirect()->route('admin.get.list.user')->with(['level'=>'success','success'=>'Xóa tài khoản thành công']);
        }
    }
}
