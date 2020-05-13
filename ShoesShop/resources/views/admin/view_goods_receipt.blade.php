@extends('admin_layout')
@section('content')

<div class="main-content">
                    <div class="container-fluid">
                        <div class="page-header">
                            <div class="row align-items-end">
                                <div class="col-lg-7">
                                    <div class="page-header-title">
                                        <i class="ik ik-edit bg-blue"></i>
                                        <div class="d-inline">
                                            <h5>Kho</h5>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{URL::to('/dashboard')}}"><i class="ik ik-home"></i></a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#">Quản lý kho</a></li>
                                             <li class="breadcrumb-item">
                                                <a href="{{URL::to('/manage-goods-receipt')}}">Quản lý phiếu nhập</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Chi tiết phiếu nhập</li>
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
                        

                        <div class="card">
                            <div class="card-header"><h3 class="d-block w-100">Mã phiếu nhập: #{{$receipt->pn_ma}} <small class="float-right">Ngày nhập: {{date('d-m-Y',strtotime($receipt->pn_ngayNhap))}}</small></h3></div>
                            <div class="card-body">
                                <div class="row invoice-info">
                                    {{-- <div class="col-sm-4 invoice-col">
                                        Người đặt
                                        <address>
                                            <strong>ThemeKit,</strong><br>795 Folsom Ave, Suite 546 <br>San Francisco, CA 54656 <br>Phone: (123) 123-4567<br>Email: info@themekit.com
                                        </address>
                                    </div>
                                    <div class="col-sm-4 invoice-col">
                                        Người nhận
                                        <address>
                                            <strong>John Doe</strong><br>795 Folsom Ave, Suite 600<br>San Francisco, CA 94107<br>Phone: (555) 123-7654<br>Email: john.doe@example.com
                                        </address>
                                    </div> --}}
                                    <div class="col-sm-4 invoice-col">
                                        <b>Mã phiếu nhập #{{$receipt->pn_ma}}</b><br>
                                        <input type="hidden" name="pn_ma" value="{{$receipt->pn_ma}}">
                                        <br>          
                                        {{-- <b>Hình thức vận chuyển:</b> VNPOST<br>

                                        <b>Tài khoản:</b> hoangmy123 --}}
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
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Mã sản phẩm</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Màu sắc</th>
                                                    <th>Kích cỡ</th>
                                                    <th>Số lượng nhập</th>
                                                    <th>Số lượng tồn</th>
                                                    <th>Đơn giá nhập</th>
                                                    <th>Đơn giá bán</th> 
                                                    <th>Thao tác</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; ?>
                                                @foreach($list_pro as $key => $pro)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$pro->sp_ma}}</td>
                                                    <td>{{$pro->sp_ten}}</td>
                                                    <td class="{{$pro->ms_ma}}">{{$pro->ms_ten}}</td>
                                                    <td class="{{$pro->kc_ma}}">{{$pro->kc_ten}}</td>
                                                    <td>{{$pro->SoLuongNhap}}</td>
                                                    <td>{{$pro->soLuongTon}}</td>
                                                    <td>{{number_format($pro->DonGiaNhap).' VND'}}</td>
                                                    <td>{{number_format($pro->sp_donGiaBan).' VND'}}</td>
                                                    <td>
                                                        <div class="table-actions" style="text-align: left">
                                                            
                                                            <a><i id="{{$pro->pn_ma}}" class="ik ik-edit-2 f-16 mr-15 edit text-green"></i></a>
                                                            <a> <i class="ik ik-trash-2 f-16 mr-15 delete text-red" id="{{$pro->sp_ma}}"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row no-print">
                                    <div class="col-12">
                                        
                                        <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
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
                                <h5 class="modal-title" id="demoModalLabel">Xóa sản phẩm nhập</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            <span>Bạn có chắc chắn muốn xóa sản phẩm nhập này?</span>
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
                                        <h5 class="modal-title" id="exampleModalCenterLabel">Chỉnh sửa sản phẩm nhập</h5>
                                        <button type="button" class="close cancelEdit" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        
                                            <meta name="csrf-token" content="{{ csrf_token() }}">
                                            <div class="row col-md-12">
                                               {{--  <div class="form-group" style="padding-bottom: 10px;"> --}}
                                                    {{-- <label for="date">Ngày nhập</label>
                                                    <input type="date" name="ngayNhap" class="form-control datetimepicker-input" id="datepicker" data-toggle="datetimepicker" data-target="#datepicker"> --}}
                                                    {{-- <div class="form-group">
                                                        <label for="exampleInputName1">Mã sản phẩm</label>
                                                        <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                            <input type="text" name="ma_sp" class="form-control" id="exampleInputName1" readonly="readonly">
                                                        </div>
                                                    </div> --}}
                                                    <div class="form-group">
                                                        <label for="exampleInputName1">Tên sản phẩm</label>
                                                        <div class="form-group  mb-2 mr-sm-2 mb-sm-0">
                                                           <select class="form-control" name="masp" >
                                                                @foreach($list_products as $key => $pro)
                                                                    <option value="{{$pro->sp_ma}}" name="sp">{{$pro->sp_ten}}</option>                                                  
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputName1">Màu sắc </label>
                                                        <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                            <select class="form-control" name="mams" >
                                                                @foreach($list_colors as $key => $color)
                                                                    <option value="{{$color->ms_ma}}" name="ms">{{$color->ms_ten}}</option>                                                  
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label for="exampleInputName1">Kích cỡ </label>
                                                        <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                            <select class="form-control" name="makc" >
                                                                @foreach($list_sizes as $key => $size)
                                                                    <option value="{{$size->kc_ma}}" name="kc">{{$size->kc_ten}}</option>                                                  
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label for="exampleInputName1">Số lượng nhập </label>
                                                        <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                            <input type="number" class="form-control" name="soLuongNhap" min="1" step="1" max="100" >
                                                        </div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label for="exampleInputName1">Đơn giá nhập </label>
                                                        <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                            <input type="number" class="form-control" name="giaNhap" min="100000" step="1000" max="5000000">
                                                        </div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label for="exampleInputName1">Đơn giá bán</label>
                                                        <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                                            <input type="number" class="form-control" name="giaBan" min="100000" step="1000" max="5000000" >
                                                        </div>
                                                    </div>

                                                    
                                       
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger cancelEdit" data-dismiss="modal">Hủy</button>
                                                <button type="button" id="ok_save_btn" class="btn btn-success">Lưu</button>
                                            </div>
                                        </div>
                                    </div>
                        </div>
                    </div>


            

<script src="http://www.codermen.com/js/jquery.js"></script>
<script>
    $(document).ready(function(){

        //dat thi gian tat thong bao
        setTimeout(function(){
           $("span.alert").remove();
        }, 5000 ); // 5 secs


        $('#kho').parent().addClass('active open');
         $("#phieunhap").addClass("active");


        // var ctsp_ma;
        //var pn_ma = $('input[name="pn_ma"]').val();
        var pn_ma, sp_ma, ms_ma, kc_ma;

        //chinh sua phieu nhap

        $(document).on('click','.edit', function(){
            pn_ma = $(this).attr('id');
            console.log('clicked edit');
            console.log(pn_ma,'pn_ma');
             sp_ma = $.trim(($(this).parent()).parent().parent().parent().children().eq(1).text());
            console.log(sp_ma,'sp_ma');
             ms_ma = $.trim(($(this).parent()).parent().parent().parent().children().eq(3).attr('class'));
            console.log(ms_ma,'ms_ma');
             kc_ma = $.trim(($(this).parent()).parent().parent().parent().children().eq(4).attr('class'));
            console.log(kc_ma,'kc_ma');
            if (pn_ma){


                $.ajax({
                    url: "{{url('getDetailGoods')}}",
                        dataType: 'json',
                        type: 'GET',
                        data:{
                            pn_ma: pn_ma,
                            sp_ma: sp_ma,
                            ms_ma: ms_ma,
                            kc_ma: kc_ma,
                        },
                    success: function(data){
                        console.log(data);
                        // $('input[name="ctsp_ma"]').replaceWith('<input type="text" name="ctsp_ma" class="form-control" id="exampleInputName1" readonly="true" value="'+data.ctsp_ma+'">');
                        $('option[value="'+data.sp_ma+'"][name="sp"]').attr({"selected" : true});
                        $('option[value="'+data.ms_ma+'"][name="ms"]').attr({"selected" : true});
                        $('option[value="'+data.kc_ma+'"][name="kc"]').attr({"selected" : true});
                        $('input[name="giaNhap"]').replaceWith('<input type="number" class="form-control" name="giaNhap" min="100000" step="1000" max="5000000" value="'+data.DonGiaNhap+'">');
                        $('input[name="giaBan"]').replaceWith('<input type="number" class="form-control" name="giaBan" min="100000" step="1000" max="5000000" value="'+data.sp_donGiaBan+'">');
                        
                        $('input[name="soLuongNhap"]').replaceWith(' <input type="number" class="form-control" name="soLuongNhap" min="1" step="1" max="100" value="'+data.SoLuongNhap+'">');
                        
                    }
                });
                $('#editModal').modal('show');
                
            }else{
             $('select[name="masp"]').empty();
             $('select[name="makc"]').empty();
             $('select[name="mams"]').empty();
            }
        });
        
        $('.cancelEdit').click(function(){
            pn_ma = null;
            sp_ma = null;
            kc_ma = null;
            ms_ma = null;
            $("option:selected").attr({"selected": false});
            // $('select[name="masp"]').empty();
            // $('select[name="makc"]').empty();
            // $('select[name="mams"]').empty();
        });


        //luu chinh sua
         $('#ok_save_btn').click(function(){
            var sp_ma_moi = $('select[name="masp"]').val();
            var ms_ma_moi = $('select[name="mams"]').val();
            var kc_ma_moi = $('select[name="makc"]').val();
            var DonGiaNhap_moi = $('input[name="giaNhap"]').val();
            var sp_donGiaBan_moi = $('input[name="giaBan"]').val();
            var SoLuongNhap_moi = $('input[name="soLuongNhap"]').val();
            console.log(sp_ma_moi,'sp_ma');
            console.log(DonGiaNhap_moi,'sp_donGiaNhap');
            console.log(sp_donGiaBan_moi,'sp_donGiaBan');
            console.log(kc_ma_moi,'kichCo');
            console.log(ms_ma_moi,'mausac');
            console.log(SoLuongNhap_moi,'ctsp_soLuongNhap');

            console.log(sp_ma,'sp_ma cu');
            console.log(kc_ma,'kichCo cu');
            console.log(ms_ma,'mausac cu');
            $.ajax({
                
                url: '<?php echo url('/save-edit-goods');?>/'+pn_ma,
                type: 'POST',
                data:{
                    pn_ma: pn_ma,
                    sp_ma_moi: sp_ma_moi,
                    DonGiaNhap_moi: DonGiaNhap_moi,
                    sp_donGiaBan_moi: sp_donGiaBan_moi,
                    kc_ma_moi: kc_ma_moi,
                    ms_ma_moi: ms_ma_moi,
                    SoLuongNhap_moi: SoLuongNhap_moi,
                    
                    sp_ma_cu: sp_ma,
                   
                    kc_ma_cu: kc_ma,
                    ms_ma_cu: ms_ma,
                   
                     _token: '{{csrf_token()}}',
                },
                
                success: function (data) {
                     window.location.replace("<?php echo url('/view-receipt');?>/"+pn_ma);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);

                },
                
            });
        });

        
        //xoa phieu nhap

        $(document).on('click','.delete', function(){
            ctsp_ma = $(this).attr('id');
            console.log('ctsp_ma',ctsp_ma);
            $('#deleteModal').modal('show');

        });

        $('#ok_delete_btn').click(function(){
            $.ajax({
                url: '<?php echo url('delete-goods');?>/'+ctsp_ma,
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
