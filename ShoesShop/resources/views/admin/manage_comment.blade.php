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
                                            <h5>Quản lý bình luận</h5>
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
                                                <a href="{{URL::to('/manage-comment')}}">Quản lý bình luận</a>
                                            </li>
                                            {{-- <li class="breadcrumb-item active" aria-current="page">Bootstrap Tables</li> --}}
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        
                       <?php
                            $message1 = Session::get('fail_message1');
                            if ($message1){
                                echo '<span class="alert alert-danger">'.$message1."</span>";
                                                
                                Session::put('fail_message1',null);
                            }
                            $message1 = Session::get('success_message1');
                            if ($message1){
                                echo '<span class="alert alert-success">'.$message1."</span>";
                                                
                                Session::put('success_message1',null);
                            }
                        ?>
                        <br><br>
                        <div class="row">
                            <div class="col-md-12">
								<div class="card">
                                    <div class="card-header d-block">
                                        <h3>Danh sách bình luận</h3>
                                        <br>
                                        
                                    </div>
                                    <div class="card-body p-0 table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                         <th>STT</th>
                                                        <!-- <th>Mã bình luận</th> -->
                                                        <th>Tên sản phẩm</th>
                                                        <th>Tên người dùng</th>
                                                        <!-- <th>Tên</th>
                                                        <th>Email</th> -->
                                                        <th>Nội dung bình luận</th>
                                                        <th>Ngày bình luận</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php {{$i=1;}} ?>
                                                    @foreach($list_comments as $key => $ds_binhluan)

                                                    <tr>
                                                        <th scope="row">{{$i}}</th>
                                                        
                                                        <td>{{$ds_binhluan->sp_ten}}</td>
                                                        <td>{{$ds_binhluan->nd_ten}}</td>
                                                        
                                                        <td>{{$ds_binhluan->noiDung}}</td>
                                                        <td>{{$ds_binhluan->ngayBinhLuan}}</td>
                                                        <td>
                                                            
                                                            <span class="text-ellipsis">
                                                              <?php
                                                              if($ds_binhluan->trangThai==0){
                                                                ?>
                                                                <a  href ="{{URL::to('unactive-comment/'.$ds_binhluan->nd_ma.'/'.$ds_binhluan->sp_ma.'/'.$ds_binhluan->ngayBinhLuan)}}">
                                                                <button type="button" id="$ds_binhluan->sp_ma/$ds_binhluan->nd_ma/$ds_binhluan->ngayBinhLuan" class="btn btn-primary cancel" data-toggle="modal" >Hiện</button>

                                                                {{-- <span class="text-green ik ik-eye cancel" id="$ds_binhluan->sp_ma/$ds_binhluan->nd_ma/$ds_binhluan->ngayBinhLuan"></span> --}}
                                                            </a>
                                                                <?php
                                                              }else{
                                                                ?>
                                                                <a href="{{URL::to('active-comment/'.$ds_binhluan->nd_ma.'/'.$ds_binhluan->sp_ma.'/'.$ds_binhluan->ngayBinhLuan)}}">

                                                                    <button type="button" id="$ds_binhluan->sp_ma/$ds_binhluan->nd_ma/$ds_binhluan->ngayBinhLuan" class="btn btn-danger  cancel1" data-toggle="modal" >Ẩn</button>

                                                                    {{-- <span class="text-red ik ik-eye-off cancel1" id="$ds_binhluan->sp_ma/$ds_binhluan->nd_ma/$ds_binhluan->ngayBinhLuan" ></span> --}}
                                                                </a>
                                                              <?php
                                                              }

                                                              ?>
                                                            </span>
                                                        </td>
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

                {{-- <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Thay đổi trạng thái của bình luận</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn ẩn bình luận này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_anbl_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
 --}}
                {{-- <div class="modal fade" id="cancelModal1" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Thay đổi trạng thái của bình luận</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn hiển thị bình luận này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_hienthibl_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div> --}}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="http://www.codermen.com/js/jquery.js"></script>
<script>
$(document).ready(function(){

         // Tien 08/05
         //dat thi gian tat thong bao
        setTimeout(function(){
           $("span.alert").remove();
        }, 5000 ); // 5 secs


        $("#binhluan").parent().addClass("active");
         

});
</script>
@endsection