@extends('admin_layout')
@section('content')

                       


<div class="main-content">
                    <div class="container-fluid">
                        <div class="page-header">
                            <div class="row align-items-end">
                                <div class="col-lg-8">
                                    <div class="page-header-title">
                                        <i class="ik ik-edit bg-blue"></i>
                                        <div class="d-inline">
                                            <h5>Kho</h5>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{URL::to('/dashboard')}}"><i class="ik ik-home"></i></a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#">Quản lý kho</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Phiếu nhập</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
								<div class="card">
                                    <div class="card-header d-block">
                                        <h3>Phiếu nhập mới #{{$ma_pn}} </h3>
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
                                                        <th>Mã sản phẩm</th>  
                                                        <th>Tên sản phẩm</th>
                                                        <th>Đơn giá bán</th>
                                                        <th>Đơn giá nhập</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=1; ?>
                                                	@foreach( $list_pro as $key => $pro)
                                                    <tr>
                                                        <th scope="row">{{$i}}</th>
                                                        <td>{{$pro->sp_ma}}</td>
                                                         
                                                        <td>{{$pro->sp_ten}}</td>
                                                       
                                                        <td>{{$pro->sp_donGiaBan}}</td>
                                                        <td>{{$pro->sp_donGiaNhap}}</td>
                                                        <td><div class="table-actions">
                                                            <a href="{{URL::to('/add-size-good/'.$ma_pn.'/'.$pro->sp_ma)}}"><i class="ik ik-plus-circle"></i></a>
                                                            <a href="{{URL::to('/chinhsua-sanphamnhap/'.$pro->sp_ma)}}"><i class="ik ik-edit-2"></i></a>
                                                            <a href="#"><i class="ik ik-trash-2"></i></a>
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
                    </div>
                </div>


            
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

        $('#kho').parent().addClass('active open');
         $("#phieunhap").addClass("active");
     });
</script>

@endsection