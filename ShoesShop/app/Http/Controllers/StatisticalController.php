<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Session;
use Charts;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class StatisticalController extends Controller
{
	public function authLogin(){
        $admin_id = Session::get('nd_ma');
        if ($admin_id) 
            return Redirect::to('/dashboard'); 
        else 
            return Redirect::to('/admin')->send();
    }


    public function showStatistical_order(){
        $this->authLogin();

        $nam = \Carbon\Carbon::now()->year;
        $sum_product = DB::table('sanpham')
              ->join('chitietsanpham','sanpham.sp_ma','chitietsanpham.sp_ma')
              ->select([DB::raw('sum(chitietsanpham.ctsp_soLuongTon) as slTon'),DB::raw('sum(chitietsanpham.ctsp_soLuongNhap) as slNhap'),'sanpham.sp_ten as ten'])
              ->where(DB::raw("(date_format(chitietsanpham.created_at,'%Y'))"),$nam)
              ->groupBy('sanpham.sp_ten')
              ->get();

        $chart_sp = Charts::multi('bar', 'material')
            ->title("Thống kê sản phẩm")
            ->dimensions(1080, 400) // Width x Height
            ->template("material")
            ->colors(['green', '#F44336', '#FFC107'])
            ->dataset('Số lượng nhập', $sum_product->pluck('slNhap')->all())
            ->dataset('Số lượng tồn', $sum_product->pluck('slTon')->all())
            ->labels($sum_product->pluck('ten')->all());


        return view('admin.statistical_order',compact('chart_sp'));
    }

    public function showStatistical_Revenue(){
        $this->authLogin();

        $nam = \Carbon\Carbon::now()->year;

        $sumorder = DB::table('donhang')
              ->select([DB::raw('sum(dh_tongTien) as doanhthu'),DB::raw("(date_format(dh_ngayDat,'%M')) as month")])
              ->where('dh_trangThai','=','Đã giao')
              ->where(DB::raw("(date_format(dh_ngayDat,'%Y'))"),$nam)
              ->groupBy('month')
              ->get();

        $chart = Charts::database($sumorder,'bar', 'highcharts')
                    ->title("Thống kê theo tháng")
                    ->elementLabel('Tổng doanh thu tháng')

                    ->labels($sumorder->pluck('month')->all())
                    
                    ->values($sumorder->pluck('doanhthu')->all())
                    ->colors(['gold', 'green', 'crimson', 'darkblue'])
                    ->dimensions(600,400)
                    ->responsive(false);

        $bon_nam = \Carbon\Carbon::now()->subYear(3);

        $sumorder1 = DB::table('donhang')
              ->select([DB::raw('sum(dh_tongTien) as doanhthu'),DB::raw("(date_format(dh_ngayDat,'%Y')) as year")])
              ->where('dh_trangThai','=','Đã giao')
              ->where(DB::raw("(date_format(dh_ngayDat,'%Y'))"),'>=',$bon_nam)
              ->groupBy('year')
              ->get();

        $line_chart = Charts::create('area', 'highcharts')
                ->title('Doanh thu theo năm')
                ->elementLabel('Tổng doanh thu năm')
                ->labels($sumorder1->pluck('year')->all())
                ->values($sumorder1->pluck('doanhthu')->all())
                ->colors(['pink'])
                ->dimensions(450,400)
                ->responsive(false);


         return view('admin.statistical_Revenue',compact('chart','line_chart'));
    }

}
