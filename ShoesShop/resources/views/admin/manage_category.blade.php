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
                                            <h5>Quản lý danh mục</h5>
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
                                                <a href="#">Quản lý danh mục</a>
                                            </li>
                                            {{-- <li class="breadcrumb-item active" aria-current="page">Bootstrap Tables</li> --}}
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                                        <?php
                                            $message = Session::get('fail_message_cate');
                                            if ($message){
                                                echo '<span class="alert alert-danger"><b>'.$message."</b></span>";
                                                
                                                Session::put('fail_message_cate',null);
                                            }
                                            $message = Session::get('success_message_cate');
                                            if ($message){
                                                echo '<span class="alert alert-success"><b>'.$message."</b></span>";
                                                
                                                Session::put('success_message_cate',null);
                                            }
                                        ?>


                        <div class="row">
                            <div class="col-md-12">
								<div class="card">
                                    
                                    <div class="card-header d-block">
                                        <h3>Danh sách danh mục</h3>
                                        
                                    </div>
                                    <div class="card-body p-0 table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                         <th>STT</th>
                                                        <th>Mã danh mục</th>
                                                        <th>Tên danh mục</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php {{$i=1;}} ?>
                                                    @foreach( $list_cate as $key => $cate)

                                                    <tr>
                                                        <th scope="row">{{$i}}</th>
                                                        <td>{{$cate->dm_ma}}</td>
                                                        <td>{{$cate->dm_ten}}</td>
                                                        <td><div class="table-actions">   
                                                            <a href="{{URL::to('/edit-category/'.$cate->dm_ma)}}"><i class="ik ik-edit-2 text-blue"></i></a>
                                                            <a> <i class="ik ik-trash-2 f-16 mr-15 delete text-red" id="{{$cate->dm_ma}}"></i></a>
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

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Xóa danh mục</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            <span>Bạn có chắc chắn muốn xóa danh mục này?</span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="ok_delete_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="http://www.codermen.com/js/jquery.js"></script>
<script>
$(document).ready(function(){

        $('#danhmuc').parent().addClass('active open');
        $("#danhsachdanhmuc").addClass("active");
        
        setTimeout(function(){
           $("span.alert").remove();
        }, 5000 ); // 5 secs

        $(document).on('click','.delete', function(){
            dm_ma = $(this).attr('id');
            console.log('dm_ma',dm_ma);
            $('#deleteModal').modal('show');

        });

        $('#ok_delete_btn').click(function(){
            $.ajax({
                url: '<?php echo url('delete-category');?>/'+dm_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php echo url('/manage-category');?>");
                }
            });
        });
     });
</script>
            


@endsection