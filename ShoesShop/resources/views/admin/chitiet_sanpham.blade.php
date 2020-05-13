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
                            @foreach($list as $key => $sp)
                            <h5> Mã {{$sp->sp_ma}} : {{$sp->sp_ten}}</h5>
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
                                <a href="{{URL::to('/manage-product')}}">Quản lý sản phẩm</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
                        </ol>
                    </nav>
                 </div>
            </div>
        </div>
        {{-- THÊM+CHỈNH SƯA --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h3>Hình ảnh của sản phẩm</h3>
                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã ảnh</th>
                                        <th>Tên ảnh</th>
                                        <th>Nội dung ảnh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php 
                                        $hinhanh= DB::table('hinhanh')->where('sp_ma',$sp->sp_ma)->get();
                                        ?>
                                    <?php $i=1; ?>
                                    @foreach( $hinhanh as $key => $ha)
                                    <tr>
                                        <th scope="row">{{$i}}</th>
                                        <th scope="row">{{$ha->ha_ma}}</th>
                                        <th scope="row">{{$ha->ha_ten}}</th>
                                        <td><img src="{{URL::to('public/upload/product/'.$ha->ha_ten)}}" height="100" width="100"></td> 
                                    </tr>
                                    <?php $i++; ?>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                </div>                 
        </div>
    </div>

        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header d-block">
                        <h3>Thông tin chi tiết sản phẩm</h3>
                    </div>
                    <div class="card-body p-0 table-border-style">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Màu sắc</th>
                                        <th>Kích thước(Size)</th>
                                        <th>Số lượng tồn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach( $data as $key => $dt)
                                    <tr>
                                        <th scope="row">{{$i}}</th>
                                        <th scope="row">{{$dt->ms_ten}}</th>
                                        <th scope="row">{{$dt->kc_ten}}</th>
                                        <th scope="row">{{$dt->soLuongTon}}</th>
                                    </tr>
                                    <?php $i++; ?>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                </div>                 
            </div>
            <div class="col-4">
                 <div class="row">
                            <div class="col-12">
                                {{-- <p class="lead">Tổng số lượng nhập:
                                    @foreach( $tongslnhap as $key => $slnhap)
                                        <b>{{$slnhap->slnhap}}</b>
                                    @endforeach 
                                </p>  --}}
                                <p class="lead">Tổng số lượng tồn:
                                     @foreach( $tongslton as $key => $slton)
                                        <b>{{$slton->slton}}</b>   
                                    @endforeach 
                                </p>
                                <p class="lead">Mô tả:
                                     @foreach( $list as $key => $sp)
                                        <b>{{$sp->sp_moTa}}</b>   
                                    @endforeach 
                                </p>
                                        
                            </div>
                </div>               
            </div>
        </div>
        
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

        $('#sanpham').parent().addClass('active open');
         $("#danhsachsanpham").addClass("active");
     });
</script>
@endsection
