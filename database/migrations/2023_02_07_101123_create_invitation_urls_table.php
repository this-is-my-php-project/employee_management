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
        Schema::create('invitation_urls', function (Blueprint $table) {
            $table->id();
            $table->integer('workspace_id');
            $table->integer('department_id');
            $table->string('signature');
            $table->string('expires');
            $table->string('url');
            $table->boolean('force_expired')->default(false);
            $table->integer('used')->nullable();
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
        Schema::dropIfExists('invitation_urls');
    }
};
