<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select('id','name','slug','image','price','gender','content','description','user_id','category_id','created_at','updated_at')->get();
    }
}
