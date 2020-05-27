@extends('admin_layout')
@section('content')
            
                <div class="main-content">
                    <div class="container-fluid">
                        <div class="row clearfix">
            <?php
                // Sản phẩm nhập
                    $total_spn= Session::get('total_spn');
                    $spn = Session::get('spn');
                // Sản phẩm bán
                    $total_spd= Session::get('total_spd');
                    $spd = Session::get('spd');
                // Doanh thu
                    $total_ren = Session::get('total_ren');
                    $Ren = Session::get('Ren');
                    
                // Bình luận
                    $total_comment = Session::get('total_comment');
                    $comment = Session::get('comment');
                    
            ?>
            <!-- Sản phẩm bán start -->
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="widget">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Sản phẩm bán ra</h6>
                                                <h2>{{$total_spd}}</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="ik ik-package"></i>
                                            </div>
                                        </div>
                                        @if($spd > 0)
                                            <?php  
                                                $spd = floor($spd);
                                            ?>
                                            <small class="text-small mt-10 d-block">Tăng {{$spd}}% so với tháng trước</small>
                                        @else
                                            <?php  
                                                $spd = floor($spd);
                                                $spd = abs($spd);
                                            ?>
                                            <small class="text-small mt-10 d-block">Giảm {{$spd}}% so với tháng trước</small>
                                        @endif 
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                <!-- Sản phẩm bán end -->
                <!-- Số lượng nhập start -->
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="widget">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Sản phẩm nhập vào</h6>
                                                <h2>{{$total_spn}}</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="ik ik-package"></i>
                                            </div>
                                        </div>
                                        @if($spn > 0)
                                            <?php  
                                                $spn = floor($spn);
                                            ?>
                                            <small class="text-small mt-10 d-block">Tăng {{$spn}}% so với tháng trước</small>
                                        @else
                                            <?php  
                                                $spn = floor($spn);
                                                $spn = abs($spn);
                                            ?>
                                            <small class="text-small mt-10 d-block">Giảm {{$spn}}% so với tháng trước</small>
                                        @endif 
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                <!-- Số lượng nhập end -->
                <!-- Doanh thu start -->
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="widget">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Doanh thu</h6>
                                                <h2>{{number_format($total_ren)}}</h2>
                                            </div>
                                            <div class="icon">VNĐ
                                               {{--  <i class="ik ik-dollar-sign"></i> --}}
                                            </div>
                                        </div>
                                        @if($Ren > 0)
                                            <?php  
                                                $Ren = floor($Ren);
                                            ?>
                                            <small class="text-small mt-10 d-block">Tăng {{$Ren}}% so với tháng trước</small>
                                        @else
                                            <?php  
                                                $Ren = floor($Ren);
                                                $Ren = abs($Ren);
                                            ?>
                                            <small class="text-small mt-10 d-block">Giảm {{$Ren}}% so với tháng trước</small>
                                        @endif
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                <!-- Doanh thu end -->
                <!-- Bình luận start -->
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="widget">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Bình luận</h6>
                                                <h2>{{$total_comment}}</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="ik ik-message-square"></i>
                                            </div>
                                        </div>
                                        @if($comment > 0)
                                            <?php  
                                                $comment = floor($comment);

                                            ?>
                                            
                                            <small class="text-small mt-10 d-block">Tăng {{$comment}}% so với tháng trước</small>
                                        @else
                                            <?php  
                                                $comment = floor($comment);
                                                $comment = abs($comment);
                                            ?>
                                            <small class="text-small mt-10 d-block">Giảm {{$comment}}% so với tháng trước</small>
                                        @endif
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                <!-- Bình luận end -->
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                
                            </div>
                            
                        </div>

                        


                      
                    </div>
                </div>

              
             
                <script src="http://www.codermen.com/js/jquery.js"></script>
<script>
$(document).ready(function(){
    
    //$( '#dashboard').parent().find( 'div.nav-item.active').removeClass( 'active' );
    var className = $('#dashboard').attr('class');
    var parName = $( '#dashboard').parent().attr('class');
    console.log('classN: ',className);
    console.log('par: ',parName);
    $( '#dashboard').parent().addClass('active');
    var parName = $( '#dashboard').parent().attr('class');
    console.log('par: ',parName);

            //$( '#dashboard' ).parent().addClass( 'active' );
});
</script>
@endsection

@section('script_dashboard')

<script src="{{asset('public/backend/plugins/screenfull/dist/screenfull.js')}}"></script>
        <script src="{{asset('public/backend/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/jvectormap/jquery-jvectormap.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/jvectormap/tests/assets/jquery-jvectormap-world-mill-en.js')}}"></script>
        <script src="{{asset('public/backend/plugins/moment/moment.js')}}"></script>
        <script src="{{asset('public/backend/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/d3/dist/d3.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/c3/c3.min.js')}}"></script>
        <script src="{{asset('public/backend/js/tables.js')}}"></script>
        <script src="{{asset('public/backend/js/widgets.js')}}"></script>
        <script src="{{asset('public/backend/js/charts.js')}}"></script>
        <script src="{{asset('public/backend/dist/js/theme.min.js')}}"></script>

@endsection