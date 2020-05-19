@extends('shop_layout')
@section('content')
	<div class="hero-wrap hero-bread" style="background-image: url({{asset('public/frontend/images/bg_6.jpg')}});">
     	<div class="container">
        	<div class="row no-gutters slider-text align-items-center justify-content-center">
          		<div class="col-md-9 ftco-animate text-center">
          			<p class="breadcrumbs"><span class="mr-2"><a href="{{URL::to('/')}}">{{ __('Trang chủ') }} </a></span> <span>{{ __('Đơn hàng của tôi') }}</span></p>
            		<h1 class="mb-0 bread">{{ __('Đơn hàng của tôi') }}</h1>
          		</div>
        	</div>
      	</div>
    </div>

    <section class="ftco-section">
    	<div class="container">
        	   <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <table class="table" border="0">
                            <thead class="thead-primary">
                              <tr class="text-center">
                                <th><h3 class=" float-left">{{ __('Mã đơn hàng') }}: {{$order->dh_ma}}</h3></th>
                                <th></th>
                                <th><h3 class=" float-right">{{ __('Ngày đặt') }}: {{date('d-m-Y',strtotime($order->dh_ngayDat))}}</h3></th>
                                
                                <th>&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody>
                                <td class=" float-left " > 
                                        {{ __('Người gửi') }} 
                                        <address>
                                            <strong>Shoesshop</strong><br>{{ __('888A Đường 3/2, Quận Ninh Kiều, Thành phố Cần Thơ') }}<br>{{ __('SĐT') }}: 034 888 3338<br>{{ __('Email') }}: shoesshop@gmail.com
                                        </address>
                                </td>
                                <td>
                                    {{ __('Người nhận') }} 
                                        <address>
                                            <strong>{{$order->dh_tenNguoiNhan}}</strong><br>{{$order->dh_diaChiNhan}}<br>{{ __('SĐT') }}: {{$order->dh_dienThoaiNhan}}<br>
                                        </address>
                                </td>
                                <td>
                                         
                                        <b>{{ __('Hình thức vận chuyển') }}:</b> {{$order->htvc_ten}}<br>
                                        <b>{{ __('Ghi chú') }}:</b> {{$order->dh_ghiChu}}
                                </td>
                            </tbody>
                          </table>
                      </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <table class="table">
                            <thead class="thead-primary">
                              <tr class="text-center">
                                <th>{{ __('STT') }}</th>
                                <th>{{ __('Tên sản phẩm') }}</th>
                                <th>Màu sắc</th>
                                <th>Kích thước</th>
                                <th>{{ __('Số lượng') }}</th>
                                <th>{{ __('Đơn giá') }}</th>
                                <th>Khuyến mãi</th>
                                <th>{{ __('Thành tiền') }}</th>
                                <th>&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i=1;
                                    $congTien=0;
                                    ?>
                                @foreach($items as $key => $item)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$item->sp_ten}}</td>

                                    <?php
                                    $tablemausac =DB::table('mausac')->where('ms_ma',$item->ms_ma)->get();
                                    ?>
                                    @foreach($tablemausac as $key => $ms)
                                    <td>{{$ms->ms_ten}}</td>
                                    @endforeach
                                    <?php
                                    $tablesize =DB::table('kichco')->where('kc_ma',$item->kc_ma)->get();
                                    ?>
                                    @foreach($tablesize as $key => $kc)
                                    <td>{{$kc->kc_ten}}</td>
                                    @endforeach


                                    <td>{{$item->SoLuongDat}}</td>
                                    <td>{{number_format($item->DonGiaBan).' VND'}}</td>
                                    <?php
                                    //Lan chỉnh sửa 18/05/2020
                                    $khuyenmai=DB::table('khuyenmai')->where('km_ma', $item->km_ma)->get();
                                    ?>
                                    @foreach($khuyenmai as $key => $km)
                                    <td>{{$km->km_chuDe}}</td>
                                    @endforeach
                                    <td>{{number_format($item->DonGiaBan*$item->SoLuongDat).' VND'}}</td>
                                    <?php $congTien = $congTien + $item->DonGiaBan*$item->SoLuongDat; ?>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                      </div>
                </div>
            </div>
            

            <div class="row">
                <div class="col-6">
                    <p class="lead">{{ __('Phương thức thanh toán') }}:</p>
                    <b>{{$order->httt_ten}}</b>
                    <p class="lead">{{ __('Trạng thái thanh toán') }}:</p>
                     @if ($order->httt_ten=='Tiền mặt')
                        <b>{{ __('Chưa thanh toán') }}</b>
                    @else
                         <b>{{ __('Đã thanh toán') }}</b>
                    @endif
                </div>
                <div class="col-6 d-flex">
                   
                        <div class="cart-detail cart-total bg-light p-3 p-md-4">
                            <h3 class="billing-heading mb-4">TỔNG TIỀN THANH TOÁN</h3>
                            <p class="d-flex">
                                        <span>{{ __('Cộng tiền') }}</span>
                                        <span>{{number_format($congTien).' VND'}}</span>
                                    </p>
                                    <p class="d-flex">
                                        <span>{{ __('Phí vận chuyển') }}</span>
                                        <span>{{number_format($order->htvc_phi).' VND'}}</span>
                                    </p>
                                    
                                    <hr>
                                    <p class="d-flex total-price">
                                        <span>{{ __('Tổng tiền thanh toán') }}</span>
                                        <span>{{number_format($congTien+$order->htvc_phi).' VND'}}</span>
                                    </p>
                        </div>
                    </div>
                {{-- <div class="table-responsive">
                <table class="table">
                    <tr align="left">
                        <th style="width:50%">: </th>
                    </tr>
                    <tr align="left">
                        <th>: 
                            
                            
                    <tr align="left" >
                        <th>: </th>
                    </tr>
                    <tr align="left" >
                        <th>: </th>
                    </tr>
                </table>
                </div> --}}
                
            </div>
            <div>
        </div>
          
      
    </section> <!-- .section -->

@endsection