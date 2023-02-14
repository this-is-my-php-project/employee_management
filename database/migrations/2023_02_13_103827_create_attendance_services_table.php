<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Attendance Service');
            $table->string('description')->default('Allows you to track attendance for your employees.');
            $table->string('icon')->default('fas fa-calendar-check');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_services');
    }
};
