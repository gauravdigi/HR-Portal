<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->integer('is_deleted')->default(0);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('alternate_phone_number')->nullable();
            $table->integer('total_experience_years')->default(0);
            $table->integer('total_experience_months')->default(0);
            $table->string('current_company')->nullable();
            $table->decimal('ctc_per_month', 12, 2)->default(0.00);
            $table->decimal('ectc_per_month', 12, 2)->default(0.00);
            $table->boolean('is_salary_negotiable')->default(false);
            $table->string('salary_negotiable')->nullable();
            $table->integer('notice_period_days')->default(0);
            $table->boolean('is_notice_negotiable')->default(false);
            $table->integer('notice_negotiable_days')->default(0);
            $table->string('linkedin_url')->nullable();
            $table->string('candidate_source')->nullable();
            $table->string('current_designation')->nullable();
            $table->string('applied_designation')->nullable();
            $table->string('stream')->nullable();
            $table->text('remark')->nullable();
            $table->text('reason')->nullable();
            $table->string('resume_path')->nullable();
            $table->text('skills')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
