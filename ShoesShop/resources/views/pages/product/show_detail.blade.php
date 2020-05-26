@extends('shop_layout')
@section('script_thumbnail')

{{-- <link href="{{asset('public/frontend/css/ThumbnailGallery/bootstrap.css')}}" rel="stylesheet" type="text/css" media="all" /> --}}


<!--theme-style-->
<link href="{{asset('public/frontend/css/ThumbnailGallery/style.css')}}" rel="stylesheet" type="text/css" media="all" />	
<link rel="stylesheet" href="{{asset('public/frontend/css/ThumbnailGallery/etalage.css')}}" type="text/css" media="all" />

<!--//fonts-->
<script src="{{asset('public/frontend/js/ThumbnailGallery/jquery.min.js')}}"></script>

<script src="{{asset('public/frontend/js/ThumbnailGallery/jquery.etalage.min.js')}}"></script>

<!-- tien 16/05 -->
<script src="{{asset('public/frontend/css/binhluan/binhluan.css')}}"></script>

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
    	   <!-- <div id='updateDiv'> -->
    		<form action="{{URL::to('/save-cart')}}" method="POST">
				{{ csrf_field() }}
			<div id='updateDiv'>
    			<div class="row">
    		
    			{{-- <div class="col-lg-6 mb-5 ftco-animate">
    				<a href="{{URL::to('/product-detail')}}">
    					<img src="{{URL::to('public/upload/product/'.$details_product->ha_ten)}}" class="img-fluid" alt="Colorlib Template">
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
    				
    				<h3>{{$details_product->sp_ten}}</h3>
    				
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

							<?php 
			                    $giamgia=(double)$details_product->sp_donGiaBan-($details_product->sp_donGiaBan*$details_product->km_giamGia/100);
			                    $time = \Carbon\Carbon::now('Asia/Ho_Chi_Minh');

			                    $today=$time->toDateString();
			                ?>

							<p class="text-left">
								
								<a href="#" class="mr-2" style="color: #000;">
									
									{{$sold_product}}<!-- tiên 11/05 -->
									
								 	<span style="color: #bbb;">  {{ __('Đã bán') }}</span>
								</a>

								<a href="">
									 @if(($details_product->km_giamGia != 0) && ($details_product->km_ngayBD <= $today) && ($today <= $details_product->km_ngayKT))
					                    <span class="status">{{ __('Giảm ').$details_product->km_giamGia.'%' }}</span>
					                @endif
								</a>
								
							</p>
						</div>

    		<!-- start thêm giá khuyến mãi -->
                                        
                    @if(($details_product->km_giamGia != 0) && ($details_product->km_ngayBD <= $today) && ($today <= $details_product->km_ngayKT))
                        <div class="pricing">
                            <p class="price"><span><del>{{number_format($details_product->sp_donGiaBan).' '.'VNĐ'}}</del></span></p>
                        </div>
                        <div class="pricing">
                            <p class="price" style="color: red"><span><b>{{number_format($giamgia).' '.'VNĐ'}}</b></span></p>
                        </div>
                    @else
                        <div class="pricing">
                            <p class="price"><span>{{number_format($details_product->sp_donGiaBan).' '.'VNĐ'}}</
                                                span></p>
                        </div>
                    @endif
            <!-- end thêm giá khuyến mãi -->

						<div class="row mt-4">
							<div class="col-md-6">
								<div class="form-group d-flex">
					                <?php 
						                 	
						                $array_ms = array();
						                $arr_ms = array();
						                 	
						                foreach($show_btn_mausac as $key => $ms){
						                 		
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
						                 	
						            @foreach($arr_ms as $key => $val)
						                @if($key == $ms_ma)
						                  	<a class="button btn btn-primary" href="{{URL::to('/product-detail/'.$details_product->sp_ma.'/'.$key)}}">{{$val}}</a> &nbsp;&nbsp;&nbsp;
						                  	  	
						                @else
						                  	<a class="button btn btn-outline-dark" href="{{URL::to('/product-detail/'.$details_product->sp_ma.'/'.$key)}}">{{$val}}</a> &nbsp;&nbsp;&nbsp;
						                @endif


						                  		
						            @endforeach
						                 
					            </div>
						    </div>

						   
						   	<input type="hidden" name="ms_ma_hidden" id="ms_ma" value="{{$ms_ma}}">
							
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

							<div class="input-group col-md-6 d-flex mb-3">
					             	<span class="input-group-btn mr-2">
					                	<button type="button" class="quantity-left-minus btn"  data-type="minus" data-field="">
					                   <i class="ion-ios-remove"></i>
					                	</button>
					            	</span>

					            	
						            <input type="text" id="quantity" name="quantity" class="quantity form-control input-number" value="1" min="1" max="5">
					  
					             	{{-- @foreach($sz_product as $key => $slt)
					                  	<option value="{{$slt->ctsp_ma}}" name="opsize">{{$slt->soLuongTon}}</option>
					                @endforeach --}}
					                
					             	<span class="input-group-btn ml-2">
					                	<button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
					                     <i class="ion-ios-add"></i>
					                 	</button>
					             	</span>
					        </div>

					        <input type="hidden" name="productid_hidden" id="spma" value="{{$details_product->sp_ma}}">
					        
					        <div class="w-100"></div>

					        
					        <br>
			        <div class="col-md-12">
					        	
					           <p id="spconlai" style="color: #000;"></p>
					         
					        </div>
					        <br><br>
					        <?php
			                    $message = Session::get('cart_message');
			                    if ($message){
			                        echo '<span class="alert alert-danger">'.$message."</span>";
			                                
			                        Session::put('cart_message',null);
			                    }
			                            
			                ?>
				        	</div>
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
		

    	<div class="row mt-5">
          <div class="col-md-12 nav-link-wrap">
            <div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link ftco-animate active mr-lg-1" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">{{ __('Mô tả') }}</a>

              <a class="nav-link ftco-animate mr-lg-1" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">{{ __('Nhà cung cấp') }}</a>

              <a class="nav-link ftco-animate" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">{{ __('Đánh giá') }}</a>

            </div>
          </div>
          <div class="col-md-12 tab-wrap">
            
            <div class="tab-content bg-light" id="v-pills-tabContent">
            	
              <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="day-1-tab">
              	<div class="p-4">
              		
	              	<h3 class="mb-4">{{$details_product->sp_ten}}</h3>
	              	<p>{{$details_product->sp_moTa}}</p>

              	</div>
              </div>

              <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-day-2-tab">
              	<div class="p-4">
	              	<h3 class="mb-4">
	              		<?php $cnt = count($suppliers); $i = 1?>
	              		@foreach($suppliers as $key => $sup)
	              		{{$sup->ncc_ten}}
	              			@if ($cnt != $i)
	              				,&nbsp;
	              			@endif
	              			<?php $i++;?> 
	              		@endforeach
	              	</h3>

	              	<p></p>
              	</div>

              </div>
             
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
								   				<span class="text-right">{{date('d/m/Y',strtotime($comment->ngayBinhLuan))}}</span>
								   				
								   			</h4>
								   			<p class="star" >
								   				<span> <!-- Tien 16/05 -->
								   					@for ($i = 0; $i < 5; ++$i)
													    <i class="ion-ios-star{{ $comment->danhGia<=$i?'-outline':'' }}" aria-hidden="true"></i>
													@endfor
							   					</span>

							   					
								   			</p>
								   				
								   			<p>{{$comment->noiDung}}</p>
								   		</div>
								   	</div>
								   	@endforeach		
								   	
						   		</div>
							
						   		<div class="col-md-4">
						   			<div class="rating-wrap">
						   				<br><br>
							   			<h3 class="mb-4">{{ __('Đánh giá') }}</h3>
							   			
							   		
							   			<?php
							   				$a = array();
							   				$nd = array();
							   				foreach($rating as $key => $value){
							   					$a[] = $value->danhGia;
							   					
								   			}		   			
									        
									        // echo "<pre>";
									        // print_r($tong_danhgia);
									        // // print_r($a);
									        // echo "</pre>";
							   			?>
						                  		
						                  	<!-- <p class="star">
										   		<span>
										   			@for ($i = 1; $i < 6; ++$i)
											   			<i class="ion-ios-star{{ $key<$i?'-outline':'' }}" aria-hidden="true"></i>
											   					
										   			@endfor
										   			
									   			</span>
									   			<span>{{$val}} Reviews</span>
										   	</p> -->

									   			<p class="star">
									   				<?php
								   						$temp1 = 0;

									   					foreach(array_count_values($a) as $key => $val){
										   					if ($key == 1 ){
										   						$temp1=$val;
										   					}
										   					
									   					}
								   					?>
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star-outline"></i>
									   					<i class="ion-ios-star-outline"></i>
									   					<i class="ion-ios-star-outline"></i>
									   					<i class="ion-ios-star-outline"></i>
									   					&nbsp;&nbsp;&nbsp;
									   					@if($tong_danhgia == 0)
									   						( {{($temp1)*100}} % )
									   					@else
									   						( {{($temp1/$tong_danhgia)*100}} % )
									   					@endif
								   					</span>

								   					<span> {{$temp1}} Reviews</span>
									   			</p>

									   			<p class="star">
									   				<?php
								   						$temp2 = 0;

									   					foreach(array_count_values($a) as $key => $val){
										   					if ($key == 2 ){
										   						$temp2=$val;
										   					}
										   					
									   					}
								   					?>
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star-outline"></i>
									   					<i class="ion-ios-star-outline"></i>
									   					<i class="ion-ios-star-outline"></i>
									   					&nbsp;&nbsp;&nbsp;
									   					@if($tong_danhgia == 0)
									   						( {{($temp2)*100}} % )
									   					@else
									   						( {{($temp2/$tong_danhgia)*100}} % )
									   					@endif
								   					</span>

								   					
								   					<span> {{$temp2}} Reviews</span>
									   			</p>

									   			<p class="star">
									   				<?php
								   						$temp3 = 0;

									   					foreach(array_count_values($a) as $key => $val){
										   					if ($key == 3 ){
										   						$temp3=$val;
										   					}
										   					
									   					}
								   					?>
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star-outline"></i>
									   					<i class="ion-ios-star-outline"></i>
									   					&nbsp;&nbsp;&nbsp;
									   					@if($tong_danhgia == 0)
									   						( {{($temp3)*100}} % )
									   					@else
									   						( {{($temp3/$tong_danhgia)*100}} % )
									   					@endif
								   					</span>
								   					
								   					<span> {{$temp3}} Reviews</span>
									   			</p>

									   			<p class="star">
									   				<?php
								   						$temp4 = 0;

									   					foreach(array_count_values($a) as $key => $val){
										   					if ($key == 4 ){
										   						$temp4=$val;
										   					}
										   					
									   					}
								   					?>
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star-outline"></i>
									   					&nbsp;&nbsp;&nbsp;
									   					@if($tong_danhgia == 0)
									   						( {{($temp4)*100}} % )
									   					@else
									   						( {{($temp4/$tong_danhgia)*100}} % )
									   					@endif
								   					</span>
								   					
								   					<span> {{$temp4}} Reviews</span>
									   			</p>

									   			<p class="star">
									   				<?php
								   						$temp5 = 0;

									   					foreach(array_count_values($a) as $key => $val){
										   					if ($key == 5 ){
										   						$temp5=$val;
										   					}
										   					
									   					}
								   					?>
									   				<span>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					<i class="ion-ios-star"></i>
									   					&nbsp;&nbsp;&nbsp;
									   					@if($tong_danhgia == 0)
									   						( {{($temp5)*100}} % )
									   					@else
									   						( {{($temp5/$tong_danhgia)*100}} % )
									   					@endif
								   					</span>
								   					
								   					<span> {{$temp5}} Reviews</span>
									   			</p>
							   		</div>
								</div> 
							
								<!-- Tiên 06/05 -->
								<?php
                                    $mand = Session::get('nd_ma');
                                    
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


															<label for="cm">{{ __('Đánh giá') }}</label>
															<div class="rating" role="optgroup">
															    
															    <i class="ion-ios-star-outline rating-star" name="example" id="rating-1" data-rating="1" tabindex="0"  role="radio"></i>&nbsp;&nbsp;&nbsp;

															    <i class="ion-ios-star-outline rating-star" name="example" id="rating-2" data-rating="2" tabindex="0"  role="radio"></i>&nbsp;&nbsp;&nbsp;

															    <i class="ion-ios-star-outline rating-star" name="example" id="rating-3" data-rating="3" tabindex="0"  role="radio"></i>&nbsp;&nbsp;&nbsp;

															    <i class="ion-ios-star-outline rating-star" name="example" id="rating-4" data-rating="4" tabindex="0"  role="radio"></i>&nbsp;&nbsp;&nbsp;

															    <i class="ion-ios-star-outline rating-star" name="example" id="rating-5" data-rating="5" tabindex="0"  role="radio"></i>
															    <br>
															</div>
															<input type="hidden" name="rating" id="rating-input" min="1" max="5" /><br>

								    						<!-- <div id="rdrating" class="ratings">
													            <i name="example" class="ion-ios-star-outline" value="1" title='Poor' /></i>
													            <i name="example" class="ion-ios-star-outline" value="2" title='Fair'/></i>
													            <i name="example" class="ion-ios-star-outline" value="3" title='Good'/></i>
													            <i name="example" class="ion-ios-star-outline" value="4" title='Excellent'/></i>
													            <i name="example" class="ion-ios-star-outline" value="5" title='WOW!!!' /></i>
													        </div> -->



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
   <!--  </div> -->
    	</div>
    </section>
   <script src="http://www.codermen.com/js/jquery.js"></script>

<script src="https://code.jquery.com/jquery-latest.js"></script>

    <script type="text/javascript">
    	 // Tien 08/05
       

        $(document).ready(function(){
        	

    	  //dat thi gian tat thong bao
	        setTimeout(function(){
	           $("span.alert").remove();
	        }, 5000 ); // 5 secs

        	var slt = 1;
        
            $('select[name="size"]').on('change',function(){
                var kc_ma = $(this).val(); // size_id => kc_ma
                var ms_ma=$('#ms_ma').val();
                var sp_ma=$('#spma').val();

                console.log(kc_ma,'kc_ma'); 
		       
                console.log(ms_ma,'ms_ma');
                console.log(sp_ma,'sp_ma');
                if(kc_ma){

                    $.ajax({

                        url: "{{url('getSlt')}}",
                        dataType: 'json',
                        type: 'GET',
                        data:{
                        	ms_ma: ms_ma,
                        	kc_ma : kc_ma,
                        	sp_ma : sp_ma
                        },
                        success: function(data){
                            console.log(data,'data size');
                            
                            $.each(data, function(name,stock){
                                $('input[name="quantity"]').attr({
								       "max" : stock,   // substitute your own
								       "min" : 1       // values (or variables) here
								    });
                              	console.log(stock, 'stock');
                             		$('input[name="quantity"]').val("1");
                              	slt = stock;

                              	$('#spconlai').replaceWith('<p id="spconlai" style="color: #000;">Còn '+slt+' sản phẩm</p>')
                              	console.log(slt,"slt get size");

                    		});
                        }
                    });
                }
            });

            

            var quantitiy=0;

		   $('.quantity-right-plus').click(function(e){
		        
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        console.log(slt,'slt');
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


		    //rating final

		    //dan gia trị vào input rating
			function setRating(rating) {

			    // $('#rating-input').val(rating);

			    var valueclicked = $('#rating-input').val();//value input
			    console.log(valueclicked,'sl rating');


			    // fill all the stars assigning the '.selected' class
			    $('.rating-star').removeClass('ion-ios-star-outline').addClass('selected');
			    // empty all the stars to the right of the mouse
			    $('.rating-star#rating-' + rating + ' ~ .rating-star').removeClass('selected').addClass('ion-ios-star-outline');
			}
			  
			$('.rating-star')
			// // rơi chuột vào rating
			  // .on('mouseover', function(e) {
			  //   var rating = $(e.target).data('rating');
			  //   // fill all the stars
			  //   $('.rating-star').removeClass('ion-ios-star-outline').addClass('ion-ios-star');
			  //   // empty all the stars to the right of the mouse
			  //   $('.rating-star#rating-' + rating + ' ~ .rating-star').removeClass('ion-ios-star').addClass('ion-ios-star-outline');
			  // })
			  // // rơi chuột ra ngoài rating
			  // .on('mouseleave', function (e) {
			  //   // empty all the stars except those with class .selected
			  //   $('.rating-star').removeClass('ion-ios-star').addClass('ion-ios-star-outline');

			  // })
			  .on('click', function(e) {
			    var rating = $(e.target).data('rating');

			    $('.rating-star').removeClass('ion-ios-star-outline').addClass('ion-ios-star');

			    setRating(rating);
			  })
			  .on('keyup', function(e){
			    // if spacebar is pressed while selecting a star
			    if (e.keyCode === 32) {
			      // set rating (same as clicking on the star)
			      var rating = $(e.target).data('rating');
			      setRating(rating);
			    }
			});

			

		});


      
    </script>

@endsection


