@extends('shop_layout')
@section('content')
	<div class="hero-wrap hero-bread" style="background-image: url({{asset('public/frontend/images/bg_6.jpg')}});">
     	<div class="container">
        	<div class="row no-gutters slider-text align-items-center justify-content-center">
          		<div class="col-md-9 ftco-animate text-center">
          			<p class="breadcrumbs"><span class="mr-2"><a href="{{URL::to('/')}}">{{ __('Trang chủ') }}</a></span> <span>{{ __('Đơn hàng của tôi') }}</span></p>
            		<h1 class="mb-0 bread">{{ __('Đơn hàng của tôi') }}</h1>
          		</div>
        	</div>
      	</div>
    </div>

    <section class="ftco-section">
    	<div class="container">
        	<?php
                    $message = Session::get('fail_message');
                    if ($message){
                        echo '<span class="alert alert-danger">'.$message."</span>";
                        
                        Session::put('fail_message',null);
                    }
                    $message = Session::get('success_message');
                    if ($message){
                        echo '<span class="alert alert-success">'.$message."</span>";
                        
                        Session::put('success_message',null);
                    }
                ?>
				@if ($orders->isempty())
                <p class="text-center "><span class="alert alert-danger" >Chưa có đơn hàng nào!</span><br><br><a href="{{URL::to('/')}}" class="btn btn-primary py-3 px-4">{{ __('Mua sắm ngay') }}</a></p>
            @else
          		<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="cart-list">
                        
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>{{ __('STT') }}</th>
						        <th>{{ __('Mã đơn hàng') }}</th>
						        <th>{{ __('Người nhận') }}</th>
						        <th>{{ __('Ngày đặt') }}</th>
						        <th>{{ __('Tổng tiền') }}</th>
						        <th>{{ __('Trạng thái') }}</th>
						        
						        <th>&nbsp;</th>
                                <th>{{ __('Xem chi tiết') }}</th>
						      </tr>
						    </thead>
						    <tbody>
                                <?php {{$i=1;}} ?>
                                @foreach( $orders as $key => $order)
								<tr>
                                    <th scope="row">{{$i}}</th>
                                    <td>{{$order->dh_ma}}</td>
                                    <td>{{$order->dh_tenNguoiNhan}}</td>
                                    <td>{{$order->dh_ngayDat}}</td>
                                    <td>{{number_format($order->dh_tongTien).' VND'}}</td>
                                    <?php
                                    $donhang=DB::table('trangthai')->where('tt_ma', $order->tt_ma)->get();
                                    ?>
                                    @foreach($donhang as $key =>$dh)
                                    <td>{{$dh->tt_ten}}</td>
                                    <td class="product-remove"> {{-- Hủy đơn M --}}
                                        @if ($dh->tt_ten != 'Đã hủy')
                                    <a onclick="<?php echo "return confirm('"; ?>{{ __("Bạn có chắc chắn muốn hủy đơn hàng này?") }}<?php echo "')";?>" class="ion-ios-close" href="{{URL::to('/cus-cancel-order/'.$order->dh_ma)}}"><i class="fa fa-times"></i></a>
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                    @endforeach
                                     <td><a href="{{URL::to('/view-customerdetails/'.$order->dh_ma)}}" class="btn btn-primary py-2 px-3">{{ __('Xem thêm') }}</a></td>
                                </tr>
                                <?php {{$i++;}} ?>
                                @endforeach
                                </tbody>
						  </table>
					  </div>
    			</div>
    		</div>
            @endif


	         
	          	</div>
          
      
    </section> <!-- .section -->

@endsection