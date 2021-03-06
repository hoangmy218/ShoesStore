@extends('shop_layout')
@section('content')

<!-- Start: Show quảng cáo -->
    <section id="home-section" class="hero">
        <div class="home-slider owl-carousel">

                @foreach( $list_ad as $key => $ad)
                    <div class="slider-item js-fullheight">
                        <div class="overlay"></div>
                        <div class="container-fluid p-0">
                          <div class="row d-md-flex no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
                            <img class="one-third order-md-last img-fluid" src="public/upload/advertisement/{{$ad->qc_hinhAnh}}" alt="">
                              <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                                <div class="text">
                                    <span class="subheading">{{$ad->qc_chuDe}}</span>
                                    <div class="horizontal">
                                        <h1 class="mb-4 mt-3"></h1>
                                      </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                @endforeach
        </div>
    </section>
<!-- End: Show quảng cáo -->




  <section class="ftco-section bg-light">
        <div class="container">
          <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
              <h2 class="mb-4">{{ __('Sản phẩm mới') }}</h2>
              <p>{{ __('Nâng niu bàn chân bạn') }}</p>
            </div>
          </div>          
        </div>

<!-- Start: Show sản phẩm -->
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-lg-10 order-md-last">
                <div class="row">

                  @foreach($all_product as $key => $product)
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
                
                    {{-- Phan trang --}}
                 <div class="row mt-5">

                    <div class="col text-right">
                        {{ $all_product->links() }}

                    </div>
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
                       </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="ftco-gallery">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 heading-section text-center mb-4 ftco-animate">
          </div>
            </div>
        </div>
        <div class="container-fluid px-0">
            <div class="row no-gutters">
                    <div class="col-md-4 col-lg-2 ftco-animate">
                        <a href="{{URL::to('public/frontend/images/gallery-1.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url({{URL::to('public/frontend/images/gallery-1.jpg')}});">
                            <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2 ftco-animate">
                        <a href="{{URL::to('public/frontend/images/gallery-2.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url({{URL::to('public/frontend/images/gallery-2.jpg')}});">
                            <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2 ftco-animate">
                        <a href="{{URL::to('public/frontend/images/gallery-3.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url({{URL::to('public/frontend/images/gallery-3.jpg')}});">
                            <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2 ftco-animate">
                        <a href="{{URL::to('public/frontend/images/gallery-4.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url({{URL::to('public/frontend/images/gallery-4.jpg')}});">
                            <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2 ftco-animate">
                        <a href="{{URL::to('public/frontend/images/gallery-5.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url({{URL::to('public/frontend/images/gallery-5.jpg')}});">
                            <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-2 ftco-animate">
                        <a href="{{URL::to('public/frontend/images/gallery-6.jpg')}}" class="gallery image-popup img d-flex align-items-center" style="background-image: url({{URL::to('public/frontend/images/gallery-6.jpg')}});">
                            <div class="icon mb-4 d-flex align-items-center justify-content-center">
                            <span class="icon-instagram"></span>
                        </div>
                        </a>
                    </div>
        </div>
        </div>
    </section>

    <!--  Tien 16/05 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="http://www.codermen.com/js/jquery.js"></script>
<script>
    $(document).ready(function(){
             
             //dat thi gian tat thong bao
            setTimeout(function(){
               $("span.alert").remove();
            }, 10000 ); // 5 secs

    });
</script>


@endsection