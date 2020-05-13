<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

session_start();

class AdvertisementController extends Controller
{
    public function authLogin(){
        $admin_id = Session::get('nd_ma');
        if ($admin_id) 
            return Redirect::to('/dashboard'); 
        else 
            return Redirect::to('/admin')->send();
    }


    public function showAdvertisement(){
        $this->authLogin();
        $list_Advertisement = DB::table('quangcao')->orderby('qc_ma','desc')->get();
        // $manager_Advertisement = view('admin.manage_Advertisement')->with('list_ad', $list_Advertisement);
        return view('admin.manage_Advertisement')->with('list_ad',$list_Advertisement);
    }

    public function addAdvertisement(){
        $this->authLogin();
        return view('admin.add_Advertisement');
        
    }

    public function saveAdvertisement(Request $request){
        $data = array();
        $data['qc_chuDe'] = $request->ad_topic;
        // S Ngân(14/4/2020)
        $data['qc_trangThai'] = 1;
        $data['qc_quangCao'] = $request->ad_DoanQC;
        // E Ngân(14/4/2020)
       
        if($request->hasFile('ad_image')) {
            $photo = $request->ad_image;
            $get_image = $photo->getClientOriginalName();
            $destinationPath = public_path('upload/advertisement');
            $photo->move($destinationPath, $get_image);
            $data['qc_hinhAnh']=$get_image;
        }
        DB::table('quangcao')->insert($data);
                Session::put('message','Thêm quảng cáo thành công!');
                return Redirect::to('/manage-advertisement');
    }

    public function editAdvertisement($advertisement_id){
        $this->authLogin();    
        $edit_ad=DB::table('quangcao')->where('qc_ma',$advertisement_id)->get();
        return view('admin.edit_Advertisement')->with('edit_ad', $edit_ad);
    }

    public function updateAdvertisement(Request $request, $advertisement_id){
        $data= array();
        $data['qc_chuDe']=$request->ad_topic;
        // S Ngân(14/4/2020)
       
        $data['qc_quangCao'] = $request->ad_DoanQC;
        // E Ngân(14/4/2020)

        if($request->hasFile('ad_image')) {
            $photo = $request->ad_image;
            $get_image = $photo->getClientOriginalName();
            $destinationPath = public_path('upload/advertisement');
            $photo->move($destinationPath, $get_image);
            $data['qc_hinhAnh']=$get_image;

            DB::table('quangcao')->where('qc_ma', $advertisement_id)->update($data);
            Session::put('message','Cập nhật quảng cáo thành công!');
                return Redirect::to('/manage-advertisement');
        }else{
            DB::table('quangcao')->where('qc_ma', $advertisement_id)->update($data);
            Session::put('message','Cập nhật quảng cáo thành công!');
        return Redirect::to('/manage-advertisement');
        }
    }

     public function deleteAdvertisement($advertisement_id){
        DB::table('quangcao')->where('qc_ma',$advertisement_id)->delete();
        Session::put('message','Xóa quảng cáo thành công');
        return Redirect::to('/manage-advertisement');
    }

    // Start Ngân (14/4/2020)

    public function activeAdvertisement($advertisement_id){
            DB::table('quangcao')->where('qc_ma', $advertisement_id)->update(['qc_trangThai'=>0]);
            Session::put('message', 'Đăng quảng cáo thành công.');
            return Redirect::to('/manage-advertisement');
        }
    public function unactiveAdvertisement($advertisement_id){
            //$this->AuthLogin();
          DB::table('quangcao')->where('qc_ma', $advertisement_id)->update(['qc_trangThai'=>1]);
            Session::put('message', 'Gỡ quảng cáo thành công');
            return Redirect::to('/manage-advertisement');
        }
    // End Ngân (14/4/2020)


}
