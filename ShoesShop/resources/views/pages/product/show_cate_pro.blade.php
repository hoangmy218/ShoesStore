
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
                            <div class="col-sm-12 col-md-12 col-lg-4 ftco-animate d-flex">
                             
                                <div class="product d-flex flex-column">
                                    <a href="#" class="img-prod"><img class="img-fluid" src="public/upload/product/{{$product->ha_ten}}" alt="Colorlib Template">
                                        <div class="overlay"></div>
                                    </a>
                                    <div class="text py-3 pb-4 px-3">
                                      <div class="d-flex">
                                            <div class="cat">
                                                <span>{{ $product->th_ten }}</span>
                                                
                                            </div>
                                            
                                            
                                        </div>
                                        <h3><a href="{{URL::to('/product-detail/'.$product->sp_ma)}}">{{$product->sp_ten}}</a></h3>
                                        <div class="pricing">
                                            <p class="price"><span>{{number_format($product->sp_donGiaBan).' '.'VNĐ'}}</span></p>
                                        </div>
                                        <p class="bottom-area d-flex px-3">
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
                                                 <a class="collapsed" href="{{URL::to('/show-pro-brand/'.$brand->th_ma)}}">{{$brand->th_ten}}
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
            </div>
        </div>
    </section>
@endsection