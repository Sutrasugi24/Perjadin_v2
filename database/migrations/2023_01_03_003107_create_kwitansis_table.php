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
        Schema::create('kwitansis', function (Blueprint $table) {
            $table->id();
            $table->string('kwitansi_number')->required();
            $table->string('kwitansi_date')->required();
            $table->timestamps();
        });

        Schema::table('kwitansis', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->foreignId('user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kwitansis');
        Schema::table('kwitansis', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
