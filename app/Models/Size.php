<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'sizes';
    protected $guarded = ['*'];

    public $timestamps = false;
    public function product_properties()
    {
    	return $this->hasMany("App\Models\ProductProperties","size_id","id");
    }
}
