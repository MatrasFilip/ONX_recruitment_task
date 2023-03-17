<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $commonUser = Role::where('name', "user")->first();

        for($i=1; $i<=5; $i++)
        {
            User::factory()->create(["id"=> $i])->attachRole($commonUser);
        }
    }
}
