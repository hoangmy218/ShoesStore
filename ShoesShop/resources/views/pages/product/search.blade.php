
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
                <h2 class="mb-4">{{ __('Kết Quả Tìm Kiếm') }}</h2>
              </div>
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
        <div class="container">
            <div class="row">
                @foreach($search as $key => $product)<!-- Tiên -->
                <div class="col-sm-12 col-md-6 col-lg-3 ftco-animate d-flex">
                     
                    <div class="product d-flex flex-column">
                        <a href="#" class="img-prod"><img class="img-fluid" src="public/upload/product/{{$product->ha_ten}}" alt="Colorlib Template">
                            <div class="overlay"></div>
                            <span class="status">{{ __('Giảm 50%') }}</span>
                        </a>
                        <div class="text py-3 pb-4 px-3">
                            <div class="d-flex">
                                <div class="cat">
                                    <span>{{ __('Phong cách thời thượng') }}</span>
                                    
                                </div>
                                <div class="rating">
                                    <p class="text-right mb-0">
                                        <a href="#"><span class="ion-ios-star-outline"></span></a>
                                        <a href="#"><span class="ion-ios-star-outline"></span></a>
                                        <a href="#"><span class="ion-ios-star-outline"></span></a>
                                        <a href="#"><span class="ion-ios-star-outline"></span></a>
                                        <a href="#"><span class="ion-ios-star-outline"></span></a>
                                    </p>
                                </div>
                            </div>
                            <!-- Tiên -->
                            <h3><a href="{{URL::to('/product-detail/'.$product->sp_ma)}}">{{$product->sp_ten}}</a></h3>
                            <div class="pricing">
                                <p class="price"><span>{{number_format($product->sp_donGiaBan).' '.'VNĐ'}}</span></p>
                            </div>
                            <p class="bottom-area d-flex px-3">
                                <a href="#" class="add-to-cart text-center py-2 mr-1"><span>{{ __('Thêm giỏ hàng') }}<i class="ion-ios-add ml-1"></i></span></a>
                                <a href="#" class="buy-now text-center py-2">{{ __('Mua ngay') }}<span><i class="ion-ios-cart ml-1"></i></span></a>
                            </p>
                        </div>

                        
                    </div>
                    
                </div>
                @endforeach
 
            </div>
        </div>
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