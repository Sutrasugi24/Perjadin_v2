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
        Schema::create('kuitansis', function (Blueprint $table) {
            $table->id();
            $table->string('kuitansi_number')->required();
            $table->date('kuitansi_date')->required();
            $table->string('cost_total')->required();
            $table->timestamps();
        });

        Schema::table('kuitansis', function (Blueprint $table) {
            $table->foreignId('biaya_id')->constrained('biayas')->onDelete('cascade');
            $table->foreignId('perjadin_id')->constrained('perjadins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuitansis');
    }
};
