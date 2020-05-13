<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use Cart;
use DB;

class PaymentController extends Controller
{
 
	public function create(Request $request)
	{
		$apiContext = new \PayPal\Rest\ApiContext(
	        new \PayPal\Auth\OAuthTokenCredential(
	            'AQByb9RaFErl1oTeyv5HUdRyfAEwBsly5WkpvXRdrhueFmjUtDzlAvdpvzFfRos6o_yngGomvCh3MtWR', 
	            'ENirRyKeVs7uXUfwLjDlweNwzessWOyTpCV2U2lfc1krrM6vFW85ubZyCW48PX15edbDReZ8cJVBnQgu'  
	        )
		);

		$payer = new Payer();
		$payer->setPaymentMethod("paypal");
		(double)$ti_le_giamgia = Session::get('ti_le_giamgia');
		$content = Cart::content();
		(double)$rate = 0.000043; //ti so USD
		(double) $discount = (100-$ti_le_giamgia)/100;
		$index = 0;
		$items = array();
    (double)$tongtien = 0;
		foreach($content as $v_content){
			$index++;
			$items[$index] = new Item();
			$items[$index]->setName($v_content->name)
			    ->setCurrency('USD')
			    ->setQuantity($v_content->qty)
			    ->setSku($v_content->id) // Similar to `item_number` in Classic API
			    ->setPrice($v_content->price * $rate * $discount );
           echo 'sp'.round($v_content->price * $rate * $discount,2) * $v_content->qty.'\n';
      $tongtien = $tongtien + round($v_content->price * $rate * $discount,2) * $v_content->qty;

		}
		$itemList = new ItemList();
		$itemList->setItems($items);
		 echo '<pre>';
     print_r($items);
     echo "</pre>";
     echo "tongtien".$tongtien;

		(double)$phi=Session::get('vc_phi');

		// $subtt =(double)Cart::subtotal(2,'.','');

		$details = new Details();
		$details->setShipping($phi * $rate)
		    ->setSubtotal($tongtien);

    (double)$tongcuoi = $tongtien +(round($phi * $rate,2));

		$amount = new Amount();
		$amount->setCurrency("USD")
		    ->setTotal($tongcuoi)
		    ->setDetails($details);
        
     echo 'tong tien cuoi: '.$tongcuoi;
	
		$transaction = new Transaction();
		$transaction->setAmount($amount)
		    ->setItemList($itemList)
		    ->setDescription("Payment description")
		    ->setInvoiceNumber(uniqid());

		// $baseUrl = getBaseUrl();
		$redirectUrls = new RedirectUrls();
		
		// $redirectUrls->setReturnUrl("http://localhost/GitHub/ShoesShopWebsite/shoesshop/execute-payment")
		$redirectUrls->setReturnUrl(URL::to('/execute-payment'))
		    ->setCancelUrl(URL::to('/payment'));

		$payment = new Payment();
		$payment->setIntent("sale")
		    ->setPayer($payer)
		    ->setRedirectUrls($redirectUrls)
		    ->setTransactions(array($transaction));

		// $request = clone $payment;
		$payment->create($apiContext);

		return redirect($payment->getApprovalLink());

	}

	public function execute()
	{
		$apiContext = new \PayPal\Rest\ApiContext(
	        new \PayPal\Auth\OAuthTokenCredential(
	            'AQByb9RaFErl1oTeyv5HUdRyfAEwBsly5WkpvXRdrhueFmjUtDzlAvdpvzFfRos6o_yngGomvCh3MtWR', 
	            'ENirRyKeVs7uXUfwLjDlweNwzessWOyTpCV2U2lfc1krrM6vFW85ubZyCW48PX15edbDReZ8cJVBnQgu'  
	        )
		);

		$paymentId = request('paymentId');
    	$payment = Payment::get($paymentId, $apiContext); 

		(double)$ti_le_giamgia = Session::get('ti_le_giamgia');

    	$execution = new PaymentExecution();
    	$execution->setPayerId(request('PayerID'));

    	$transaction = new Transaction();
	    $amount = new Amount();
	    $details = new Details();


	    //them du lieu
		$content = Cart::content();
	
	    (double)$rate = 0.000043; //ti so USD
		(double) $discount = (100-$ti_le_giamgia)/100;
	    (double)$tongtien = 0;
	    foreach($content as $v_content){
	      $tongtien = $tongtien + round($v_content->price * $rate * $discount,2) * $v_content->qty;
	    }

		(double)$phi=Session::get('vc_phi');
    	(double)$tongcuoi = $tongtien +(round($phi * $rate ,2));

		// $details = new Details();
		$details->setShipping($phi * $rate)
		    ->setSubtotal($tongtien);

		// $amount = new Amount();
		$amount->setCurrency("USD")
		    ->setTotal($tongcuoi)
		    ->setDetails($details);



	    // $details->setShipping(1.2)
		   //      ->setTax(1.3)
		   //      ->setSubtotal(17.50);

     //    $amount->setCurrency('USD');
	    // $amount->setTotal(20);
	    // $amount->setDetails($details);
	    $transaction->setAmount($amount);

	    $execution->addTransaction($transaction);

	    $result = $payment->execute($execution, $apiContext); //ktra tinh tong tien

		return Redirect::to('/orderplace');
	}

    public function thankyou()
    {
    	return view('pages.checkout.thankyou');
    }

    public function orderPlace()
    {
    	$content = Cart::content(); 
        //them don hang
    	$matt = DB::table('thanhtoan')->where('tt_ten','Paypal')->first();
        if (!$content->isempty()) {

            $data = array();
            $data['dh_tenNhan'] = Session::get('dh_tenNhan');
            $data['dh_diaChiNhan'] = Session::get('dh_diaChiNhan');
            $data['dh_dienThoai'] = Session::get('dh_dienThoai');
            $data['dh_email'] = Session::get('dh_email');
            $data['dh_ghiChu'] = Session::get('dh_ghiChu');
            $data['dh_ngayDat'] = Session::get('dh_ngayDat');
            $data['dh_trangThai'] = 'Chờ xử lý';
            $subtt =(int)Cart::subtotal(2,'.','');
            $data['dh_tongTien'] =  $subtt;
            $data['vc_ma'] = Session::get('vc_ma');
            $data['tt_ma'] = $matt->tt_ma;
            $data['nd_ma'] = Session::get('nd_ma');
            $data['km_ma'] = Session::get('ma_khuyenmai');


           

            //insert chi tiet don hang


            $hethang = 0; //false
            $outstock = array();
            foreach ($content as $v_content) {
                 $ctsp_ton =  DB::table('chitietsanpham')->where('ctsp_ma', $v_content->id)->first();
                if ( $v_content->qty > $ctsp_ton->ctsp_soLuongTon){
                    $hethang = $hethang+1; //true
                    $outstock[$hethang] = $ctsp_ton->sp_ma;
                }
            }
            
            if ($hethang == 0){
                $insert_donhang_id = DB::table('donhang')->insertGetId($data);
                foreach ($content as $v_content) {
                    $order_detail_data = array();
                    $order_detail_data['dh_ma'] = $insert_donhang_id; 
                    $order_detail_data['ctsp_ma'] = $v_content->id;
                     $product = DB::table('chitietsanpham')->join('sanpham','sanpham.sp_ma','=','chitietsanpham.sp_ma')->where('ctsp_ma',$v_content->id)->select('sanpham.sp_ma', 'sp_donGiaNhap','sp_donGiaBan')->first();
                    $order_detail_data['donGiaBan'] = $product->sp_donGiaBan;
                    $order_detail_data['donGiaNhap'] = $product->sp_donGiaNhap;
                    $order_detail_data['soLuongDat'] = $v_content->qty;
                    $order_detail_data['thanhTien'] = $v_content->qty*$v_content->price;            
                    $insert_orderdetail_id = DB::table('chitietdonhang')->insertGetId($order_detail_data);
                    $ctsp_ton = DB::table('chitietsanpham')->where('ctsp_ma', $v_content->id)->first();
                    DB::table('chitietsanpham')->where('ctsp_ma', $v_content->id)->update(['ctsp_soLuongTon' => $ctsp_ton->ctsp_soLuongTon - $v_content->qty]);
                }
                Cart::destroy();
                return Redirect::to('thankyou');
            }
            else {
                $tenhang = '';
                foreach ($outstock as $key => $value) {
                    $hang = DB::table('sanpham')->where('sp_ma',$value)->select('sp_ten')->first();
                    $tenhang .= ' ';
                    $tenhang .= $hang->sp_ten;
                    if ($key != count($outstock))
                    $tenhang .= ',';
                }
                /*$sizes = DB::Table('chitietsanpham')->select('ctsp_kichCo','ctsp_ma')->where('sp_ma',4)->get(); */
           
                Session::put('message','Đặt hàng không thành công! <b>'.$tenhang.'</b> không đủ hàng');
                return view('pages.cart.show_cart');
            }
        }
    }
}
