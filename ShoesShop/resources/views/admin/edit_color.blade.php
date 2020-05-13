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
                                            <h5>Màu Sắc</h5>
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
                                                <a href="{{URL::to('/manage-color')}}">Quản lý màu sắc</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Cập nhật màu sắc</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                                <div class="card">
                                    <div class="card-header"><h3>Cập nhật màu sắc sản phẩm</h3></div>
                                    <div class="card-body">
                                        @foreach($edit_color as $key => $edit_value)
                                        <div class="position-center">
                                            <form role="form" action="{{URL::to('/update-color/'.$edit_value->ms_ma)}}" method="post">
                                                {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="exampleInputName1">Mã màu sắc</label>
                                                <input type="text" class="form-control" id="exampleInputName1" name="color_id" value="{{$edit_value->ms_ma}}" disabled="disabled"> 
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Tên màu sắc</label>
                                                <input type="text" value="{{$edit_value->ms_ten}}" name="color_name" class="form-control" id="exampleInputName1" placeholder="Name" >
                                            </div>
                                            
                                           
                                            <button type="submit" name="add_color" class="btn btn-primary mr-2">Cập nhật</button>
                                             <a href="{{url()->previous()}}" class="btn btn-default">Hủy</a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                    </div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

        $('#mausac').parent().addClass('active open');
         $("#danhsachmausac").addClass("active");
     });
</script>               
@endsection