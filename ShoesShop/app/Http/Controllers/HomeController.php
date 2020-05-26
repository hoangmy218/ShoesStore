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
    }
   public function index()
    {
        $list_ad = DB::table('quangcao')->where('qc_trangThai',0)->get();

        $all_product = DB::table('hinhanh')
                ->join('sanpham','hinhanh.sp_ma','=','sanpham.sp_ma')
                ->join('cochitietphieunhap','sanpham.sp_ma','=','cochitietphieunhap.sp_ma')
                ->join('phieunhap','phieunhap.pn_ma','=','cochitietphieunhap.pn_ma')
                ->join('khuyenmai','khuyenmai.km_ma','=','sanpham.km_ma')
                ->join('thuonghieu', 'thuonghieu.th_ma','=','sanpham.th_ma')
                ->where('sp_trangThai','=',0)
                ->orderby('phieunhap.pn_ngayNhap','desc')
                ->groupby('hinhanh.sp_ma')
                ->paginate(6);


        $cate = DB::table('danhmuc')->orderby('dm_ma','asc')->get();
        $brand = DB::table('thuonghieu')->orderby('th_ma','asc')->get();

        $time_month = \Carbon\Carbon::now()->month;
        
       // Đếm sản phẩm theo danh mục
        $list_category = DB::table('danhmuc')->select('dm_ma')->get();
        $count_dm = count($list_category);
        $dm_array= array();
        $dm=0;
        foreach ($list_category as $key => $danhmuc){
            $sl_dm = db::table('sanpham')->where([['dm_ma',$danhmuc->dm_ma],['sp_trangThai',0]])->count();
            $dm_array[$dm] = $sl_dm;
            $dm++;
        }

        // Đếm sản phẩm theo thương hiệu
        $list_brand = DB::table('thuonghieu')->select('th_ma')->get();
        $count_th = count($list_brand);
        $th_array= array();
        $th=0;
        foreach ($list_brand as $key => $thuonghieu){
            $sl_th = db::table('sanpham')->where([['th_ma',$thuonghieu->th_ma],['sp_trangThai',0]])->count();
            $th_array[$th] = $sl_th;
            $th++;
        }
        // echo "<pre>";
        // print_r($all_product);
        // echo "</pre>";
        
       return view("pages.home")
                ->with('list_ad',$list_ad)
                ->with('all_product',$all_product)
                ->with('list_cate',$cate)
                ->with('list_brand',$brand)
                ->with('dm_array',$dm_array)
                ->with('th_array',$th_array);
    }



    public function userLogin(){
        return view('pages.customer.user_login');
    }

    public function contact(){
        return view('pages.customer.contact');
    }
    public function about(){
        return view('pages.customer.about');
    }

    public function returnExchange(){
        return view('pages.customer.returnexchange');
    }

    public function Home_u(){
        $this->authLogin();
        $list_ad = DB::table('quangcao')->where('qc_trangThai',0)->get();
        //$manager_Advertisement = view('pages.home')->with('list_ad',$list_ad);

        // Tiên  thêm where Ngan join km
        $all_product = DB::table('hinhanh')
                ->join('sanpham','hinhanh.sp_ma','=','sanpham.sp_ma')
                ->join('cochitietphieunhap','sanpham.sp_ma','=','cochitietphieunhap.sp_ma')
                ->join('phieunhap','phieunhap.pn_ma','=','cochitietphieunhap.pn_ma')
                ->join('khuyenmai','khuyenmai.km_ma','=','sanpham.km_ma')
                ->join('thuonghieu', 'thuonghieu.th_ma','=','sanpham.th_ma')
                ->select()
                ->orderby('phieunhap.pn_ngayNhap','desc')
                ->groupby('hinhanh.sp_ma')
                ->paginate(6);  



         $cate = DB::table('danhmuc')->orderby('dm_ma','asc')->get();
         $brand = DB::table('thuonghieu')->orderby('th_ma','asc')->get();

         $time_month = \Carbon\Carbon::now()->month;
        
       // Đếm sản phẩm theo danh mục
        $list_category = DB::table('danhmuc')->select('dm_ma')->get();
        $count_dm = count($list_category);
        $dm_array= array();
        $dm=0;
        foreach ($list_category as $key => $danhmuc){
            $sl_dm = db::table('sanpham')->where('dm_ma',$danhmuc->dm_ma)->count();
            $dm_array[$dm] = $sl_dm;
            $dm++;
        }

        // Đếm sản phẩm theo thương hiệu
        $list_brand = DB::table('thuonghieu')->select('th_ma')->get();
        $count_th = count($list_brand);
        $th_array= array();
        $th=0;
        foreach ($list_brand as $key => $thuonghieu){
            $sl_th = db::table('sanpham')->where('th_ma',$thuonghieu->th_ma)->count();
            $th_array[$th] = $sl_th;
            $th++;
        }
        // echo "<pre>";
        // print_r($all_product);
        // echo "</pre>";
        
       return view("pages.home",compact('all_product'))->with('list_ad',$list_ad)->with('list_cate',$cate)->with('list_brand',$brand)->with('dm_array',$dm_array)->with('th_array',$th_array);
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
            $data['ltk_ma'] = "2"; //Chuc vu Khach hang
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
                Session::put('ltk_ma',$result->ltk_ma);
                $ltk=Session::get('ltk_ma');
                if($result->nd_trangThai==1){
                    Session::put('message','Tài khoản đã bị vô hiệu hóa!');
                    return Redirect::to('/userLogin');
                }
                if($ltk==2){
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
        Session::put('ltk_ma',null);
        Session::put('nd_email',null);
        Cart::destroy();
        return Redirect::to('/');
       /* return Redirect::to('/userLogin');*/
                //echo "Logout";
    }


    
    //LAN update 14/05/2020

    public function status_order(){
        $nd_ma= Session::get('nd_ma');
        $orders=DB::table('donhang')->where('nd_ma',$nd_ma )->orderby('dh_ma','desc')->get();
        if($orders!=NULL){
            return view('pages.customer.status_order')->with('orders', $orders);
        }
    }

    public function view_customerdetails($dh_ma){
        $this->authLogin();
        $items = DB::table('cochitietdonhang')->join('sanpham','sanpham.sp_ma','cochitietdonhang.sp_ma')->where('dh_ma',$dh_ma)->get();

        
            $order = DB::table('donhang')->join('nguoidung','nguoidung.nd_ma','donhang.nd_ma')->join('hinhthucthanhtoan','hinhthucthanhtoan.httt_ma','donhang.httt_ma')->join('hinhthucvanchuyen','hinhthucvanchuyen.htvc_ma','donhang.htvc_ma')->where('donhang.dh_ma','=',$dh_ma)->first();
        
        
        return view('pages.customer.view_customerdetails')->with('order',$order)->with('items',$items);
    }

      public function search(Request $request){// Tiên 15/03

        $brand = DB::table('thuonghieu')->get(); //tien 14/05
        $cate = DB::table('danhmuc')->get();//tien 14/05
        // tien thêm 21/05
       
        $time_month = \Carbon\Carbon::now()->month;
        
       // Đếm sản phẩm theo danh mục
        $list_category = DB::table('danhmuc')->select('dm_ma')->get();
        $count_dm = count($list_category);
        $dm_array= array();
        $dm=0;
        foreach ($list_category as $key => $danhmuc){
            $sl_dm = db::table('sanpham')->where('dm_ma',$danhmuc->dm_ma)->count();
            $dm_array[$dm] = $sl_dm;
            $dm++;
        }

        // Đếm sản phẩm theo thương hiệu
        $list_brand = DB::table('thuonghieu')->select('th_ma')->get();
        $count_th = count($list_brand);
        $th_array= array();
        $th=0;
        foreach ($list_brand as $key => $thuonghieu){
            $sl_th = db::table('sanpham')->where('th_ma',$thuonghieu->th_ma)->count();
            $th_array[$th] = $sl_th;
            $th++;
        }
        // echo "<pre>";
        // print_r($all_product);
        // echo "</pre>";

        $keywords = $request->keywords_submit;

        $search = DB::table('hinhanh')
                ->join('sanpham','hinhanh.sp_ma','=','sanpham.sp_ma')
                ->join('thuonghieu', 'thuonghieu.th_ma','=','sanpham.th_ma')
                ->join('cochitietphieunhap','sanpham.sp_ma','=','cochitietphieunhap.sp_ma')
                ->join('phieunhap','phieunhap.pn_ma','=','cochitietphieunhap.pn_ma')
                ->join('khuyenmai','khuyenmai.km_ma','=','sanpham.km_ma')
                ->orderby('phieunhap.pn_ngayNhap','desc')
                ->orderby('sanpham.sp_ma','desc')
                ->groupby('hinhanh.sp_ma')
                ->limit(6)
                ->where('sp_ten','like','%'.$keywords.'%')->get(); 

           
        if(!($search->isempty())){
           Session::put('success_message','Tìm kiếm sản phẩm thành công !');
        }else{
             Session::put('fail_message','Không tìm thấy sản phẩm !');
        }

        return view('pages.product.search')
                ->with('search',$search)
                ->with('list_brand',$brand)
                ->with('list_cate',$cate)
                ->with('dm_array',$dm_array)
                ->with('th_array',$th_array);
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