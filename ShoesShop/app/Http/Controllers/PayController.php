<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
session_start();
class PayController extends Controller
{
    public function authLogin(){
        $admin_id = Session::get('nd_ma');
        if ($admin_id) 
            return Redirect::to('/dashboard'); 
        else 
            return Redirect::to('/admin')->send();
    }

    public function manage_pay(){
    	 $this->authLogin();
    	$list_pay = DB::table('hinhthucthanhtoan')->orderby('httt_ma','desc')->get();
    	$manager_pay = view('admin.manage_pay')->with('list_pay', $list_pay);
    	return view('admin_layout')->with('admin.manage_pay', $manager_pay);
    }
    public function add_pay(){
    	 $this->authLogin();
    	 return view('admin.add_pay');
    }
    public function save_pay(Request $request){
    	$this->authLogin();
        try{
           $data = array();
            $data['httt_ten'] = $request->pay_name;
            Db::table('hinhthucthanhtoan')->insert($data);
            Session::put('success_message','Thêm hình thức thanh toán thành công!'); 
            return Redirect::to('/manage-pay');
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Thêm hình thức không thành công!');
            return Redirect::to('/manage-pay');
        }
    	
        
    }
    public function edit_pay($edit_id){
        $this->authLogin();     
        $list_pay = DB::table("hinhthucthanhtoan")->where('httt_ma', $edit_id)->orderby('httt_ma','desc')->get();
        
        // echo $hinh_anh;
        return view('admin.edit_pay')->with('list_pay', $list_pay);
    }
    public function update_pay(Request $request, $update_id){
    	$this->authLogin();
        try{
            $data= array();
        $data['httt_ten']=$request->pay_name;
        DB::table('hinhthucthanhtoan')->where('httt_ma', $update_id)->update($data);
         Session::put('success_message','Cập nhật hình thức thanh toán thành công!');
        return Redirect::to('/manage-pay');
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Cập nhật hình thức không thành công!');
            return Redirect::to('/manage-pay');
        } 
        
    }
    public function delete_pay($delete_id){
    	$this->authLogin();
        try{
            DB::table('hinhthucthanhtoan')->where('httt_ma', $delete_id)->delete();
        Session::put('success_message','Xóa hình thức thanh toán thành công!');
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Xóa hình thức không thành công!');
            
        }
    	
    }
    //18/05/2020
    public function unactive_pay($Controll_httt_ma){
        try{
            //$this->AuthLogin();
           DB::table('hinhthucthanhtoan')->where('httt_ma', $Controll_httt_ma)->update(['httt_trangThai'=>1]);
            Session::put('success_message', 'Ẩn hình thức này thành công!');
            // return Redirect::to('manage-product');
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Ẩn hình thức này không thành công!');
        }
           
    }

    public function active_pay($Controll_httt_ma){
        try{
            //$this->AuthLogin();
           DB::table('hinhthucthanhtoan')->where('httt_ma', $Controll_httt_ma)->update(['httt_trangThai'=>0]);
            Session::put('success_message', 'Hiện hình thức này thành công!');
            // return Redirect::to('manage-product');
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Hiện hình thức này không thành công!');
        }
       
    }
}
