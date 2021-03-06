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
                            <h5>Quản lý quảng cáo</h5>
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
                                <a href="{{URL::to('/manage-advertisement')}}">Quản lý quảng cáo</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h3>Danh sách quảng cáo</h3>
                            <?php
                                $message =Session::get('message');
                                if($message){
                                    echo '<span style="color:green" class="text-alert"><b>'.$message.'</b></span>';
                                              Session::put('message', null);
                                }
                            ?>
                    </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>STT</th>
                                    <th>Mã quảng cáo</th>
                                    <th>Hình ảnh</th>
                                    <th>Chủ đề quảng cáo</th>
                                    <th>Thao tác</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                    @foreach( $list_ad as $key => $ad)
                                        <tr>
                                            <th scope="row">{{$i}}</th>
                                            <td>{{$ad->qc_ma}}</td>
     
                                            <td><img src="{{URL::to('public/upload/advertisement/'.$ad->qc_hinhAnh)}}" height="100" width="200"></td> 

                                            <td>{{$ad->qc_chuDe}}</td>
                                          
                                            <td><div class="table-actions" style="text-align: center;">  
                                                @switch($ad->qc_trangThai)
                                                @case(1)
                                                    <button type="button" id="{{$ad->qc_ma}}" class="btn btn-primary Dangqc" data-toggle="modal" >Đăng quảng cáo</button>
                                                    @break

                                                @case(0)
                                                    <button type="button" id="{{$ad->qc_ma}}" class="btn btn-danger Goqc" data-toggle="modal">Gỡ quảng cáo</button>
                                                    @break
                                                 @default
                                                                    
                                            @endswitch  
                                                    <a href="{{URL::to('/edit-advertisement/'.$ad->qc_ma)}}"><i class="ik ik-edit-2 text-yellow"></i></a>
                                                    <a><i class="ik ik-trash-2 f-16 mr-15 delete text-red" id="{{$ad->qc_ma}}"></i></a>
                                                        </div></td>
                                                
                                        </tr>
                                        <?php $i++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="DangqcModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Đăng quảng cáo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn đăng quảng cáo này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_Dangqc_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
<div class="modal fade" id="GoqcModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Gỡ quảng cáo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn gỡ bỏ quảng cáo này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_Goqc_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Xóa quảng cáo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <span>Bạn có chắc chắn muốn xóa quảng cáo này?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                <button type="button" id="ok_delete_btn" class="btn btn-success">Xác nhận</button>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

        $( '#quangcao').parent().addClass('active open');
        $("#danhsachquangcao").addClass("active");

        setTimeout(function(){
           $("span.alert").remove();
        }, 5000 ); // 5 secs

        $(document).on('click','.delete', function(){
            qc_ma = $(this).attr('id');
            console.log('qc_ma',qc_ma);
            $('#deleteModal').modal('show');

        });

        $('#ok_delete_btn').click(function(){
            $.ajax({
                url: '<?php echo url('delete-advertisement');?>/'+qc_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php echo url('/manage-advertisement');?>");
                }
            });
        });

        // Đăng quảng cáo
        $(document).on('click','.Dangqc', function(){
            qc_ma = $(this).attr('id');
            console.log(qc_ma,'qc_ma');
            $('#DangqcModal').modal('show');

        });

        $('#ok_Dangqc_btn').click(function(){
            $.ajax({
                url: '<?php echo url('/active-advertisement'); ?>/'+qc_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php echo url('/manage-advertisement'); ?>");
                }
            });
        });

        // Gỡ quảng cáo
        $(document).on('click','.Goqc', function(){
            qc_ma = $(this).attr('id');
            $('#GoqcModal').modal('show');

        });

        $('#ok_Goqc_btn').click(function(){
            $.ajax({
                url: '<?php echo url('/unactive-advertisement'); ?>/'+qc_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php echo url('/manage-advertisement'); ?>");
                }
            });
        });
});
</script>

@endsection
