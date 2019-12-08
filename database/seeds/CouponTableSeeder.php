<?php

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
        	'code' => 'abc123',
        	'type' => 'fixed',
        	'value' => 200000
        ]);

        Coupon::create([
        	'code' => 'def456',
        	'type' => 'percent',
        	'percent_off' => 20
        ]);
    }
}
