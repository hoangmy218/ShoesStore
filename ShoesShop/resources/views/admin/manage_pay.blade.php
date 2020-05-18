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
                                            <h5>Quản lý phương thức thanh toán</h5>
                                            {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
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
                                                <a href="#">Quản lý phương thức thanh toán</a>
                                            </li>
                                            {{-- <li class="breadcrumb-item active" aria-current="page">Bootstrap Tables</li> --}}
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <?php
                            $message = Session::get('fail_message');
                            if ($message){
                                echo '<span class="alert alert-danger">'.$message."</span>";
                                
                                Session::put('fail_message',null);
                            }
                            $message = Session::get('success_message');
                            if ($message){
                                echo '<span class="alert alert-success">'.$message."</span>";
                                
                                Session::put('success_message',null);
                            }
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header d-block">
                                        <h3>Danh sách phương thức thanh toán</h3>
                                        <?php
                                        $message =Session::get('message');
                                        if($message){
                                          echo '<span class="text-alert">'.$message.'</span>';
                                          Session::put('message', null);
                                        }
                                      ?>
                                    </div>
                                    <div class="card-body p-0 table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                         <th>STT</th>
                                                        <th>Mã thanh toán</th>
                                                        <th>Tên phương thức thanh toán</th>
                                                        <th>Trạng thái</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php {{$i=1;}} ?>
                                                    @foreach( $list_pay as $key => $pay)

                                                    <tr>
                                                        <th scope="row">{{$i}}</th>
                                                        <td>{{$pay->httt_ma}}</td>
                                                        <td>{{$pay->httt_ten}}</td>
                                                        <td><span class="text-ellipsis">
                                                          <?php
                                                          if($pay->httt_trangThai==0){
                                                            ?>
                                                            <span class="text-green ik ik-eye cancel{{-- fa-thumb-styling fa fa-thumbs-up --}}" id="{{$pay->httt_ma}}"></span>
                                                            <?php
                                                          }else{
                                                            ?>
                                                            <span class="text-red ik ik-eye-off cancel1{{-- fa-thumb-styling fa fa-thumbs-down --}}" id="{{$pay->httt_ma}}"></span>
                                                          <?php
                                                          }

                                                          ?>
                                                        </span>
                                                    </td>
                                                        <td><div class="table-actions">  
                                                            <a href="{{URL::to('/edit-pay/'.$pay->httt_ma)}}"><i class="ik ik-edit-2"></i></a>
                                                            <a><i id="{{$pay->httt_ma}}" class="ik ik-trash-2 cancel2"></i></a>
                                                        </div></td>
                                                    </tr>
                                                    <?php {{$i++;}} ?>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Thay đổi trạng thái của hình thức thanh toán</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn ẩn hình thức thanh toán này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_anhttt_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="cancelModal1" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Thay đổi trạng thái của hình thức thanh toán</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn hiện hình thức thanh toán này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_hienhttt_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
<div class="modal fade" id="cancelModal2" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Xóa hình thức thanh toán</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn xóa hình thức thanh toán này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_xoahttt_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

        $('#thanhtoan').parent().addClass('active open');
         $("#danhsachthanhtoan").addClass("active");
     
        $(document).on('click','.cancel', function(){
            httt_ma = $(this).attr('id');
            console.log(httt_ma);
            $('#cancelModal').modal('show');
            
        });
        $(document).on('click','.cancel1', function(){
            httt_ma = $(this).attr('id');
            console.log(httt_ma);
            $('#cancelModal1').modal('show');
        });

        $('#ok_anhttt_btn').click(function(){
            $.ajax({
                url: '<?php echo url('unactive-pay');?>/'+httt_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php echo url('/manage-pay');?>");
                }
            });
        });
        $('#ok_hienhttt_btn').click(function(){
            $.ajax({
                url: '<?php echo url('active-pay');?>/'+httt_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php echo url('/manage-pay');?>");
                }
            });
        });

        $(document).on('click','.cancel2', function(){
            httt_ma = $(this).attr('id');
            console.log(httt_ma);
            $('#cancelModal2').modal('show');
        });

        $('#ok_xoahttt_btn').click(function(){
            $.ajax({
                url: '<?php echo url('delete-pay');?>/'+httt_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php echo url('/manage-pay');?>");
                }
            });
        });
     });
</script>

            


@endsection