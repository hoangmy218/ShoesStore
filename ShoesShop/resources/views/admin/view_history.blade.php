@extends('admin_layout')
@section('content')

<div class="main-content">
                    <div class="container-fluid">
                        <div class="page-header">
                            <div class="row align-items-end">
                                <div class="col-lg-8">
                                    <div class="page-header-title">
                                        <i class="ik ik-credit-card bg-blue"></i>
                                        <div class="d-inline"> 
                                             @foreach($ten as $key => $nd)
                                            <h5>Lịch sử mua hàng của người dùng {{$nd->nd_ten}}</h5>
                                            {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{URL::to('/dashboard')}}"><i class="ik ik-home"></i></a>
                                            </li>
                                            <li class="breadcrumb-item active">
                                               
                                                <a href="{{URL::to('/history-customer')}}">Quản lý lịch sử</a>
                                                
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Lịch sử đơn</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
								<div class="card">
                                    <div class="card-header d-block">
                                        <h3>Danh sách đơn hàng của người dùng</h3>
                                        <?php
                                        $message =Session::get('message');
                                        if($message){
                                          echo '<span class="text-alert">'.$message.'</span>';
                                          Session::put('message', null);
                                        }
                                      ?>
                                    </div>
                                    <div class="card-body p-0 table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Mã đơn hàng</th>
                                                        <th>Người nhận</th>
                                                        <th>Ngày đặt</th>
                                                        <th>Tổng tiền</th>
                                                        <th>Trạng Thái</th>
                                                        <th>Xem chi tiết</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php {{$i=1;}} ?>
                                                	@foreach( $don_hang as $key => $don_hang)

                                                    <tr>
                                                        <th scope="row">{{$i}}</th>
                                                        <td>{{$don_hang->dh_ma}}</td>
                                                        <td>{{$don_hang->dh_tenNhan}}</td>
                                                        <td>{{date('d-m-Y',strtotime($don_hang->dh_ngayDat))}}</td>
                                                        <td>{{$don_hang->dh_tongTien}}</td>
                                                        <td>{{$don_hang->dh_trangThai}}</td>
                                                        {{-- @foreach($tam as $key => $tam)
                                                        <td>{{$tam}}</td>
                                                        @endforeach --}}
                                                        {{-- <td>{{$don_hang->dh_ngayDat}}</td>
                                                        <td>{{$don_hang->thanhTien}}</td> --}}
                                                        <td><div class="">                                                  
                                                           <a href="{{URL::to('/view-order/'.$don_hang->dh_ma)}}"><i class="ik ik-eye"></i></a>
                                                        </div></td>
                                                    </tr>
                                                    <?php {{$i++;}} ?>
                                                   	@endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

        $('#nguoidung').parent().addClass('active open');
         $("#lichsumua").addClass("active");
     });
</script>
            


@endsection