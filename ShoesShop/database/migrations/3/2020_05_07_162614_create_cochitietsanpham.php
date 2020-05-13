<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCochitietsanpham extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cochitietsanpham', function (Blueprint $table) {
            $table->Integer('sp_ma')->unsigned();
            $table->foreign('sp_ma')->references('sp_ma')->on('sanpham');
            $table->Integer('ms_ma')->unsigned();
            $table->foreign('ms_ma')->references('ms_ma')->on('mausac');
            $table->Integer('kc_ma')->unsigned();
            $table->foreign('kc_ma')->references('kc_ma')->on('kichco');
            $table->Integer('soLuongTon');
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
        Schema::dropIfExists('cochitietsanpham');
    }
}
