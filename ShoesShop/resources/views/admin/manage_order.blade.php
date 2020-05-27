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
                                            <h5>Quản lý đơn hàng</h5>
                                            {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
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
                                                <a href="#">Quản lý đơn hàng</a>
                                            </li>
                                            {{-- <li class="breadcrumb-item active" aria-current="page">Bootstrap Tables</li> --}}
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-2 clearfix">
                                    <div class="btn-group float-md-left mr-1 mb-1">
                                                <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Lọc
                                                    <i class="ik ik-chevron-down mr-0 align-middle"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{URL::to('/manage-order/')}}">Tất cả đơn hàng</a>
                                                    @foreach ( $status_orders as $key => $status)
                                                    <a class="dropdown-item" href="{{URL::to('/filter-order/'.$status->tt_ma)}}">{{$status->tt_ten}}</a>
                                                    @endforeach
                                                   
                                                </div>
                                            </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-2 clearfix">
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
                                </div>
                            </div>
                        </div>
                        @if ( !($orders->isempty()))
                        <div class="row">

                            <div class="col-md-12">
								<div class="card">
                                    <div class="card-header d-block">
                                        <h3>Danh sách đơn hàng</h3>
                                        
                                    </div>
                                    <div class="card-body p-0 table-border-style">
                                        <div class="table-responsive">
                                            {{-- Searching --}} 
                                            {{-- <div class="row col-md-12">
                                                <div class="search-md d-inline-block float-md-left mr-1 mb-1 align-top">
                                                <form action="">
                                                    <input type="text" class="form-control" placeholder="Search.." required>
                                                    <button type="submit" class="btn btn-icon"><i class="ik ik-search"></i></button>
                                                    <button type="button" id="adv_wrap_toggler" class="adv-btn ik ik-chevron-down dropdown-toggle" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                    <div class="adv-search-wrap dropdown-menu dropdown-menu-right" aria-labelledby="adv_wrap_toggler">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Full Name">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="email" class="form-control" placeholder="Email">
                                                        </div>
                                                        <button class="btn btn-theme">Search</button>
                                                    </div>
                                                </form>
                                            </div> --}}
                                            </div>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Mã đơn hàng</th>
                                                        <th>Tên người mua</th>
                                                        <th>Thông tin giao hàng</th>
                                                        <th>Ngày đặt hàng</th>
                                                        
                                                        <th>Hình thức thanh toán</th>
                                                        <th>Tổng tiền</th>
                                                        <th>Trạng thái</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=1; ?>
                                                	@foreach( $orders as $key => $order)
                                                    <tr>
                                                        <th scope="row">{{$i}}</th>
                                                        <td>{{$order->dh_ma}}</td>
                                                        <td>{{$order->nd_ten}}</td>
                                                        <td>{{$order->dh_tenNguoiNhan}} / {{$order->dh_diaChiNhan}} / {{$order->dh_dienThoaiNhan}} / {{$order->htvc_ten}} </td>
                                                        <td>{{date('d-m-Y',strtotime($order->dh_ngayDat))}}</td>
                                                        
                                                        <td>{{$order->httt_ten}}</td>
                                                        <td>{{number_format($order->dh_tongTien).' VND'}}</td>
                                                        <td>
                                                            @switch($order->tt_ma)
                                                                @case(1)
                                                                   <span class="badge badge-pill badge-warning">{{$order->tt_ten}}</span>
                                                                    @break

                                                                @case(2)
                                                                    <span class="badge badge-pill badge-primary">{{$order->tt_ten}}</span>
                                                                    @break

                                                                @case(3)
                                                                    <span class="badge badge-pill badge-info">{{$order->tt_ten}}</span>
                                                                    @break
                                                                @case(4)
                                                                   <span class="badge badge-pill badge-success">{{$order->tt_ten}}</span>
                                                                    @break
                                                                @case(5)
                                                                   <span class="badge badge-pill badge-danger">{{$order->tt_ten}}</span>
                                                                    @break
                                                                    
                                                            @endswitch
                                                            </td>
                                                        <td><div class="table-actions" style="text-align: left">
                                                            
                                                                
                                                           @switch($order->tt_ma)
                                                                @case(1)
                                                                    <button type="button" id="{{$order->dh_ma}}" class="btn btn-primary approve" data-toggle="modal" >Duyệt</button>
                                                                    @break

                                                                @case(2)
                                                                    <button type="button" id="{{$order->dh_ma}}" class="btn btn-info ship" data-toggle="modal" >Sẵn sàng giao</button>
                                                                    @break

                                                                @case(3)
                                                                    <button type="button" id="{{$order->dh_ma}}" class="btn btn-success complete" data-toggle="modal" >Hoàn tất</button>
                                                                    @break
                                                                @default
                                                                    
                                                            @endswitch
                                                            <br>
                                                            <a href="{{URL::to('/view-order/'.$order->dh_ma)}}"><i class="ik ik-eye f-16 mr-15 text-blue"></i></a>  
                                                            @if (($order->tt_ma != 5 ) && ($order->tt_ma != 4) )
                                                            <i class="ik ik-x-circle cancel text-red" id="{{$order->dh_ma}}"></i>
                                                            @endif
                                                             {{-- <button type="button"  class="btn btn-danger " ><i class="ik ik-x-circle cancel" id="{{$order->dh_ma}}" ></i></button> --}}
                                                            
                                                        </div></td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                   	@endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Duyệt đơn hàng</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn duyệt đơn hàng này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_approve_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="shipModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Sẵn sàng giao</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn đã sẵn sàng giao đơn hàng này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_ship_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="completeModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Hoàn tất đơn hàng</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn đã giao hoàn tất đơn hàng này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_complete_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Hủy đơn hàng</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn hủy đơn hàng này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_cancel_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
            
<script src="{{asset('public/backend/js/layouts.js')}}"></script>
<script src="{{asset('public/backend/plugins/sweetalert/dist/sweetalert.min.js')}}"></script>
<script src="{{asset('public/backend/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
<script src="http://www.codermen.com/js/jquery.js"></script>
<script>
    $(document).ready(function(){
        $( '#donhang').parent().addClass('active');

        //dat thi gian tat thong bao
        setTimeout(function(){
           $("span.alert").remove();
        }, 5000 ); // 5 secs

        var dh_ma;

        //duyet 
        $(document).on('click','.approve', function(){
            dh_ma = $(this).attr('id');
            $('#approveModal').modal('show');

        });

        $('#ok_approve_btn').click(function(){
            $.ajax({
                url: '<?php echo url('approve-order');?>/'+dh_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php echo url('/manage-order');?>");
                }
            });
        });

        //giao
        $(document).on('click','.ship', function(){
            dh_ma = $(this).attr('id');
            $('#shipModal').modal('show');

        });

        $('#ok_ship_btn').click(function(){
            $.ajax({
                url: '<?php echo url('ship-order');?>/'+dh_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php echo url('/manage-order');?>");
                }
            });
        });

        //hoan tat
        $(document).on('click','.complete', function(){
            dh_ma = $(this).attr('id');
            $('#completeModal').modal('show');

        });

        $('#ok_complete_btn').click(function(){
            $.ajax({
                url: '<?php echo url('complete-order');?>/'+dh_ma,
                type: 'get',
                success: function(data)
                {
                    /* location.reload();*/
                    window.location.replace("<?php echo url('/manage-order');?>");
                }
            });
        });

        //huy

        
        $(document).on('click','.cancel', function(){
            dh_ma = $(this).attr('id');
            $('#cancelModal').modal('show');

        });

        $('#ok_cancel_btn').click(function(){
            $.ajax({
                url: '<?php echo url('cancel-order');?>/'+dh_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php echo url('/manage-order');?>");
                }
            });
        });

    });
</script>

@endsection