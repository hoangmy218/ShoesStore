@extends('admin_layout')
@section('head_repeat')


@endsection
@section('content')

                       


<div class="main-content">
                    <div class="container-fluid">
                        <div class="page-header">
                            <div class="row align-items-end">
                                <div class="col-lg-8">
                                    <div class="page-header-title">
                                        <i class="ik ik-edit bg-blue"></i>
                                        <div class="d-inline">
                                            <h5>Kho</h5>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{URL::to('/dashboard')}}"><i class="ik ik-home"></i></a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#">Quản lý kho</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Quản lý phiếu nhập</li>
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
                                        <h3>Danh sách phiếu nhập</h3>
                                        
                                    </div>
                                    <div class="card-body p-0 table-breceipt-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Mã phiếu nhập</th>
                                                        <th>Ngày nhập</th> 
                                                        <th>Số sản phẩm</th>
                                                        <th>Tổng tiền</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=1; ?>
                                                	@foreach( $list_receipts as $key => $receipt)
                                                    <tr>
                                                        <th scope="row">{{$i}}</th>
                                                        <td>{{$receipt->pn_ma}}</td>
                                                        <td>{{ date('d-m-Y',strtotime($receipt->pn_ngayNhap))}}</td>
                                                        <td >{{$receipt->count}}</td>
                                                        <td style="text-align: right;">{{number_format($receipt->pn_tongTien).' VND'}}</td>
                                                        <td><div class="table-actions" style="text-align: left">
                                                            <a href="{{URL::to('/view-receipt/'.$receipt->pn_ma)}}"><i class="ik ik-eye f-16 mr-15 text-blue"></i></a> 
                                                            <a><i id="{{$receipt->pn_ma}}" class="ik ik-edit-2 f-16 mr-15 edit text-green"></i></a> 
                                                            
                                                            <a> <i class="ik ik-trash-2 f-16 mr-15 delete text-red" id="{{$receipt->pn_ma}}"></i></a>
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

                {{-- MODAL --}}
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Xóa phiếu nhập</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            <span>Bạn có chắc chắn muốn xóa phiếu nhập này?</span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_delete_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterLabel">Chỉnh sửa phiếu nhập</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        
                                            <meta name="csrf-token" content="{{ csrf_token() }}">
                                            <div class="row col-md-12">
                                                <div class="form-group" style="padding-bottom: 10px;">
                                                    <label for="date">Ngày nhập</label>
                                                    <input type="date" name="ngayNhap" class="form-control datetimepicker-input" id="datepicker" data-toggle="datetimepicker" data-target="#datepicker">
                                                    
                                                </div>                                                        
                                            </div>
                                       
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                        <button type="button" id="ok_save_btn" class="btn btn-success">Lưu</button>
                                    </div>
                                </div>
                            </div>
                        </div>


            

<script src="http://www.codermen.com/js/jquery.js"></script>
<script>
    function rating(a){
      console.log((a.parentElement).parentElement.parentElement.childNodes[3].childNodes[1].innerHTML);
      var ctsp_ma = (a.parentElement).parentElement.parentElement.childNodes[3].childNodes[1].innerHTML;
     /* var size_id = a.innerHTML;
        console.log(size_id);*/
    }
    $(document).ready(function(){

        //dat thi gian tat thong bao
        setTimeout(function(){
           $("span.alert").remove();
        }, 5000 ); // 5 secs


        $('#kho').parent().addClass('active open');
         $("#phieunhap").addClass("active");


        var pn_ma;

        //chinh sua phieu nhap

        $(document).on('click','.edit', function(){
            pn_ma = $(this).attr('id');
            console.log('clicked edit');
            console.log(pn_ma,'pn_ma');
            
            if (pn_ma){


                $.ajax({
                    url: "{{url('getDateReceipt')}}",
                        dataType: 'json',
                        type: 'GET',
                        data:{
                            pn_ma: pn_ma,
                        },
                    success: function(data){
                        console.log(data);
                        /* $('select[name="stock"]').empty();*/
                        $.each(data, function(name,date){ 
                        console.log(date);                         
                            $('input[name="ngayNhap"]').replaceWith('<input type="text" name="ngayNhap" class="form-control datetimepicker-input" id="datepicker" data-toggle="datetimepicker" value="'+date+'"  data-target="#datepicker">');
                        });
                    }
                });
                $('#editModal').modal('show');
                
            }
        });
        

        //luu chinh sua
         $('#ok_save_btn').click(function(){
            var pn_ngayNhap = $('input[name="ngayNhap"]').val();
            console.log(pn_ngayNhap,'pn_ngayNhap')
            $.ajax({
                
                url: '<?php echo url('save-edit-receipt');?>/'+pn_ma,
                type: 'POST',
                data:{
                    pn_ngayNhap : pn_ngayNhap,
                     _token: '{{csrf_token()}}'
                },
                
                success: function (data) {
                     window.location.replace("<?php echo url('/manage-goods-receipt');?>");
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);

                },
                
            });
        });

        
        //xoa phieu nhap

        $(document).on('click','.delete', function(){
            pn_ma = $(this).attr('id');
            console.log('pn_ma',pn_ma);
            $('#deleteModal').modal('show');

        });

        $('#ok_delete_btn').click(function(){
            $.ajax({
                url: '<?php echo url('delete-receipt');?>/'+pn_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php echo url('/manage-goods-receipt');?>");
                }
            });
        });


    });
</script>
@endsection
@section('script_repeat')
<script src="{{URL::to('public/backend/plugins/datedropper/datedropper.min.js')}}"></script>
<script src="{{URL::to('public/backend/js/form-picker.js')}}"></script>

@endsection