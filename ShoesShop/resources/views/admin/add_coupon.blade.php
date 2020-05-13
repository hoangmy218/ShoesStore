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
                                                <a href="{{URL::to('/manage-coupon')}}">Quản lý khuyến mãi</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Thêm khuyến mãi</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                                <div class="card">
                                    <div class="card-header"><h3>Thêm khuyến mãi</h3></div>
                                    <div class="card-body">
                                        <form class="forms-sample" action="{{URL::to('/save-coupon')}}" method="POST">
                                             {{csrf_field()}}
                                            <div class="form-group">
                                                <label for="exampleInputName1">Chủ đề khuyến mãi</label>
                                                <input type="text" class="form-control" id="exampleInputName1" name="coupon_topic" placeholder="Mừng Quốc tế Phụ nữ 8/3, khuyến mãi 5% từ 8/3/2020 - 10/3/2020">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Ngày bắt đầu</label>
                                                <input type="date" class="form-control datetimepicker-input" name="coupon_dateB" />
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Ngày kết thúc</label>
                                                <input type="date" class="form-control datetimepicker-input" name="coupon_dateE" />
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Giá trị % được giảm</label>
                                                <input class="form-control datetimepicker-input" name="coupon_discount" type="number" value="1">
                                            </div> 
                                            <button type="submit" name="add_coupon" class="btn btn-primary mr-2">Thêm</button>
                                            <button onclick="history.go(0)" class="btn btn-light">Hủy</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

        $('#khuyenmai').parent().addClass('active open');
         $("#themkhuyenmai").addClass("active");
     });
</script>
@endsection