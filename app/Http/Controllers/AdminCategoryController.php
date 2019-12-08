<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function list(){
        $categories = Category::select('id','name','active','parent_id')->get();
    	return view('admin.category.index',compact('categories'));
    }
    public function add(){
        $parent = Category::select('id','name','parent_id')->get();
    	return view('admin.category.add',compact('parent'));
    }
    public function create(Request $req){
    	$this->validate($req,[
    		'name' => 'required|unique:categories,name'
    	],[
    		'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại'
    	]);
        $category = new Category();
        $category->name = $req->name;
        $category->slug = str_slug($req->name);
        $category->parent_id = $req->category_id;
        $category->description = $req->description;
        $category->save();

        return redirect()->route('admin.get.list.category')->with(['level'=>'success','success'=>'Thêm mới danh mục thành công']);
    }
    public function edit($id){
        $category = Category::findOrFail($id);
        $parent = Category::select('id','name','parent_id')->get()->toArray();
        return view('admin.category.edit',compact('category','parent'));
    }
    public function update($id,Request $req){
        $category = Category::find($id);
        $category->name = $req->name;
        $category->slug = str_slug($req->name);
        $category->parent_id = $req->category_id;
        $category->description = $req->description;
        $category->save();

        return redirect()->route('admin.get.list.category')->with(['level'=>'success','success'=>'Sửa danh mục thành công']);
    }
    public function delete($id){
        $parent = Category::where('parent_id',$id)->count();
        if ($parent == 0) {
            $cate = Category::find($id);
            $cate->delete($id);
            return redirect()->back()->with(['level'=>'success','success'=>'Xóa danh mục thành công']);
        }
        else{
            echo "<script type='text/javascript'>
                alert('Bạn không được xóa danh mục có chứa danh mục con');
                window.location = '";
                    echo route('admin.get.list.category');
                echo"'
            </script>";
        }
    }

    public function action($id){
        $category = Category::find($id);
        $category->active = $category->active ? 0 : 1;
        $category->save();
        return redirect()->back();
    }
}
