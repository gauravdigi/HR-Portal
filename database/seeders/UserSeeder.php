<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;  // <---- Correct import here
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run()
{
    User::create([
        'name' => 'Parampreet Singh',
        'email' => 'parampreet@digisoftsolution.com',
        'password' => Hash::make('password'),
        'employee_id' => '1',
        'is_deleted' => '0',
        'role' => 'admin',
    ]);
}

}
