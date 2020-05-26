
@extends('shop_layout')
@section('content')

  <section class="ftco-section bg-light">
        <div class="container">
                <div class="row justify-content-center mb-3 pb-3">
          <div class="col-md-12 heading-section text-center ftco-animate">
            <h2 class="mb-4">{{ __('Sản phẩm') }}</h2>
          </div>
        </div>          
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-10 order-md-last">
                  <?php 
                      $count_th = Session::get('count_th');
                  ?>
                    <div class="row">
                  @foreach($list_bra_pro as $key => $product)
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
<<<<<<< HEAD
                          <a href="#" class="img-prod" ><img  class="img-fluid" src="{{asset('public/upload/product/'.$product->ha_ten)}}" alt="Colorlib Template">
                            <span class="status" style="background-color: red; color: yellow;"><b>MỚI</b></span>
                            <div class="overlay" ></div></a>
=======
                          <a class="img-prod"><img class="img-fluid" src="{{asset('public/upload/product/'.$product->ha_ten)}}" alt="Colorlib Template">
                             <span class="status" style="background-color: red; color: yellow;"><b>MỚI</b></span>
                            <div class="overlay"></div></a>

>>>>>>> 9177047ee8cdfd88f57d50d48779208b2fef809e

                          <div class="text py-3 pb-4 px-3">
                            <!-- Show hình sp -->
                              <div class="d-flex">
                                  <div class="cat">
                                      <span>{{ $product->th_ten }}</span>
                                   </div>
                                              
                              </div>
<<<<<<< HEAD
                               <!-- Tiên 13/05-->
                                <?php
=======
                              <?php
>>>>>>> 9177047ee8cdfd88f57d50d48779208b2fef809e
                                  $request= DB::table('cochitietsanpham')->select('ms_ma')->where('sp_ma','=',$product->sp_ma)->first();
                                  $ms=$request->ms_ma;
                                  // echo "<pre>";
                                  // print_r($ms);
                                  // echo "</pre>";
                                  // echo $ms_ma=$request->ms_ma;
                                ?>
<<<<<<< HEAD
                               
                              <h3 ><a style="background-image: url({{asset('public/frontend/images/hot-icon-2.gif')}}); background-size: contain; background-repeat: no-repeat; background-position: right;" href="{{URL::to('/product-detail/'.$product->sp_ma.'/'.$ms)}}" >{{$product->sp_ten}} &emsp;&emsp;</a></h3>
                             
=======
                              <h3 ><a style="background-image: url({{asset('public/frontend/images/hot-icon-2.gif')}}); background-size: contain; background-repeat: no-repeat; background-position: right;" href="{{URL::to('/product-detail/'.$product->sp_ma.'/'.$ms)}}" >{{$product->sp_ten}} &emsp;&emsp;</a></h3>
>>>>>>> 9177047ee8cdfd88f57d50d48779208b2fef809e

                              <!-- Show giá sp -->
                              @if(($product->km_giamGia != 0) && ($product->km_ngayBD <= $today) && ($today <= $product->km_ngayKT))
                                <div class="pricing">
                                  <p class="price"><span><del>{{number_format($product->sp_donGiaBan).' '.'VNĐ'}}</del></span></p>
                                </div>
                                <div class="pricing">
                                  <p class="price" style="color: red;"><span><b>{{number_format($giamgia).' '.'VNĐ'}}</b></span></p>
<<<<<<< HEAD
                                 
=======
                                  
>>>>>>> 9177047ee8cdfd88f57d50d48779208b2fef809e
                                </div>
                              @else
                                <div class="pricing">
                                  <p class="price"><span>{{number_format($product->sp_donGiaBan).' '.'VNĐ'}}</span></p>
<<<<<<< HEAD
                                  
=======
                                 
>>>>>>> 9177047ee8cdfd88f57d50d48779208b2fef809e
                                </div>
                              @endif
                            </div>
                        </div>
                      </div>
                    @else
                      <div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
                        <div class="product d-flex flex-column">
                          <!-- Show hình sp -->
                          <a href="#" class="img-prod"><img class="img-fluid" src="{{asset('public/upload/product/'.$product->ha_ten)}}" alt="Colorlib Template">
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
                    <div class="col text-center">
                      <div class="block-27">
                       <!--Tổng số trang--> <!--{{  $list_bra_pro ->lastPage() }} -->
                        <ul>
                          @for($i=1 ; $i <= $list_bra_pro ->lastPage() ; $i ++)
                         <!--  <li><a href="#">Prev</a></li> -->
                          <li class="active" >
                              <a href="{{ str_replace('/?','?',$list_bra_pro->url($i)) }}">
                                {{ $i }}
                              </a>
                          </li>
                          <!-- <li><a href="#">Next</a></li> -->
                          @endfor
                        </ul>

                      </div>
                     
                    </div>
                  </div>
                </div>

                <div class="col-md-4 col-lg-2">
                    <div class="sidebar">
                        <div class="sidebar-box-2">
                            <h2 class="heading">{{ __('Danh mục')}}</h2>
                            <div class="fancy-collapse-panel">
                                <div class="panel-group"  role="tablist" aria-multiselectable="true">
                                  <?php $dm=0; ?>
                                    @foreach($list_cate as $key => $cate)
                                      @if($dm_array[$dm] != 0)
                                        <div class="panel panel-default">
                                               <div class="panel-heading" role="tab">
                                                   <h4 class="panel-title">
                                                       <a class="collapsed" href="{{URL::to('/show-pro-category/'.$cate->dm_ma)}}">{{$cate->dm_ten}} (<?php echo $dm_array[$dm]; ?>)
                                                       </a>
                                                   </h4>
                                               </div>
                                           </div>
                                      @endif
                                      <?php $dm++; ?>
                                    @endforeach
                                </div>
                                     
                            </div>

                            {{-- Brand --}}
                            <h2 class="heading">{{ __('Thương hiệu')}}</h2>
                            <div class="fancy-collapse-panel">

                                <div class="panel-group"  role="tablist" aria-multiselectable="true">
                                    <?php 
                                      $th_hienhanh = Session::get('th_hienhanh');
                                      $th=0;
                                    ?>

                                <div class="panel-group"  role="tablist" aria-multiselectable="true">
                                    @foreach($list_brand as $key => $brand)
                                      @if($th_array[$th] != 0)
                                        @if ($th_hienhanh == $brand->th_ma)
                                          <div class="panel panel-default">
                                             <div class="panel-heading" role="tab">
                                                 <h4 class="panel-title">
                                                     <a style="color: red;" class="collapsed" href="{{URL::to('/show-pro-brand/'.$brand->th_ma)}}"><u>{{$brand->th_ten}} (<?php echo $th_array[$th]; ?>)</u>
                                                     </a>
                                                 </h4>
                                             </div>
                                         </div>
                                        @else
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab">
                                                 <h4 class="panel-title">
                                                     <a class="collapsed" href="{{URL::to('/show-pro-brand/'.$brand->th_ma)}}">{{$brand->th_ten}} (<?php echo $th_array[$th]; ?>)
                                                     </a>
                                                 </h4>
                                             </div>
                                         </div>
                                        @endif
                                      @endif
                                      <?php $th++; ?>
                                    @endforeach


                                </div>
                                     
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection