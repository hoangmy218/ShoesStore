<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhieunhap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phieunhap', function (Blueprint $table) {
            $table->Increments('pn_ma'); //Increments là khóa chính
            $table->Date('pn_ngayNhap');
            $table->Integer("pn_tongTien");
            $table->timestamps();
            $table->Integer('ncc_ma')->unsigned();
            $table->foreign('ncc_ma')->references('ncc_ma')->on('nhacungcap');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phieunhap');
    }
}
