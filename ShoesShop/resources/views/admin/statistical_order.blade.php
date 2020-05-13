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
                                            <h5>Thống kê sản phẩm</h5>
                                          
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
                                                <a href="{{URL::to('/statistical_order')}}">Thống kê sản phẩm</a>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>

                            </div>
                        </div>

                        {!!$chart_sp->html()!!}
</div>
{!!Charts::scripts()!!}

{!!$chart_sp->script()!!}   

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

        $('#thongke').parent().addClass('active open');
         $("#theosanpham").addClass("active");
     });
</script>  
@endsection


