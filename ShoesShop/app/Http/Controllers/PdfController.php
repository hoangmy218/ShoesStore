<?php

namespace App\Http\Controllers;
use PDF;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
use Dompdf\Dompdf;
use Dompdf\Options;


class PdfController extends Controller
{
	 public function authLogin(){
        $admin_id = Session::get('nd_ma');
        if ($admin_id) 
            return Redirect::to('/dashboard'); 
        else 
            return Redirect::to('/admin')->send();
    }

    public function createOrderPdf($dh_ma)
    {
    	$this->authLogin();
        $disc = DB::table('donhang')->where('donhang.dh_ma','=',$dh_ma)->first();
        // if ($disc->km_ma != NULL){
        //     $order = DB::table('donhang')->join('nguoidung','nguoidung.nd_ma','donhang.nd_ma')->join('thanhtoan','thanhtoan.tt_ma','donhang.tt_ma')->join('vanchuyen','vanchuyen.vc_ma','donhang.vc_ma')->join('khuyenmai','khuyenmai.km_ma','donhang.km_ma')->where('donhang.dh_ma','=',$dh_ma)->first();
        // }else{
            $order = DB::table('donhang')->join('nguoidung','nguoidung.nd_ma','donhang.nd_ma')->join('hinhthucthanhtoan','hinhthucthanhtoan.httt_ma','donhang.httt_ma')->join('hinhthucvanchuyen','hinhthucvanchuyen.htvc_ma','donhang.htvc_ma')->where('donhang.dh_ma','=',$dh_ma)->first();
        //}
        $items = DB::table('cochitietdonhang')
            ->leftJoin('cochitietsanpham', function($join)
                             {
                                 $join->on('cochitietsanpham.sp_ma', '=', 'cochitietdonhang.sp_ma');
                                 $join->on('cochitietsanpham.kc_ma', '=', 'cochitietdonhang.kc_ma');
                                 $join->on('cochitietsanpham.ms_ma', '=', 'cochitietdonhang.ms_ma');
                                
                             })
            ->join('kichco','kichco.kc_ma','cochitietdonhang.kc_ma')
            ->join('mausac','mausac.ms_ma','cochitietsanpham.ms_ma')
            ->join('sanpham','sanpham.sp_ma','cochitietdonhang.sp_ma')
            ->where('dh_ma',$dh_ma)->get();

        

        $pdf = PDF::loadView('admin.order_pdf', compact('order', 'items'));
        return $pdf->download('order'.$dh_ma.'.pdf');
    }
}
