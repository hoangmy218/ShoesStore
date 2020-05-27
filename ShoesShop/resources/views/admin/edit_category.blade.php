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
                                            <h5>Danh mục</h5>
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
                                                <a href="{{URL::to('/manage-category')}}">Quản lý danh mục</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Cập nhật danh mục</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                                <div class="card">
                                    <div class="card-header"><h3>Chỉnh sửa danh mục</h3></div> <!-- Ngân (6/4/2020) Chỉnh thành Chỉnh sửa danh mục -->
                                     @foreach($edit_cate as $key => $edit_value)
                                    <div class="card-body">

                                        <form class="forms-sample" action="{{URL::to('/update-category/'.$edit_value->dm_ma)}}" method="POST">
                                             {{csrf_field()}}
                                            <div class="form-group">
                                                <label for="exampleInputName1">Mã danh mục</label>
                                                <input type="text" class="form-control" id="exampleInputName1" name="cate_id" value="{{$edit_value->dm_ma}}" disabled="disabled"> <!-- Ngân (6/4/2020) thêm disabled="disabled" -->
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Tên danh mục</label>
                                                <input type="text" value="{{$edit_value->dm_ten}}" class="form-control" id="exampleInputName1" name="cate_name" >
                                            </div>   
                                            
                                            <div class="form-group pull-right">
                                                <button type="submit" name="update_cate" class="btn btn-primary mr-2">Cập nhật</button>
                                               <button id="cancel" class="btn btn-light">Hủy</button>
                                              
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

        $('#danhmuc').parent().addClass('active open');
        $("#danhsachdanhmuc").addClass("active");
     });
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('#cancel').click(function(e){
        e.preventDefault();
        window.location.replace("<?php echo url('/manage-category');?>");
    })
});
</script>
@endsection