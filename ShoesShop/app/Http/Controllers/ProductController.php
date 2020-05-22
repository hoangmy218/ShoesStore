<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
use Cart;
use App\Comment;

class ProductController extends Controller
{

     public function authLogin(){
        $admin_id = Session::get('nd_ma');
        if ($admin_id) 
            return Redirect::to('/dashboard'); 
        else 
            return Redirect::to('/admin')->send();
    }

    public function addProduct(){
        $this->authLogin();
        $list_brand = DB::table("danhmuc")->orderby('dm_ma','desc')->get();
        $list_cate = DB::table("thuonghieu")->orderby('th_ma','desc')->get();
        $list_km = DB::table("khuyenmai")->orderby('km_ma','desc')->get();
        // $list_color = DB::table("mausac")->orderby('ms_ma','desc')->get();
        // $list_size = DB::table("kichco")->orderby('kc_ma','desc')->get();
        return view('admin.add_product')->with('list_cate',$list_cate)->with('list_brand',$list_brand)->with('list_km',$list_km)/*->with('list_color',$list_color)->with('list_size',$list_size)*/;
    	
    }

     public function saveProduct(Request $request){
        $data = array();
        $data['sp_ten'] = $request->pro_name;
        $data['sp_donGiaBan'] = $request->pro_price;
        $data['sp_moTa'] = $request->pro_des;
        $data['th_ma'] = $request->pro_brand;
        $data['dm_ma'] = $request->pro_cate;
        //$data['ms_ma'] = $request->pro_color;
        //$data['sp_soLuongTon'] = 0;
        $data['sp_trangThai'] = 1;
        $data['km_ma'] =$request->pro_km;
        // $data['kc_ma'] = 0;
        try{
                if($request->hasFile('product_image')) {
                $sp_ma = DB::table('sanpham')->insertGetId($data);
                    // duyệt từng ảnh và thực hiện lưu
                    foreach ($request->product_image as $photo) {
                        $get_image = $photo->getClientOriginalName();
                        $destinationPath = public_path('upload/product');
                        $photo->move($destinationPath, $get_image);
                        $data_img = array();
                        $data_img['sp_ma']=$sp_ma;
                        $data_img['ha_ten']=$get_image;
                        //$data['ms_ma'] = $request->pro_color;
                        DB::table('hinhanh')->insert($data_img);
                    }
                    Session::put('success_message','Thêm sản phẩm thành công!');
                    return Redirect::to('/manage-product');
            }
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Thêm sản phẩm không thành công!');
            return Redirect::to('/manage-product');
        }

    }


    public function showProduct(){
       $this->authLogin();
        $list_products = DB::table('sanpham')->join('thuonghieu','sanpham.th_ma','=','thuonghieu.th_ma')->join('danhmuc','danhmuc.dm_ma','=','sanpham.dm_ma')->orderby('sanpham.sp_ma','desc')->get();
        /*echo "<pre>";
        print_r($list_products);
        echo "</pre>";*/
        $manager_product = view('admin.manage_product')->with('list_pro', $list_products);
        return view('admin_layout')->with('admin.manage_product', $manager_product);
    }
 
    public function chitiet_sanpham($ct_id){
        $tongslton= DB::table('cochitietsanpham')->select(DB::raw("sum(soLuongTon) as slton"))->where('sp_ma',$ct_id)->get();
        // $tongslnhap= DB::table('cochitietsanpham')->select(DB::raw("sum(ctsp_soLuongNhap) as slnhap"))->where('sp_ma',$ct_id)->get();
        $data= DB::table('cochitietsanpham')->join('kichco', 'kichco.kc_ma', '=','cochitietsanpham.kc_ma')->join('mausac','mausac.ms_ma', '=','cochitietsanpham.ms_ma')->where('sp_ma',$ct_id)->get();


        $list=DB::table('sanpham')->where('sanpham.sp_ma', $ct_id)->get();

        $image = DB::table('hinhanh')->where('hinhanh.sp_ma','=',$ct_id)->get();
        // $ton=DB::table('chitietsanpham')->where('sp_ma', $ct_id)->get();
       
        return view('admin.chitiet_sanpham')->with('list', $list)->with('tongslton', $tongslton)->with('hinh',$image)->with('data', $data);

    }

    //Tien thêm getSlt xóa hàm getSlt bên SocksController 13/05
    public function getSlt(Request $request)
    {
        
        $stocks = DB::Table('cochitietsanpham')->select('soLuongTon')->where([['ms_ma','=',$request->ms_ma],['kc_ma','=',$request->kc_ma],['sp_ma','=',$request->sp_ma]])->first(); 
        return json_encode($stocks);

    }


    public function details_product($product_id,$ms_ma){

        $content = Cart::content();
        $image_product =  DB::table('hinhanh')
                    ->where('hinhanh.sp_ma',$product_id)->get(); 

        $details_product = DB::table('sanpham')
                    ->join('hinhanh','hinhanh.sp_ma','=','sanpham.sp_ma')
                    ->join('thuonghieu', 'thuonghieu.th_ma','=','sanpham.th_ma')
                    ->join('khuyenmai','khuyenmai.km_ma','=','sanpham.km_ma')
                    ->where('sanpham.sp_ma','=',$product_id)
                    ->first(); 
        // tien 13/05
        $sz_product = DB::table('cochitietsanpham')
                    ->join('kichco','kichco.kc_ma','=','cochitietsanpham.kc_ma')
                    ->join('mausac','mausac.ms_ma','=','cochitietsanpham.ms_ma')
                    ->where([['cochitietsanpham.sp_ma','=',$product_id],['soLuongTon','>',0],['cochitietsanpham.ms_ma','=',$ms_ma]])
                    ->orderby('cochitietsanpham.kc_ma','asc')
                    ->orderby('cochitietsanpham.ms_ma','asc')
                    ->get(); 
        //Tien 13/05
        $show_btn_mausac = DB::table('cochitietsanpham')
                    ->join('kichco','kichco.kc_ma','=','cochitietsanpham.kc_ma')
                    ->join('mausac','mausac.ms_ma','=','cochitietsanpham.ms_ma')
                    ->where([['cochitietsanpham.sp_ma','=',$product_id],['soLuongTon','>',0]])
                    ->orderby('cochitietsanpham.kc_ma','asc')
                    ->orderby('cochitietsanpham.ms_ma','asc')
                    ->get();


        $all_product = DB::table('sanpham')->select('sp_ma')
                    ->where('sanpham.sp_ma',$product_id)
                    ->limit(1)->get(); //Tiên 14/03

   
        $sizes = DB::Table('cochitietsanpham')
                    ->select('kc_ma','soLuongTon')
                    ->where('cochitietsanpham.sp_ma',$product_id)
                    ->get(); // Tiên 12/03
        
        $sold_product=DB::table('cochitietdonhang')
                    ->join('sanpham','sanpham.sp_ma','=','cochitietdonhang.sp_ma')
                    ->where('cochitietdonhang.sp_ma',$product_id)
                    ->select('soLuongDat')->sum('soLuongDat'); //Tien 11/05  

        $comments = Comment::where('sp_ma',$product_id)
                    ->join('nguoidung','nguoidung.nd_ma','=','binhluan.nd_ma')
                    ->where('trangThai','=',0)->get(); // Tiên 06/05

        $total_view=DB::table('binhluan')
                    ->join('sanpham','sanpham.sp_ma','=','binhluan.sp_ma')
                    ->where([['binhluan.sp_ma',$product_id],['trangThai','=',0]])
                    ->select('sp_ma')->count();//Tien thêm ['trangThai','=',0] (12/05)

// Tiên 16/05
        $rating = DB::table('binhluan')
                    ->where('sp_ma',$product_id)
                    ->get();
// Tiên 21/05   
        $tong_danhgia = DB::table('binhluan')
                    ->where('sp_ma',$product_id)
                    ->count();    

       
        return view('pages.product.show_detail')
                ->with('details_product',$details_product)
                ->with('sz_product',$sz_product)
                ->with('sizes',$sizes)
                ->with('all_product',$all_product)
                ->with('comments',$comments)
                ->with('total_view',$total_view)
                ->with('image_product',$image_product)
                ->with('sold_product',$sold_product)
                ->with('show_btn_mausac',$show_btn_mausac)
                ->with('ms_ma',$ms_ma)
                ->with('rating',$rating)
                ->with('tong_danhgia',$tong_danhgia);

    }
    

    //GOODS RECEIPT MY
    public function addGoodsReceipt()
    {
        $this->authLogin();     
        $list_products = DB::table('sanpham')->orderby('sp_ma','desc')->get();
        $list_colors = DB::table('mausac')->orderby('ms_ma','desc')->get();
        $list_sizes = DB::table('kichco')->orderby('kc_ma','desc')->get();
        $list_suppliers = DB::table('nhacungcap')->orderby('ncc_ma','desc')->get();

        return  view('admin.add_receipt')->with('list_pro', $list_products)->with('list_col',$list_colors)->with('list_sz',$list_sizes)->with('list_suppliers',$list_suppliers);
    }

    public function saveGoodsReceipt(Request $request)
    {
        $data = array();
        $data = $request->all();
        $datapn = array();
        $pn_tongTien = 0;
        /*
        $datapn['pn_ngayNhap']=$request->ngayNhap;*/
        $dateTime = Carbon::parse($request->ngayNhap);

        $datapn['pn_ngayNhap'] = $dateTime->format('Y-m-d');
        $datapn['pn_tongTien'] = 0;
        $datapn['ncc_ma'] = $request->nhacungcap;
        $pn_id = DB::table('phieunhap')->insertGetId($datapn);

        foreach($data['group-a'] as $pro){
             $datasp = array($pro);
             $insert_data[] = $datasp;
        }

  
         $count = count($insert_data);
         /*echo $count.'count <br>';*/
         $masp = array();
        for ($i=0; $i<$count; $i++){
            $insert_datapro = $insert_data[$i];
             $count_i = count($insert_datapro);
            for ($y=0; $y<$count_i; $y++){
                $insert_datadetail = $insert_datapro[$y];
                $masp[$i+1] = $insert_datadetail['masp'];
                $data_ctpn = array();
                $data_ctpn['sp_ma']= $insert_datadetail['masp'];
                $data_ctpn['kc_ma']= $insert_datadetail['makc'];
                $data_ctpn['ms_ma']= $insert_datadetail['mams'];
                $data_ctpn['SoLuongNhap'] = $insert_datadetail['SoLuongNhap'];
                $data_ctpn['DonGiaNhap'] =  $insert_datadetail['DonGiaNhap'];
                $data_ctpn['pn_ma'] = $pn_id;
                $data_ctpn['created_at'] = $datapn['pn_ngayNhap'];

                try {
                	$ctpn_id = DB::table('cochitietphieunhap')->insertGetId($data_ctpn);
                	Session::put('success_message','Thêm phiếu nhập thành công!');
                	$pn_tongTien = $pn_tongTien + ($insert_datadetail['DonGiaNhap'] *  $insert_datadetail['SoLuongNhap']);
			        //echo 'Successfully!';
		        }catch (\Illuminate\Database\QueryException $e) {
		           
		            Session::put('fail_message','Thêm phiếu nhập không thành công!');
		            //echo "Fail";
		            return Redirect::to('/manage-goods-receipt');

		        }
                
                $ctsp = DB::table('cochitietsanpham')
                        ->where([['sp_ma','=',$insert_datadetail['masp']],
                                 ['kc_ma','=',$insert_datadetail['makc']],
                                 ['ms_ma','=',$insert_datadetail['mams']]])
                        ->first();

                // echo 'ctsp \n';
                // echo '<pre>';
                // print_r($ctsp);
                // echo '</pre>';
                $data_ctsp = array();
                $data_ctsp['sp_ma'] = $insert_datadetail['masp'];
                $data_ctsp['kc_ma'] = $insert_datadetail['makc'];
                $data_ctsp['ms_ma'] = $insert_datadetail['mams'];
                

                if (!$ctsp)
                {
               		//echo 'empty';
               		$data_ctsp['soLuongTon'] = $insert_datadetail['SoLuongNhap'];
               		
               		try {
               			$ctsp_id = DB::table('cochitietsanpham')->insertGetId($data_ctsp);
               			Session::put('success_message','Thêm phiếu nhập thành công!');
			            //echo 'Successfully!';
			        }catch (\Illuminate\Database\QueryException $e) {
			           
			            Session::put('fail_message','Thêm phiếu nhập không thành công!');
			            //echo "Fail";
			            return Redirect::to('/manage-goods-receipt');
			        }
                } 
                else
                {
                    //echo 'not empty';
                    $data_ctsp['soLuongTon'] = $ctsp->soLuongTon + $insert_datadetail['SoLuongNhap'];
                    try {
                    	$ctsp_update = DB::table('cochitietsanpham')
                        ->where([['sp_ma','=',$insert_datadetail['masp']],
                                 ['kc_ma','=',$insert_datadetail['makc']],
                                 ['ms_ma','=',$insert_datadetail['mams']]])
                        ->update($data_ctsp);

			            Session::put('success_message','Thêm phiếu nhập thành công!');
			            //echo 'Successfully!';
			        }catch (\Illuminate\Database\QueryException $e) {
			           
			            Session::put('fail_message','Thêm phiếu nhập không thành công!');
			            //echo "Fail";
			            return Redirect::to('/manage-goods-receipt');
			        }
                }
            }   
        }
        // $data_ctsp = array();
        // $data_ctpn['pn_ma'] = $pn_id;
        // $data_ctpn['pn_tongtien'] = $pn_tongTien;
        try {
        	$ok = DB::table('phieunhap')->where('pn_ma','=',$pn_id)->update(['pn_tongTien' => $pn_tongTien]);
         	Session::put('success_message','Thêm phiếu nhập thành công!');
         	return Redirect::to('/manage-goods-receipt');
            //echo 'Successfully!';
        }catch (\Illuminate\Database\QueryException $e) {
           
            Session::put('fail_message','Thêm phiếu nhập không thành công!');
            //echo "Fail";
            return Redirect::to('/manage-goods-receipt');
        }
    }

    public function updateSumPrice(){
    	$receipts = DB::table('phieunhap')->get();
    	foreach ($receipts as $key => $receipt) {
    		$receipt_details = DB::table('cochitietphieunhap')->where('pn_ma','=',$receipt->pn_ma)->get();
    		$pn_tongTien = 0;
    		foreach ($receipt_details as $key => $receipt_detail) {
    			$pn_tongTien = $pn_tongTien + ($receipt_detail->SoLuongNhap * $receipt_detail->DonGiaNhap);	
    		}
    		DB::table('phieunhap')->where('pn_ma','=',$receipt->pn_ma)->update(['pn_tongTien' => $pn_tongTien]); 
    		
    	}
    	return Redirect::to('/manage-goods-receipt');
    }

    public function savePriceReceipt(Request $request)
    {
         $data = array();
        $data = $request->all();
        /*echo "<pre>"; print_r($data); echo '</pre>';
        echo "<br>";*/
        $dataSP = array();
        $i=0;
        foreach($data['sp_ma'] as $key => $pro){
             $dataSP[$i] = $pro;       
             $i++;
        }
  
        $count = count($dataSP);
/*          echo $count.'count dataSP <br>';
          echo "<pre>"; print_r($data['sp_ma']); echo '</pre><br>';
          echo '<br>array insert_dataSP<br>';
          echo "<pre>"; print_r($dataSP); echo '</pre><br>';*/
          /*echo '<br> array dataSP <br>';
          foreach ($dataSP as $key => $value) {
              echo $value.' SP_MA<br>';
          }*/

        $dataGN = array();
        $i=0;
        foreach($data['giaNhap'] as $key => $pro){
             $dataGN[$i] = $pro;       
             $i++;
        }
        $dataGB = array();
        $i=0;
        foreach($data['giaBan'] as $key => $pro){
             $dataGB[$i] = $pro;       
             $i++;
        }

        $data_price_pro = array();
        for ($i=0; $i<$count; $i++){
            $data_price_pro['sp_donGiaNhap'] =$dataGN[$i];
            $data_price_pro['sp_donGiaBan'] = $dataGB[$i];
           /* echo '<br>array data_price_pro SP_MA'.$dataSP[$i].'<br>' ;
            echo "<pre>"; print_r($data_price_pro); echo '</pre><br>';*/
            DB::table('sanpham')->where('sp_ma',$dataSP[$i])->update($data_price_pro);
        }
        return Redirect::to('/manage-goods-receipt');
    }

    public function showGoodsReceipt()
    {

        // $list_receipts = DB::table('phieunhap')->join('cochitietsanpham','cochitietsanpham.pn_ma','=','phieunhap.pn_ma')->select('phieunhap.*',DB::raw("count(cochitietsanpham.pn_ma) as count"))->orderby('pn_ma','desc')->groupBy('cochitietphieunhap.pn_ma')->get();  

        $list_receipts = DB::table('cochitietphieunhap')->join('phieunhap','cochitietphieunhap.pn_ma','=','phieunhap.pn_ma')->select('phieunhap.*',DB::raw("count(cochitietphieunhap.pn_ma) as count"))->orderby('cochitietphieunhap.pn_ma','desc')->groupBy('cochitietphieunhap.pn_ma')->get();        
        return view('admin.manage_goods_receipt')->with('list_receipts', $list_receipts);
    }

    public function viewReceiptDetails($pn_ma)
    {
        $receipt_detail = DB::table('phieunhap')->join('cochitietphieunhap','cochitietphieunhap.pn_ma','=','phieunhap.pn_ma')->join('sanpham','sanpham.sp_ma','=','cochitietphieunhap.sp_ma')->where('phieunhap.pn_ma',$pn_ma)->orderby('cochitietphieunhap.pn_ma','desc')->get();
        $receipt = DB::table('phieunhap')->where('pn_ma',$pn_ma)->first();
        // $list_product = DB::table('sanpham')->join('thuonghieu','sanpham.th_ma','=','thuonghieu.th_ma')->join('danhmuc','danhmuc.dm_ma','=','sanpham.dm_ma')->join('hinhanh','hinhanh.sp_ma','=','sanpham.sp_ma')->join('cochitietphieunhap','cochitietphieunhap.sp_ma','=','sanpham.sp_ma')->join('kichco','kichco.kc_ma','=','cochitietphieunhap.kc_ma')->join('mausac','mausac.ms_ma','=','cochitietphieunhap.ms_ma')->orderby('sanpham.sp_ma','desc')->orderby('cochitietphieunhap.kc_ma','desc')->get();   
        $list_colors = DB::table('mausac')->get();
        $list_sizes = DB::table('kichco')->get();
        $list_products = DB::table('sanpham')->get();

        // $list_pro = DB::table('cochitietphieunhap')
        //         ->join('cochitietsanpham','cochitietphieunhap.sp_ma','=','cochitietsanpham.sp_ma')
        //         ->join('sanpham','sanpham.sp_ma','=','cochitietphieunhap.sp_ma')
        //         ->join('kichco','kichco.kc_ma','=','cochitietphieunhap.kc_ma')
        //         ->join('mausac','mausac.ms_ma','=','cochitietphieunhap.ms_ma')
        //         ->where('pn_ma','=',$pn_ma)
        //         ->orderby('cochitietphieunhap.sp_ma','desc')
        //         ->orderby('cochitietphieunhap.kc_ma','desc')
        //         ->orderby('cochitietphieunhap.ms_ma','desc')
        //         ->distinct('cochitietsanpham.sp_ma')
        //         ->get();

                $results = DB::table('cochitietphieunhap')
                     ->distinct()
                     ->leftJoin('cochitietsanpham', function($join)
                         {
                             $join->on('cochitietsanpham.sp_ma', '=', 'cochitietphieunhap.sp_ma');
                             $join->on('cochitietsanpham.kc_ma', '=', 'cochitietphieunhap.kc_ma');
                             $join->on('cochitietsanpham.ms_ma', '=', 'cochitietphieunhap.ms_ma');
                            
                         })
                     ->join('sanpham','sanpham.sp_ma','=','cochitietphieunhap.sp_ma')
                     ->join('kichco','kichco.kc_ma','=','cochitietphieunhap.kc_ma')
                     ->join('mausac','mausac.ms_ma','=','cochitietphieunhap.ms_ma')
                     ->where('pn_ma', '=', $pn_ma)
                     ->get();
        // echo 'list_products \n';
        // echo '<pre>';
        // print_r($list_products);
        // echo '</pre>';

        // echo "\nlist pro \n";
        // echo '<pre>';
        // print_r($list_pro);
        // echo '</pre>';

        // echo "\nresult \n";
        // echo '<pre>';
        // print_r($results);
        // echo '</pre>';
       
        return view('admin.view_goods_receipt')->with('receipt',$receipt)->with('receipt_detail',$receipt_detail)->with('list_pro', $results)->with('list_colors',$list_colors)->with('list_sizes',$list_sizes)->with('list_products',$list_products);
    }

    public function deleteReceipt($pn_ma)
    {
        $this->authLogin();
        try {
            DB::table('chitietsanpham')->where('pn_ma', $pn_ma)->delete();
            DB::table('phieunhap')->where('pn_ma', $pn_ma)->delete(); //Neu doi ctsp cascade thi xoa dong nay
            Session::put('success_message','Xóa phiếu nhập thành công!');
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Xóa phiếu nhập không thành công!');
        }

    }

    public function getDateReceipt(Request $request)
    {
        $receipt_date = DB::Table('phieunhap')->select('pn_ngayNhap')->where('pn_ma',$request->pn_ma)->first(); 
        return json_encode($receipt_date);
    }

    public function saveEditReceipt(Request $request, $pn_ma)
    {
        $this->authLogin();
        
        $date = $request->pn_ngayNhap;
        echo gettype($date);
        $ngayNhap = array();
        $ngayNhap['pn_ngayNhap'] = date('Y-m-d',strtotime($date));
        
        echo $pn_ma;
        try{
            DB::table('phieunhap')->where('pn_ma',$pn_ma)->update($ngayNhap);
            
             Session::put('success_message','Cập nhật phiếu nhập thành công!');
        }catch (\Illuminate\Database\QueryException $e) {
           
            Session::put('fail_message','Cập nhật phiếu nhập không thành công!');
        }
       

    }

    //Edit Goods of Receipt
    public function deleteGoods($ctsp_ma)
    {
        $this->authLogin();
        try {
            DB::table('chitietsanpham')->where('ctsp_ma', $ctsp_ma)->delete();
           //DB::table('phieunhap')->where('pn_ma', $pn_ma)->delete(); //Neu doi ctsp cascade thi xoa dong nay
            Session::put('success_message','Xóa sản phẩm thành công!');
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Xóa sản phẩm không thành công!');
        }
    }

    public function getDetailGoods(Request $request)
    {
        $receipt_good = DB::Table('cochitietphieunhap')	
         		->leftJoin('cochitietsanpham', function($join)
                         {
                             $join->on('cochitietsanpham.sp_ma', '=', 'cochitietphieunhap.sp_ma');
                             $join->on('cochitietsanpham.kc_ma', '=', 'cochitietphieunhap.kc_ma');
                             $join->on('cochitietsanpham.ms_ma', '=', 'cochitietphieunhap.ms_ma');
                            
                         })
                ->join('sanpham','sanpham.sp_ma','=','cochitietphieunhap.sp_ma')
                ->join('kichco','kichco.kc_ma','=','cochitietphieunhap.kc_ma')
                ->join('mausac','mausac.ms_ma','=','cochitietphieunhap.ms_ma')
                ->where([['cochitietphieunhap.pn_ma', '=', $request->pn_ma],
             			  ['cochitietphieunhap.kc_ma', '=', $request->kc_ma],
             			  ['cochitietphieunhap.ms_ma', '=', $request->ms_ma],
             			  ['cochitietphieunhap.sp_ma', '=', $request->sp_ma]])
        		->first(); 
        return json_encode($receipt_good);
    }

    public function saveEditGoods(Request $request, $pn_ma)
    {
        $this->authLogin();
        
        $sp_ma_moi = $request->sp_ma_moi;
        // echo gettype($date);
        // $dataSP = array();
        // $ngayNhap['pn_ngayNhap'] = date('Y-m-d',strtotime($date));
        
        // $dataSP['sp_donGiaBan'] = $request->sp_donGiaBan;
        try {
        	DB::table('sanpham')->where('sp_ma',$sp_ma_moi)->update(['sp_donGiaBan' => $request->sp_donGiaBan_moi]);
         	Session::put('success_message','Cập nhật chi tiết sản phẩm nhập thành công!');
        }catch (\Illuminate\Database\QueryException $e) {
           
            Session::put('fail_message','Cập nhật chi tiết sản phẩm nhập không thành công!');
            return Redirect::to('/view-receipt/'.$request->pn_ma);

        }
        
        $sp_donGiaBan_cu = 0;
        $ctpn_cu = DB::table('cochitietphieunhap')
             ->where([['cochitietphieunhap.sp_ma', '=', $request->sp_ma_cu],
             			  ['cochitietphieunhap.kc_ma', '=', $request->kc_ma_cu],
             			  ['cochitietphieunhap.ms_ma', '=', $request->ms_ma_cu]])
             ->first();
        $DonGiaNhap_cu = $ctpn_cu->DonGiaNhap;
        $SoLuongNhap_cu = $ctpn_cu->SoLuongNhap;
        
        $ctsp_old = DB::table('sanpham')->where('sp_ma',$request->sp_ma_cu)->first();
        $sp_donGiaBan_cu = $ctsp_old->sp_donGiaBan;
        $dataCTPN = array();
        $dataCTPN['sp_ma']= $request->sp_ma_moi;
        $dataCTPN['ms_ma']= $request->ms_ma_moi;
        $dataCTPN['kc_ma'] = $request->kc_ma_moi;
        $dataCTPN['SoLuongNhap'] = $request->SoLuongNhap_moi;
        $dataCTPN['DonGiaNhap'] = $request->DonGiaNhap_moi;

        try{
            DB::table('cochitietphieunhap')
             ->where([['cochitietphieunhap.pn_ma', '=', $request->pn_ma],
             			  ['cochitietphieunhap.kc_ma', '=', $request->kc_ma_cu],
             			  ['cochitietphieunhap.ms_ma', '=', $request->ms_ma_cu],
             			  ['cochitietphieunhap.sp_ma', '=', $request->sp_ma_cu]])
             ->update($dataCTPN);
            // DB::table('chitietsanpham')->where('ctsp_ma',$ctsp_ma)->update($dataCTPN);
             //tim ctsp moi trong bang ctsp
             $ctsp_moi = DB::table('cochitietsanpham')
             ->where([['cochitietsanpham.sp_ma', '=', $request->sp_ma_moi],
             			  ['cochitietsanpham.kc_ma', '=', $request->kc_ma_moi],
             			  ['cochitietsanpham.ms_ma', '=', $request->ms_ma_moi]])
             ->first();

             $ctsp_cu = DB::table('cochitietsanpham')
             ->where([['cochitietsanpham.sp_ma', '=', $request->sp_ma_cu],
             			  ['cochitietsanpham.kc_ma', '=', $request->kc_ma_cu],
             			  ['cochitietsanpham.ms_ma', '=', $request->ms_ma_cu]])
             ->first();
            


             if(!$ctsp_moi) 
             {

             	//ctsp moi khong co trong bang ctsp

             	//tru slt cua ctsp_cu
             	$stock = $ctsp_cu->soLuongTon - $request->SoLuongNhap_cu; 
             	if ($stock == 0)
             	{
             		$del_stock_old = DB::table('cochitietsanpham')
					             	->where([['cochitietsanpham.sp_ma', '=', $request->sp_ma_cu],
					             			  ['cochitietsanpham.kc_ma', '=', $request->kc_ma_cu],
					             			  ['cochitietsanpham.ms_ma', '=', $request->ms_ma_cu]])
					             	->delete();
             	}
             	else{
             		$up_stock_old = DB::table('cochitietsanpham')
					             	->where([['cochitietsanpham.sp_ma', '=', $request->sp_ma_cu],
					             			  ['cochitietsanpham.kc_ma', '=', $request->kc_ma_cu],
					             			  ['cochitietsanpham.ms_ma', '=', $request->ms_ma_cu]])
					             	->update(['soLuongTon'=> $stock]);
             	}
             	
             	$dataCTSP_MOI = array();
             	$dataCTSP_MOI['sp_ma'] = $request->sp_ma_moi;
             	$dataCTSP_MOI['ms_ma'] = $request->ms_ma_moi;
             	$dataCTSP_MOI['kc_ma'] = $request->kc_ma_moi;
             	$dataCTSP_MOI['soLuongTon'] = $request->SoLuongNhap_moi;
             	$insert_ctsp_moi = DB::table('cochitietsanpham')->insertGetId($dataCTSP_MOI);

             }else
             {
             	$stock = $ctsp_cu->soLuongTon - $request->SoLuongNhap_cu; 
             	if ($stock == 0)
             	{
             		$del_stock_old = DB::table('cochitietsanpham')
					             	->where([['cochitietsanpham.sp_ma', '=', $request->sp_ma_cu],
					             			  ['cochitietsanpham.kc_ma', '=', $request->kc_ma_cu],
					             			  ['cochitietsanpham.ms_ma', '=', $request->ms_ma_cu]])
					             	->delete();
             	}
             	else{
             		$up_stock_old = DB::table('cochitietsanpham')
					             	->where([['cochitietsanpham.sp_ma', '=', $request->sp_ma_cu],
					             			  ['cochitietsanpham.kc_ma', '=', $request->kc_ma_cu],
					             			  ['cochitietsanpham.ms_ma', '=', $request->ms_ma_cu]])
					             	->update(['soLuongTon'=> $stock]);
             	}

             	$dataCTSP_MOI = array();
             	$dataCTSP_MOI['sp_ma'] = $request->sp_ma_moi;
             	$dataCTSP_MOI['ms_ma'] = $request->ms_ma_moi;
             	$dataCTSP_MOI['kc_ma'] = $request->kc_ma_moi;
             	$dataCTSP_MOI['soLuongTon'] = $ctsp_moi->soLuongTon + $request->SoLuongNhap_moi;
             	$insert_ctsp_moi = DB::table('cochitietsanpham')
             		->where([['cochitietsanpham.sp_ma', '=', $request->sp_ma_moi],
             			  ['cochitietsanpham.kc_ma', '=', $request->kc_ma_moi],
             			  ['cochitietsanpham.ms_ma', '=', $request->ms_ma_moi]])
             		->update($dataCTSP_MOI);


             }
             $product_receipt = DB::table('cochitietphieunhap')->where('pn_ma','=',$request->pn_ma)->get();
             $pn_tongTien = 0;
             foreach ($product_receipt as $key => $value) {
             	$pn_tongTien = $pn_tongTien + ($value->SoLuongNhap * $value->DonGiaNhap);
             	
             }
             $up_Total = DB::table('phieunhap')->where('pn_ma','=',$request->pn_ma)->update(['pn_tongTien'=> $pn_tongTien]);
             			 
            
            Session::put('success_message','Cập nhật chi tiết sản phẩm nhập thành công!');
        }catch (\Illuminate\Database\QueryException $e) {
           
            Session::put('fail_message','Cập nhật chi tiết sản phẩm nhập không thành công!');
             return Redirect::to('/view-receipt/'.$request->pn_ma);
        }
         return Redirect::to('/view-receipt/'.$request->pn_ma);
    }

    //Lan
    public function chinhsua_sanpham($chinhsua_sp_ma){
        $this->authLogin();    
        $list_cate = DB::table("danhmuc")->orderby('dm_ma','desc')->get();
        $list_brand = DB::table("thuonghieu")->orderby('th_ma','desc')->get();
        $hinh_anh=DB::table('hinhanh')->where('sp_ma', $chinhsua_sp_ma)->get();
        $edit_pro=DB::table('sanpham')->where('sp_ma',$chinhsua_sp_ma)->get();
        $list_km=DB::table('khuyenmai')->orderby('km_ma','desc')->get();
        // echo $hinh_anh;
        return view('admin.edit_product')->with('edit_pro', $edit_pro)->with('list_brand', $list_brand)->with('list_cate', $list_cate)->with('hinh_anh', $hinh_anh)->with('list_km', $list_km);
    }
    
    public function capnhat_sanpham(Request $request, $chinhsua_sp_ma){
         $data= array();
        $data['sp_ten']=$request->pro_name;
        // $data['sp_donGiaNhap']=$request->pro_pricegor;
        $data['sp_donGiaBan']=$request->pro_price;
        $data['sp_moTa']=$request->pro_moTa;
        $data['th_ma']=$request->pro_brand;
        $data['dm_ma']=$request->pro_cate;
        $data['km_ma']=$request->pro_km;
        try{
            if($request->hasFile('product_image')) {
            DB::table('sanpham')->where('sp_ma', $chinhsua_sp_ma)->update($data);
                // duyệt từng ảnh và thực hiện lưu
                foreach ($request->product_image as $photo) {
                    $get_image = $photo->getClientOriginalName();
                    $destinationPath = public_path('upload/product');
                    $photo->move($destinationPath, $get_image);
                    $data_img = array();
                    $data_img['sp_ma']=$chinhsua_sp_ma;
                    $data_img['ha_ten']=$get_image;
                    DB::table('hinhanh')->insert($data_img);
                }
                Session::put('success_message','Cập nhật sản phẩm thành công!');
                return Redirect::to('/manage-product');
        }else{
            DB::table('sanpham')->where('sp_ma', $chinhsua_sp_ma)->update($data);
        Session::put('success_message','Cập nhật sản phẩm thành công!');
        return Redirect::to('/manage-product');
        }
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Cập nhật sản phẩm thành công!');
        }
    }

    public function xoa_sanpham($id_xoa){
        $this->AuthLogin();
        $data= DB::table('cochitietsanpham')->select(DB::raw("count(sp_ma) as slsp"))->where('sp_ma',$id_xoa)->get();
        foreach ($data as $key => $value) {
            $v=$value->slsp;
        }
        if($v>0){
            Session::put('fail_message', 'Sản phẩm đang bán, không thể xóa!');
           
           
            }else{
                DB::table('hinhanh')->join('sanpham', 'sanpham.sp_ma', '=', 'hinhanh.sp_ma')->where('hinhanh.sp_ma',$id_xoa)->delete();
                DB::table('sanpham')->where('sp_ma',$id_xoa)->delete();
               
                Session::put('success_message', 'Xóa sản phẩm ảnh thành công');

            }      
       
    }

    public function delete_image_product($ha_id){
        try{
        $this->AuthLogin();
        DB::table('hinhanh')->where('ha_ma',$ha_id)->delete();
        Session::put('success_message', 'Xóa hình ảnh thành công');
        // return redirect()->back();
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Xóa hình ảnh không thành công!');
            // return redirect()->back();
        }
       
    }

    public function unactive_product($Controll_sp_ma){
        try{
            //$this->AuthLogin();
           DB::table('sanpham')->where('sp_ma', $Controll_sp_ma)->update(['sp_trangThai'=>1]);
            Session::put('success_message', 'Ẩn sản phẩm thành công!');
            // return Redirect::to('manage-product');
        }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Ẩn sản phẩm không thành công!');
        }
           
    }

    public function active_product($Controll_sp_ma){
        $data= DB::table('cochitietsanpham')->select(DB::raw("count(sp_ma) as slsp"))->where('sp_ma',$Controll_sp_ma)->get();
        foreach ($data as $key => $value) {
            $v=$value->slsp;
        }
        if($v>0){
                try{ //$this->AuthLogin();
                DB::table('sanpham')->where('sp_ma', $Controll_sp_ma)->update(['sp_trangThai'=>0]);
                Session::put('success_message', 'Hiển thị sản phẩm thành công!');
                // return Redirect::to('manage-product');

            }catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Hiển thị sản phẩm không thành công!');
            }
        }else{
            Session::put('fail_message','Sản phẩm hiện chưa nhập số lượng nên không thể hiển thị!');
        }
       
    }

     public function showProCategory($category_id){
        $list_cate_product = DB::table('hinhanh')
            ->join('sanpham','sanpham.sp_ma','=','hinhanh.sp_ma')
            ->join('cochitietphieunhap','sanpham.sp_ma','=','cochitietphieunhap.sp_ma')
            ->join('phieunhap','phieunhap.pn_ma','=','cochitietphieunhap.pn_ma')
            ->join('thuonghieu', 'thuonghieu.th_ma','=','sanpham.th_ma')
            ->join('khuyenmai', 'khuyenmai.km_ma','=','sanpham.km_ma')
            ->where('sanpham.dm_ma',$category_id)
            ->orderby('phieunhap.pn_ngayNhap','desc')
            ->groupby('hinhanh.sp_ma')
            ->paginate(6);

         $cate = DB::table('danhmuc')->orderby('dm_ma','asc')->get();
         $brand = DB::table('thuonghieu')->orderby('th_ma','asc')->get();

         Session::put('dm_hienhanh',$category_id);

        // Đếm sản phẩm theo danh mục
        $list_category = DB::table('danhmuc')->select('dm_ma')->get();
        $count_dm = count($list_category);
        $dm_array= array();
        $dm=0;
        foreach ($list_category as $key => $danhmuc){
            $sl_dm = db::table('sanpham')->where('dm_ma',$danhmuc->dm_ma)->count();
            $dm_array[$dm] = $sl_dm;
            $dm++;
        }

        // Đếm sản phẩm theo thương hiệu
        $list_brand = DB::table('thuonghieu')->select('th_ma')->get();
        $count_th = count($list_brand);
        $th_array= array();
        $th=0;
        foreach ($list_brand as $key => $thuonghieu){
            $sl_th = db::table('sanpham')->where('th_ma',$thuonghieu->th_ma)->count();
            $th_array[$th] = $sl_th;
            $th++;
        }

        return view("pages.product.show_cate_pro")->with('list_cate_pro',$list_cate_product)->with('list_cate',$cate)->with('list_brand',$brand)->with('list_cate_pro',$list_cate_product)->with('dm_array',$dm_array)->with('th_array',$th_array);
    }

    public function showProBrand($brand_id){
        $list_bra_product = DB::table('hinhanh')
            ->join('sanpham','sanpham.sp_ma','=','hinhanh.sp_ma')
            ->join('cochitietphieunhap','sanpham.sp_ma','=','cochitietphieunhap.sp_ma')
            ->join('phieunhap','phieunhap.pn_ma','=','cochitietphieunhap.pn_ma')
            ->join('thuonghieu', 'thuonghieu.th_ma','=','sanpham.th_ma')
            ->join('khuyenmai', 'khuyenmai.km_ma','=','sanpham.km_ma')
            ->where('sanpham.th_ma',$brand_id)
            ->orderby('phieunhap.pn_ngayNhap','desc')
            ->groupby('hinhanh.sp_ma')
            ->paginate(6);


        $cate = DB::table('danhmuc')->orderby('dm_ma','asc')->get();
        $brand = DB::table('thuonghieu')->orderby('th_ma','asc')->get();

        Session::put('th_hienhanh',$brand_id);

        // Đếm sản phẩm theo danh mục
        $list_category = DB::table('danhmuc')->select('dm_ma')->get();
        $count_dm = count($list_category);
        $dm_array= array();
        $dm=0;
        foreach ($list_category as $key => $danhmuc){
            $sl_dm = db::table('sanpham')->where('dm_ma',$danhmuc->dm_ma)->count();
            $dm_array[$dm] = $sl_dm;
            $dm++;
        }

        // Đếm sản phẩm theo thương hiệu
        $list_brand = DB::table('thuonghieu')->select('th_ma')->get();
        $count_th = count($list_brand);
        $th_array= array();
        $th=0;
        foreach ($list_brand as $key => $thuonghieu){
            $sl_th = db::table('sanpham')->where('th_ma',$thuonghieu->th_ma)->count();
            $th_array[$th] = $sl_th;
            $th++;
        }

        return view("pages.product.show_bra_pro")->with('list_bra_pro',$list_bra_product)->with('list_cate',$cate)->with('list_brand',$brand)->with('dm_array',$dm_array)->with('th_array',$th_array);
    }

}
