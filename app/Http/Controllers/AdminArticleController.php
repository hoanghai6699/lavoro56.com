<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use File,Auth;

class AdminArticleController extends Controller
{
    public function list(){
    	$article = Article::select('id','name','active','image','created_at')->get();
    	return view('admin.article.index',compact('article'));
    }

    public function add(){
    	return view('admin.article.add');
    }

    public function create(Request $req){
    	$this->validate($req,[
    		'name' => 'required|unique:articles,name',
    		'description' => 'required|max:191',
    		'content' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg,gif,bmp'
    	],[
    		'name.required' => 'Bạn phải nhập tên bài viết',
    		'name.unique' => 'Tên bài viết đã tồn tại',
    		'description.required' => 'Bạn phải nhập mô tả bài viết',
            'description.max' => 'Mô tả quá dài',
    		'content.required' => 'Bạn phải nhập nội dung bài viết',
            'image.required' => 'Bạn phải nhập ảnh sản phẩm',
            'image.mimes' => 'Ảnh có một trong các định dạng jpg,png,jpeg,gif,bmp'
    	]);
        $file_name = $req->file('image')->getClientOriginalName();

    	$article = new Article();
    	$article->name = $req->name;
    	$article->slug = str_slug($req->name);
    	$article->description = $req->description;
    	$article->content = $req->content;
        $article->hot = $req->hot;
        $article->user_id = Auth::user()->id;
        $article->image = $file_name;
        $req->file('image')->move(base_path('uploads/article/'),$file_name);
    	$article->save();
    	return redirect()->route('admin.get.list.article')->with(['level'=>'success','success'=>'Thêm mới bài viết thành công']);
    }
    public function edit($id){
    	$article = Article::find($id);
    	return view('admin.article.edit',compact('article'));
    }
    public function update(Request $req,$id){
    	$article = Article::find($id);
    	$article->name = $req->name;
    	$article->slug = str_slug($req->name);
    	$article->description = $req->description;
    	$article->content = $req->content;
        $article->hot = $req->hot;
        $article->user_id = Auth::user()->id;
        $img_current = 'uploads/article/'.$req->img_current;
        if (!empty($req->image)) {
            $file_name = $req->file('image')->getClientOriginalName();
            $article->image = $file_name;
            $req->file('image')->move('uploads/article/',$file_name);
            if (File::exists($img_current)) {
                File::delete($img_current);
            }
        }else{
            echo "không có file";
        }
    	$article->save();
    	return redirect()->route('admin.get.list.article')->with(['level'=>'success','success'=>'Sửa bài viết thành công']);
    }
    public function delete($id){
    	$article = Article::find($id);
        File::delete('uploads/article/'.$article->image);
    	$article->delete($id);
    	return redirect()->back()->with(['level'=>'success','success'=>'Xóa bài viết thành công']);
    }
    public function action($id){
        $article = Article::find($id);
        $article->active = $article->active ? 0 : 1;
        $article->save();
        return redirect()->back();
    }
}
