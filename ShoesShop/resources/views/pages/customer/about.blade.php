@extends('shop_layout')
@section('content')

 <div class="hero-wrap hero-bread" style="background-image: url({{URL::to('public/frontend/images/bg_6.jpg')}});">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="{{URL::to('/')}}">{{ __('Trang chủ') }}</a></span> <span>{{ __('Giới thiệu') }}</span></p>
            <h1 class="mb-0 bread">{{ __('Giới thiệu về chúng tôi') }}</h1>
          </div>
        </div>
      </div>
    </div>
   
    <section class="ftco-section contact-section bg-light">
      <div class="container">
      	<div class="row d-flex  contact-info">
          <div class="w-100"></div>
    		<div class="col-md-12 d-flex">
    			<div class="info bg-white p-4">
    					
    					
					<h3><b>Giới thiệu</b></h3>

					<h4>ShoesShop là trang mua sắm trực tuyến giày dép dành cho nam, nữ ở mọi lứa tuổi, vừa mang đến các sản phẩm chất lượng vừa giúp bạn tiếp cận xu hướng thời trang mới nhất.</h4>
    					
    				<p class="text-center"><a href="{{URL::to('/')}}" class="btn btn-primary py-3 px-4">{{ __('Trang chủ') }}</a></p>
    			
    		</div>
			</div>
		</div>
	</div>

		</section>
    
@endsection