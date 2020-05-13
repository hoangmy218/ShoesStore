<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
session_start();

class AdminController extends Controller
{
    
    public function authLogin(){
        
        $ltk=Session::get('ltk_ma');
        
        if ($ltk==1) 
            return Redirect::to('/dashboard'); 
        else 
            return Redirect::to('/admin')->send();
    }


    public function index()
    {
        $ltk=Session::get('ltk_ma');
        
        if ($ltk==1) //Kiem tra neu dang dang nhap thi khong vao lai duoc trang admin-login
            return Redirect::to('/dashboard'); 
        else 
            return view('admin_login');
    }

    public function show_dashboard(){
       $this->authLogin();
        return view('dashboard');
    }

    public function dashboard(Request $request){

        $this->validate($request, [
            'admin_email'=>'required',
            'admin_password'=>'required|min:3|max:28'
            ],[
            'admin_email.required'=>'Bạn chưa nhập Email',
            'admin_password.required'=>'Bạn chưa nhập Password',
            'admin_password.min'=>'Password không nhỏ hơn 3 ký tự',
            'admin_password.max'=>'Password không lớn hơn 28 ký tự']);
        // if (Auth::attempt(['email'=>$request->admin_email, 'password'=>$request->admin_password]))
        // {
            $admin_email = $request->admin_email; // request trỏ tới tên thẻ
            $admin_password = md5($request->admin_password);

            $result = DB::table('nguoidung')->where('nd_email', $admin_email)->where('nd_matKhau',$admin_password)->first();
            /*echo '<pre>';
            print_r($result);
            echo '</pre>';*/
            /*return view('admin.dashboard');*/
            if ($result) {
                Session::put('ltk_ma',$result->ltk_ma);
                $ltk=Session::get('ltk_ma');
                if($ltk==1){
                    Session::put('nd_ma', $result->nd_ma); // result trỏ tới trường csdl
                    Session::put('nd_ten',$result->nd_ten);
                    Session::put('nd_email',$result->nd_email);
                        return Redirect::to('/dashboard');
                }else{
                    Session::put('message1','Bạn không có quyền truy cập.');
                        return Redirect::to('/admin');
                }
            }    
            else {
                Session::put('message','Email hoặc mật khẩu không đúng. Vui lòng thử lại.');
                return Redirect::to('/admin');
            }
        //}
        
        
    }
    public function logout(){
        $this->authLogin();
        Session::put('nd_ma',null);
        Session::put('nd_ten',null);
        Session::put('ltk_ma',null);
        Session::put('nd_email',null);
        //Ngân (7/5/2020) bỏ return
    }

    public function manage_customer(){
        //$this->authLogin();
        $list_customer =DB::table('nguoidung')->get();
        return view('admin.manage_customer')->with('list_customer', $list_customer);
    }

    //Lan
    
    public function active_customer($Controll_nd_ma){
        try{
            //$this->AuthLogin();
            DB::table('nguoidung')->where('nd_ma', $Controll_nd_ma)->update(['nd_trangThai'=>0]);
            Session::put('success_message', 'Bỏ vô hiệu hóa người dùng thành công');
            return Redirect::to('manage-customer');
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Bỏ vô hiệu hóa người dùng không thành công!');
        }
            
        }
    public function unactive_customer($Controll_nd_ma){
        try{

            //$this->AuthLogin();
           DB::table('nguoidung')->where('nd_ma', $Controll_nd_ma)->update(['nd_trangThai'=>1]);
            Session::put('message', 'Vô hiệu hóa người dùng thành công!');
            return Redirect::to('manage-customer');
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Vô hiệu hóa người dùng không thành công!');
        }
        }
    public function history_customer(){
            //$this->AuthLogin();
            $list_customer =DB::table('nguoidung')->get();
            return view('admin.history_customer')->with('list_customer', $list_customer);
        }
    public function view_history($Controll_nd_ma){
            //$this->AuthLogin();
           
            $ten=DB::table('nguoidung')->where('nd_ma',$Controll_nd_ma)->get();

            $don_hang= DB::table('donhang')->where('nd_ma', $Controll_nd_ma)->get();
           
            return view('admin.view_history')->with('ten', $ten)->with('don_hang',$don_hang);
        }
    public function view_details($id_details){// dh_ma
            //$this->AuthLogin();
            $ten=DB::table('donhang')->where('dh_ma',$id_details)->get();

            $chitiet_ctsp=DB::table('chitietdonhang')->where('chitietdonhang.dh_ma', $id_details)->join('chitietsanpham', 'chitietdonhang.ctsp_ma', '=','chitietsanpham.ctsp_ma')->get();
           $sanpham=DB::table('sanpham')->get();
           $vanchuyen=DB::table('vanchuyen')->get();
            return view('admin.view_details')->with('chitiet_ctsp', $chitiet_ctsp)->with('sanpham', $sanpham)->with('ten', $ten)->with('vanchuyen', $vanchuyen);
        }

    //Lan
    public function chitiet_sanpham($ct_id){
        $tongslton= DB::table('chitietsanpham')->select(DB::raw("sum(ctsp_soLuongTon) as slton"))->where('sp_ma',$ct_id)->get();
        $tongslnhap= DB::table('chitietsanpham')->select(DB::raw("sum(ctsp_soLuongNhap) as slnhap"))->where('sp_ma',$ct_id)->get();
        $kichco= DB::table('chitietsanpham')->select("ctsp_kichCo")->where('sp_ma',$ct_id)->distinct()->get();



        $list=DB::table('sanpham')->where('sanpham.sp_ma', $ct_id)->get();
        $image = DB::table('hinhanh')->where('hinhanh.sp_ma','=',$ct_id)->get();
        $ton=DB::table('chitietsanpham')->where('sp_ma', $ct_id)->get();
       
        return view('admin.chitiet_sanpham')->with('list', $list)->with('tongslton', $tongslton)->with('tongslnhap', $tongslnhap)->with('kichco', $kichco)->with('ton', $ton)->with('hinh',$image);
    }

    public function delete_image_product($ha_id){
        $this->AuthLogin();
        DB::table('hinhanh')->where('ha_ma',$ha_id)->delete();
        Session::put('message', 'Xóa hình ảnh thành công');
       return redirect()->back();
    }

    public function xoa_sanpham($id_xoa){
        $this->AuthLogin();
        $data= DB::table('chitietsanpham')->select(DB::raw("count(sp_ma) as slsp"))->where('sp_ma',$id_xoa)->get();
        foreach ($data as $key => $value) {
            $v=$value->slsp;
        }
        if($v>0){
            Session::put('message', 'Sản phẩm đang bán, không thể xóa!');
            return redirect()->back();
           
            }else{
               
                 DB::table('hinhanh')->join('sanpham', 'sanpham.sp_ma', '=', 'hinhanh.sp_ma')->where('hinhanh.sp_ma',$id_xoa)->delete();

            DB::table('sanpham')->where('sp_ma',$id_xoa)->delete();
       
            Session::put('message', 'Xóa sản phẩm ảnh thành công');
            return redirect()->back();
            }
       
    }
   
   
}
