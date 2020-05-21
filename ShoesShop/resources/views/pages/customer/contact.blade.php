@extends('shop_layout')
@section('content')

 <div class="hero-wrap hero-bread" style="background-image: url({{URL::to('public/frontend/images/bg_6.jpg')}});">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="{{URL::to('/')}}">{{ __('Trang chủ') }}</a></span> <span>{{ __('Liên hệ') }}</span></p>
            <h1 class="mb-0 bread">{{ __('Liên hệ với chúng tôi') }}</h1>
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
    					
    					
					<h3><b>Địa chỉ chúng tôi</b></h3>

					<h4>888A Đường 3/2, P. Xuân Khánh, Q. Ninh Kiều, Tp.Cần Thơ</h4>

					<h3><b>Email chúng tôi</b></h3>

					<h4>Shoesshop@gmail.com</h4>

					<h3><b>Điện thoại</b></h3>

					<h4>034 888 3338</h4>

					<h3><b>Thời gian làm việc</b></h3>

					<h4>Từ 9:00 đến 21:00 tất cả các ngày trong tuần.</h4>


    					
    				<p class="text-center"><a href="{{URL::to('/')}}" class="btn btn-primary py-3 px-4">{{ __('Trang chủ') }}</a></p>
    			
    		</div>
			</div>
		</div>
	</div>

		</section>
    
@endsection