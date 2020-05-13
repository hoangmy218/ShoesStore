
@extends('admin_layout')
@section('content')

<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5>Quảng cáo</h5>
                            <?php
                                $message =Session::get('message');
                                if($message){
                                    echo '<span class="text-alert">'.$message.'</span>';
                                              Session::put('message', null);
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{URL::to('/dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{URL::to('/manage-advertisement')}}">Quản lý quảng cáo</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa thông tin quảng cáo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h3>Chỉnh sửa thông tin quảng cáo</h3></div>
                <div class="card-body">
                    @foreach($edit_ad as $key => $ad)
                        <form class="forms-sample" action="{{URL::to('/update-advertisement/'.$ad->qc_ma)}}" method="POST" enctype="multipart/form-data" >
                        {{csrf_field()}}
                        <div class="form-group">
                                <label for="exampleInputName1">Mã quảng cáo</label>
                                <input type="text" class="form-control" id="exampleInputName1" value="{{$ad->qc_ma}}" disabled="disabled">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Chủ đề quảng cáo</label>
                                <input type="text" name="ad_topic" class="form-control" id="exampleInputName1" value="{{$ad->qc_chuDe}}">
                            </div>
                            <!-- S Ngân (14/4/2020) -->
                            <div class="form-group">
                                <label for="exampleInputName1">Đoạn giới thiệu</label>
                                <input type="text" name="ad_DoanQC" class="form-control" id="exampleInputName1" value="{{$ad->qc_quangCao}}">
                            </div>
                           <!-- E Ngân (14/4/2020) -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh</label> <br>

                                <img src="{{URL::to('public/upload/advertisement/'.$ad->qc_hinhAnh)}}"height="100" width="200">

                            &nbsp
                                <input type="file" name="ad_image"  class="selectImage" id="images" max_file_uploads="1" multiple /> 

                            </div>
                            
                           
                                <button type="submit" id="capnhat" name="update_ad" class="btn btn-primary mr-2">Cập nhật</button>
                                
                                <button type="reset" class="btn btn-light">Hủy</button>
                     </form>

                 @endforeach
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

$(document).ready(function(){
    $('#images').change(function(){
        var soluong = $('#soluong').val();
        var files = $(this)[0].files;
        var limit = 1;
        console.log(soluong);
        if(files.length > limit){
            alert("Bạn chỉ cung cấp 1 hình ảnh");
            $('#images').val('');
            return false;
        }else{
            return true;
        }
    });

});
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-latest.pack.js"></script>
<script>
$(document).ready(function(){
    $('#xoa').click(function(){
        var soluong = $('#soluong').val();
        var x = parseInt(soluong);
        console.log(soluong);
        if(x==1){
            alert("Phải có 1 hình ảnh cho quảng cáo này");
            return false;
        }else{
            return true;
        }
    });
    
});
</script>
<script type="text/javascript">
$(document).ready(function(){

        $('#quangcao').parent().addClass('active open');
         $("#danhsachquangcao").addClass("active");

    $('#images').change(function(){
        var fileName = document.getElementById('images').files.length;
        console.log(fileName);
        for (var index = 0; index < fileName; index++) {
            var checkImage=document.getElementById('images').files[index].name;
            var ext = checkImage.substring(checkImage.lastIndexOf('.') + 1).toLowerCase();
            console.log(ext);
            if (ext=="gif"|| ext == "png" || ext == "jpg" || ext == "jpeg")
                {
                    return true;
                }
                else
                    alert("Vui lòng nhập hình đúng định dạng (jpg, jpeg, png).")
                    $('#images').val('');
                    return false; 
                }
    });
});
</script>               
@endsection


@section('script_components')

        <script src="{{asset('public/backend/dist/js/theme.min.js')}}"></script>
        <script src="{{asset('public/backend/js/form-components.js')}}"></script>


@endsection