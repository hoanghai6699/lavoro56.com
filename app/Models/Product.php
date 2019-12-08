<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
		'name','slug','category_id','price','active','keywords','description','user_id','hot','view','image','content','gender'
    ];

    protected $guarded = [''];

    public function pimages(){
        return $this->hasMany('App\Models\ProductImage');
    }
    public function product_properties()
    {
    	return $this->hasMany("App\Models\ProductProperties","product_id","id");
    }
    public function order_details()
    {
        return $this->hasMany("App\Models\OrderDetail","product_id","id");
    }
}
