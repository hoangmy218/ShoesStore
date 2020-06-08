
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
                  
                <div class="row">
                  @foreach($list_cate_pro as $key => $product)
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
                          <a class="img-prod"><img class="img-fluid" src="{{asset('public/upload/product/'.$product->ha_ten)}}" alt="Colorlib Template">
                             <span class="status" style="background-color: red; color: yellow;"><b>MỚI</b></span>
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
                      <div class="col text-right">
                          {{ $list_cate_pro->links() }}
                      </div>
                     
                    </div>
                  </div>
                
               <div class="col-md-4 col-lg-2">
                    <div class="sidebar">
                        <div class="sidebar-box-2">
                            <h2 class="heading">{{ __('Danh mục')}}</h2>
                             <?php 
                                  $dm_hienhanh = Session::get('dm_hienhanh');
                                  $dm=0;
                                ?>
                            <div class="fancy-collapse-panel">
                                <div class="panel-group"  role="tablist" aria-multiselectable="true">
                                  
                                    @foreach($list_cate as $key => $cate)
                                      @if($dm_array[$dm] != 0)
                                        @if ($dm_hienhanh == $cate->dm_ma)
                                          <div class="panel panel-default">
                                               <div class="panel-heading" role="tab">
                                                   <h4  class="panel-title">
                                                       <a style="color: red;" class="collapsed" href="{{URL::to('/show-pro-category/'.$cate->dm_ma)}}"><u>{{$cate->dm_ten}} (<?php echo $dm_array[$dm]; ?>)</u></a>
                                                   </h4>
                                               </div>
                                           </div>
                                        @else
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
                                      @endif
                                    @endforeach
                                  
                                </div>
                                     
                            </div>

                            {{-- Brand --}}
                            <h2 class="heading">{{ __('Thương hiệu')}}</h2>
                            <div class="fancy-collapse-panel">

                                <div class="panel-group"  role="tablist" aria-multiselectable="true">
                                  <?php $th=0; ?>
                                     @foreach($list_brand as $key => $brand)
                                        @if($th_array[$th] != 0)
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
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection