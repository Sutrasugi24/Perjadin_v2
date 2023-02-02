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
        Schema::create('perjadins', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('plan')->required();
            $table->string('destination')->required();
            $table->enum('transport', ['darat', 'laut', 'udara'])->required();
            $table->date('leave_date')->required();
            $table->date('return_date')->required();
            $table->integer('coordinator')->required();
            $table->string('description')->required();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perjadins');
    }
};
