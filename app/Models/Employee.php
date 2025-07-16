<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Employee extends Model
{


    use HasFactory;

    protected $fillable = [
        'digi_id', 'gender', 'dob','celb_dob',
        'blood_group', 'phone', 'is_approved', 'emergency_contacts', 'official_email', 'email', 'profile_image', 'voter_id',
        'pan', 'aadhar', 'designation', 'team_lead', 'joining_date',
        'exp_years', 'exp_months', 'salary', 'inc_years', 'inc_months',
        'probation_end', 'release_date', 'address_perm', 'state_perm', 'city_perm',
        'zip_perm', 'country_perm', 'address_local', 'state_local', 'city_local',
        'zip_local', 'country_local', 'acc_name', 'acc_no', 'confirm_acc_no',
        'bank_name', 'ifsc', 'branch_address',    'skills', 'documents', 'previous_companies'
    ];
	
	protected $casts = [
        'skills' => 'array',
        'documents' => 'array',
        'previous_companies' => 'array',
        'emergency_contacts' => 'array',
    ];


    public function user()
    {
        return $this->hasOne(User::class, 'employee_id');
    }

}
