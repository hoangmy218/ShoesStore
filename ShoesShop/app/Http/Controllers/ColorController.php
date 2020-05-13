<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();


 // Tien 09/05
class ColorController extends Controller
{
     public function authLogin(){
        $admin_id = Session::get('nd_ma');
        if ($admin_id) 
            return Redirect::to('/dashboard'); 
        else 
            return Redirect::to('/admin')->send();
    }

    public function addColor(){
        $this->authLogin(); 
    	return view('admin.add_color');
    }

    public function saveColor(Request $request)
    {
        $data = array();
        $data['ms_ma'] = $request->color_id;
        $data['ms_ten'] = $request->color_name;
       
        try {
    
            DB::table('mausac')->insert($data);
            Session::put('success_message1','Thêm màu sắc thành công !');
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message1','Thêm màu sắc không thành công !');
        }
       
        return Redirect::to('/manage-color');
    }

    public function showColor(){
        $this->authLogin();
    	$list_color = DB::table('mausac')->get();
    	$manager_color = view('admin.manage_color')->with('list_color', $list_color);
    	return view('admin_layout')->with('admin.manage_color', $manager_color);
    	/*return view('admin.manage_color');*/
    }

    public function edit_Color($ms_ma){
        $this->AuthLogin();
        $edit_color = DB::table('mausac')->where('ms_ma',$ms_ma)->get();

        $manager_color  = view('admin.edit_color')->with('edit_color', $edit_color);

        return view('admin_layout')->with('admin.edit_color', $manager_color);
    }

    public function update_Color(Request $request,$ms_ma){
        $this->AuthLogin();
        $data = array();
         
        // $data['ms_ma'] = $request->color_ma;
        $data['ms_ten'] = $request->color_name;
         // Tien 09/05
        try {
    
            DB::table('mausac')->where('ms_ma',$ms_ma)->update($data);
            Session::put('success_message1','Cập nhật màu sắc thành công !');
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message1','Cập nhật màu sắc không thành công !');
        }
        return Redirect::to('/manage-color');
    }

     public function delete_Color($ms_ma){
        $this->AuthLogin();
         // Tien 09/05
        try {
    
           DB::table('mausac')->where('ms_ma',$ms_ma)->delete();
            Session::put('success_message1','Xóa màu sắc thành công !');
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message1','Màu sắc sản phẩm đang bán, không thể xóa!');
        }
       
        // return Redirect::to('/manage-brand');
    }
}
