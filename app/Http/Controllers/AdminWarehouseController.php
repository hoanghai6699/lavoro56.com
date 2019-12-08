<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminWarehouseController extends Controller
{
    public function list(){
    	$ware = Product::select('id','name','price','image','category_id','pay','created_at')->get();
    	return view('admin.warehouse.index',compact('ware'));
    }
}
