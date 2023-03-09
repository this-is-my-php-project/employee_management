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
        Schema::create('adjustments', function (Blueprint $table) {
            $table->id();
            $table->time('clock_in');
            $table->time('clock_out');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('reason')->nullable();
            $table->integer('adjustment_type');
            $table->unsignedBigInteger('attendance_record_id');
            $table->unsignedBigInteger('workspace_id');
            $table->unsignedBigInteger('profile_id');
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
        Schema::dropIfExists('adjustments');
    }
};
