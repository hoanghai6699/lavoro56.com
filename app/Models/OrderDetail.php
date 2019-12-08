<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $guarded = ['*'];

    public function product(){
    	return $this->belongsTo('\App\Models\Product','product_id','id');
    }
}
