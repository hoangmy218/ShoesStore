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
		//(double)$ti_le_giamgia = Session::get('ti_le_giamgia');
		$content = Cart::content();
		(double)$rate = 0.000043; //ti so USD
		//(double) $discount = (100-$ti_le_giamgia)/100;

		// Session::put('httt_ma', );
		// echo $request->optradio;
		// echo Session::get('httt_ma');
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
			    ->setPrice($v_content->price * $rate );
           echo 'sp'.round($v_content->price * $rate ,2) * $v_content->qty.'\n';
      $tongtien = $tongtien + round($v_content->price * $rate ,2) * $v_content->qty;

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

		//(double)$ti_le_giamgia = Session::get('ti_le_giamgia');

    	$execution = new PaymentExecution();
    	$execution->setPayerId(request('PayerID'));

    	$transaction = new Transaction();
	    $amount = new Amount();
	    $details = new Details();


	    //them du lieu
		$content = Cart::content();
	
	    (double)$rate = 0.000043; //ti so USD
		//(double) $discount = (100-$ti_le_giamgia)/100;
	    (double)$tongtien = 0;
	    foreach($content as $v_content){
	      $tongtien = $tongtien + round($v_content->price * $rate,2) * $v_content->qty;
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
    	$matt = DB::table('hinhthucthanhtoan')->where('httt_ten','Paypal')->first();
    	// $matt = Session::get('httt_ma');
    	// echo $matt;
        if (!$content->isempty()) 
        {

			$data = array();
            $data['dh_tenNguoiNhan'] = Session::get('dh_tenNhan');
            $data['dh_diaChiNhan'] = Session::get('dh_diaChiNhan');
            $data['dh_dienThoaiNhan'] = Session::get('dh_dienThoai');
            $data['dh_ghiChu'] = Session::get('dh_ghiChu');
            $data['dh_ngayDat'] = Session::get('dh_ngayDat');
            $data['tt_ma'] = 1; //'Chờ xử lý';
            $subtt =(int)Cart::subtotal(2,'.','');
            $data['dh_tongTien'] =  $subtt;
            $data['htvc_ma'] = Session::get('htvc_ma');
            $data['httt_ma'] = $matt->httt_ma;
            $data['nd_ma'] = Session::get('nd_ma');
           

           
            //insert chi tiet don hang
            $hethang = 0; //false - con hang
            $outstock = array();
            foreach ($content as $v_content) 
            {
                //echo "\n mau sac".$v_content->options->mausac;
                $ctsp_ton =  DB::table('cochitietsanpham')
                             ->where([['cochitietsanpham.kc_ma',$v_content->options->size],
                                ['cochitietsanpham.ms_ma',$v_content->options->mausac],
                                ['cochitietsanpham.sp_ma',$v_content->id]])
                             ->first();
                if ( $v_content->qty > $ctsp_ton->soLuongTon)
                {
                    $hethang = $hethang+1; //true
                    $outstock[$hethang] = $ctsp_ton->sp_ma;
                    $rowId = $v_content->rowId;
                    Cart::update($rowId,0);
                }
            } 

            if ($hethang != 0)
            {
                $tenhang = '';
                foreach ($outstock as $key => $value) {
                    $hang = DB::table('sanpham')->where('sp_ma',$value)->select('sp_ten')->first();
                    $tenhang .= ' ';
                    $tenhang .= $hang->sp_ten;
                    if ($key != count($outstock))
                    $tenhang .= ',';
                }
                Session::put('fail_message','<b>'.$tenhang.'</b> không đủ hàng');
                Redirect::to('/payment');
            } 
            else
            {
                $insert_donhang_id = DB::table('donhang')->insertGetId($data);
                foreach ($content as $v_content) {
                    $order_detail_data = array();
                    $order_detail_data['dh_ma'] = $insert_donhang_id; 
                    $order_detail_data['sp_ma'] = $v_content->id;
                    $order_detail_data['ms_ma'] = $v_content->options->mausac;
                    $order_detail_data['kc_ma'] = $v_content->options->size;
                    $order_detail_data['DonGiaBan'] = $v_content->price;
                    $order_detail_data['SoLuongDat'] = $v_content->qty; 
                    try {
                        $insert_orderdetail_id = DB::table('cochitietdonhang')->insertGetId($order_detail_data);
                        //if ($insert_orderdetail_id != NULL){

                           $ctsp_ton =  DB::table('cochitietsanpham')
                             ->where([['cochitietsanpham.kc_ma',$v_content->options->size],
                                ['cochitietsanpham.ms_ma',$v_content->options->mausac],
                                ['cochitietsanpham.sp_ma',$v_content->id]])
                             ->first();
                            $slt = $ctsp_ton->soLuongTon - $v_content->qty;
                            DB::table('cochitietsanpham')
                                ->where([['cochitietsanpham.kc_ma',$v_content->options->size],
                                ['cochitietsanpham.ms_ma',$v_content->options->mausac],
                                ['cochitietsanpham.sp_ma',$v_content->id]])
                                ->update(['soLuongTon' => $slt]);
                        //}             
                    } catch (\Illuminate\Database\QueryException $e) {
                        Session::put('fail_message1','Đặt hàng không thành công!');
                        Redirect::to('/payment');
                    }              
                    
                }
                Cart::destroy();
                return Redirect::to('/thankyou');
            }
        }
        return Redirect::to('/show-cart');

    }
}
