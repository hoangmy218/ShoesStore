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
                                            <li class="breadcrumb-item active" aria-current="page">Thêm kích cỡ</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                                <div class="card">
                                    <div class="card-header"><h3>Thêm kích cỡ </h3></div>
                                    <div class="card-body">
                                        <form class="forms-sample" action="{{URL::to('/save-size')}}" method="POST">
                                             {{csrf_field()}}
                                            {{-- <div class="form-group">
                                                <label for="exampleInputName1">Mã kích cỡ</label>
                                                <input type="text" class="form-control" name="size_id"  placeholder="Mã">
                                            </div> --}}
                                            <div class="form-group">
                                                <label for="exampleInputName1">Tên kích cỡ</label>
                                                <input type="text" class="form-control" name="size_name" placeholder="Tên">
                                            </div>   
                                            <button type="submit" name="add_size" class="btn btn-primary mr-2">Thêm</button>
                                            <button type="button" class="btn btn-light cancel">Hủy</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                    {{-- tien 16/05/2020 --}}
                    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                
                                <div class="modal-header">
                                    <h5 class="modal-title" id="demoModalLabel">Hủy thêm kích cỡ sản phẩm mới</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                Bạn có chắc chắn muốn hủy thêm kích cỡ này?
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

        $( '#kichco').parent().addClass('active open');
        $("#themkichco").addClass("active");
        
        $(document).on('click','.cancel', function(){
            kc_ma = $(this).attr('id');
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