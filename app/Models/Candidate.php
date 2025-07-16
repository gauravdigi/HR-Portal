<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'alternate_phone_number',
        'total_experience_years',
        'total_experience_months',
        'current_company',
        'ctc_per_month',
        'ectc_per_month',
        'is_salary_negotiable',
        'salary_negotiable',
        'notice_period_days',
        'is_notice_negotiable',
        'notice_negotiable_days',
        'linkedin_url',
        'candidate_source',
        'current_designation',
        'applied_designation',
        'stream',
        'remark',
        'reason',
        'resume_path',
        'skills',
    ];

    protected $casts = [
        'skills' => 'array',
        'is_salary_negotiable' => 'boolean',
        'is_notice_negotiable' => 'boolean',
    ];

}
