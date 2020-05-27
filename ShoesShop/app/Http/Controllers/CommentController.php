<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;
use App\Comment;
use App\SanPham;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

session_start();

class CommentController extends Controller

{
    //Tien 21/03
     public function authLogin(){
        $admin_id = Session::get('nd_ma');
        if ($admin_id) 
            return Redirect::to('/dashboard'); 
        else 
            return Redirect::to('/admin')->send();
    }

    // Tiên 14/03
    public function postComment(Request $request, $id){

         try {
            $ratings = $request->rating;

            if($ratings == null ){
                Session::put('fail_message','Bạn chưa đánh giá sản phẩm !');
            }else{

                $data = new Comment; // cách 1 insert vào model Comment
        
                $data->noiDung = $request->content;
                $data->trangThai = 0;
                $data->sp_ma = $id;
                $data->nd_ma = Session::get('nd_ma');
                $data->ngayBinhLuan=Carbon::now()->toDateString();
                $data->danhGia= $request->rating;
                $data->save();

                Session::put('success_message','Viết bình luận thành công !');
            }
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Bạn vừa viết bình luận của sản phẩm này xong !');
        }
        return back(); 
    }   
    //Tien 21/03
    public function showComment(){

        $this->authLogin();
        $list_comments = DB::table('binhluan')->join('sanpham','sanpham.sp_ma','=','binhluan.sp_ma')->join('nguoidung','nguoidung.nd_ma','=','binhluan.nd_ma')->get();
        $manager_comment = view('admin.manage_comment')->with('list_comments', $list_comments);
        return view('admin_layout')->with('admin.manage_comment', $manager_comment);
        /*return view('admin.manage_category');*/
    }
// Tiên 08/05
    public function active_comment(Request $request){
        try {
    
            DB::table('binhluan')->where([['nd_ma', '=',$request->nd_ma],['sp_ma','=',$request->sp_ma],['ngayBinhLuan','=',$request->ngayBinhLuan]])->update(['trangThai'=>0]);
            Session::put('success_message','Hiển thị bình luận thành công !');
        
            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Hiển thị bình luận không thành công !');
        }
            // return Redirect::to('manage-comment');

    }
    // Tiên 08/05
    public function unactive_comment(Request $request){
            //$this->AuthLogin();
        try {
    
            DB::table('binhluan')->where([['nd_ma', '=',$request->nd_ma],['sp_ma','=',$request->sp_ma],['ngayBinhLuan', '=',$request->ngayBinhLuan]])->update(['trangThai'=>1]);
            Session::put('success_message','Ẩn bình luận thành công !');

            
        } catch (\Illuminate\Database\QueryException $e) {
            Session::put('fail_message','Ẩn bình luận không thành công !');
        }
        // return Redirect::to('manage-comment');

    }
}
