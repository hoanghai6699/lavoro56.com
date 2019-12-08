<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
		'name','slug','icon','active','keywords','description','total_product'
    ];

    protected $guarded = [''];

    public function products(){
    	return $this->hasMany('\App\Models\Product','category_id','id');
    }
}
