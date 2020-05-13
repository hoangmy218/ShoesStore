<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();


 // Tien 09/05
class SizeController extends Controller
{
     public function authLogin(){
        $admin_id = Session::get('nd_ma');
        if ($admin_id) 
            return Redirect::to('/dashboard'); 
        else 
            return Redirect::to('/admin')->send();
    }

    public function addSize(){
        $this->authLogin(); 
    	return view('admin.add_size');
    }

    public function saveSize(Request $request)
    {
        $data = array();
        $data['kc_ma'] = $request->size_id;
        $data['kc_ten'] = $request->size_name;
       
        try {
    
            DB::table('kichco')->insert($data);
            Session::put('success_message1','Thêm kích cỡ thành công !');
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message1','Thêm kích cỡ không thành công !');
        }
       
        return Redirect::to('/manage-size');
    }

    public function showSize(){
        $this->authLogin();
    	$list_size = DB::table('kichco')->get();
    	$manager_size = view('admin.manage_size')->with('list_size', $list_size);
    	return view('admin_layout')->with('admin.manage_size', $manager_size);
    	/*return view('admin.manage_size');*/
    }

    public function edit_Size($kc_ma){
        $this->AuthLogin();
        $edit_size = DB::table('kichco')->where('kc_ma',$kc_ma)->get();

        $manager_size  = view('admin.edit_size')->with('edit_size', $edit_size);

        return view('admin_layout')->with('admin.edit_size', $manager_size);
    }

    public function update_Size(Request $request,$kc_ma){
        $this->AuthLogin();
        $data = array();
         
        // $data['kc_ma'] = $request->size_ma;
        $data['kc_ten'] = $request->size_name;
         // Tien 09/05
        try {
    
            DB::table('kichco')->where('kc_ma',$kc_ma)->update($data);
            Session::put('success_message1','Cập nhật kích cỡ thành công !');
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message1','Cập nhật kích cỡ không thành công !');
        }
        return Redirect::to('/manage-size');
    }

     public function delete_Size($kc_ma){
        $this->AuthLogin();
         // Tien 09/05
        try {
    
           DB::table('kichco')->where('kc_ma',$kc_ma)->delete();
            Session::put('success_message1','Xóa kích cỡ thành công !');
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message1','Kích cỡ sản phẩm đang bán, không thể xóa!');
        }
       
        // return Redirect::to('/manage-size');
    }
}
