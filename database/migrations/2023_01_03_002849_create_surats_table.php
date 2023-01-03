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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->required();
            $table->string('document_date')->required();
            $table->timestamps();
        });

        Schema::table('surats', function (Blueprint $table) {
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
        Schema::dropIfExists('surats');
        Schema::table('surats', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
