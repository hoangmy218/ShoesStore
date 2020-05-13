<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class OrderController extends Controller
{
	 public function authLogin(){
        $admin_id = Session::get('nd_ma');
        if ($admin_id) 
            return Redirect::to('/dashboard'); 
        else 
            return Redirect::to('/admin')->send();
    }

    public function showOrder()
    {
    	$this->authLogin();
        $orders = DB::table('donhang')->join('nguoidung','nguoidung.nd_ma','donhang.nd_ma')->join('hinhthucthanhtoan','hinhthucthanhtoan.httt_ma','donhang.httt_ma')->join('hinhthucvanchuyen','hinhthucvanchuyen.htvc_ma','donhang.htvc_ma')->join('trangthai','trangthai.tt_ma','donhang.tt_ma')->orderby('donhang.dh_ma','desc')->get();
    	return view('admin.manage_order')->with('orders',$orders);
    }

    public function viewOrder($dh_ma)
    {
    	$this->authLogin();
        $disc = DB::table('donhang')->where('donhang.dh_ma','=',$dh_ma)->first();
        // if ($disc->km_ma != NULL){
        //     $order = DB::table('donhang')->join('nguoidung','nguoidung.nd_ma','donhang.nd_ma')->join('hinhthucthanhtoan','hinhthucthanhtoan.httt_ma','donhang.httt_ma')->join('hinhthucvanchuyen','hinhthucvanchuyen.htvc_ma','donhang.htvc_ma')->join('khuyenmai','khuyenmai.km_ma','donhang.km_ma')->where('donhang.dh_ma','=',$dh_ma)->first();
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
        return view('admin.view_order')->with('order',$order)->with('items',$items); 	
    }

    public function orderPdf($dh_ma)
    {
        $this->authLogin();
        $order = DB::table('donhang')->join('nguoidung','nguoidung.nd_ma','donhang.nd_ma')->join('hinhthucthanhtoan','hinhthucthanhtoan.httt_ma','donhang.httt_ma')->join('hinhthucvanchuyen','hinhthucvanchuyen.htvc_ma','donhang.htvc_ma')->where('donhang.dh_ma','=',$dh_ma)->first();
        $items = DB::table('chitietdonhang')->join('chitietsanpham','chitietsanpham.ctsp_ma','chitietdonhang.ctsp_ma')->join('sanpham','sanpham.sp_ma','chitietsanpham.sp_ma')->where('dh_ma',$dh_ma)->get();
        return view('admin.order_pdf')->with('order',$order)->with('items',$items);    
    }

    public function approveOrder($dh_ma)
    {
        $this->authLogin();
        try {
    
            $count = DB::table('donhang')->where('dh_ma', $dh_ma)->update(['tt_ma' => 2]);
            Session::put('success_message','Cập nhật trạng thái đơn hàng thành công!');
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Cập nhật trạng thái đơn hàng không thành công!');
        }
      
    }

    public function shipOrder($dh_ma)
    {
        $this->authLogin();
        try {
    
            $count = DB::table('donhang')->where('dh_ma', $dh_ma)->update(['tt_ma' => 3]);
            Session::put('success_message','Cập nhật trạng thái đơn hàng thành công!');
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Cập nhật trạng thái đơn hàng không thành công!');
        }
        

    }

    public function completeOrder($dh_ma)
    {
        $this->authLogin();
        try {
    
            $count = DB::table('donhang')->where('dh_ma', $dh_ma)->update(['tt_ma' => 4]);
            Session::put('success_message','Cập nhật trạng thái đơn hàng thành công!');
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Cập nhật trạng thái đơn hàng không thành công!');
        }
       
    }

    public function cancelOrder($dh_ma)
    {
        $this->authLogin();
        try {
    
            $count = DB::table('donhang')->where('dh_ma', $dh_ma)->update(['tt_ma' => 5]);
            Session::put('success_message','Cập nhật trạng thái đơn hàng thành công!');
            $items_cancel = DB::table('chitietdonhang')->join('chitietsanpham','chitietdonhang.ctsp_ma','chitietsanpham.ctsp_ma')->where('dh_ma', $dh_ma)->select('chitietdonhang.ctsp_ma','chitietdonhang.soLuongDat','chitietsanpham.ctsp_soLuongTon')->get();
            foreach ($items_cancel as $key => $item) {
                try{
                    /*echo $item->soLuongDat;
                    echo $item->ctsp_soLuongTon;*/
                   /*echo*/  $new_stock = $item->soLuongDat+$item->ctsp_soLuongTon;

                    DB::table('chitietsanpham')->where('ctsp_ma', $item->ctsp_ma)->update(['ctsp_soLuongTon' => $new_stock]);
                }catch (\Illuminate\Database\QueryException $e) {
                    Session::put('fail_message','Cập nhật trạng thái đơn hàng không thành công!');
                }
            }

            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Cập nhật trạng thái đơn hàng không thành công!');
        }
        
       
    }

    public function cusCancelOrder($dh_ma)
    {
        $this->authLogin();
       
        try {
    
            $count = DB::table('donhang')->where('dh_ma', $dh_ma)->update(['dh_trangThai' => 'Đã hủy']);
            Session::put('success_message','Cập nhật trạng thái đơn hàng thành công!');
            $items_cancel = DB::table('chitietdonhang')->join('chitietsanpham','chitietdonhang.ctsp_ma','chitietsanpham.ctsp_ma')->where('dh_ma', $dh_ma)->select('chitietdonhang.ctsp_ma','chitietdonhang.soLuongDat','chitietsanpham.ctsp_soLuongTon')->get();
            foreach ($items_cancel as $key => $item) {
                try{
                    /*echo $item->soLuongDat;
                    echo $item->ctsp_soLuongTon;*/
                   /*echo*/  $new_stock = $item->soLuongDat+$item->ctsp_soLuongTon;

                    DB::table('chitietsanpham')->where('ctsp_ma', $item->ctsp_ma)->update(['ctsp_soLuongTon' => $new_stock]);

                }catch (\Illuminate\Database\QueryException $e) {
                    Session::put('fail_message','Cập nhật trạng thái đơn hàng không thành công!');
                    $nd_ma= Session::get('nd_ma');
                    $status=DB::table('donhang')->where('nd_ma',$nd_ma )->get();
                    if($status!=NULL){
                        return view('pages.customer.status_order')->with('status', $status);
                    }
                }
            }

            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Cập nhật trạng thái đơn hàng không thành công!');
            $nd_ma= Session::get('nd_ma');
            $status=DB::table('donhang')->where('nd_ma',$nd_ma )->get();
            if($status!=NULL){
                return view('pages.customer.status_order')->with('status', $status);
            }
        }
        Session::put('success_message','Cập nhật trạng thái đơn hàng thành công!');
        $nd_ma= Session::get('nd_ma');
        $status=DB::table('donhang')->where('nd_ma',$nd_ma )->get();
        if($status!=NULL){
            return view('pages.customer.status_order')->with('status', $status);
        }
        
       
    }
}
