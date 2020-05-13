@extends('shop_layout')
@section('content')
 <div class="hero-wrap hero-bread" style="background-image: url({{URL::to('public/frontend/images/bg_6.jpg')}});">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="{{URL::to('/')}}">{{ __('Trang chủ') }}</a></span> <span>{{ __('Thông tin của tôi') }}</span></p>
            <h1 class="mb-0 bread">{{ __('Thông tin của tôi') }}</h1>
          </div>
        </div>
      </div>
    </div>
    <section class="ftco-section ftco-cart">
			<div class="container">
                <?php
                $message = Session::get('message');
                if ($message){
                    echo '<span class="alert alert-success">'.$message."</span>";
                    
                    Session::forget('message');
                }
                $message = Session::get('error');
                if ($message){
                    echo '<span class="alert alert-danger">'.$message."</span>";
                    
                    Session::forget('error');
                }
            ?>
               
    		<div class="row justify-content-start">
    			<div class="col col-lg-12 col-md-12 mt-5 cart-wrap ftco-animate">
    				<div class="cart-total mb-3">
    					<h3 class="billing-heading mb-4">{{ __('Thông tin của tôi') }}</h3>
    					
    					@foreach($nguoi_dung as $key => $ndma)
    					<p class="d-flex">
    						<span>{{ __('Mã khách hàng') }}</span>
    						<span>{{$ndma->nd_ma}}</span>
    					</p>
	          			<p class="d-flex">
    						<span>{{ __('Họ và tên') }}</span>
    						<span>{{$ndma->nd_ten}}</span>
    					</p>
    					<p class="d-flex">
    						<span>{{ __('Email') }}</span>
    						<span>{{$ndma->nd_email}}</span>
    					</p>
    					<p class="d-flex">
    						<span>{{ __('SĐT') }}</span>
    						<span>{{$ndma->nd_dienThoai}}</span>
    					</p>
    					<p class="d-flex">
    						<span>{{ __('Giới tính') }}</span>
    					
    						@if($ndma->nd_gioiTinh==1)
    							<span>{{ __('Nữ') }}</span>
    						@else
    							<span>{{ __('Nam') }}</span>
    						@endif
    						
    					</p>
    					<p class="d-flex">
    						<span>{{ __('Ngày sinh') }}</span>
    						<span>{{date('d/m/Y',strtotime($ndma->nd_ngaySinh))}}</span>
    					</p>
    					<p class="d-flex">
    						<span>{{ __('Địa chỉ') }}</span>
    						<span>{{$ndma->nd_diaChi}}</span>
    					</p>
    					@endforeach
    				</div>
    				<p class="text-center"><a href="{{URL::to('/chinhsua-thongtin')}}" class="btn btn-primary py-3 px-4">{{ __('Chỉnh sửa thông tin của tôi') }}</a></p>
    			</div>
    		</div>
			</div>
		</section>
    
@endsection

