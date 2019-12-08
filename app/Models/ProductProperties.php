<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductProperties extends Model
{
    protected $table = "product_properties";

    protected $fillable = [
		'product_id','size_id','qty'
    ];
    public $timestamps = false;

    public function product()
    {
    	return $this->belongsTo("App\Models\Product","product_id","id");
    }
    public function size()
   	{
   		return $this->belongsTo("App\Models\Size","size_id","id");
   	}
}
