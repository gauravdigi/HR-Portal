<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('increments', function (Blueprint $table) {
            $table->id(); // int(11) Auto Increment
            $table->unsignedBigInteger('empID'); // int(11)

            $table->text('old_salary')->nullable(); // text
            $table->text('new_salary')->nullable(); // text

            $table->string('month', 20); // varchar(20)

            $table->tinyInteger('admin_approval')->default(0); // tinyint(1) default 0
            $table->tinyInteger('is_deleted')->default(0); // tinyint(1) default 0

            $table->timestamp('created_at')->useCurrent(); // timestamp [CURRENT_TIMESTAMP]
            $table->dateTime('updated_at')->nullable(); // datetime NULL

            // Optionally:
            // $table->foreign('empID')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('increments');
    }
};
