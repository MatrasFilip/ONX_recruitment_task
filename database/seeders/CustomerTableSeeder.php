<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=5; $i++)
        {
            Customer::factory()->create(["id"=> (($i*2)-1), "user_id"=>$i]);
            Customer::factory()->create(["id"=> ($i*2),"user_id"=>$i]);
        }
    }
}
