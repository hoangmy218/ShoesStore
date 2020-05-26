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


    public function showStatistical(){
        $this->authLogin();

        $nam = \Carbon\Carbon::now()->year;

        $sum_cate = DB::table('danhmuc')
                    ->join('sanpham','danhmuc.dm_ma','=','sanpham.dm_ma')
                    ->join('cochitietsanpham','cochitietsanpham.sp_ma','=','sanpham.sp_ma')
                    ->join('cochitietphieunhap','cochitietphieunhap.sp_ma','=','sanpham.sp_ma')
                    ->join('phieunhap','cochitietphieunhap.pn_ma','=','phieunhap.pn_ma')
                    ->select([DB::raw('sum(cochitietsanpham.soLuongTon) as slTon'),DB::raw('sum(cochitietphieunhap.SoLuongNhap) as slNhap'),'danhmuc.dm_ten as tendanhmuc'])
                    // ->where(floor(abs((strtotime($time)-strtotime('phieunhap.pn_ngayNhap')))/(60*60*24)),'<=',30)
                    ->where(DB::raw("(date_format(phieunhap.pn_ngayNhap,'%Y'))"),$nam)
                    ->groupBy('tendanhmuc')
                    ->get();

        $chart_cate = Charts::multi('bar', 'material')
            ->title("Danh mục")
            ->dimensions(1080, 400) // Width x Height
            ->template("material")
            ->colors(['yellow', 'purple'])
            ->dataset('Số lượng nhập', $sum_cate->pluck('slNhap')->all())
            ->dataset('Số lượng tồn', $sum_cate->pluck('slTon')->all())
            ->labels($sum_cate->pluck('tendanhmuc')->all());

            
        $sum_brand = DB::table('thuonghieu')
                    ->join('sanpham','thuonghieu.th_ma','=','sanpham.th_ma')
                    ->join('cochitietsanpham','cochitietsanpham.sp_ma','=','sanpham.sp_ma')
                    ->join('cochitietphieunhap','cochitietphieunhap.sp_ma','=','sanpham.sp_ma')
                    ->join('phieunhap','cochitietphieunhap.pn_ma','=','phieunhap.pn_ma')
                    ->select([DB::raw('sum(cochitietsanpham.soLuongTon) as slTon'),DB::raw('sum(cochitietphieunhap.SoLuongNhap) as slNhap'),'thuonghieu.th_ten as tenthuonghieu'])
                    ->where(DB::raw("(date_format(phieunhap.pn_ngayNhap,'%Y'))"),$nam)
                    ->groupBy('tenthuonghieu')
                    ->get();

        $chart_brand = Charts::multi('bar', 'material')
                      ->title("Thương hiệu")
                      ->dimensions(1080, 400) // Width x Height
                      ->template("material")
                      ->colors(['blue' ,'red'])
                      ->dataset('Số lượng nhập', $sum_brand->pluck('slNhap')->all())
                      ->dataset('Số lượng tồn', $sum_brand->pluck('slTon')->all())
                      ->labels($sum_brand->pluck('tenthuonghieu')->all());

        

        // echo "<pre>";
        //     print_r($sum_producer);
        //     echo "</pre>";


        return view('admin.statistical_order',compact('chart_cate'),compact('chart_brand'));
    }

    public function showStatistical_Revenue(){
        $this->authLogin();

        $nam = \Carbon\Carbon::now()->year;
        $thang = \Carbon\Carbon::now()->month;

        $sumorder = DB::table('donhang')
              ->select([DB::raw('sum(dh_tongTien) as doanhthu'),DB::raw("(date_format(dh_ngayDat, 'Tháng %m')) as month")])
              ->where('tt_ma','=',4)
              ->where(DB::raw("(date_format(dh_ngayDat,'%Y'))"),$nam)
              ->groupBy('month')
              ->orderBy('month','asc')
              ->get();

        $chart = Charts::database($sumorder,'bar', 'highcharts')
                    ->title("Thống kê theo tháng")
                    ->elementLabel('Tổng doanh thu tháng')
                    ->labels($sumorder->pluck('month')->all())
                    ->values($sumorder->pluck('doanhthu')->all())
                    ->colors(['gold', 'green', 'red', 'darkblue'])
                    ->dimensions(1080, 400)
                    ->responsive(false);

        $ba_nam = \Carbon\Carbon::now()->subYear(3);

        $sumorder1 = DB::table('donhang')
              ->select([DB::raw('sum(dh_tongTien) as doanhthu'),DB::raw("(date_format(dh_ngayDat,'%Y')) as year")])
              ->where('tt_ma','=',4)
              ->where(DB::raw("(date_format(dh_ngayDat,'%Y'))"),'>=',$ba_nam)
              ->groupBy('year')
              ->get();

        $line_chart = Charts::create('area', 'highcharts')
                ->title('Doanh thu theo năm')
                ->elementLabel('Tổng doanh thu năm')
                ->labels($sumorder1->pluck('year')->all())
                ->values($sumorder1->pluck('doanhthu')->all())
                ->colors(['pink'])
                ->dimensions(1080, 400)
                ->responsive(false);

        // echo "<pre>";
        // print_r($sumorder);
        // echo "</pre>";

        return view('admin.statistical_Revenue',compact('chart','line_chart'));
    }

    public function showStatistical_top3(){
        $this->authLogin();
        $list_pro_top= DB::table('sanpham')
                          ->join('cochitietdonhang','cochitietdonhang.sp_ma','=','sanpham.sp_ma')
                          ->join('donhang','cochitietdonhang.dh_ma','=','donhang.dh_ma')
                          ->select([DB::raw('sum(cochitietdonhang.SoLuongDat) as sLDat'),'sanpham.sp_ten as tensanpham'])
                          ->where([
                                ['donhang.tt_ma', '=', 4],
                                ['donhang.dh_ngayDat', '>=', 'date_add()(NOW(), INTERVAL -30 DAY']
                            ])
                          ->groupBy('tensanpham')
                          ->orderBy('sLDat','desc')
                          ->limit(3)
                          ->get();

        // echo "<pre>";
        // print_r($list_pro_top);
        // echo "</pre>";

         $bar_chart = Charts::database($list_pro_top,'bar', 'highcharts')
                    ->title("Các sản phẩm bán chạy nhất")
                    ->elementLabel('Số sản phẩm đã bán')
                    ->labels($list_pro_top->pluck('tensanpham')->all())
                    ->values($list_pro_top->pluck('sLDat')->all())
                    ->colors(['red', 'gold', 'green',])
                    ->dimensions(1080, 400)
                    ->responsive(false);

        return view('admin.statistical_top',compact('bar_chart'));
    }


    public function Statis_Dashboard_Ban(){
        $this->AuthLogin();
        $thang = \Carbon\Carbon::now()->month(2);
        
        return view('dashboard');
    }
    public function Statis_D_Nhap(){
        $this->AuthLogin();
        
        return view('dashboard');
    }
    public function Statis_D_Reve(){
        $this->AuthLogin();
        
        return view('dashboard');
    }

}

