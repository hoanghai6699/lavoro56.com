<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
		'name','slug','active','description','image','view','content','user_id'
    ];

    protected $guarded = [''];
}
