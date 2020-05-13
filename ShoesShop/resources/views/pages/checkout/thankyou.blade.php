@extends('shop_layout')
@section('content')
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
            ?>
    		<div class="row mt-5 pt-3 d-flex">
	          	<div class="col-md-12 d-flex">
	          		<div class="cart-detail cart-total bg-light p-3 p-md-4">
	          			<h3 class="billing-heading mb-4">{{ __('Hoàn tất đặt hàng') }}</h3>
                    	<p class="d-flex">
                        	<span>
								<p>{{ __("Cảm ơn Quý khách đã mua sắm tại SHOESSHOP! Sản phẩm sẽ được đóng gói và giao cho đơn vị vận chuyện nhanh nhất. Bạn có thể xem trạng thái đơn hàng của mình tại mục 'Đơn hàng của tôi'. Nếu bạn có bất kỳ thắc mắc gì về vấn đề thanh toán, xin hãy liên hệ ngay chúng tôi tại mục 'Liên hệ'.") }}
								</p>
								<p>{{ __('Chúc Quý khách có những trải nghiệm mua sắm tuyệt vời tại SHOESSHOP!') }}</p>
							</span>
						</p>
						<a href="{{URL::to('/')}}" class="btn btn-primary py-3 px-4">{{ __('Trang chủ') }}</a>
					</div>

				</div>
			</div>
		</div>
	</section>

	

@endsection