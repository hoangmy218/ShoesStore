<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonhang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donhang', function (Blueprint $table) {
            $table->Increments('dh_ma');
            $table->String('dh_tenNguoiNhan');
            $table->String('dh_diaChiNhan');
            $table->String('dh_dienThoaiNhan');
            $table->Text('dh_ghiChu');
            $table->Date('dh_ngayDat');
            $table->Integer('dh_tongTien')->unsigned();

            $table->Integer('htvc_ma')->unsigned();
            $table->foreign('htvc_ma')->references('htvc_ma')->on('hinhthucvanchuyen');

            $table->Integer('httt_ma')->unsigned();
            $table->foreign('httt_ma')->references('httt_ma')->on('hinhthucthanhtoan');

            $table->Integer('nd_ma')->unsigned();
            $table->foreign('nd_ma')->references('nd_ma')->on('nguoidung');

            $table->Integer('tt_ma')->unsigned();
            $table->foreign('tt_ma')->references('tt_ma')->on('trangthai');

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
        Schema::dropIfExists('donhang');
    }
}
