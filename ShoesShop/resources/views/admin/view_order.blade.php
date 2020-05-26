@extends('admin_layout')
@section('content')

<div class="main-content">
                    <div class="container-fluid">
                        <div class="page-header">`
                            <div class="row align-items-end">
                                <div class="col-lg-8">
                                    <div class="page-header-title">
                                        <i class="ik ik-file-text bg-blue"></i>
                                        <div class="d-inline">
                                            <h5>Đơn hàng</h5>
                                           {{--  <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{URL::to('/dashboard')}}"><i class="ik ik-home"></i></a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="{{URL::to('/manage-order')}}">Quản lý đơn hàng</a>
                                            </li>
                                            
                                            <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header"><h3 class="d-block w-100">Mã đơn hàng: {{$order->dh_ma}} <small class="float-right">Ngày đặt: {{date('d-m-Y',strtotime($order->dh_ngayDat))}}</small></h3></div>
                            <div class="card-body">
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        Người đặt
                                        <address>
                                            <strong>{{$order->nd_ten}}</strong><br>{{$order->nd_diaChi}} <br>Phone: {{$order->nd_dienThoai}}<br>Email: {{$order->nd_email}}
                                        </address>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        Người nhận
                                        <address>
                                            <strong>{{$order->dh_tenNguoiNhan}}</strong><br>{{$order->dh_diaChiNhan}}<br>Phone: {{$order->dh_dienThoaiNhan}}<br>
                                        </address>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        <b>Mã đơn hàng #{{$order->dh_ma}}</b><br>          
                                        <b>Hình thức vận chuyển:</b> {{$order->htvc_ten}}<br>
                                        <b>Hình thức thanh toán:</b> {{$order->httt_ten}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>                                                
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tên sản phẩm</th>                                                   
                                                    <th>Màu sắc</th>
                                                    <th>Kích cỡ</th>                                                    
                                                    <th>Đơn giá</th>
                                                    <th>Số lượng</th>
                                                    <th>Thành tiền</th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $i=1;
                                                    $congTien=0;
                                                    $thanhTien=0;

                                                ?>
                                                @foreach($items as $item)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$item->sp_ten}}</td>
                                                    <td>{{$item->ms_ten}}</td>
                                                    <td>{{$item->kc_ten}}</td>  
                                                    <td>{{number_format($item->DonGiaBan).' VND'}}</td>
                                                    <td>{{$item->SoLuongDat}}</td>
                                                    <?php $thanhTien = $item->DonGiaBan * $item->SoLuongDat; ?>
                                                    <td>{{number_format($thanhTien).' VND'}}</td>
                                                    <?php $congTien = $congTien + $thanhTien; ?>
                                                </tr>
                                                 @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <p class="lead">Phương thức thanh toán:</p>
                                        <h5><b>{{$order->httt_ten}}</b></h5>
                                        <p class="lead">Trạng thái thanh toán:</p>
                                        @if ($order->httt_ten=='Tiền mặt')
                                            <h5><b>Chưa thanh toán</b></h5>
                                        @else
                                             <h5><b>Đã thanh toán</b></h5>
                                        @endif
                                        {{-- <img src="{{URL::to('public/backend/img/credit/visa.png')}}" alt="Visa">
                                        <img src="{{URL::to('public/backend/img/credit/mastercard.png')}}" alt="Mastercard">
                                        <img src="{{URL::to('public/backend/img/credit/american-express.png')}}" alt="American Express">
                                        <img src="{{URL::to('public/backend/img/credit/paypal2.png')}}" alt="Paypal"> --}}
                                        <p class="lead">Ghi chú:</p>
                                        <div class="alert alert-secondary mt-20">
                                          {{$order->dh_ghiChu}}
                                        </div>
                                    </div>
                                    <div class="col-6">
                                       {{--  <p class="lead">Amount Due 10/11/2018</p> --}}
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th style="width:50%">Cộng tiền:</th>
                                                    <td>{{number_format($congTien).' VND'}}</td>
                                                </tr>
                                               <?php 
                                                            $disc = 0; 
                                                        /*if (($order->km_ma != NULL) || ($order->km_ma != 0))
                                                            $disc = $congTien*$order->km_giamGia/100;*/
                                                        
                                                                                                                   
                                                        ?>
                                                        
                                                   
                                                <tr>
                                                    <th>Phí vận chuyển:</th>
                                                    <td>{{number_format($order->htvc_phi).' VND'}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tổng tiền thanh toán:</th>
                                                    <td>{{number_format($congTien + $order->htvc_phi - $disc).' VND'}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-print">
                                    <div class="col-12">
                                        {{-- <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button> --}}
                                        <a href="{{URL::to('/createOrderPdf/'.$order->dh_ma)}}"><button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Tải về PDF</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <script src="http://www.codermen.com/js/jquery.js"></script>
    <script>
        $(document).ready(function(){
            $( '#donhang').parent().addClass('active');
        });
    </script>
@endsection
