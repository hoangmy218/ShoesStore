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
                                            <li class="breadcrumb-item active" aria-current="page">Thêm màu sắc</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                                <div class="card">
                                    <div class="card-header"><h3>Thêm màu sắc</h3></div>
                                    <div class="card-body">
                                        <form class="forms-sample" action="{{URL::to('/save-color')}}" method="POST">
                                             {{csrf_field()}}
                                            {{-- <div class="form-group">
                                                <label for="exampleInputName1">Mã màu sắc</label>
                                                <input type="text" class="form-control" name="color_id"  placeholder="Mã">
                                            </div> --}}
                                            <div class="form-group">
                                                <label for="exampleInputName1">Tên màu sắc</label>
                                                <input type="text" class="form-control" name="color_name" placeholder="Tên">
                                            </div>   
                                            <button type="submit" name="add_color" class="btn btn-primary mr-2">Thêm</button>
                                            <button class="btn btn-light">Hủy</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://www.codermen.com/js/jquery.js"></script>
<script>
$(document).ready(function(){

        $( '#mausac').parent().addClass('active open');
         $("#themmausac").addClass("active");
     });
     </script>
@endsection