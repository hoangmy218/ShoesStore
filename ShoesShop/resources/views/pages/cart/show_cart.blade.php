@extends('shop_layout')
@section('content')


    <div class="hero-wrap hero-bread" style="background-image: url({{URL::to('public/frontend/images/bg_6.jpg')}});">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="{{URL::to('/')}}">{{ __('Trang chủ') }}</a></span> <span>{{ __('Giỏ hàng của tôi') }}</span></p>
            <h1 class="mb-0 bread">{{ __('Giỏ hàng của tôi') }}</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-cart">

		<div class="container">
			
            <?php
            	$success_message = Session::get('success_message');
            	if ($success_message){
            		echo '<span class="alert alert-success">'.$success_message."</span>";
            		
            		Session::put('success_message',null);
            	}
            	$message = Session::get('fail_message');
            	if ($message){
            		echo '<span class="alert alert-danger">'.$message."</span>";
            		
            		Session::put('fail_message',null);
            	}
            	
            ?>
			<?php
				$content = Cart::content();
			?>

			@if ($content->isempty())
				<p class="text-center"><a href="{{URL::to('/')}}" class="btn btn-primary py-3 px-4">{{ __('Mua sắm ngay') }}</a></p>
			@else
{{-- <div id='updateDiv'> --}}
			<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div id='updateDiv'>
					
		            <div class="cart-list">
	    				<table class="table">
						    <thead class="thead-primary">
							     <tr class="text-center">
							        <th>{{ __('STT') }}</th>
							        <th>{{ __('Mã sản phẩm') }}</th>
							        <th>{{ __('Hình ảnh') }}</th>
							        <th>{{ __('Tên sản phẩm') }}</th>
							        <th>{{ __('Màu sắc') }}</th>
							        <th>{{ __('Kích cỡ') }}</th>
							        <th>{{ __('Đơn giá') }}</th>
							        <th>{{ __('Số lượng') }}</th>
							        <th>{{ __('Thành tiền') }}</th>
							        <th>&nbsp;</th>
							    </tr>
						    </thead>
						    <?php $count=1; ?>
							@foreach($content as $v_content)<!-- tien -->
							    <tbody>
								    <tr class="text-center">
								      	<td class="product-price">
								        	<h4>{{$count}}</h4>
								        </td>
								        <td class="product-id">
								        	<h3>{{$v_content->id}}</h3>
								        	
								        </td>
								        <td class="image-prod"><div class="img" style="background-image:url({{URL::to('public/upload/product/'.$v_content->options->image)}});" ></div></td>
								        
								        <td class="product-name">
								        	<h3>{{$v_content->name}}</h3>
								        	
								        </td>
								        <td class="quantity">
								        	<select name="color" id="color"  class="form-control color<?php echo $count; ?>">
							                    
							                    <?php 
								                    $item = DB::Table('cochitietsanpham')
											                    ->join('sanpham','sanpham.sp_ma','=','cochitietsanpham.sp_ma')
												                ->join('kichco','kichco.kc_ma','=','cochitietsanpham.kc_ma')
												                ->join('mausac','mausac.ms_ma','=','cochitietsanpham.ms_ma')
											                    ->where([['cochitietsanpham.kc_ma',$v_content->options->size],
									                                ['cochitietsanpham.ms_ma',$v_content->options->mausac],
									                                ['cochitietsanpham.sp_ma',$v_content->id]])			                    
									                            ->first();
								                    $colors = DB::Table('cochitietsanpham')
								                     			->join('mausac','mausac.ms_ma','=','cochitietsanpham.ms_ma')			
								                     			->where([['cochitietsanpham.sp_ma',$v_content->id],
								                    					 ['soLuongTon','!=',0]])
								                    			->orderBy('cochitietsanpham.ms_ma','asc')->get();
								                    $array = array();
						                 	
								                 	foreach($colors as $key => $clr){
								                 		
								                 		$array[$clr->ms_ma] = $clr->ms_ten;
								                 		
								                 	}  
							                    ?>

							                    {{-- @foreach($sizes as $key => $value) --}}
							                    @foreach(array_unique($array) as $key => $val)
							                    	@if ($v_content->options->mausac == $key )
							                        <option value="{{$key}}" selected>{{$val}}</option>
							                        @else
							                        	<option value="{{$key}}">{{$val}}</option>
							                        @endif
							                    @endforeach
							                </select>
							               								        	
								        
								        </td>
								        <td class="quantity">
								        	
								        	<select name="size" id="size"  class="form-control size<?php echo $count; ?>">
							                    <?php 
								                   	$sizes = DB::Table('cochitietsanpham')
								                     			->join('kichco','kichco.kc_ma','=','cochitietsanpham.kc_ma')			
								                     			->where([['cochitietsanpham.sp_ma',$v_content->id],
								                    					 ['soLuongTon','!=',0]])
								                    			->orderBy('cochitietsanpham.kc_ma','asc')->get();
								                    $array = array();
						                 	
								                 	foreach($sizes as $key => $sz){
								                 		
								                 		$array[$sz->kc_ma] = $sz->kc_ten;
								                 		
								                 	}  
							                    ?>

							                    {{-- @foreach($sizes as $key => $value) --}}
							                    @foreach(array_unique($array) as $key => $val)
							                    	@if ($v_content->options->size == $key )
							                        <option value="{{$key}}" selected>{{$val}}</option>
							                        @else
							                        	<option value="{{$key}}">{{$val}}</option>
							                        @endif
							                    @endforeach
							                </select>
							               								        	
								        </td>
								        
								        <td class="price">{{number_format($v_content->price).' '.'vnđ'}}</td>
								        
								        <td class="quantity">
									        
										        <div class="input-group mb-3" id="divquantity">		
										        	<input type="hidden" value="{{$v_content->rowId}}" id="rowId<?php echo $count; ?>" name="rowId" class="form-control">
										        	<input type="hidden" value="{{$item->sp_ma}}" id="sp_ma<?php echo $count; ?>" name="sp_ma" class="form-control">
										        	<input type="hidden" value="{{$v_content->id}}" id="ctsp_ma<?php echo $count; ?>" name="ctsp_ma" class="form-control">								        	
														
							             			<input type="number" name="quantity" id="upCart<?php echo $count; ?>" class="quantity form-control input-number" value="{{$v_content->qty}}" min="1" max="{{$item->soLuongTon}}">
							             			    	
									          	</div>
									          	
									        
							         	</td>
								        <td class="total">
								        	<p class="cart_total_price">
											
											<?php
											$subtotal = $v_content->price * $v_content->qty;
											echo number_format($subtotal).' '.'VNĐ';
											?><!-- Tien -->
										</p>
								        </td>
								        <td class="product-remove">
								         	<a class="ion-ios-close" onclick="<?php echo "return confirm('"; ?>{{ __("Bạn chắc chắn muốn xóa sản phẩm này?") }}<?php echo "')";?>" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
								         	
								         </td>
								         
							         
							      		</tr><!-- END TR-->
							    	</tbody>
							   <?php $count++; ?>
							@endforeach 

						</table>
						<h3 class="billing-heading mb-4" align="right">{{ __('Tổng tiền') }}: &emsp;{{Cart::subtotal().' VND'}}</h3>	
					</div>

				</div>

    			</div>

    		</div>
	    	<div class="row justify-content-start">
	    		<div class="col-md-12 ftco-animate">
	    			{{-- <div class="cart-total mb-3">
	    				<h3 class="billing-heading mb-4" align="right">{{ __('Tổng tiền') }}: &emsp;{{Cart::subtotal().' '.'vnđ'}}</h3>		
	    			</div> --}}
	    			<br>
	    			<p class="text-center"><a href="{{URL::to('/')}}" class="btn btn-primary py-3 px-4">{{ __('MUA SẮM NGAY') }}</a>

					<a href="{{URL::to('/checkout')}}" class="btn btn-primary py-3 px-4">ĐẶT HÀNG</a></p>

	    			
	    		</div>
	    	</div>
	  {{--   </div> --}}
	    	@endif
	    

	</div>


	<script src="http://www.codermen.com/js/jquery.js"></script>
    <script type="text/javascript">	
        $(document).ready(function(){
        	 //dat thi gian tat thong bao
	        setTimeout(function(){
	           $("span.alert").remove();
	        }, 5000 ); // 5 secs


        	$('select[name="color"]').on('change',function(){
                var color_id = $(this).val();
                console.log(color_id);
                var sp_ma = $.trim(($(this).parent()).parent().children().eq(1).text());
            		console.log(sp_ma,'sp_ma');
                if(color_id){

                    
                    $.ajax({

                        url: "{{url('getSize')}}",
                        dataType: 'json',
                        type: 'GET',
                        data:{
                        	color_id: color_id,
                        	sp_ma: sp_ma
                        },
                        
                        success: function(data){
                            console.log(data,'getSize');
                            
                             $('select[name="size"]').empty();
                             $.each(data, function(index, value){ 
                                $('select[name="size"]').append('<option value="'+value['kc_ma']+'">'+value['kc_ten']+'</option>');
								 /*$('input[name="quantity"]').replaceWith('<input type="number" onchange="this.form.submit()" name="quantity" class="quantity form-control input-number" value="1" min="1" max="'+stock+'">');*/
								 /* $('input[name="quantity"]').replaceWith('<input type="number"  name="quantity" id="upCart" class="quantity form-control input-number" value="1" min="1" max="'+stock+'">');*/
								/*--
								  $('input[name="quantity"]').attr({
								       "max" : stock,        // substitute your own
								       "min" : 1          // values (or variables) here
								    });
                              --*/
                             });
                        }
                    }); 
                }else{
                    $('select[name="size"]').empty();
                }
            });
        	
            $('select[name="size"]').on('change',function(){
                var size_id = $(this).val();
                console.log(size_id);
                var sp_ma = $.trim(($(this).parent()).parent().children().eq(1).text());
            		console.log(sp_ma,'sp_ma');
                if(size_id){

                    $.ajax({

                        url: "{{url('getColor')}}",
                        dataType: 'json',
                        type: 'GET',
                        data:{
                        	size_id: size_id,
                        	sp_ma: sp_ma
                        },
                        
                        success: function(data){
                            console.log(data,'getColor');
                             // $('select[name="color"]').empty();
                            $.each(data, function(index, value){ 

                                $('select[name="color"]').append('<option value="'+value['ms_ma']+'">'+value['ms_ten']+'</option>');
								 /*$('input[name="quantity"]').replaceWith('<input type="number" onchange="this.form.submit()" name="quantity" class="quantity form-control input-number" value="1" min="1" max="'+stock+'">');*/
								 /* $('input[name="quantity"]').replaceWith('<input type="number"  name="quantity" id="upCart" class="quantity form-control input-number" value="1" min="1" max="'+stock+'">');*/
								  // $('input[name="quantity"]').attr({
								  //      "max" : stock,        // substitute your own
								  //      "min" : 1          // values (or variables) here
								  //   });
                              
                             });
                        }
                    });
                    var color_id = $.trim(($(this).parent()).parent().children().eq(4).children().val());
                    console.log(color_id,'ms_ma');
                    console.log(size_id,'kc_ma');
                    $.ajax({

                        url: "{{url('getStock')}}",
                        dataType: 'json',
                        type: 'GET',
                        data:{
                        	size_id: size_id,
                        	color_id: color_id,
                        	sp_ma: sp_ma
                        },
                        
                        success: function(data){
                            console.log(data,'getStock');
                             // $('select[name="color"]').empty();
                            $.each(data, function(index, stock){ 
                                console.log(stock, ' stock');
								  $('input[name="quantity"]').attr({
								       "max" : stock,        // substitute your own
								       "min" : 1          // values (or variables) here
								    });
                              
                             });
                        }
                    });
                }else{
                    $('select[name="color"]').empty();
                }
            });

			<?php 
				$count = Cart::count();

				for($i=1; $i<=$count; $i++){
			?>
			$('#upCart<?php echo $i; ?>').on('change keyup', function(){
				var newqty = $('#upCart<?php echo $i; ?>').val();
				var rowId = $('#rowId<?php echo $i; ?>').val();				
				var sp_ma = $('#sp_ma<?php echo $i; ?>').val();
				var size = $('.size<?php echo $i; ?>').val();
				var color = $('.color<?php echo $i; ?>').val();
				console.log(newqty, ' new qty');
				console.log(rowId, ' rowId');
				console.log(sp_ma, ' sp_ma');
				console.log(size, ' size');
				console.log(color, ' color');
				// alert('sl:'+newqty+' rowId:'+rowId+' sp_ma'+sp_ma+" kc_ma"+size+" ms_ma"+color);
				if (newqty <=0 ){
					alert('Số lượng không hợp lệ! Số lượng lớn hơn 0');
				} else{

					$.ajax({
						type: 'get',
						dataType: 'html',
						url: '<?php echo url('update-qty');?>/'+sp_ma,
						data: "qty="+newqty+"&rowId="+rowId+"&sp_ma="+sp_ma+"&size="+size+"&color="+color,
						success: function(response){
							 console.log(response);
							 $('#updateDiv').html(response);
						}
					});

					/*alert(newqty+' '+rowId+' '+ctsp_ma);*/
				}


			});
			<?php } ?>

        });
    </script>
</section>
@endsection
		