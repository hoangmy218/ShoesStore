<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class TransportController extends Controller
{
	 public function authLogin(){
        $admin_id = Session::get('nd_ma');
        if ($admin_id) 
            return Redirect::to('/dashboard'); 
        else 
            return Redirect::to('/admin')->send();
    }

    public function manage_transport(){
    	 $this->authLogin();
    	$list_transport = DB::table('hinhthucvanchuyen')->orderby('htvc_ma','desc')->get();
    	$manager_transport = view('admin.manage_transport')->with('list_transport', $list_transport);
    	return view('admin_layout')->with('admin.manage_transport', $manager_transport);
    }
    public function add_transport(){
    	 $this->authLogin();
    	 return view('admin.add_transport');
    }
    public function save_transport(Request $request){
    	$this->authLogin();
        try{
            $data = array();
            $data['htvc_ten'] = $request->transport_name;
            $data['htvc_phi'] = $request->transport_price;
            Db::table('hinhthucvanchuyen')->insert($data);
            Session::put('success_message','Thêm hình thức vận chuyển thành công!');
            return Redirect::to('/manage-transport');
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Thêm hình thức không thành công!');
            return Redirect::to('/manage-transport');
        }
    	
    }
    public function edit_transport($edit_id){
        $this->authLogin();     
        $list_transport = DB::table("hinhthucvanchuyen")->where('htvc_ma', $edit_id)->orderby('htvc_ma','desc')->get();
        
        // echo $hinh_anh;
        return view('admin.edit_transport')->with('list_transport', $list_transport);
    }
    public function update_transport(Request $request, $update_id){
    	$this->authLogin();
        try{
           $data= array();
            $data['htvc_ten']=$request->transport_name;
            $data['htvc_phi']=$request->transport_price;
            DB::table('hinhthucvanchuyen')->where('htvc_ma', $update_id)->update($data);
            Session::put('success_message','Cập nhật hình thức vận chuyển thành công!');
            return Redirect::to('/manage-transport');
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Cập nhật hình thức không thành công!');
            return Redirect::to('/manage-transport');
        }
    }
    public function delete_transport($delete_id){
    	$this->authLogin();
        try{
            DB::table('hinhthucvanchuyen')->where('htvc_ma', $delete_id)->delete();
            Session::put('success_message','Xóa hình thức vận chuyển thành công!');
            
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Xóa hình thức không thành công!');
            
        }
    	
    }
    //18/05/2020
    public function unactive_transport($Controll_htvc_ma){
        try{
            //$this->AuthLogin();
           DB::table('hinhthucvanchuyen')->where('htvc_ma', $Controll_htvc_ma)->update(['htvc_trangThai'=>1]);
            Session::put('success_message', 'Ẩn hình thức này thành công!');
            // return Redirect::to('manage-product');
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Ẩn hình thức này không thành công!');
        }
           
    }

    public function active_transport($Controll_htvc_ma){
        try{
            //$this->AuthLogin();
           DB::table('hinhthucvanchuyen')->where('htvc_ma', $Controll_htvc_ma)->update(['htvc_trangThai'=>0]);
            Session::put('success_message', 'Hiện hình thức này thành công!');
            // return Redirect::to('manage-product');
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Hiện hình thức này không thành công!');
        }
       
    }
}
