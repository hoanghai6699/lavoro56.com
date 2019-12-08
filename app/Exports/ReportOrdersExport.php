<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class ReportOrdersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('orders')
               ->join('users','orders.user_id','=','users.id')
               ->where('status','!=',3)->where('payment','=','Đã thanh toán')
               ->select('orders.id','users.name','orders.created_at','orders.total')
               ->get();
    }
}
