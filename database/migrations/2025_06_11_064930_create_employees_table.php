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
        $table->string('digi_id');
        $table->string('gender');
        $table->date('dob');
        $table->date('celb_dob');
        $table->string('blood_group')->nullable();
        $table->string('phone');
        $table->text('emergency_contacts')->nullable();
        $table->string('official_email')->nullable();
        $table->string('email')->nullable();
        $table->string('voter_id')->nullable();
        $table->string('pan')->nullable();
        $table->string('aadhar')->nullable();
        $table->string('designation')->nullable();
        $table->string('team_lead')->nullable();
        $table->date('joining_date')->nullable();
        $table->integer('exp_years')->nullable();
        $table->integer('exp_months')->nullable();
        $table->text('salary')->nullable();
        $table->integer('inc_years')->nullable();
        $table->integer('inc_months')->nullable();
        $table->date('next_increment')->nullable();
        $table->date('probation_end')->nullable();
        $table->date('release_date')->nullable();
        $table->text('address_perm')->nullable();
        $table->string('state_perm')->nullable();
        $table->string('city_perm')->nullable();
        $table->string('zip_perm')->nullable();
        $table->string('country_perm')->nullable();
        $table->text('address_local')->nullable();
        $table->string('state_local')->nullable();
        $table->string('city_local')->nullable();
        $table->string('zip_local')->nullable();
        $table->string('country_local')->nullable();
        $table->string('acc_name')->nullable();
        $table->string('acc_no')->nullable();
		 $table->string('confirm_acc_no')->nullable();
        $table->string('bank_name')->nullable();
        $table->string('ifsc')->nullable();
        $table->string('branch_address')->nullable();
        $table->string('profile_image')->nullable();
        $table->text('skills')->nullable();
        $table->text('documents')->nullable();
        $table->text('previous_companies')->nullable();
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
