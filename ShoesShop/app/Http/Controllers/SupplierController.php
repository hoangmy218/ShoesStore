<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();

class SupplierController extends Controller
{
     public function authLogin(){
        $admin_id = Session::get('nd_ma');
        if ($admin_id) 
            return Redirect::to('/dashboard'); 
        else 
            return Redirect::to('/admin')->send();
    }

    public function addSupplier(){
        $this->authLogin(); 
        $count_supplier = DB::table('nhacungcap')->count();
    	return view('admin.add_supplier')->with('count_supplier',$count_supplier);
    }



    public function saveSupplier(Request $request)
    {
    	$this -> authLogin();
        $data = array();
        $data['ncc_ma'] = $request->supplier_id;
        $data['ncc_ten'] = $request->supplier_name;
        $data['ncc_email'] = $request->supplier_email;
        $data['ncc_dienThoai'] = $request->supplier_phone;
        $data['ncc_diaChi'] = $request->supplier_address;

       	//$count =  Db::table('nhacungcap')->insert($data);
        try {
    
            $count =  Db::table('nhacungcap')->insert($data);
            Session::put('success_message','Thêm Nhà cung cấp thành công!');
            
        } catch (\Illuminate\Database\QueryException $e) {
        	
            Session::put('fail_message','Thêm Nhà cung cấp thất bại!');
        }
        return Redirect::to('/manage-suppliers');
    }

    public function editSupplier($ncc_ma){
    	$this->authLogin();
    	$supplier = DB::table('nhacungcap')->where('ncc_ma','=',$ncc_ma)->first();
    	return  view('admin.edit_supplier')->with('supplier',$supplier);
    }
    
    public function updateSupplier(Request $request, $ncc_ma){
    	$this->authLogin();
    	$data = array();
    	$data['ncc_ma'] = $request->supplier_id;
        $data['ncc_ten'] = $request->supplier_name;
        $data['ncc_email'] = $request->supplier_email;
        $data['ncc_dienThoai'] = $request->supplier_phone;
        $data['ncc_diaChi'] = $request->supplier_address;
    	try {
    		$count = DB::table('nhacungcap')->where('ncc_ma','=',$ncc_ma)->update($data);
    		Session::put('success_message','Chỉnh sửa Nhà cung cấp thành công!');
    		
    	} catch (\Illuminate\Database\QueryException $e) {
    		Session::put('fail_message','Chỉnh sửa Nhà cung cấp thất bại!');
    	}
    	return Redirect::to("/manage-suppliers");
    }

    public function showSuppliers(){
        $this->authLogin();
    	$suppliers = DB::table('nhacungcap')->orderby('ncc_ma','desc')->get();
    	return view('admin.manage_suppliers')->with('suppliers',$suppliers);
    }

    public function deleteSupplier($ncc_ma){
    	$this -> authLogin();


    	try{
    		$count = DB::table('nhacungcap')->where('ncc_ma',$ncc_ma)->delete();
    		Session::put('success_message','Xóa Nhà cung cấp thành công!');

    	} catch (\Illuminate\Database\QueryException $e) {
        	
            Session::put('fail_message','Xóa Nhà cung cấp thất bại!');
        }
        return Redirect::to('/manage-suppliers');
    }
}
