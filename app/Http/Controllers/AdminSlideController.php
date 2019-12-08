<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use File;

class AdminSlideController extends Controller
{
    public function list(){
    	$slide = Slide::all();
    	return view('admin.slide.index',compact('slide'));
    }

    public function add(){
    	return view('admin.slide.add');
    }

    public function create(Request $req){
    	$this->validate($req,[
    		'image' => 'required|mimes:jpg,png,jpeg,gif,bmp'
    	],[
    		'image.unique' => 'Ảnh đã tồn tại',
    		'image.required' => 'Bạn phải nhập ảnh sản phẩm',
    		'image.mimes' => 'Ảnh có một trong các định dạng jpg,png,jpeg,gif,bmp'
    	]);
    	$file_name = $req->file('image')->getClientOriginalName();
    	$slide = new Slide();
    	$slide->image = $file_name;
    	$slide->status = $req->status;
    	$slide->type = $req->type;
    	$req->file('image')->move(base_path('public/frontend/img/'),$file_name);
    	$slide->save();

    	return redirect()->route('admin.get.list.slide')->with(['level'=>'success','success'=>'Thêm mới slide thành công']);
    }

    public function edit($id){
        $slide = Slide::find($id);
        return view('admin.slide.edit',compact('slide'));
    }

    public function update(Request $req,$id){
        $slide = Slide::find($id);
        $slide->type = $req->type;
        $img_current = 'public/frontend/img/'.$req->img_current;
        if (!empty($req->image)) {
            $file_name = $req->file('image')->getClientOriginalName();
            $slide->image = $file_name;
            $req->file('image')->move('public/frontend/img/',$file_name);
            if (File::exists($img_current)) {
                File::delete($img_current);
            }
        }else{
            echo "không có file";
        }
        $slide->save();
        return redirect()->route('admin.get.list.slide')->with(['level'=>'success','success'=>'Sửa slide thành công']);
    }

    public function delete($id){
        $slide = Slide::find($id);
        File::delete('public/frontend/img/'.$slide->image);
        $slide->delete($id);
        return redirect()->back()->with(['level'=>'success','success'=>'Xóa slide thành công']);
    }

    public function action($id){
        $slide = Slide::find($id);
        $slide->status = $slide->status ? 0 : 1;
        $slide->save();
        return redirect()->back();
    }
}
