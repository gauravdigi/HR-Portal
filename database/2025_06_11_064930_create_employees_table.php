<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('middle_name')->nullable();
        $table->string('last_name');
        $table->string('gender');
        $table->string('email')->unique();
        $table->date('dob');
        $table->string('blood_group')->nullable();
        $table->string('phone');
        $table->string('emergency')->nullable();
        $table->string('official_email')->nullable();
        $table->string('voter_id')->nullable();
        $table->string('pan')->nullable();
        $table->string('aadhar')->nullable();
        $table->string('designation')->nullable();
        $table->string('role');
        $table->string('team_lead')->nullable();
        $table->date('joining_date')->nullable();
        $table->integer('exp_years')->nullable();
        $table->integer('exp_months')->nullable();
        $table->decimal('salary', 10, 2)->nullable();
        $table->integer('inc_years')->nullable();
        $table->integer('inc_months')->nullable();
        $table->date('probation_end')->nullable();
        $table->date('release_date')->nullable();
        $table->text('address_perm');
        $table->string('state_perm');
        $table->string('city_perm');
        $table->string('zip_perm');
        $table->string('country_perm');
        $table->text('address_local');
        $table->string('state_local');
        $table->string('city_local');
        $table->string('zip_local');
        $table->string('country_local');
        $table->string('acc_name');
        $table->string('acc_no');
		 $table->string('confirm_acc_no');
        $table->string('bank_name');
        $table->string('ifsc');
        $table->string('branch_address')->nullable();
        $table->string('profile_image')->nullable();
        $table->json('skills')->nullable();
        $table->json('documents')->nullable();
        $table->json('previous_companies')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
