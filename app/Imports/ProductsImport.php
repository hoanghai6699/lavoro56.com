<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name'     => $row[0],
            'slug'    => $row[1],
            'image'    => $row[2],
            'price'    => $row[3],
            'gender'    => $row[4],
            'content'    => $row[5],
            'description'    => $row[6],
            'user_id'    => $row[7],
            'category_id'    => $row[8],
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }
}
