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
                                            <h5>Quản lý hình thức vận chuyển</h5>
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
                                                <a href="#">Quản lý hình thức vận chuyển</a>
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
                                        <h3>Danh sách hình thức vận chuyển</h3>
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
                                                        <th>Mã vận chuyển</th>
                                                        <th>Tên vận chuyển</th>
                                                        <th>Chi phí vận chuyển</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php {{$i=1;}} ?>
                                                    @foreach( $list_transport as $key => $transport)

                                                    <tr>
                                                        <th scope="row">{{$i}}</th>
                                                        <td>{{$transport->htvc_ma}}</td>
                                                        <td>{{$transport->htvc_ten}}</td>
                                                        <td>{{number_format($transport->htvc_phi).' VND'}}</td>
                                                        <td><div class="table-actions">                                                  
                                                            <a href="{{URL::to('/edit-transport/'.$transport->htvc_ma)}}"><i class="ik ik-edit-2"></i></a>
                                                            <a><i id="{{$transport->htvc_ma}}" class="ik ik-trash-2 cancel2"></i></a>


                                                           
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
                </div>
<div class="modal fade" id="cancelModal2" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Xóa hình thúc vận chuyển</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn hình thức vận chuyển này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_xoahtvc_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

        $('#vanchuyen').parent().addClass('active open');
         $("#danhsachvanchuyen").addClass("active");

        $(document).on('click','.cancel2', function(){
            htvc_ma = $(this).attr('id');
            console.log(htvc_ma);
            $('#cancelModal2').modal('show');
        });

        $('#ok_xoahtvc_btn').click(function(){
            $.ajax({
                url: '<?php echo url('delete-transport');?>/'+htvc_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php echo url('/manage-transport');?>");
                }
            });
        });
     });
</script>
            


@endsection