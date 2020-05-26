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
                                            <h5>Nhà cung cấp</h5>
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
                                                <a href="{{URL::to('/manage-suppliers')}}">Quản lý nhà cung cấp</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa nhà cung cấp</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                                <div class="card">
                                    <div class="card-header"><h3>Cập nhật nhà cung cấp</h3></div>
                                    <div class="card-body">
                                        <form class="forms-sample" action="{{URL::to('/update-supplier/'.$supplier->ncc_ma)}}" method="POST">
                                             {{csrf_field()}}
                                            <div class="form-group">
                                                <label for="exampleInputName1">Mã nhà cung cấp</label>
                                                <input type="text" class="form-control" name="supplier_id"  placeholder="Mã" value="{{$supplier->ncc_ma}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Tên nhà cung cấp</label>
                                                <input type="text" class="form-control" name="supplier_name" placeholder="Tên" value="{{$supplier->ncc_ten}}">
                                            </div>   
                                            <div class="form-group">
                                                <label for="exampleInputName1">Email nhà cung cấp</label>
                                                <input type="text" class="form-control" name="supplier_email" placeholder="Email" value="{{$supplier->ncc_email}}">
                                            </div> 
                                            <div class="form-group">
                                                <label for="exampleInputName1">Số điện thoại nhà cung cấp</label>
                                                <input type="text" class="form-control" name="supplier_phone" placeholder="Số điện thoại" value="{{$supplier->ncc_dienThoai}}">
                                            </div> 
                                            <div class="form-group">
                                                <label for="exampleInputName1">Địa chỉ nhà cung cấp</label>
                                                <input type="text" class="form-control" name="supplier_address" placeholder="Địa chỉ" value="{{$supplier->ncc_diaChi}}">
                                            </div> 

                                            <button type="submit" name="edit_supplier" class="btn btn-primary mr-2">Cập nhật</button>
                                            <button  class="cancel btn btn-light">Hủy</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                
                                <div class="modal-header">
                                    <h5 class="modal-title" id="demoModalLabel">Hủy cập nhật nhà cung cấp</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                Bạn có chắc chắn muốn hủy cập nhật nhà cung cấp này?
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

        $('#nhacungcap').parent().addClass('active open');
        $("#danhsachnhacungcap").addClass("active");

         $(document).on('click','.cancel', function(){
            
            $('#cancelModal').modal('show');
            
        }); 
         $('#cancel').click(function(e){
            e.preventDefault();
             window.location.replace("<?php echo url('/manage-suppliers');?>");
                    // e.preventDefault();
                    // window.history.back();
        });
    });
</script>
@endsection