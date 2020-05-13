<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use App\Http\Requests;
use App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
session_start();
class HomeController extends Controller
{
    
    // Ngân (11/3/2020) paste lại nguyên cái public authLogin
    public function authLogin(){
         $ltk=Session::get('ltk_ma');
        if ($ltk==2) 
            return Redirect::to('/Home_u'); 
        else 
            return Redirect::to('/userLogin')->send();

        // if(Auth::check()){
        //     view()->share('nguoidung',Auth::user());
        // }
    }
    public function index()
    {
        // Start Ngân (14/4/2020)
        $list_ad = DB::table('quangcao')->where('qc_trangThai',0)->get();
        //$manager_Advertisement = view('pages.home')->with('list_ad',$list_ad);

        // Tiên
         $all_product = DB::table('hinhanh')->join('sanpham','hinhanh.sp_ma','=','sanpham.sp_ma')->orderby('sanpham.sp_ma','desc')->groupby('hinhanh.sp_ma')->limit(6)->join('thuonghieu', 'thuonghieu.th_ma','=','sanpham.th_ma')->get(); 
         $cate = DB::table('danhmuc')->orderby('dm_ma','desc')->get();
         $brand = DB::table('thuonghieu')->orderby('th_ma','desc')->get();
        
       return view("pages.home")->with('list_ad',$list_ad)->with('all_product',$all_product)->with('list_cate',$cate)->with('list_brand',$brand);
        // End Ngân (14/4/2020)

        // Tiên bản cũ 
        /*
        $all_product = DB::table('hinhanh')->join('sanpham','hinhanh.sp_ma','=','sanpham.sp_ma')->orderby('sanpham.sp_ma','desc')->groupby('hinhanh.sp_ma')->limit(4)->get(); 
        return view("pages.home")->with('all_product',$all_product);*/
    }



    public function userLogin(){
        return view('pages.customer.user_login');
    }

    public function Home_u(){
        $this->authLogin();
       // Start Ngân (14/4/2020)
        $list_ad = DB::table('quangcao')->where('qc_trangThai',0)->get();
        //$manager_Advertisement = view('pages.home')->with('list_ad',$list_ad);

        // Tiên
         $all_product = DB::table('hinhanh')->join('sanpham','hinhanh.sp_ma','=','sanpham.sp_ma')->orderby('sanpham.sp_ma','desc')->groupby('hinhanh.sp_ma')->limit(6)->join('thuonghieu', 'thuonghieu.th_ma','=','sanpham.th_ma')->get(); 
         $cate = DB::table('danhmuc')->orderby('dm_ma','desc')->get();
         $brand = DB::table('thuonghieu')->orderby('th_ma','desc')->get();
        
       return view("pages.home")->with('list_ad',$list_ad)->with('all_product',$all_product)->with('list_cate',$cate)->with('list_brand',$brand);
        // End Ngân (14/4/2020)

        //  // Start Ngân (14/4/2020)
        // $list_Advertisement = DB::table('quangcao')->where('qc_trangThai',0)->get();
        // $manager_Advertisement = view('pages.home')->with('list_ad',$list_Advertisement);

        // $all_product = DB::table('sanpham')->join('hinhanh','hinhanh.sp_ma','=','sanpham.sp_ma')->orderby('sanpham.sp_ma','desc')->limit(4)->get();
        // $manager_product = view('pages.home')->with('all_product',$all_product); 
        // return view("shop_layout")->with('pages.home',$manager_product)->with('pages.home',$manager_Advertisement);
        // // End Ngân (14/4/2020)

        //Bản cũ
        /*$this->authLogin();
        $all_product = DB::table('sanpham')->join('hinhanh','hinhanh.sp_ma','=','sanpham.sp_ma')->orderby('sanpham.sp_ma','desc')->limit(4)->get(); 
        return view("pages.home")->with('all_product',$all_product);*/
    }

    public function get_register(){
        return view('pages.customer.user_register');
    }

   public function post_register(Request $req){

        // start  Ngân (11/4/2020)

        $validate = Validator::make($req->all(), [
            'user_birth'=>'date',
            'user_phone'=>'numeric',
            'user_email'=>'email',
            'user_password'=>'min:3|max:28',
            'user_confirm_pass'=>'same:user_password',
            ],[
            'user_birth.date'=>'Ngày sinh phải theo định dạng năm/tháng/ngày', 
            'user_phone.numeric'=>'Số điện thoại phải là số.',
            'user_email.email'=>'Mail chưa được nhập đúng định dạng abc@gmai.com',
            'user_password.min'=>'Mật khẩu không nhỏ hơn 3 ký tự',
            'user_password.max'=>'Mật khẩu không lớn hơn 28 ký tự',
            'user_confirm_pass.same'=>'Mật khẩu và mật khẩu nhập lại không trùng nhau.']);
        if ($validate->fails()) {
            return View('pages.customer.user_register')->withErrors($validate);
        }



        $mail_used = DB::table("nguoidung")->where('nd_email',$req->user_email)->count();
        if($mail_used == 0){
            $data=array();

            $data['nd_ten'] = $req->user_name;
            $data['nd_ngaySinh'] = $req->user_birth;
            $data['nd_email'] = $req->user_email;
            $data['nd_dienThoai'] = $req->user_phone;
            $data['nd_diaChi'] = $req->user_address;
            $data['cv_ma'] = "2"; //Chuc vu Khach hang
            $data['nd_trangThai'] = "0"; //Trạng thái tài khoản (không vô hiệu) Ngân(6/3/2020)
            if($req->rdGioitinh=="Male"){
                $data['nd_gioiTinh'] = 0;
            }
            else{
                $data['nd_gioiTinh'] = 1;
            }
            $data['nd_matKhau'] = md5($req->user_password);

            $customer_id = DB::table('nguoidung')->insertGetId($data);

            Session::put('nd_ma',$customer_id);
            Session::put('nd_ten',$req->user_name);
            return Redirect::to('/Home_u');
        }else{
            Session::put('message','Mail đã được đăng ký.');
            return Redirect::to('/register');
        }

        // end Ngân (11/4/2020
        
    }

     
     public function AfterLogin(Request $request){
       
        $validate = Validator::make($request->all(),[
            'user_email'=>'email',
            'user_password'=>'min:3|max:28',
            ],[
            'user_email.email'=>'Email chưa nhập đúng định dạng abc@gmai.com',
            'user_password.min'=>'Mật khẩu không nhỏ hơn 3 ký tự',
            'user_password.max'=>'Mật khẩu không lớn hơn 28 ký tự',]);
        if ($validate->fails()) {
            return View('pages.customer.user_login')->withErrors($validate);
        }
        // if (Auth::attempt(['email'=>$request->admin_email, 'password'=>$request->admin_password]))
        // {
            $user_email = $request->user_email; // request trỏ tới tên thẻ
            $user_password = md5($request->user_password);

            $result = DB::table('nguoidung')->where('nd_email', $user_email)->where('nd_matKhau',$user_password)->first();
            /*echo '<pre>';
            print_r($result);
            echo '</pre>';*/
            /*return view('admin.dashboard');*/
            if ($result) {
                Session::put('cv_ma',$result->cv_ma);
                $cv=Session::get('cv_ma');
                if($result->nd_trangThai==1){
                    Session::put('message','Tài khoản đã bị vô hiệu hóa!');
                    return Redirect::to('/userLogin');
                }
                if($cv==2){
                    Session::put('nd_ma', $result->nd_ma); // result trỏ tới trường csdl
                    Session::put('nd_ten',$result->nd_ten);
                    Session::put('nd_email',$result->nd_email);
                        return Redirect::to('/Home_u');
                }else{
                    Session::put('message1','Bạn không có quyền truy cập.');
                        return Redirect::to('/userLogin');
                }
            }    
            else {
                
                Session::put('message','Email hoặc mật khẩu không đúng. Vui lòng thử lại');
                return Redirect::to('/userLogin');
            }
            
        //}
    }



    public function log_out(){
        $this->authLogin();
        Session::put('nd_ma',null);
        Session::put('nd_ten',null);
        Session::put('cv_ma',null);
        Session::put('nd_email',null);
        Cart::destroy();
        return Redirect::to('/');
       /* return Redirect::to('/userLogin');*/
                //echo "Logout";
    }


    
    //LAN

    public function status_order(){
        $nd_ma= Session::get('nd_ma');
        $status=DB::table('donhang')->where('nd_ma',$nd_ma )->orderby('dh_ma','desc')->get();
        if($status!=NULL){
            return view('pages.customer.status_order')->with('status', $status);
        }
    }

    public function view_customerdetails($dh_ma){
        $this->authLogin();
        $disc = DB::table('donhang')->where('donhang.dh_ma','=',$dh_ma)->first();
        if ($disc->km_ma != NULL){
        $order = DB::table('donhang')->join('nguoidung','nguoidung.nd_ma','donhang.nd_ma')->join('thanhtoan','thanhtoan.tt_ma','donhang.tt_ma')->join('vanchuyen','vanchuyen.vc_ma','donhang.vc_ma')->join('khuyenmai','khuyenmai.km_ma','donhang.km_ma')->where('donhang.dh_ma','=',$dh_ma)->first();
        } else{
             $order = DB::table('donhang')->join('nguoidung','nguoidung.nd_ma','donhang.nd_ma')->join('thanhtoan','thanhtoan.tt_ma','donhang.tt_ma')->join('vanchuyen','vanchuyen.vc_ma','donhang.vc_ma')->where('donhang.dh_ma','=',$dh_ma)->first();
        }
        $items = DB::table('chitietdonhang')->join('chitietsanpham','chitietsanpham.ctsp_ma','chitietdonhang.ctsp_ma')->join('sanpham','sanpham.sp_ma','chitietsanpham.sp_ma')->where('dh_ma',$dh_ma)->get();
        return view('pages.customer.view_customerdetails')->with('order',$order)->with('items',$items);
    }

    public function search(Request $request){// Tiên 08/05

        $keywords = $request->keywords_submit;
        $search = DB::table('sanpham')->join('hinhanh','hinhanh.sp_ma','=','sanpham.sp_ma')->where('sp_ten','like','%'.$keywords.'%')->get(); 
           
        if(!($search->isempty())){
           Session::put('success_message','Tìm kiếm sản phẩm thành công !');
        }else{
             Session::put('fail_message','Không tìm thấy sản phẩm !');
        }

        return view('pages.product.search')->with('search',$search);
    }

    public function info_customer(){
        $nd_ma= Session::get('nd_ma');
        $nguoi_dung=DB::table('nguoidung')->where('nd_ma',$nd_ma )->get();

        return view('pages.customer.thongtin_nguoidung')->with('nguoi_dung', $nguoi_dung);
    }
    public function chinhsua_thongtin(){
        $nd_ma= Session::get('nd_ma');
        $nguoi_dung=DB::table('nguoidung')->where('nd_ma',$nd_ma )->get();

        return view('pages.customer.chinhsua_thongtin')->with('nguoi_dung', $nguoi_dung);
    }
    public function capnhat_thongtin(Request $request, $capnhat_nd_ma){
        $data= array();
        $data['nd_ten']=$request->capnhat_nd_ten;
        $data['nd_email']=$request->capnhat_nd_email;
        $data['nd_dienThoai']=$request->capnhat_nd_dienThoai;
        $data['nd_gioiTinh']=$request->capnhat_nd_gioiTinh;
        $data['nd_ngaySinh']=$request->capnhat_nd_ngaySinh;
        $data['nd_diaChi']=$request->capnhat_nd_diaChi;
       
        DB::table('nguoidung')->where('nd_ma', $capnhat_nd_ma)->update($data);
        Session::put('message', 'Cập nhật thông tin thành công!');
        return Redirect::to('info-customer');
    }
}