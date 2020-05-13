<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCochitietdonhang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cochitietdonhang', function (Blueprint $table) {
            $table->Integer('sp_ma')->unsigned();
            $table->foreign('sp_ma')->references('sp_ma')->on('sanpham');
            $table->Integer('dh_ma')->unsigned();
            $table->foreign('dh_ma')->references('dh_ma')->on('donhang');
            $table->Integer('ms_ma')->unsigned();
            $table->foreign('ms_ma')->references('ms_ma')->on('mausac');
            $table->Integer('kc_ma')->unsigned();
            $table->foreign('kc_ma')->references('kc_ma')->on('kichco');
            
            $table->Integer('SoLuongDat');
            $table->String('DonGiaBan');
           
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
        Schema::dropIfExists('cochitietdonhang');
    }
}
