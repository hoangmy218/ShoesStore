<?php

namespace App\Http\Controllers;
use App\Size;
use App\Stock;
use DB;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
    	/*$sizes = Size::all()->pluck('size_number','size_id');
    	return view('welcome',compact('sizes'));*/

    	$sizes = DB::Table('chitietsanpham')->select('ctsp_kichCo','ctsp_ma')->where('sp_ma',4)->get(); 
    	return view('welcome',compact('sizes'));
    }

/*    public function getStock($id)
    {
    	$stocks = Stock::where('size_id',$id)->pluck('stock_number','stock_id');
    	return json_encode($stocks);
    }*/
    public function getColor(Request $request)
    {
    	$pro = DB::Table('cochitietsanpham')
            ->join('mausac', 'mausac.ms_ma','=','cochitietsanpham.ms_ma')
            ->where([['sp_ma',$request->sp_ma],['kc_ma',$request->size_id]])
            ->distinct()
            ->get();
    	// $stocks = DB::Table('chitietsanpham')->select('ctsp_soLuongTon')->where([['sp_ma',$pro->sp_ma],['ctsp_kichCo',$request->size_id]])->first(); 
    	return json_encode($pro);
    	/*
    	$stocks = DB::Table('chitietsanpham')->select('ctsp_soLuongTon')->where([['sp_ma',$request->sp_ma],['ctsp_kichCo',$request->size_id]])->first(); 
    	return json_encode($stocks);

    	$stocks = Stock::where('size_id',$request->size_id)->pluck('stock_number','stock_id');
    	return json_encode($stocks);*/
    }

    public function getSize(Request $request)
    {
        $pro = DB::Table('cochitietsanpham')
            ->join('kichco', 'kichco.kc_ma','=','cochitietsanpham.kc_ma')
            ->where([['sp_ma',$request->sp_ma],['ms_ma',$request->color_id]])
            ->distinct()
            ->get();
        // $stocks = DB::Table('chitietsanpham')->select('ctsp_soLuongTon')->where([['sp_ma',$pro->sp_ma],['ctsp_kichCo',$request->size_id]])->first(); 
        return json_encode($pro);
        /*
        $stocks = DB::Table('chitietsanpham')->select('ctsp_soLuongTon')->where([['sp_ma',$request->sp_ma],['ctsp_kichCo',$request->size_id]])->first(); 
        return json_encode($stocks);

        $stocks = Stock::where('size_id',$request->size_id)->pluck('stock_number','stock_id');
        return json_encode($stocks);*/
    }

    public function getStock(Request $request)
    {
         $stocks = DB::Table('cochitietsanpham')
                    ->select('soLuongTon')
                    ->where([['sp_ma',$request->sp_ma],['ms_ma',$request->color_id],['kc_ma',$request->size_id]])
                    ->first(); 
        return json_encode($stocks);
    }

    /*public function getSlt(Request $request)
    {
        
        $stocks = DB::Table('chitietsanpham')->select('ctsp_soLuongTon')->where('ctsp_ma',$request->ctsp_ma)->first(); 
        return json_encode($stocks);
        /*
        $stocks = DB::Table('chitietsanpham')->select('ctsp_soLuongTon')->where([['sp_ma',$request->sp_ma],['ctsp_kichCo',$request->size_id]])->first(); 
        return json_encode($stocks);

        $stocks = Stock::where('size_id',$request->size_id)->pluck('stock_number','stock_id');
        return json_encode($stocks);*/
    //}

     public function getAmount(Request $request)
    {
    	$amount = DB::Table('chitietsanpham')->select('ctsp_donGiaBan')->where('ctsp_ma',$request->ctsp_ma)->first();
    	$total = $amount->ctsp_donGiaBan * $request->qty; 
    	return json_encode($total);
    	/*$stocks = Stock::where('size_id',$request->size_id)->pluck('stock_number','stock_id');
    	return json_encode($stocks);*/
    }
}
