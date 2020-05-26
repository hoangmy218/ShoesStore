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
    					
    					
					<h3><b>Quy định đổi hàng:</b></h3>

					<h4>- Hạn đổi hàng là 5 ngày kể từ lúc nhận (căn cứ theo thời điểm phát hàng thành công từ phía Nhà vận chuyển).</h4>
          <h4>- Sản phẩm đổi phải còn nguyên tem mạc, chưa giặt, chưa qua sử dụng.</h4>
          <h4>- Khách hàng thanh toán toàn bộ phí vận chuyển phát sinh.</h4>
          <h4>- Chúng tôi không nhận trả hàng, hoàn tiền cho sản phẩm đã mua</h4>
          <br>

					<h3><b>Sản phẩm đổi trả quý khách gửi về:</b></h3>

					<h4>ShoesShop</h4>

          <h4>888A Đường 3/2, P. Xuân Khánh, Q. Ninh Kiều, Tp.Cần Thơ</h4>

          <h4>Điện thoại: 034 888 3338</h4>

					<h4><b>Lưu ý: </b>Quý khách vào website, đặt sản phẩm muốn đổi. Tổng giá trị đơn hàng mới phải bằng hoặc lớn hơn đơn hàng đổi.
Khi nhân được hàng trả, nhân viên sẽ liên hệ và ship hàng đổi cho quý khách.</h4>

    					
    				<p class="text-center"><a href="{{URL::to('/')}}" class="btn btn-primary py-3 px-4">{{ __('Trang chủ') }}</a></p>
    			
    		</div>
			</div>
		</div>
	</div>

		</section>
    
@endsection