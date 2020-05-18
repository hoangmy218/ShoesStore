<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();

class CartController extends Controller
{
     public function authLogin(){
        $user_id = Session::get('nd_ma');
        $ltk=Session::get('ltk_ma');
        
        if (($user_id)&&($ltk==2)) 
            return Redirect::to('/Home_u'); 
        else 
            return Redirect::to('/')->send();
    }

    public function showCart()
    {
        $this->authLogin();
        $content = Cart::content();
        if ($content->isempty()){
            Session::put('fail_message','Giỏ hàng trống!');
        }
        else
        {
            // echo "<pre>";
            // print_r($content);
            // echo "</pre>";
        
        //Kiemtra het hang

          
            $hethang = 0; //false - con hang
            $outstock = array();
            foreach ($content as $v_content) 
            {
                //echo "\n mau sac".$v_content->options->mausac;
                $ctsp_ton =  DB::table('cochitietsanpham')
                             ->where([['cochitietsanpham.kc_ma',$v_content->options->size],
                                ['cochitietsanpham.ms_ma',$v_content->options->mausac],
                                ['cochitietsanpham.sp_ma',$v_content->id]])
                             ->first();
                if ( $v_content->qty > $ctsp_ton->soLuongTon)
                {
                    $hethang = $hethang+1; //true
                    $outstock[$hethang] = $ctsp_ton->sp_ma;
                    $rowId = $v_content->rowId;
                    Cart::update($rowId,0);
                }
            } 
            if ($hethang == 1)
            {
                $tenhang = '';
                foreach ($outstock as $key => $value) {
                    $hang = DB::table('sanpham')->where('sp_ma',$value)->select('sp_ten')->first();
                    $tenhang .= ' ';
                    $tenhang .= $hang->sp_ten;
                    if ($key != count($outstock))
                    $tenhang .= ',';
                }
                Session::put('fail_message','<b>'.$tenhang.'</b> không đủ hàng');
            }
        }

        
    	return view("pages.cart.show_cart");
    }

     // Tien sua 08/05
    public function save_cart(Request $request){
    
        $mand = Session::get('nd_ma');

        if ($mand != null) {

            $size= $request->size; //size_id
            $mausac= $request->ms_ma_hidden; //mausac_id
            $sp_ma= $request->productid_hidden; //sp_ma

            $soluong = $request->quantity;
            echo 'size'.$size.'\n';
            echo 'mausac'.$mausac.'\n';
            echo 'sp_ma'.$sp_ma.'\n';
            echo 'soluong'.$soluong;

            $ctsp = DB::table('cochitietsanpham')
                    ->join('sanpham','sanpham.sp_ma','=','cochitietsanpham.sp_ma')
                    ->join('kichco','kichco.kc_ma','=','cochitietsanpham.kc_ma')
                    ->join('mausac','mausac.ms_ma','=','cochitietsanpham.ms_ma')
                    ->join('khuyenmai','khuyenmai.km_ma','=','sanpham.km_ma')
                    ->where([['cochitietsanpham.kc_ma',$size],
                            ['cochitietsanpham.ms_ma',$mausac],
                            ['cochitietsanpham.sp_ma',$sp_ma]])
                    ->first();



            $hinhanh= DB::table('hinhanh')->where('sp_ma',$sp_ma)->first(); 

            $data= array();
            $data['id'] = $sp_ma;
            $data['qty'] = $soluong;
            $data['name'] = $ctsp->sp_ten;
            $data['price'] = $ctsp->sp_donGiaBan*(100-$ctsp->km_giamGia)/100;
            $data['weight'] = 0;
            $data['options']['image'] = $hinhanh->ha_ten;
            $data['options']['mausac'] = $ctsp->ms_ma;
            $data['options']['size'] = $ctsp->kc_ma;
              
                    
            Cart::add($data);
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // return view("pages.cart.show_cart");
               
        }else{

            Session::put('cart_message','Bạn vui lòng đăng nhập trước khi thêm sản phẩm vào giỏ !');
            return Redirect::to('/'); //sd jquery để load lại trang

        }
        return Redirect::to('/show-cart');
        
       
    }// Tien 
    
    public function delete_to_cart($rowId){
        Cart::update($rowId,0);
        Session::put('success_message','Xóa sản phẩm thành công!');
        return Redirect::to('/show-cart');
    }
    

    public function update_qty(Request $request, $sp_ma)
    {$qty = $request->qty;
        $rowId = $request->rowId;
        $kc_ma = $request->size;
        $ms_ma = $request->color;
        $sp_ma = $request->sp_ma;
        $test = "qty: ".$qty." kc_ma:".$kc_ma." ms_ma:".$ms_ma." sp_ma:".$sp_ma;
        $content = Cart::get($rowId);  
        $newpro = DB::Table('cochitietsanpham')
               ->where([['sp_ma',$sp_ma],['ms_ma',$ms_ma],['kc_ma',$kc_ma]])
               ->first();
        if (($content->options->mausac == $newpro->ms_ma) && ($content->options->size == $newpro->kc_ma)) {//sp cu - khong doi kich co 
            if ($qty > $newpro->soLuongTon){ //chon qua so luong ton
                $hang = DB::table('sanpham')->where('sp_ma',$sp_ma)->select('sp_ten')->first();
                $tenhang = ' ';
                $tenhang .= $hang->sp_ten;                
                Session::put('fail_message','Cập nhật giỏ hàng không thành công!<b>'.$tenhang.'</b> không đủ hàng'); 
                $content = Cart::content();
                return view('pages.cart.upCart',compact('content'));
            }else {
                Cart::update($rowId, $qty);
                $content = Cart::content();
                Session::put('success_message','Cập nhật giỏ hàng thành công!');
                return view('pages.cart.upCart',compact('content'));
            }
        }else{
            if ($qty > $newpro->soLuongTon){
                $hang = DB::table('sanpham')->where('sp_ma',$sp_ma)->select('sp_ten')->first();
                $tenhang = ' ';
                $tenhang .= $hang->sp_ten;                
                Session::put('fail_message','Cập nhật giỏ hàng không thành công!<b>'.$tenhang.'</b> không đủ hàng'); 
                $content = Cart::content();
                return view('pages.cart.upCart',compact('content'));                
            }else{
                // Session::put('fail_message','failed! deleted '.$test); 
                //Cart::remove($rowId);
               
                $hinhanh= DB::table('hinhanh')->where('sp_ma',$sp_ma)->first(); 
                $sanpham = DB::table('sanpham')->join('khuyenmai','khuyenmai.km_ma','=','sanpham.km_ma')->where('sp_ma',$sp_ma)->first(); 
                $data= array();
                $data['id'] = $sp_ma;
                $data['qty'] = $qty;
                $data['name'] = $sanpham->sp_ten;
                $data['price'] = $sanpham->sp_donGiaBan*(100 - $sanpham->km_giamGia)/100;
                $data['weight'] = 0;
                $data['options']['image'] = $hinhanh->ha_ten;
                $data['options']['mausac'] = $ms_ma;
                $data['options']['size'] = $kc_ma;
                $data['options']['km']= $sanpham->km_ma;
                // Cart::update($rowId, [['qty'  => $qty],['options'  => ['size' => $kc_ma]],['options'  => ['mausac' => $ms_ma]]]);
                // Session::put('fail_message','failed! deleted '.$test." data".$data); 
                // return view("pages.cart.show_cart");
                //Cart::add($data);
                Cart::update($rowId, $data);
                Session::put('success_message','Cập nhật giỏ hàng thành công!');
                $content = Cart::content();
                return view('pages.cart.upCart',compact('content'));
            }
            
            

        }
    }

    public function removeCart()
    {
        Cart::destroy();
        return Redirect::to('/');
    }

}
