
<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Order Pdf</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    	body{margin-top:10px;
			background:#FFFFFF;
			}

			.invoice {
			    padding: 0px;
			}

			.invoice h2 {
				margin-top: 0px;
				line-height: 0.8em;
			}

			.invoice .mdall {
				font-weight: 300;
			}

			.invoice hr {
				margin-top: 10px;
				border-color: #ddd;
			}

			.invoice .table tr.line {
				border-bottom: 1px solid #ccc;
			}

			.invoice .table td {
				border: none;
			}

			.invoice .identity {
				margin-top: 10px;
				font-size: 1.1em;
				font-weight: 300;
			}

			.invoice .identity strong {
				font-weight: 600;
			}


			.grid {
			    position: relative;
				width: 100%;
				background: #fff;
				color: #666666;
				border-radius: 2px;
				margin-bottom: 10px;
				box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1);
			}
			tr.tongtien td {
			  border-top: 2px solid black;
			  background: #E0E0E0;
			}
			.table{
				 border-collapse: collapse;
			}
    </style>
</head>
<body style="font-family:  DejaVu Sans, sans-serif;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="grid invoice">
					<div class="grid-body">
						<div class="invoice-title">
							<div class="row">
								<div class="col-md-12">
									<img src="{{asset('public/backend/img/logo.png')}}" alt="" height="35">
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-12">
									<strong>Hóa đơn<br>
									Mã #{{$order->dh_ma}}</strong>
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-xs-5">
								<address>
									<strong>Người đặt:</strong><br>
									<strong>{{$order->nd_ten}}</strong><br>
									{{$order->nd_diaChi}} <br>
									Phone: {{$order->nd_dienThoai}}<br>
									Email: {{$order->nd_email}}
								</address>
							</div>
							<div class="col-xs-6 text-right">
								<address>
									<strong>Người nhận:</strong><br>
									<strong>{{$order->dh_tenNguoiNhan}}</strong><br>
									{{$order->dh_diaChiNhan}}<br>
									Phone: {{$order->dh_dienThoaiNhan}}<br>
									&nbsp;
								</address>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<address>											        
                                    <b>Hình thức vận chuyển:</b> {{$order->htvc_ten}}<br>
                                    <b>Hình thức thanh toán:</b> {{$order->httt_ten}}<br>
                                    <b>Ghi chú:</b> {{$order->dh_ghiChu}}
								</address>
							</div>
							<div class="col-xs-5 text-right">
								<address>
									<strong>Ngày đặt:</strong><br>
									{{date('d-m-Y',strtotime($order->dh_ngayDat))}}
								</address>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12">
								<h3><strong>NỘI DUNG ĐƠN HÀNG</strong></h3>
								
								<table class="table table-striped">
									<thead>
										<tr class="line">
											<td><strong>STT</strong></td>
											<td class="text-center"><strong>TÊN SẢN PHẨM</strong></td>
											<td class="text-center"><strong>MÀU SẮC</strong></td>
											<td class="text-center"><strong>KÍCH CỠ</strong></td>
											<td class="text-center"><strong>SỐ LƯỢNG</strong></td>
											<td class="text-right"><strong>ĐƠN GIÁ</strong></td>
											<td class="text-right"><strong>THÀNH TIỀN</strong></td>
										</tr>
									</thead>
									<tbody>
										 <?php 
                                            $i=1;
                                            $congTien=0;
                                        ?>
										@foreach($items as $item)
											<tr>
												<td>{{$i++}}</td>
                                                <td><strong>{{$item->sp_ten}}</strong></td>
                                                <td class="text-center">{{$item->ms_ten}}</td>
                                                <td class="text-center">{{$item->kc_ten}}</td>
												<td class="text-center">{{$item->SoLuongDat}}</td>
												<?php $thanhTien = $item->SoLuongDat * $item->DonGiaBan; ?>
												<td class="text-center">{{number_format($item->DonGiaBan).' VND'}}</td>
												<td class="text-right">{{number_format($thanhTien).' VND'}}</td>
											</tr>
                                            <?php $congTien = $congTien + $thanhTien; ?>
                                         @endforeach
                                         <tr class="tongtien">
											<td colspan="5"></td>
											<td class="text-right "><strong>Cộng tiền</strong></td>
											<td class="text-right"><strong>{{number_format($congTien).' VND'}}</strong></td>
										</tr>
										<tr>
											<td colspan="5"></td>
											<td class="text-right"><strong>Khuyến mãi</strong></td>
											<td class="text-right">
												<strong> 
													<?php 
														$disc = 0;
														/*if (($order->km_ma != NULL) || ($order->km_ma != 0))
                                                            $disc = $congTien*$order->km_giamGia/100;*/
                                                                                                              
                                                        ?>
                                                        {{number_format($disc).' VND'}}
                                                    </strong>
                                                </td>
										</tr>
										<tr>
											<td colspan="5">
											</td><td class="text-right"><strong>Vận chuyển</strong></td>
											<td class="text-right"><strong>{{number_format($order->htvc_phi).' VND'}}</strong></td>
										</tr>
										<tr class="tongtien">
											<td colspan="3">
											</td><td  colspan="3" class="text-right"><strong>Tổng tiền thanh toán</strong></td>
											<td class="text-right"><strong>{{number_format($congTien+$order->htvc_phi - $disc).' VND'}}</strong></td>
										</tr>
									</tbody>
								</table>
							</div>									
						</div>
					</div>
				</div>
			</div>		
		</div>
	</div>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript">
	
</script>
</body>
</html>