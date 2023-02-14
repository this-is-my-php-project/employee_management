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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->dateTime('clock_in');
            $table->dateTime('clock_out');
            $table->date('date');
            $table->string('note')->nullable();
            $table->unsignedBigInteger('job_detail_id');
            $table->unsignedBigInteger('shift_id');
            $table->unsignedBigInteger('workspace_id');
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
        Schema::dropIfExists('attendance_records');
    }
};
