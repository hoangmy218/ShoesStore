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
                                            <h5>Thêm hình thức vận chuyển</h5>
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
                                                <a href="{{URL::to('/manage-transport')}}">Quản lý hình thức vận chuyển</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Thêm hình thức mới</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                                <div class="card">
                                    <div class="card-header"><h3>Thêm hình thức vận chuyển</h3></div>
                                    <div class="card-body">
                                        <form class="forms-sample" action="{{URL::to('/save-transport')}}" method="POST">
                                             {{csrf_field()}}
                                            <div class="form-group">
                                                <label for="exampleInputName1">Tên hình thức vận chuyển</label>
                                                <input type="text" class="form-control" id="exampleInputName1" name="transport_name" required="" placeholder="Name">
                                            </div>
                                             <div class="form-group">
                                                <label for="exampleInputName1">Chi phí vận chuyển</label>
                                                <input type="text" class="form-control" id="exampleInputName1" name="transport_price" required="" placeholder="Name">
                                            </div>
                                            <button type="submit" name="add_transport" class="btn btn-primary mr-2">Thêm</button>
                                            <button type="button" class="btn btn-light cancel">Hủy</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                    {{-- lan 13/05/2020 --}}
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Hủy thêm hình thức vận chuyển mới</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn hủy thêm hình thức vận chuyển mới?
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

        $('#vanchuyen').parent().addClass('active open');
         $("#themvanchuyen").addClass("active");
     });
setTimeout(function(){
           $("span.alert").remove();
        }, 5000 );
$(document).on('click','.cancel', function(){
            $('#cancelModal').modal('show');
            
        });
 $('#cancel').click(function(e){
    e.preventDefault();
     window.location.replace("<?php echo url('/manage-transport');?>");
            // e.preventDefault();
            // window.history.back();
        });


</script>
@endsection