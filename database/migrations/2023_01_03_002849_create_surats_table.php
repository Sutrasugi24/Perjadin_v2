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
            $table->date('document_date')->required();
            $table->timestamps();
        });

        Schema::table('surats', function (Blueprint $table) {
            $table->foreignId('perjadin_id')->constrained('perjadins');
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
            $table->dropColumn('perjadin_id');
        });
    }
};
