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
                                        <th>Kích thước(Size)</th>
                                        <th>Số lượng nhập</th>
                                        <th>Số lượng tồn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach( $kichco as $key => $size)
                                    <tr>
                                        <th scope="row">{{$i}}</th>
                                        <th scope="row">{{$size->ctsp_kichCo}}</th>
                                        
                                        @foreach($list as $key => $sp)
                                        <?php 
                                            $tslnhapsize= DB::table('chitietsanpham')->select(DB::raw("sum(ctsp_soLuongNhap) as tslnhap"))->where('ctsp_kichCo',$size->ctsp_kichCo)->where('sp_ma',$sp->sp_ma)->get();
                                        ?>
                                        @endforeach
                                        
                                       @foreach($tslnhapsize as $key =>$tn)
                                        <th scope="row">{{$tn->tslnhap}}</th>
                                        @endforeach

                                        

                                        @foreach($list as $key => $sp)
                                        <?php 
                                            $tsltonsize= DB::table('chitietsanpham')->select(DB::raw("sum(ctsp_soLuongTon) as tslton"))->where('ctsp_kichCo',$size->ctsp_kichCo)->where('sp_ma',$sp->sp_ma)->get();
                                        ?>
                                        @endforeach
                                        
                                        @foreach($tsltonsize as $key =>$tnn)
                                        <th scope="row">{{$tnn->tslton}}</th>
                                        @endforeach

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
                                <p class="lead">Tổng số lượng nhập:
                                    @foreach( $tongslnhap as $key => $slnhap)
                                        <b>{{$slnhap->slnhap}}</b>
                                    @endforeach 
                                </p> 
                                <p class="lead">Tổng số lượng tồn:
                                     @foreach( $tongslton as $key => $slton)
                                        <b>{{$slton->slton}}</b>   
                                    @endforeach 
                                </p>
                                <p class="lead">Ghi chú:
                                     @foreach( $list as $key => $sp)
                                        <b>{{$sp->sp_ghiChu}}</b>   
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
