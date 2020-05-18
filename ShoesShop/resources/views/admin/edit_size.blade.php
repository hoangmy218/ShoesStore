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
                                            <h5>Kích Cỡ</h5>
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
                                                <a href="{{URL::to('/manage-size')}}">Quản lý kích cỡ</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Cập nhật kích cỡ</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                                <div class="card">
                                    <div class="card-header"><h3>Cập nhật kích cỡ sản phẩm</h3></div>
                                    <div class="card-body">
                                        @foreach($edit_size as $key => $edit_value)
                                        <div class="position-center">
                                            <form role="form" action="{{URL::to('/update-size/'.$edit_value->kc_ma)}}" method="post">
                                                {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="exampleInputName1">Mã kích cỡ</label>
                                                <input type="text" class="form-control" id="exampleInputName1" name="size_id" value="{{$edit_value->kc_ma}}" disabled="disabled"> 
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Tên kích cỡ</label>
                                                <input type="text" value="{{$edit_value->kc_ten}}" name="size_name" class="form-control" id="exampleInputName1" placeholder="Name" >
                                            </div>
                                            
                                           
                                            <button type="submit" name="add_size" class="btn btn-primary mr-2">Cập nhật</button>
                                            <button type="button" class="btn btn-light cancel">Hủy</button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                    </div>

                    {{-- tien 16/05/2020 --}}
                    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                
                                <div class="modal-header">
                                    <h5 class="modal-title" id="demoModalLabel">Hủy chỉnh sửa kích cỡ sản phẩm</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                Bạn có chắc chắn muốn hủy chỉnh sửa kích cỡ này?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                    <button type="button" id="cancel" class="btn btn-success">Xác nhận</button>
                                </div>
                            </div>
                        </div>
                    </div>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){

        $('#kichco').parent().addClass('active open');
         $("#danhsachkichco").addClass("active");
         $(document).on('click','.cancel', function(){
            kc_ma = $(this).attr('value');
            console.log(kc_ma);
            $('#cancelModal').modal('show');
            
        });
        $('#cancel').click(function(e){
            e.preventDefault();
             window.location.replace("<?php echo url('/manage-size');?>");
                    // e.preventDefault();
                    // window.history.back();
        });
    });
</script>               
@endsection