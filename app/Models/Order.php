<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = ['*'];

    public function custommer(){
    	return $this->belongsTo('\App\Models\User');
    }
    public function coupon(){
    	return $this->belongsTo('App\Models\Coupon','coupon_id','id');
    }
}
