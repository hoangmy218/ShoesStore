@extends('shop_layout')
@section('content')

    <section id="home-section" class="hero">
        <div class="home-slider owl-carousel">
            <!-- Start Ngân (17/4/2020) -->

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

                                        <h1 class="mb-4 mt-3"> Hello - Tien</h1>
                                         

                                      </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                @endforeach
                <!-- End Ngân (17/4/2020) -->
          
        {{--   Bản cũ        
          <div class="slider-item js-fullheight">
            <div class="overlay"></div>
                <div class="container-fluid p-0">
                  <div class="row d-md-flex no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
                    <img class="one-third order-md-last img-fluid" src="{{URL::to('public/frontend/images/bg_1.png')}}" alt="">
                    <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                        <div class="text">
                          <span class="subheading">{{ __('Sản phẩm mới') }}</span>
                          <div class="horizontal">
                            <h1 class="mb-4 mt-3">{{ __('Bộ sưu tập giày 2019') }}</h1>
                            <p class="mb-4">{{ __('Loạt sản phẩm giày thể thao hoàn toàn khác biệt và đậm tính thời trang. Sắc màu của tôi - Giấc mơ của bạn.') }}</p>
                            
                            <p><a href="#" class="btn-custom">{{ __('Khám phá ngay') }}</a></p>
                            
                          </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>

          <div class="slider-item js-fullheight">
            <div class="overlay"></div>
            <div class="container-fluid p-0">
              <div class="row d-flex no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
                <img class="one-third order-md-last img-fluid" src="{{URL::to('public/frontend/images/bg_2.png')}}" alt="">
                  <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                    <div class="text">
                        <span class="subheading">{{ __('Sản phẩm mới') }}</span>
                        <div class="horizontal">
                            <h1 class="mb-4 mt-3">{{ __('Bộ sưu tập giày mùa hè mới') }}</h1>
                            <p class="mb-4">{{ __('Lắng nghe âm thanh của mùa hạ') }}</p>
                            
                            <p><a href="#" class="btn-custom">{{ __('Khám phá ngay') }}</a></p>
                          </div>
                    </div>
                  </div>
                </div>
            </div>
          </div> 
        --}}

        </div>
    </section>

    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row no-gutters ftco-services">
              <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services p-4 py-md-5">
                  <div class="icon d-flex justify-content-center align-items-center mb-4">
                        <span class="flaticon-bag"></span>
                  </div>
                  <div class="media-body">
                    <h3 class="heading">{{ __('Khuyến mãi') }}</h3>
                    <p>{{ __('Nhiều mã giảm giá hấp dẫn') }}</p>
                  </div>
                </div>      
              </div>
              <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services p-4 py-md-5">
                  <div class="icon d-flex justify-content-center align-items-center mb-4">
                        <span class="flaticon-customer-service"></span>
                  </div>
                  <div class="media-body">
                    <h3 class="heading">{{ __('Hỗ trợ khách hàng') }}</h3>
                    <p>{{ __('Nhanh chóng, kinh nghiệm và hiệu quả. Chúng tôi luôn luôn sẵn sàng giải đáp tất cả các thằc mắc và giải quyết nhanh chóng vấn đề của bạn!') }}</p>
                  </div>
                </div>    
              </div>
              <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services p-4 py-md-5">
                  <div class="icon d-flex justify-content-center align-items-center mb-4">
                        <span class="flaticon-payment-security"></span>
                  </div>
                  <div class="media-body">
                    <h3 class="heading">{{ __('Thanh toán bảo mật') }}</h3>
                    <p>{{ __('Dịch vụ được đảm bảo an toàn, nhanh chóng và bảo mật với hình thức thanh toán trực tuyến.') }}</p>
                  </div>
                </div>      
              </div>
            </div>
        </div>
    </section>

  <section class="ftco-section bg-light">
        <div class="container">
          <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
            <h2 class="mb-4">{{ __('Sản phẩm mới') }}</h2>
            <p>{{ __('Nâng niu bàn chân bạn') }}</p> 
                        
            </div>
          </div>          
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-10 order-md-last"> {{-- them --}}
                    <div class="row"> {{-- them --}}
                        @foreach($all_product as $key => $product)<!-- Tiên -->
                            <div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
                            {{-- <div class="col-sm-12 col-md-6 col-lg-3 ftco-animate d-flex"> sua --}}
                             
                                <div class="product d-flex flex-column">
                                    <a href="#" class="img-prod"><img class="img-fluid" src="{{asset('public/upload/product/'.$product->ha_ten)}}" alt="Colorlib Template">
                                        <div class="overlay"></div>
                                         <?php 
                                              $giamgia=(double)$product->sp_donGiaBan-($product->sp_donGiaBan*$product->km_giamGia/100);
                                              $time = \Carbon\Carbon::now('Asia/Ho_Chi_Minh');

                                              $today=$time->toDateString();
                                           ?>
                                         @if(($product->km_giamGia != 0) && ($product->km_ngayBD <= $today) && ($today <= $product->km_ngayKT))
                                          <span class="status">{{ __('Giảm ').$product->km_giamGia.'%' }}</span>
                                          @endif
                                    </a>
                                    <div class="text py-3 pb-4 px-3">
                                        <div class="d-flex">
                                            <div class="cat">
                                                <span>{{ $product->th_ten }}</span>
                                                
                                            </div>
                                            {{-- <div class="rating">
                                                <p class="text-right mb-0">
                                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                                    <a href="#"><span class="ion-ios-star-outline"></span></a>
                                                </p>
                                            </div> --}}
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
                                        <h3><a href="{{URL::to('/product-detail/'.$product->sp_ma.'/'.$ms)}}">{{$product->sp_ten}}</a></h3>
                                      <!-- start Ngân(13/5/2020) thêm giá khuyến mãi -->
                                        
                                        @if(($product->km_giamGia != 0) && ($product->km_ngayBD <= $today) && ($today <= $product->km_ngayKT))
                                              <div class="pricing">
                                                <p class="price"><span><del>{{number_format($product->sp_donGiaBan).' '.'VNĐ'}}</del></span></p>
                                              </div>
                                              <div class="pricing">
                                                <p class="price" style="color: red"><span><b>{{number_format($giamgia).' '.'VNĐ'}}</b></span></p>
                                            </div>
                                        @else
                                          <div class="pricing">
                                              <p class="price"><span>{{number_format($product->sp_donGiaBan).' '.'VNĐ'}}</
                                                span></p>
                                          </div>
                                        @endif
                                      <!-- end Ngân(13/5/2020) thêm giá khuyến mãi -->
                                        <p class="bottom-area d-flex px-3">
                                           {{--  <a href="#" class="add-to-cart text-center py-2 mr-1"><span>{{ __('Thêm giỏ hàng') }}<i class="ion-ios-add ml-1"></i></span></a>
                                            <a href="#" class="buy-now text-center py-2">{{ __('Buy now') }}<span><i class="ion-ios-cart ml-1"></i></span></a> --}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- Phan trang --}}
                    <div class="row mt-5">
                      <div class="col text-center">
                        <div class="block-27">
                          <ul>
                            <li class="active"><span>1</span></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                </div>

                  <!-- Start Ngân (13/5/2020)  -->
                {{-- Categories --}} 

                <div class="col-md-4 col-lg-2">
                    <div class="sidebar">
                        <div class="sidebar-box-2">
                            <h2 class="heading">{{ __('Danh mục')}}</h2>
                            <div class="fancy-collapse-panel">

                                <div class="panel-group"  role="tablist" aria-multiselectable="true">
                                    @foreach($list_cate as $key => $cate)
                                    <div class="panel panel-default">
                                         <div class="panel-heading" role="tab">
                                             <h4 class="panel-title">
                                                 <a class="collapsed" href="{{URL::to('/show-pro-category/'.$cate->dm_ma)}}">{{$cate->dm_ten}}
                                                 </a>
                                             </h4>
                                         </div>
                                     </div>
                                    @endforeach
                                </div>
                                     
                            </div>

                            {{-- Brand --}}
                            <h2 class="heading">{{ __('Thương hiệu')}}</h2>
                            <div class="fancy-collapse-panel">

                                <div class="panel-group"  role="tablist" aria-multiselectable="true">
                                     @foreach($list_brand as $key => $brand)
                                    <div class="panel panel-default">
                                         <div class="panel-heading" role="tab">
                                             <h4 class="panel-title">
                                                 <a class="collapsed" href="{{URL::to('/show-bra-category/'.$brand->th_ma)}}">{{$brand->th_ten}}
                                                 </a>
                                             </h4>
                                         </div>
                                     </div>
                                    @endforeach
                                   
                                </div>
                                     
                            </div>
                       </div>
                    </div>
                </div>
              <!-- end Ngân (13/5/2020)  -->
            </div>
        </div>
    </section>

    <section class="ftco-gallery">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 heading-section text-center mb-4 ftco-animate">
            {{-- <h2 class="mb-4">Follow Us On Instagram</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p> --}}
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