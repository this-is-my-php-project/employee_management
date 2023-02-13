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
        Schema::create('user_attendance_meta', function (Blueprint $table) {
            $table->id();
            $table->string('clock_in');
            $table->string('clock_out');
            $table->unsignedBigInteger('workspace_id');
            $table->unsignedBigInteger('job_detail_id');
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
        Schema::dropIfExists('user_attendance_meta');
    }
};
