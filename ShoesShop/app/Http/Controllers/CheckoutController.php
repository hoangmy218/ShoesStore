<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use Cart;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
{
     public function authLogin(){
        $user_id = Session::get('nd_ma');
        $cv=Session::get('cv_ma');
        
        if (($user_id)&&($cv==2)) 
            return Redirect::to('/Home_u'); 
        else 
            return Redirect::to('/')->send();
    }

    public function checkout()
    {
        $this->authLogin();
        $this->authLogin();
        $content = Cart::content();
        if ($content->isempty()){
            return Redirect::to('/');
        }else {
             //Kiemtra het hang
            $content = Cart::content(); 
            $hethang = 0; //false - con hang
            $outstock = array();
            foreach ($content as $v_content) {
                 $ctsp_ton =  DB::table('chitietsanpham')->where('ctsp_ma', $v_content->id)->first();
                if ( $v_content->qty > $ctsp_ton->ctsp_soLuongTon){
                    $hethang = $hethang+1; //true
                    $outstock[$hethang] = $ctsp_ton->sp_ma;
                }
            } 
            if ($hethang == 1){
                $tenhang = '';
                foreach ($outstock as $key => $value) {
                    $hang = DB::table('sanpham')->where('sp_ma',$value)->select('sp_ten')->first();
                    $tenhang .= ' ';
                    $tenhang .= $hang->sp_ten;
                    if ($key != count($outstock))
                    $tenhang .= ',';
                }
                /*$sizes = DB::Table('chitietsanpham')->select('ctsp_kichCo','ctsp_ma')->where('sp_ma',4)->get(); */
           
                Session::put('message','<b>'.$tenhang.'</b> không đủ hàng');
            }
        	$ma_vanchuyen=DB::table('vanchuyen')->orderby('vc_ma', 'desc')->get();
        	return view("pages.checkout.checkout")->with('ma_vanchuyen', $ma_vanchuyen);
        }
    }

    public function save_checkout_customer(Request $request){
   
        $nd_id = Session::get('nd_ma');
        $time= Carbon::now('Asia/Ho_Chi_Minh');//lấy luôn giờ phút giây
         $dh_ngayDat=$time->toDateString();// chỉ lấy ngày
        Session::put('dh_tenNhan', $request->dh_tenNhan);
        Session::put('dh_diaChiNhan', $request->dh_diaChiNhan);
        Session::put('dh_dienThoai', $request->dh_dienThoai);
        Session::put('dh_email', $request->dh_email);
        Session::put('dh_ghiChu', $request->dh_ghiChu);
        Session::put('dh_ngayDat', $dh_ngayDat);
        /*Session::put('dh_trangThai', 'Chờ xử lý');*/
        // Session::put('dh_tongTien','100000');
        Session::put('vc_ma', $request->vanc_id);
        $vanchuyen=DB::table('vanchuyen')->where('vc_ma',$request->vanc_id)->first();
        Session::put('vc_ten', $vanchuyen->vc_ten);
        Session::put('vc_phi', $vanchuyen->vc_phi);
        // echo Session::get('vc_phi');
    	return Redirect::to('payment');
    }

    //show payment
    public function payment() 
    {
        $this->authLogin();
        $content = Cart::content();
        if ($content->isempty()){
            return Redirect::to('/');
        }else {
            //Kiemtra het hang
            
            $hethang = 0; //false - con hang
            $outstock = array();
            foreach ($content as $v_content) {
                 $ctsp_ton =  DB::table('chitietsanpham')->where('ctsp_ma', $v_content->id)->first();
                if ( $v_content->qty > $ctsp_ton->ctsp_soLuongTon){
                    $hethang = $hethang+1; //true
                    $outstock[$hethang] = $ctsp_ton->sp_ma;
                }
            } 
            if ($hethang == 1){
                $tenhang = '';
                foreach ($outstock as $key => $value) {
                    $hang = DB::table('sanpham')->where('sp_ma',$value)->select('sp_ten')->first();
                    $tenhang .= ' ';
                    $tenhang .= $hang->sp_ten;
                    if ($key != count($outstock))
                    $tenhang .= ',';
                }
                /*$sizes = DB::Table('chitietsanpham')->select('ctsp_kichCo','ctsp_ma')->where('sp_ma',4)->get(); */
           
                Session::put('message','<b>'.$tenhang.'</b> không đủ hàng');
            }
            $ma_vanchuyen=DB::table('vanchuyen')->orderby('vc_ma', 'desc')->get();
        	$ma_thanhtoan=DB::table('thanhtoan')->orderby('tt_ma', 'desc')->get();
        	return view("pages.checkout.payment")->with('ma_thanhtoan', $ma_thanhtoan)->with('ma_vanchuyen', $ma_vanchuyen);
        }
    }

    //add order
    public function orderPlace(Request $request)
    {
        $content = Cart::content(); 
        //them don hang

        if (!$content->isempty()) {

            $data = array();
            $data['dh_tenNhan'] = Session::get('dh_tenNhan');
            $data['dh_diaChiNhan'] = Session::get('dh_diaChiNhan');
            $data['dh_dienThoai'] = Session::get('dh_dienThoai');
            $data['dh_email'] = Session::get('dh_email');
            $data['dh_ghiChu'] = Session::get('dh_ghiChu');
            $data['dh_ngayDat'] = Session::get('dh_ngayDat');
            $data['dh_trangThai'] = 'Chờ xử lý';
            $subtt =(int)Cart::subtotal(2,'.','');
            $data['dh_tongTien'] =  $subtt;
            $data['vc_ma'] = Session::get('vc_ma');
            $data['tt_ma'] = $request->optradio;
            $data['nd_ma'] = Session::get('nd_ma');
            $data['km_ma'] = Session::get('ma_khuyenmai');


           

            //insert chi tiet don hang


            $hethang = 0; //false
            $outstock = array();
            foreach ($content as $v_content) {
                 $ctsp_ton =  DB::table('chitietsanpham')->where('ctsp_ma', $v_content->id)->first();
                if ( $v_content->qty > $ctsp_ton->ctsp_soLuongTon){
                    $hethang = $hethang+1; //true
                    $outstock[$hethang] = $ctsp_ton->sp_ma;
                }
            }
            
            if ($hethang == 0){
                $insert_donhang_id = DB::table('donhang')->insertGetId($data);
                foreach ($content as $v_content) {
                    $order_detail_data = array();
                    $order_detail_data['dh_ma'] = $insert_donhang_id; 
                    $order_detail_data['ctsp_ma'] = $v_content->id;
                    $product = DB::table('chitietsanpham')->join('sanpham','sanpham.sp_ma','=','chitietsanpham.sp_ma')->where('ctsp_ma',$v_content->id)->select('sanpham.sp_ma', 'sp_donGiaNhap','sp_donGiaBan')->first();
                    $order_detail_data['donGiaBan'] = $product->sp_donGiaBan;
                    $order_detail_data['donGiaNhap'] = $product->sp_donGiaNhap;
                    $order_detail_data['soLuongDat'] = $v_content->qty;
                    $order_detail_data['thanhTien'] = $v_content->qty*$v_content->price;            
                    $insert_orderdetail_id = DB::table('chitietdonhang')->insertGetId($order_detail_data);
                    $ctsp_ton = DB::table('chitietsanpham')->where('ctsp_ma', $v_content->id)->first();
                    DB::table('chitietsanpham')->where('ctsp_ma', $v_content->id)->update(['ctsp_soLuongTon' => $ctsp_ton->ctsp_soLuongTon - $v_content->qty]);
                }
                Cart::destroy();
                return Redirect::to('/thankyou');
            }
            else {
                $tenhang = '';
                foreach ($outstock as $key => $value) {
                    $hang = DB::table('sanpham')->where('sp_ma',$value)->select('sp_ten')->first();
                    $tenhang .= ' ';
                    $tenhang .= $hang->sp_ten;
                    if ($key != count($outstock))
                    $tenhang .= ',';
                }
                /*$sizes = DB::Table('chitietsanpham')->select('ctsp_kichCo','ctsp_ma')->where('sp_ma',4)->get(); */
           
                Session::put('message','Đặt hàng không thành công! <b>'.$tenhang.'</b> không đủ hàng');
                return view('pages.cart.show_cart');
            }
        }
            
    }
    

    public function handcash()
    {
        $this->authLogin();
        return view('pages.checkout.handcash');
    }

    public function paypal()
    {
        $this->authLogin();
        return view('pages.checkout.thankyou');
    }

    //Lan show checkout CHI PHI VAN CHUYEN
    public function get_list_transport(){
        $vanchuyen = DB::table("vanchuyen")->pluck("vc_ma","vc_phi");
        return view('shop_layout',compact('vanchuyen'));
    }
    public function get_price(Request $request){
        $vanchuyenphi = DB::table("vanchuyen")->select('vc_phi')
        ->where('vc_ma', $request->vc_ma)->first();
        Session::put('tienvc',$vanchuyenphi->vc_phi);
        return json_encode($vanchuyenphi);
    }

    //NGAN
    // ngân (12/3/2020)
    public function checkCoupon(Request $res){
        $this->authLogin();
        $time= Carbon::now('Asia/Ho_Chi_Minh');
        $dh_ngayDat=$time->toDateString();
        $code = $res->code;
        
        $check = db::table('khuyenmai')
            ->where('km_doanMa',$code)
            ->get();
        // Start Ngân (8/4/2020)
        if(count($check)=="1")
        {
            if($check[0]->km_ngayBD > $dh_ngayDat)
            {
                ?>
                <div class="cart-detail cart-total bg-light p-3 p-md-4">
                       
                        <div class="form-group">
                                <input name="coupon_code" id="coupon_id" class="form-control" rows="3" cols="20" placeholder="<?php echo __('Mã khuyến mãi'); ?>" required>            
                        </div>
                        
                        <p style="color: red;"><b><?php echo __("Vẫn chưa đến thời gian áp dụng khuyến mãi này."); ?></b></p>
                        <div class="sign-btn text-center">
                                <input type="button" value="<?php echo __('Áp dụng'); ?>" id="coupon_btn" class="btn btn-theme btn-primary py-3 px-4">
                        </div>
                         <br>
                        
                        <h3 class="billing-heading mb-4"><?php echo __('Tổng tiền thanh toán'); ?></h3>
                        <p class="d-flex">
                            <span><?php echo __('Cộng tiền'); ?></span>
                            <span><?php echo number_format((double)Cart::subtotal(2,'.','')).' VND'; ?></span>
                        </p>
                        
                        <p class="d-flex">
                            <span><?php echo __('Phí vận chuyển'); ?></span>
                            <?php (int)$phi=Session::get('tienvc'); ?> 
                            <span><?php echo number_format($phi).' VND'; ?></span>
                        </p>
                        
                        
                        <hr>
                        <p class="d-flex total-price">
                            <span><b><?php echo __('Tổng tiền thanh toán'); ?></b></span>
                            <?php $subtt =(int)Cart::subtotal(2,'.',''); ?> 
                            <span>
                                <input id="tong" name="tong" value="<?php echo $subtt; ?>" type="hidden" placeholder="<?php echo gettype($subtt); ?>">
                                <div id="tongtext"><?php echo number_format($subtt+$phi).' VND'; ?></div>
                            </span>
                        </p>
                    </div>
                <?php
            } else if ( $check[0]->km_ngayKT < $dh_ngayDat) 
            {
                ?>
                <div class="cart-detail cart-total bg-light p-3 p-md-4">
                       
                        <div class="form-group">
                                <input name="coupon_code" id="coupon_id" class="form-control" rows="3" cols="20" placeholder="<?php echo __('Mã khuyến mãi'); ?>" required>            
                        </div>
                        
                        <p style="color: red;"><b><?php echo __("Đã qua thời gian áp dụng khuyến mãi này."); ?></b></p>
                        <div class="sign-btn text-center">
                                <input type="button" value="<?php echo __('Áp dụng'); ?>" id="coupon_btn" class="btn btn-theme btn-primary py-3 px-4">
                        </div>
                         <br>
                        
                        <h3 class="billing-heading mb-4"><?php echo __('Tổng tiền thanh toán'); ?></h3>
                        <p class="d-flex">
                            <span><?php echo __('Cộng tiền'); ?></span>
                            <span><?php echo number_format((double)Cart::subtotal(2,'.','')).' VND'; ?></span>
                        </p>
                        
                        <p class="d-flex">
                            <span><?php echo __('Phí vận chuyển'); ?></span>
                            <?php (int)$phi=Session::get('tienvc'); ?> 
                            <span><?php echo number_format($phi).' VND'; ?></span>
                        </p>
                        
                        
                        <hr>
                        <p class="d-flex total-price">
                            <span><b><?php echo __('Tổng tiền thanh toán'); ?></b></span>
                            <?php $subtt =(int)Cart::subtotal(2,'.',''); ?> 
                            <span>
                                <input id="tong" name="tong" value="<?php echo $subtt; ?>" type="hidden" placeholder="<?php echo gettype($subtt); ?>">
                                <div id="tongtext"><?php echo number_format($subtt+$phi).' VND'; ?></div>
                            </span>
                        </p>
                    </div>
                <?php
            }else
            {
                $user_id=Session::get('nd_ma');
                $check_user = db::table('donhang')
                ->where('nd_ma',$user_id)
                ->where('km_ma',$check[0]->km_ma)
                ->count();
               

                if($check_user < $check[0]->km_soLan){
                    // $user_add=db::table('donhang')
                    //    ->insert([
                    //        'km_ma' => $check[0]->km_ma,
                    //        'nd_ma' => $user_id
                    //    ]);
                    Session::put('ma_khuyenmai',$check[0]->km_ma);
                    // $insert_cart_total= db::table('tonggiohang')
                    //     ->insert([
                    //         'tgh_tong' => (double)Cart::subtotal(2,'.',''),
                    //         'km_giamGia' => $check[0]->km_giamGia,
                    //         'nd_ma' => $user_id,   
                    //         'tgh_gtong' => (double)Cart::subtotal(2,'.','')-((double)Cart::subtotal(2,'.','')*$check[0]->km_giamGia)/100
                    //     ]);
                        $giamgia=(double)Cart::subtotal(2,'.','')*$check[0]->km_giamGia/100;
                        Session::put('ti_le_giamgia',$check[0]->km_giamGia);
                        Session::put('tien_giamgia', $giamgia);
                     // Khúc div này làm theo trong clip #31
                    ?>
                    <div class="cart-detail cart-total bg-light p-3 p-md-4">
                       
                        <!-- <div class="form-group">
                                <input name="coupon_code" id="coupon_id" class="form-control" rows="3" cols="20" placeholder="<?php echo __('Mã khuyến mãi'); ?>" required>            
                        </div> -->
                        <p style="color: green;"><b><?php echo __("Áp dụng thành công."); ?></b></p>
                        <div class="sign-btn text-center">
                                <input type="button" value="<?php echo __('Áp dụng'); ?>" id="coupon_btn" class="btn btn-theme btn-primary py-3 px-4">
                        </div>
                         <br>
                        
                        <h3 class="billing-heading mb-4"><?php echo __('Tổng tiền thanh toán'); ?></h3>
                        <p class="d-flex">
                            <span><?php echo __('Cộng tiền'); ?></span>
                            <span><?php echo number_format((double)Cart::subtotal(2,'.','')).' VND'; ?></span>
                        </p>
                        
                        <p class="d-flex">
                            <span><?php echo __('Phí vận chuyển'); ?></span>
                            <?php (int)$phi=Session::get('tienvc'); ?> 
                            <span><?php echo number_format($phi).' VND'; ?></span>
                        </p>
                         <p class="d-flex">
                            <span><?php echo __('Khuyến mãi'); ?></span>
                            <?php $giam= $giamgia; ?> 
                            <span><?php echo '-'.number_format($giam).' VND'; ?></span> 
                        </p>
                        
                        <hr>
                        <p class="d-flex total-price">
                            <span><b><?php echo __('Tổng tiền thanh toán'); ?></b></span>
                            <?php $subtt =(int)Cart::subtotal(2,'.',''); ?> 
                            <span>
                                <input id="tong" name="tong" value="<?php echo $subtt; ?>" type="hidden" placeholder="<?php echo gettype($subtt); ?>">
                                <div id="tongtext"><?php echo number_format($subtt+$phi-$giam).' VND'; ?></div>
                            </span>
                        </p>
                    </div>
                    <?php

                }else{
                    ?>
                    <div class="cart-detail cart-total bg-light p-3 p-md-4">
                       
                        <div class="form-group">
                                <input name="coupon_code" id="coupon_id" class="form-control" rows="3" cols="20" placeholder="<?php echo __('Mã khuyến mãi'); ?>" required>            
                        </div>
                        
                        <p style="color: red;"><b><?php echo __("Giới hạn khuyến mãi đã được sử dụng hết."); ?></b></p>
                        <div class="sign-btn text-center">
                                <input type="button" value="<?php echo __('Áp dụng'); ?>" id="coupon_btn" class="btn btn-theme btn-primary py-3 px-4">
                        </div>
                         <br>
                        
                        <h3 class="billing-heading mb-4"><?php echo __('Tổng tiền thanh toán'); ?></h3>
                        <p class="d-flex">
                            <span><?php echo __('Cộng tiền'); ?></span>
                            <span><?php echo number_format((double)Cart::subtotal(2,'.','')).' VND'; ?></span>
                        </p>
                        
                        <p class="d-flex">
                            <span><?php echo __('Phí vận chuyển'); ?></span>
                            <?php (int)$phi=Session::get('tienvc'); ?> 
                            <span><?php echo number_format($phi).' VND'; ?></span>
                        </p>
                        
                        
                        <hr>
                        <p class="d-flex total-price">
                            <span><b><?php echo __('Tổng tiền thanh toán'); ?></b></span>
                            <?php $subtt =(int)Cart::subtotal(2,'.',''); ?> 
                            <span>
                                <input id="tong" name="tong" value="<?php echo $subtt; ?>" type="hidden" placeholder="<?php echo gettype($subtt); ?>">
                                <div id="tongtext"><?php echo number_format($subtt+$phi).' VND'; 
                                 Session::put('ma_khuyenmai',0);?></div>
                            </span>
                        </p>
                    </div>
                    <?php
                
                }
            }
            
        }else
        {
            ?>
            <div class="cart-detail cart-total bg-light p-3 p-md-4">
                   
                <div class="form-group">
                    <input name="coupon_code" id="coupon_id" class="form-control" rows="3" cols="20" placeholder="<?php echo __('Mã khuyến mãi'); ?>" required>            
                </div>
                    
                <p style="color: red;"><b><?php echo __("Mã khuyến mãi không tồn tại. Vui lòng nhập lại!"); ?></b></p>
                <div class="sign-btn text-center">
                    <input type="button" value="<?php echo __('Áp dụng'); ?>" id="coupon_btn" class="btn btn-theme btn-primary py-3 px-4">
                </div>
                <br>
                    
                <h3 class="billing-heading mb-4"><?php echo __('Tổng tiền thanh toán'); ?></h3>
                <p class="d-flex">
                    <span><?php echo __('Cộng tiền'); ?></span>
                    <span><?php echo number_format((double)Cart::subtotal(2,'.','')).' VND'; ?></span>
                </p>
                    
                <p class="d-flex">
                    <span><?php echo __('Phí vận chuyển'); ?></span>
                    <?php (int)$phi=Session::get('tienvc'); ?> 
                    <span><?php echo number_format($phi).' VND'; ?></span>
                </p>
                    
                    
                <hr>
                <p class="d-flex total-price">
                    <span><b><?php echo __('Tổng tiền thanh toán'); ?></b></span>
                    <?php $subtt =(int)Cart::subtotal(2,'.',''); ?> 
                    <span>
                        <input id="tong" name="tong" value="<?php echo $subtt; ?>" type="hidden" placeholder="<?php echo gettype($subtt); ?>">
                        <div id="tongtext"><?php echo number_format($subtt+$phi).' VND'; 
                         Session::put('ma_khuyenmai',0); ?></div>
                    </span>
                </p>
            </div>
            <?php
            
        }
    // End Ngân (8/4/2020)
    }
}


