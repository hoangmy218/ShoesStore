@extends('shop_layout')
@section('content')
        <style type="text/css">
/*#cashbtn, #paypal-button {
display: none;
}*/
#cashbtn, #paypalbtn {
display: none;
}

</style>
    <div class="hero-wrap hero-bread" style="background-image: url({{asset('public/frontend/images/bg_6.jpg')}});">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="{{URL::to('/')}}">{{ __('Trang chủ') }}</a></span> <span>{{ __('Thanh toán') }}</span></p>
            <h1 class="mb-0 bread">{{ __('Thanh toán') }}</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
      <div class="container">
            <?php
                $message = Session::get('success');
                if ($message){
                    echo '<span class="alert alert-success">'.$message."</span>";
                    
                    Session::forget('success');
                }
                $message = Session::get('error');
                if ($message){
                    echo '<span class="alert alert-danger">'.$message."</span>";
                    
                    Session::forget('error');
                }
            
            
                $content = Cart::content();
                $count=1;
            ?>
          	<div class="row">
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <table class="table">
                            <thead class="thead-primary">
                                 <tr class="text-center">
                                    <th>{{ __('STT') }}</th>
                                    <th>{{ __('Mã sản phẩm') }}</th>
                                    <th>{{ __('Hình ảnh') }}</th>
                                    <th>{{ __('Tên sản phẩm') }}</th>
                                    <th>{{ __('Kích cỡ') }}</th>
                                    <th>{{ __('Đơn giá') }}</th>
                                    <th>{{ __('Số lượng') }}</th>
                                    <th>{{ __('Thành tiền') }}</th>
                                    
                                </tr>
                            </thead>
                            
                                <tbody>
                                    
                            @foreach($content as $v_content)
                                    <tr class="product-id">
                                        <td class="product-price">
                                            <h4>{{$count++}}</h4>
                                        </td>
                                        <td class="product-id">
                                            <h3>{{$v_content->id}}</h3>
                                            
                                        </td>
                                        <td class="image-prod"><div class="img" style="background-image:url({{URL::to('public/upload/product/'.$v_content->options->image)}});" ></div></td>
                                        
                                        <td class="product-name">
                                            <h3>{{$v_content->name}}</h3>
                                            
                                        </td>
                                        <td class="quantity">
                                            <h3>{{$v_content->options->size}}</h3>                                          
                                        </td>
                                        
                                        <td class="price">{{number_format($v_content->price).' '.'vnđ'}}</td>
                                        
                                        <td class="quantity">
                                            <h4>{{$v_content->qty}}</h4>
                                                        {{-- <inget type="number" name="cart_quantity" class="quantity form-control inget-number" value="{{$v_content->qty}}" min="1" max="100"> --}}       
                                                
                                        </td>
                                        <td class="total">
                                            <p class="cart_total_price">
                                            
                                            <?php
                                            $subtotal = $v_content->price * $v_content->qty;
                                            echo number_format($subtotal).' '.'vnđ';
                                            ?><!-- Tien -->
                                            </p>
                                        </td>
                                        </tr><!-- END TR-->
                                       
                                     @endforeach 
                                </tbody>
                                    
                        </table>
                    </div>
                </div>
            </div>
	         <div class="row mt-5 pt-3 d-flex">
	          	<div class="col-md-12 d-flex">
	          		<div class="cart-detail cart-total bg-light p-3 p-md-4">
	          			<h3 class="billing-heading mb-4">{{ __('Thông tin giao hàng') }}</h3>
	          				<?php 
                                echo '<p class="d-flex"><span>'; 
                                echo __('Họ và tên người nhận').'</span>';
                                echo '<span>'.Session::get('dh_tenNhan').'</span></p>';
                                echo '<p class="d-flex"><span>';
                                echo __('Địa chỉ').'</span>';
						        echo '<span>'.Session::get('dh_diaChiNhan').'</span></p>';
						        echo '<p class="d-flex"><span>';
                                echo __('Điện thoại').'</span>';
						        echo '<span>'.Session::get('dh_dienThoai').'</span></p>';
						        echo '<p class="d-flex"><span>';
                                echo __('Email').'</span>';
						        echo '<span>'.Session::get('dh_email').'</span></p>';
						       
						        echo '<p class="d-flex"><span>';
                                echo __('Ngày đặt').'</span>';
						        $date =date_create(Session::get('dh_ngayDat'));
						        echo '<span>'.date_format($date,"d/m/Y ").'</span></p>';
						        					       
						       echo '<p class="d-flex"><span>';
                               echo __('Hình thức vận chuyển').'</span>';
						        echo '<span>'.Session::get('vc_ten').'</span></p>';
						        echo '<p class="d-flex"><span>';
                                echo __('Ghi chú').'</span>';
						        echo '<span>'.Session::get('dh_ghiChu').'</span></p>';
						    ?>
	          		</div>
                    <div class="cart-detail cart-total bg-light p-3 p-md-4">
                        <h3 class="billing-heading mb-4">{{ __('Tổng tiền thanh toán') }}</h3>
                        <p class="d-flex">
                            <span>{{ __('Cộng tiền') }}</span>
                            <span>{{number_format((double)Cart::subtotal(2,'.','')).' VND'}}</span>
                        </p>
                        <p class="d-flex">
                            <span>{{ __('Phí vận chuyển') }}</span>
                            <?php (int)$phi = Session::get('vc_phi'); ?>
                            <span>{{number_format($phi).' VND'}}</span>
                        </p>
                         <p class="d-flex">
                            <span>{{ __('Khuyến mãi') }}</span>
                            <?php 
                               
                            if (Session::get('tien_giamgia') != null){
                                (int)$giamgia = Session::get('tien_giamgia');
                            } else
                                (int)$giamgia  = 0; ?>
                            <span>{{number_format($giamgia).' VND'}}</span>
                           {{--  <span>Tỉ lệ giảm {{Session::get('ti_le_giamgia')}}</span> --}}
                        </p>
                        
                        <hr>
                        <p class="d-flex total-price">
                            <span>{{ __('Tổng tiền thanh toán') }}</span>
                            <?php $subtt =(double)Cart::subtotal(2,'.',''); ?> {{-- bo dau hang nghin, chuyen sau thap phan thanh , --}}
                            <span>{{number_format($subtt + $phi - $giamgia).' VND'}}</span>
                            <?php Session::put('dh_tongTien',number_format((double)Cart::subtotal(2,'.','')));?>
                        </p>
                    </div>
	          		<div class="cart-detail bg-light p-3 p-md-4">
	          			<form action="{{URL::to('/order-place')}}" method="POST">
							{{csrf_field()}}
		          			<h3 class="billing-heading mb-4">{{ __('Phương thức thanh toán') }}</h3>
		          			<div class="payment-options">
    		          			@foreach($ma_thanhtoan as $key => $matt)
    			          			<div class="form-group">
    									<div class="col-md-12">
    										<div class="paymentradio">
    											<label><input type="radio" name="optradio" id="btn{{$matt->tt_ma}}" value="{{$matt->tt_ma}}" class="mr-2">{{$matt->tt_ten}}</label>
    										</div>
    									</div>
    								</div> 

    	                        @endforeach		
                               {{--  btn1: cash; btn2: paypal	 --}}						
    							<button type="submit" id="cashbtn" class="btn btn-theme btn-primary py-3 px-4">{{ __('Hoàn tất') }}</button>
                                {{-- @include('pages.checkout.paypal2') --}}
                               
							</div>
						
					    </form>
                         @include('pages.checkout.paypal')
                    </div>
                 
	            </div>
            </div> <!-- .col-md-8 -->
        </div>

        {{-- paypal : paypalbtn / paypal2: paypal-button --}}

            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
        <script>
            $(document).ready(function(){

            //dat thi gian tat thong bao
            setTimeout(function(){
               $("span.alert").remove();
            }, 5000 ); // 5 secs

            $('input[id="btn1"]').change(function(){
                $('#cashbtn').show();
                // $('#paypal-button').hide();
                $('#paypalbtn').hide();
            });

            $('input[id="btn2"]').change(function(){
                // $('#paypal-button').show();
                $('#paypalbtn').show();
                $('#cashbtn').hide();
            });
        });

            // $('#paypalbtn').attr('hidden': hidden);
            
        </script>
    </section> <!-- .section -->
		

<br>
<br>

@endsection