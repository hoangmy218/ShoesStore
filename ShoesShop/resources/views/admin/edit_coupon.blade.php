@extends('admin_layout')
@section('content')

<div class="main-content">
                    <div class="container-fluid">
                        <div class="page-header">
                            <div class="row align-items-end">
                                <div class="col-lg-8">
                                    <div class="page-header-title">
                                        <i class="ik ik-file-text bg-blue"></i>
                                        <div class="d-inline">
                                            <h5>Khuyến mãi</h5>
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
                                                <a href="{{URL::to('/manage-coupon')}}">Quản lý khuyến mãi</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Cập nhật khuyến mãi</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                                <div class="card">
                                    <div class="card-header"><h3>Thêm khuyến mãi</h3></div>
                                     @foreach($edit_coupon as $key => $edit_value)
                                    <div class="card-body">

                                        <form class="forms-sample" action="{{URL::to('/update-coupon/'.$edit_value->km_ma)}}" method="POST">
                                             {{csrf_field()}}
                                            <div class="form-group">
                                                <label for="exampleInputName1">Chủ đề khuyến mãi</label>
                                                <input type="text" class="form-control" id="exampleInputName1" name="coupon_topic" value="{{$edit_value->km_chuDe}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputName1">Ngày bắt đầu</label>
                                                <input class="form-control datetimepicker-input" type="date" name="coupon_dateB" value="{{$edit_value->km_ngayBD}}" /> 
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Ngày kết thúc</label>
                                                <input class="form-control datetimepicker-input" type="date" name="coupon_dateE" value="{{$edit_value->km_ngayKT}}" />
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Giảm giá % được giảm</label>
                                                <input class="form-control datetimepicker-input" name="coupon_discount" type="number" value="{{$edit_value->km_giamGia}}">
                                            </div> 
                                            <!-- end Ngân (7/4/2020) -->
                                            
                                            <div class="form-group pull-right">
                                                <button type="submit" name="update_coupon" class="btn btn-primary mr-2">Cập nhật</button>
                                                <a href="{{url()->previous()}}" class="btn btn-default">Hủy</a>
                                              
                                            </div>

                                            
                                        </form>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

        $('#khuyenmai').parent().addClass('active open');
         $("#danhsachkhuyenmai").addClass("active");
     });
</script>                
@endsection