<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleProduct;
use App\Models\Product;

class AdminSaleController extends Controller
{
    public function list(){
    	$sale = SaleProduct::all();
    	return view('admin.sale.index',compact('sale'));
    }

    public function add(){
    	$product = Product::all();
    	return view('admin.sale.add',compact('product'));
    }

    public function create(Request $req){
    	$this->validate($req,[
    		'startdate' => 'required',
    		'enddate' => 'required',
    		'sale' => 'required',
            'name_product' => 'unique:sale_products,product_id'
    	],[
    		'startdate.required' => 'Bạn chưa chọn ngày bắt đầu',
    		'enddate.required' => 'Bạn chưa chọn ngày kết thúc',
    		'sale.required' => 'Bạn chưa chọn % giảm giá',
            'name_product.unique' => 'Sản phẩm đã tồn tại giảm giá',
    	]);

    	$sale = new SaleProduct;
    	$sale->start_date = $req->startdate;
    	$sale->end_date = $req->enddate;
    	$sale->sale = $req->sale;
    	$sale->product_id = $req->name_product;
    	$sale->save();

    	return redirect()->route('admin.get.list.sale')->with(['level'=>'success','success'=>'Thêm % giảm giá thành công']);
    }
    
    public function edit($id){
        $sale = SaleProduct::find($id);
        return view('admin.sale.edit',compact('sale'));
    }

    public function update(Request $req,$id){
        $sale = SaleProduct::find($id);
        $sale->start_date = $req->startdate;
        $sale->end_date = $req->enddate;
        $sale->sale = $req->sale;
        $sale->save();
        return redirect()->route('admin.get.list.sale')->with(['level'=>'success','success'=>'Sửa % giảm giá thành công']);
    }

    public function delete($id){
        $sale = SaleProduct::find($id);
        $sale->delete($id);
        return redirect()->back()->with(['level'=>'success','success'=>'Xóa sản phẩm khuyến mãi thành công']);
    }
}
