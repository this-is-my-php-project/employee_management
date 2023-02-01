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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('level')->unsigned()->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_global')->default(false);

            $table->unsignedBigInteger('workspace_id')->nullable();
            $table->foreign('workspace_id')->references('id')->on('workspaces');

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
        Schema::dropIfExists('departments');
    }
};
