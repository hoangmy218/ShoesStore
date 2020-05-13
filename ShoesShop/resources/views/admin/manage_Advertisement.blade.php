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
                                <tr>
                                    <th>STT</th>
                                    <th>Mã quảng cáo</th>
                                    <th>Hình ảnh</th>
                                    <th>Chủ đề quảng cáo</th>
                                    <th>Đoạn giới thiệu</th><!-- Ngân (14/4/2020) -->
                                    <th>Trạng thái</th> <!-- Ngân (14/4/2020) -->
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
                                             <!-- Start Ngân (14/4/2020) -->
                                            <td>{{$ad->qc_quangCao}}</td>
                                           
                                            <td><span class="text-ellipsis">
                                                          <?php
                                                          if($ad->qc_trangThai==0){
                                                            ?>
                                                            <a href ="{{URL::to('/unactive-advertisement/'.$ad->qc_ma)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                                                            <?php
                                                          }else{
                                                            ?>
                                                            <a href="{{URL::to('/active-advertisement/'.$ad->qc_ma)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                                                          <?php
                                                          }

                                                          ?>
                                                        </span>
                                            </td>
                                            <!-- End Ngân (14/4/2020) -->
                                            <td><div class="table-actions">   
                                                    <a href="{{URL::to('/edit-advertisement/'. $ad->qc_ma)}}"><i class="ik ik-edit-2"></i></a>
                                                    <a onclick="return confirm('Bạn chắc chắn muốn xóa?')" href="{{URL::to('/delete-advertisement/'. $ad->qc_ma)}}"><i class="ik ik-trash-2"></i></a>
                                                </div>
                                            </td>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

        $( '#quangcao').parent().addClass('active open');
         $("#danhsachquangcao").addClass("active");
});
</script>

@endsection
