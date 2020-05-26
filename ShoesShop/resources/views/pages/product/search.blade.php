
<!--  Tiên -->

@extends('shop_layout')
@section('content')

   <div class="hero-wrap hero-bread" style="background-image: url({{URL::to('public/frontend/images/bg_6.jpg')}});">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <p class="breadcrumbs"><span class="mr-2"><a href="{{URL::to('/')}}">{{ __('Trang chủ') }}</a></span> <span>{{ __('Cửa hàng') }}</span></p>
            <h1 class="mb-0 bread">{{ __('Cửa hàng') }}</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
              <div class="col-md-12 heading-section text-center ftco-animate">
                  <!--  Tien 07/05 -->
                <h2 class="mb-4">{{ __('Kết Quả Tìm Kiếm') }}</h2>
              </div>
                <!--  Tien 07/05 -->
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
            </div>          
        </div>

        <!-- Start: Show sản phẩm -->
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-lg-10 order-md-last">
             <!-- Tiên -->
                <div class="row">

                  @foreach($search as $key => $product)
                    <?php 
                      $time = \Carbon\Carbon::now('Asia/Ho_Chi_Minh');
                      $today=$time->toDateString();

                      $datediff = abs(strtotime($time) - strtotime($product->pn_ngayNhap));
                      $days = floor($datediff / (60*60*24));

                      $giamgia=(double)$product->sp_donGiaBan-($product->sp_donGiaBan*$product->km_giamGia/100);
                    ?>
                    @if( $days <= 30)
                      <div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
                        <div class="product d-flex flex-column" >
                          <!-- Show hình sp -->
                          <a href="#" class="img-prod" ><img  class="img-fluid" src="public/upload/product/{{$product->ha_ten}}" alt="Colorlib Template">
                            <span class="status" style="background-color: red; color: yellow;"><b>MỚI</b></span>
                            <div class="overlay" ></div></a>

                          <div class="text py-3 pb-4 px-3">
                            <!-- Show hình sp -->
                              <div class="d-flex">
                                  <div class="cat">
                                      <span>{{ $product->th_ten }}</span>
                                   </div>
                                              
                              </div>
                               <!-- Tiên 13/05-->
                                <?php
                                  $request= DB::table('cochitietsanpham')->select('ms_ma')->where('sp_ma','=',$product->sp_ma)->first();
                                  $ms=$request->ms_ma;
                                  // echo "<pre>";
                                  // print_r($ms);
                                  // echo "</pre>";
                                  // echo $ms_ma=$request->ms_ma;
                                ?>
                               
                              <h3 ><a style="background-image: url({{asset('public/frontend/images/hot-icon-2.gif')}}); background-size: contain; background-repeat: no-repeat; background-position: right;" href="{{URL::to('/product-detail/'.$product->sp_ma.'/'.$ms)}}" >{{$product->sp_ten}} &emsp;&emsp;</a></h3>
                             

                              <!-- Show giá sp -->
                              @if(($product->km_giamGia != 0) && ($product->km_ngayBD <= $today) && ($today <= $product->km_ngayKT))
                                <div class="pricing">
                                  <p class="price"><span><del>{{number_format($product->sp_donGiaBan).' '.'VNĐ'}}</del></span></p>
                                </div>
                                <div class="pricing">
                                  <p class="price" style="color: red;"><span><b>{{number_format($giamgia).' '.'VNĐ'}}</b></span></p>
                                 
                                </div>
                              @else
                                <div class="pricing">
                                  <p class="price"><span>{{number_format($product->sp_donGiaBan).' '.'VNĐ'}}</span></p>
                                  
                                </div>
                              @endif
                            </div>
                        </div>
                      </div>
                    @else
                      <div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
                        <div class="product d-flex flex-column">
                          <!-- Show hình sp -->
                          <a href="#" class="img-prod"><img class="img-fluid" src="public/upload/product/{{$product->ha_ten}}" alt="Colorlib Template">
                            <div class="overlay"></div></a>

                          <div class="text py-3 pb-4 px-3">
                            <!-- Show hình sp -->
                              <div class="d-flex">
                                  <div class="cat">
                                      <span>{{ $product->th_ten }}</span>
                                   </div>
                                              
                              </div>
                              <?php
                                  $request= DB::table('cochitietsanpham')->select('ms_ma')->where('sp_ma','=',$product->sp_ma)->first();
                                  $ms=$request->ms_ma;
                                  // echo "<pre>";
                                  // print_r($ms);
                                  // echo "</pre>";
                                  // echo $ms_ma=$request->ms_ma;
                                ?>
                              <h3><a href="{{URL::to('/product-detail/'.$product->sp_ma.'/'.$ms)}}">{{$product->sp_ten}}</a></h3>

                              <!-- Show giá sp -->
                              @if(($product->km_giamGia) && ($product->km_ngayBD <= $today) && ($today <= $product->km_ngayKT))
                                <div class="pricing">
                                  <p class="price"><span><del>{{number_format($product->sp_donGiaBan).' '.'VNĐ'}}</del></span>
                                </div>
                                <div class="pricing">
                                  <p class="price" style="color: red"><span><b>{{number_format($giamgia).' '.'VNĐ'}}</b></span></p>
                                </div>
                              @else
                                <div class="pricing">
                                  <p class="price"><span>{{number_format($product->sp_donGiaBan).' '.'VNĐ'}}</span></p>
                                </div>
                              @endif
                            </div>
                        </div>
                      </div>
                    @endif
                  @endforeach
                </div>
              </div>
<!-- End: Show sản phẩm -->


                {{-- Categories --}} 

                <div class="col-md-4 col-lg-2">
                    <div class="sidebar">
                        <div class="sidebar-box-2">
<!-- Start: Show danh mục -->
                            <h2 class="heading">{{ __('Danh mục')}}</h2>
                            <div class="fancy-collapse-panel">

                                <div class="panel-group"  role="tablist" aria-multiselectable="true">
                                   <?php $dm=0; ?>
                                    @foreach($list_cate as $key => $cate)
                                      @if($dm_array[$dm]!=0)
                                        <div class="panel panel-default">
                                             <div class="panel-heading" role="tab">
                                                 <h4 class="panel-title">
                                                     <a class="collapsed" href="{{URL::to('/show-pro-category/'.$cate->dm_ma)}}">{{$cate->dm_ten}} (<?php echo $dm_array[$dm]; ?>)</a>
                                                 </h4>
                                             </div>
                                         </div>
                                       @endif
                                     <?php $dm++; ?>
                                    @endforeach
                                </div>  
                            </div>
<!--End: Show danh mục -->

<!-- Start: Show thương hiệu -->
                            {{-- Brand --}}
                            <h2 class="heading">{{ __('Thương hiệu')}}</h2>
                            <div class="fancy-collapse-panel">
                                <div class="panel-group"  role="tablist" aria-multiselectable="true">
                                  <?php $th=0; ?>
                                     @foreach($list_brand as $key => $brand)
                                     @if($th_array[$th])
                                    <div class="panel panel-default">
                                         <div class="panel-heading" role="tab">
                                             <h4 class="panel-title">
                                                 <a class="collapsed" href="{{URL::to('/show-pro-brand/'.$brand->th_ma)}}">{{$brand->th_ten}} (<?php echo $th_array[$th]; ?>)
                                                 </a>
                                             </h4>
                                         </div>
                                     </div>
                                     @endif
                                     <?php $th++; ?>
                                    @endforeach
                                </div>
                                     
                            </div>
<!-- Start: Show thương hiệu -->
    </section>

    <!--  Tien 07/05 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="http://www.codermen.com/js/jquery.js"></script>
<script>
  $(document).ready(function(){
           
           //dat thi gian tat thong bao
          setTimeout(function(){
             $("span.alert").remove();
          }, 5000 ); // 5 secs

  });
</script>
              
        <!--/recommended_items-->
@endsection