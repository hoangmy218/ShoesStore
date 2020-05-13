@extends('shop_layout')
@section('script_thumbnail')
{{-- <link href="{{asset('public/frontend/css/ThumbnailGallery/bootstrap.css')}}" rel="stylesheet" type="text/css" media="all" /> --}}

<!--theme-style-->
<link href="{{asset('public/frontend/css/ThumbnailGallery/style.css')}}" rel="stylesheet" type="text/css" media="all" />	
<link rel="stylesheet" href="{{asset('public/frontend/css/ThumbnailGallery/etalage.css')}}" type="text/css" media="all" />
{{-- <!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--fonts-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'> --}}
<!--//fonts-->
<script src="{{asset('public/frontend/js/ThumbnailGallery/jquery.min.js')}}"></script>

<script src="{{asset('public/frontend/js/ThumbnailGallery/jquery.etalage.min.js')}}"></script>
<script>
			jQuery(document).ready(function($){

				$('#etalage').etalage({
					thumb_image_width: 500,
					thumb_image_height: 500,
					source_image_width: 900,
					source_image_height: 1200,
					show_hint: true,
					
				});

			});
		</script>
@endsection
@section('content')


{{-- <link href="rateit/src/rateit.css" rel="stylesheet" type="text/css">
<script src="rateit/src/jquery.rateit.js" type="text/javascript"></script>  --}}

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

    <section class="ftco-section">
    	<div class="container">
    		@foreach($details_product as $key => $value)
    		<form action="{{URL::to('/save-cart')}}" method="POST">
				{{ csrf_field() }}
    		<div class="row">
    		
    			{{-- <div class="col-lg-6 mb-5 ftco-animate">
    				<a href="{{URL::to('/product-detail')}}">
    					<img src="{{URL::to('public/upload/product/'.$value->ha_ten)}}" class="img-fluid" alt="Colorlib Template">
    				</a>
    			</div> --}}
    			<div class="col-lg-6 mb-5 ftco-animate">
    			<div class="grid images_3_of_2">
						<ul id="etalage">
							@foreach($image_product as $key => $img_pro)
							<li>
								<a href="{{URL::to('public/upload/product/'.$img_pro->ha_ten)}}">
									<img class="etalage_thumb_image" src="{{URL::to('public/upload/product/'.$img_pro->ha_ten)}}" class="img-responsive" />
									<img class="etalage_source_image" src="{{URL::to('public/upload/product/'.$img_pro->ha_ten)}}" class="img-responsive" title="" />
								</a>
							</li>
							@endforeach
							
						</ul>
							<div class="clearfix"> </div>		
				  </div>
				</div>
				
				<div class="col-lg-6 product-details pl-md-5 ftco-animate">
    				
    				<h3>{{$value->sp_ten}}</h3>
    				
    				<div class="rating d-flex">
							{{-- <p class="text-left mr-4">
								<a href="#" class="mr-2">5.0</a>
								<a href="#"><span class="ion-ios-star-outline"></span></a>
								<a href="#"><span class="ion-ios-star-outline"></span></a>
								<a href="#"><span class="ion-ios-star-outline"></span></a>
								<a href="#"><span class="ion-ios-star-outline"></span></a>
								<a href="#"><span class="ion-ios-star-outline"></span></a>
							</p> --}}
							<p class="text-left mr-4">
								<a href="#" class="mr-2" style="color: #000;">
									{{$total_view}}
									<span style="color: #bbb;">{{ __('Đánh giá') }}</span>
								</a>
							</p>
							<p class="text-left">
								
								<a href="#" class="mr-2" style="color: #000;">
									
									<!-- tiên 18/04 -->
									
								 	<span style="color: #bbb;">{{ __('Đã bán') }}</span>
								</a>
								
							</p>
						</div>
    				<p class="price"><span>{{number_format($value->sp_donGiaBan).' '.'VNĐ'}}</span></p>
    				
						<div class="row mt-4">

							<div class="col-md-6">
								<div class="form-group d-flex">
						            <div class="select-wrap">
					                  <div class="icon">
					                  	<span class="ion-ios-arrow-down"></span>
					                  </div>
					                  	<?php 
						                 	
						                 	$array_ms = array();
						                 	$arr_ms = array();
						                 	
						                 	foreach($sz_product as $key => $ms){
						                 		
						                 		// $array[$sz->sp_ma] = $ms->ms_ten;
						                 		
							                 	// echo 'ma'.$ms->ms_ma;
							                 	// echo 'ten'.$ms->ms_ten;
							                 	$arr_ms[$ms->ms_ma]=$ms->ms_ten;
							                 	
						                 	}
						                 	
						                 	// echo '<pre>';
						                 	// print_r($arr_ms); 	
						                 	// echo '</pre>';

						                 	/*echo '<pre>';
						                 	print_r($array);echo '</pre>';
						                 	echo '<pre>';
						                 	print_r(array_unique($array));echo '</pre>';
						                 	$a = array();
						                 	$a = array_unique($array);*/
											 	
								        ?>
					           
										<select id="mausac" name="mausac" class="form-control" required="" pattern="" style="width:200px" >
						                	<option value=""  selected disabled>{{ __('Chọn màu sắc') }}</option>
						                 	
						                  	@foreach($arr_ms as $key => $val)
						                  		<option value="{{$key}}">{{$val}}</option>
						                  		
						                  	@endforeach
						                </select>
						                  		
					                </div>
						        </div>
							</div>
							
							<div class="w-100"></div>

							<div class="col-md-6">
								<div class="form-group d-flex">
						            <div class="select-wrap">
					                  <div class="icon">
					                  	<span class="ion-ios-arrow-down"></span>
					                  </div>
					                  	<?php 
						                 	
						                 	$array = array();
						                 	
						                 	foreach($sz_product as $key => $sz){
						                 		
						                 		 $array[$sz->kc_ma] = $sz->kc_ten;
						                 		// array_push($array, "$sz->sp_ma");
						                 		// $b=array_push($array, "$sz->kc_ten");
						                 		// $c=array_unique($array);
						                 		// for( $i=0; $i < count($c) ; $i++){
							                 	// 	$d[$i] = $sz->sp_ma;
						                 		// }

						                 		// $kq_sz=array_combine($c,$d);
						                 	}
						                 	
						                 	//  echo '<pre>';
						                 	// print_r($array); 	
						                 	// echo '</pre>';
						                 

						                 	/*echo '<pre>';
						                 	print_r($array);echo '</pre>';
						                 	echo '<pre>';
						                 	print_r(array_unique($array));echo '</pre>';
						                 	$a = array();
						                 	$a = array_unique($array);*/
											 	
								        ?>
					           
										<select id="size" name="size" class="form-control" required="" pattern="" style="width:200px" >
						                	<option value=""  selected disabled>{{ __('Chọn kích cỡ') }}</option>
						                 	
						                  	@foreach($array as $key => $val)
						                  		<option value="{{$key}}">{{$val}}</option>
						                  		
						                  	@endforeach
						                </select>
						                  		
					                </div>
						        </div>
							</div>
							
							<div class="w-100"></div>
							<!-- <div class="col-md-6">
								<div class="form-group d-flex">
						            <div class="select-wrap">
					                  <div class="icon">
					                  	<span class="ion-ios-arrow-down"></span>
					                  </div>
					                  <select name="slton" id="slton" class="form-control" style="width:200px">
               						  </select>
					                </div>
						        </div>
							</div> -->
															                
							<div class="input-group col-md-6 d-flex mb-3">
					             	<span class="input-group-btn mr-2">
					                	<button type="button" class="quantity-left-minus btn"  data-type="minus" data-field="">
					                   <i class="ion-ios-remove"></i>
					                	</button>
					            	</span>

					            	
						            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number" value="1" min="1" max="5">
					  
					             	<!-- {{-- @foreach($sz_product as $key => $slt)
					                  	<option value="{{$slt->ctsp_ma}}" name="opsize">{{$slt->soLuongTon}}</option>
					                @endforeach --}} -->
					                
					             	<span class="input-group-btn ml-2">
					                	<button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
					                     <i class="ion-ios-add"></i>
					                 	</button>
					             	</span>
					        </div>

					        <input type="hidden" name="productid_hidden" id="spma" value="{{$value->sp_ma}}">

					        <div class="w-100"></div>
					        
					        <br>
					        <div class="col-md-12">
					        	<!-- @foreach($sz_product as $key => $conlai)
					          		<p style="color: #000;">Size {{$conlai->kc_ten}} màu {{$conlai->ms_ten}} có sẵn {{$conlai->soLuongTon}} đôi</p> 
					            @endforeach -->
					        </div>
				        	</div>

				        	
				          	<!-- <p><a href="cart.html" class="btn btn-primary py-3 px-5">{{ __('Mua ngay') }}</a></p> -->

						</div>
				
				    			
    			</div>
    			<div class="row">
    				<div class="col-lg-6 ">
    					
    				</div>
    				<div class="col-lg-6 ">
    					<div class="sign-btn text-center ">
				        	<button type="submit" class="btn btn-theme btn-primary py-3 px-5">{{ __('Thêm giỏ hàng') }}</button>
				        	
				        </div>
    				</div>
    			</div>
    					
    		</form>


<!-- Tien 13/3 -->
    		<!-- <form action="{{URL::to('/reviews')}}" method="POST">
				{{ csrf_field() }}
					<div class="col-lg-8 ">
    					<div class="sign-btn text-right ">
				     <button type="submit" class="btn btn-theme btn-primary py-3 px-5">{{ __('Đánh giá') }}</button>
				       </div>
    				</div>
			</form> -->
		@endforeach



    		<div class="row mt-5">
          <div class="col-md-12 nav-link-wrap">
            <div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link ftco-animate active mr-lg-1" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">{{ __('Mô tả') }}</a>

              <a class="nav-link ftco-animate mr-lg-1" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">{{ __('Nhà sản xuất') }}</a>

              <a class="nav-link ftco-animate" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">{{ __('Đánh giá') }}</a>

            </div>
          </div>
          <div class="col-md-12 tab-wrap">
            
            <div class="tab-content bg-light" id="v-pills-tabContent">
            	@foreach($details_product as $key => $value)
              <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="day-1-tab">
              	<div class="p-4">
              		
	              	<h3 class="mb-4">{{$value->sp_ten}}</h3>
	              	<p>{{$value->sp_moTa}}</p>

              	</div>
              </div>

              <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-day-2-tab">
              	<div class="p-4">
	              	<h3 class="mb-4">{{$value->th_ten}}</h3>
	              	<p>...</p>
              	</div>

              </div>
              @endforeach
              <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-day-3-tab">
              	<div class="row p-4">
              		
						   		 <div class="col-md-7 "> <!-- Tiên 14/03 -->
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
						                        <br>
						                        <br>
						   		 	<h3 class="mb-4">{{$total_view}} {{ __('nhận xét:') }}</h3>
						   		 	@foreach($comments as $key => $comment)
						   		 	
						   						   			
						   			<div class="review">
								   		<div class="user-img" style="background-image: url({{URL::to('public/frontend/images/avatar.jpg')}})"></div>
								   		<div class="desc">
								   			<h4>
								   				<span class="text-left">{{$comment->nd_ten}}</span>
								   				<span class="text-right">{{$comment->ngayBinhLuan}}</span>
								   				<!-- <span class="text-right">{{date('d/m/Y H:i',strtotime($comment->created_at))}}</span> -->
								   			</h4>
								   			<p class="star">
								   				<span>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
								   					<i class="ion-ios-star-outline"></i>
							   					</span>
							   					<span class="text-right"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
								   			</p>
								   			<p>{{$comment->noiDung}}</p>
								   		</div>
								   	</div>
								   	@endforeach		
								   	
						   		</div>
					
						   		{{-- <div class="col-md-4">
						   			<div class="rating-wrap">
							   			<h3 class="mb-4">{{ __('Đánh giá') }}</h3>
							   			<p class="star">
							   				<span>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					(98%)
						   					</span>
						   					<span>20 Reviews</span>
							   			</p>
							   			<p class="star">
							   				<span>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					(85%)
						   					</span>
						   					<span>10 Reviews</span>
							   			</p>
							   			<p class="star">
							   				<span>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					(98%)
						   					</span>
						   					<span>5 Reviews</span>
							   			</p>
							   			<p class="star">
							   				<span>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					(98%)
						   					</span>
						   					<span>0 Reviews</span>
							   			</p>
							   			<p class="star">
							   				<span>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					<i class="ion-ios-star-outline"></i>
							   					(98%)
						   					</span>
						   					<span>0 Reviews</span>
							   			</p>
							   		</div>
								</div> --}}
								<!-- Tiên 06/05 -->
								<?php
                                    $mand = Session::get('nd_ma');
                                    // $tennd = Session::get('nd_ten');
                                ?>
                                    @if ($mand)
                                    	@foreach($all_product as $key => $product)
											<div class="col-md-6">
												


								    				<div class="well" >
								    					<h3>{{ __('Viết nhận xét của bạn') }}</h3>
								 						
								    					<form method="post" action="{{URL::to('/comment/'.$product->sp_ma)}}" >
								    						{{ csrf_field() }}
								    						
								    						<div class="form-group" >
								    							
								    							<label for="cm">{{ __('Nhận xét') }}</label>
								    							<input type="hidden" name="_token" value="{{csrf_token()}}"/>
								    							<textarea class="form-control" rows="3" id="cm" name="content" required="" ></textarea>
								    						</div>
								    						<div class="form-group text-left">
								    							<button type="submit" class="btn btn-primary">{{ __('Gửi') }}</button>
								    						</div>
								    						

								    					</form>
								    					
								    				</div>
								    		</div>
								    	@endforeach
								    @endif

                                    
                                        
                                
                                    
								
					    		
						   	</div>
              </div>
            </div>
          </div>
        </div>
    	</div>
    </section>
   <script src="http://www.codermen.com/js/jquery.js"></script>

        <script type="text/javascript">
    	
        $(document).ready(function(){
        	var slt = 1;

            $('select[name="size"]').on('change',function(){
                var ctsp_ma = $(this).val(); // size_id => ctsp_ma
                console.log(ctsp_ma,'ctsp_ma'); 
                
                if(ctsp_ma){

                    $.ajax({

                        url: "{{url('getSlt')}}",
                        dataType: 'json',
                        type: 'GET',
                        data:{
                        	ctsp_ma: ctsp_ma
                        },
                        success: function(data){
                            console.log(data);
                            
                             $.each(data, function(name,stock){
                                $('input[name="quantity"]').attr({
								       "max" : stock,        // substitute your own
								       "min" : 1          // values (or variables) here
								    });
                              console.log(stock, 'stock');
                              $('input[name="quantity"]').val("1");
                              slt = stock;

                             
                             
                        
                    		});
                        }
                    });
                }
            });

             $('select[name="mausac"]').on('change',function(){
                var ms_ma = $(this).val(); // size_id => ctsp_ma
                console.log(ms_ma,'ms_ma'); 
            });


            var quantitiy=0;

		   $('.quantity-right-plus').click(function(e){
		        
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		        if (quantity < slt){
		            
		            $('#quantity').val(quantity + 1);

		        }
		            // Increment
		        
		    });

		     $('.quantity-left-minus').click(function(e){
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		      
		            // Increment
		            if(quantity>1){
		            $('#quantity').val(quantity - 1);
		            }
		    });
        });
    </script>

@endsection


