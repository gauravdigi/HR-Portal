<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;  // <---- Correct import here
use App\Models\User;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run()
{
    Employee::create([
        'digi_id' => 'DS001',
        'gender' => 'Male',
        'dob' => '1990-07-04',
        'celb_dob' => '1990-07-04',
        'blood_group' => 'B+',
        'phone' => '9478806550',
        'is_approved' => '2',
        'official_email' => 'parampreet@digisoftsolution.com',
        'email' => '    parampreet479@gmail.com',
        'pan' => 'ABCDE1234F',
        'aadhar' => '154326789077',
        'designation' => 'Team Lead',
        'team_lead' => '1',
        'joining_date' => '2013-06-13',
        'salary'  => 'eyJpdiI6IllHR09rd0hSWXNXeFdpanlWZlUwbWc9PSIsInZhbHVlIjoiZGJLOVdOZXlYSmhCRzRGbFBWTFVOYno5VlVza3VKNlNIS2NoaEdsNURBcz0iLCJtYWMiOiI1NDJlMDQzZmQ5ODllZDYyOTI0MTAzZTIxNTQ4MTIyNDUwMjIxNjdkMzhhYTU5M2FkOWVlM2IyMThmMWU5ZmY3IiwidGFnIjoiIn0=',
        'inc_years' => '1',
        'inc_months' => '0',

    ]);
}

}
