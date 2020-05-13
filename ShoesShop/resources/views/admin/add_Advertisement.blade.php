

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
                                <a href="{{URL::to('/manage-category')}}">Quản lý quảng cáo</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Thêm quảng cáo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h3>Thêm quảng cáo</h3></div>
                <div class="card-body">
                    <form class="forms-sample" action="{{URL::to('/save-advertisement')}}" method="POST" enctype="multipart/form-data" >
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="exampleInputName1">Chủ đề quảng cáo</label>
                        <input type="text" name="ad_topic" class="form-control" placeholder="Tên chủ đề" required="" title="Vui lòng nhập tên chủ đề">
                        {{-- @if($errors->first('ad_topic'))
                            <p class="text-primary">Vui lòng điền tên chủ đề!</p>
                        @endif --}}
                    </div>
                    <!--S Ngân (14/4/2020) -->
                    <div class="form-group">
                        <label for="exampleInputName1">Giới thiệu</label>
                        <textarea type="areatext" name="ad_DoanQC" class="form-control" placeholder="Đoạn giới thiệu" required="" title="Vui lòng nhập đoạn giới thiệu"></textarea>
                    </div>
                    <!--E Ngân (14/4/2020) -->
                    <div class="form-group">
                                                {{-- <div class="raw">
                                                    <div class="col-lg-8"></div>

                                                </div> --}}
                        <label  for="exampleInputEmail1">Hình ảnh</label>
                        <input type="file" name="ad_image"  class="selectImage" id="images"  required="" pattern="Chọn 1 hình ảnh cho quảng cáo" />
        
                    </div>

                    <button type="submit" id="uploadImage" name="add_ad" class="btn btn-primary mr-2">Thêm</button>
                    <button id="cancel" class="btn btn-light">Hủy</button>
                </form>
                </div>
            </div>
        </div>
    </div>
<script src="http://www.codermen.com/js/jquery.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-latest.pack.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#cancel').click(function(e){
        e.preventDefault();
        window.history.back();
    });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('#images').change(function(){
        var fileName = document.getElementById('images').files.length;
        console.log(fileName);
        for (var index = 0; index < fileName; index++) {
            var checkImage=document.getElementById('images').files[index].name;
            var ext = checkImage.substring(checkImage.lastIndexOf('.') + 1).toLowerCase();
            console.log(ext);
            if (ext=="gif"|| ext == "png" || ext == "PNG" || ext == "jpg" || ext == "jpeg")
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

        $( '#quangcao').parent().addClass('active open');
         $("#themquangcao").addClass("active");

    $('#images').change(function(){
        var files = $(this)[0].files;
        var limit = 1;
        if(files.length > limit){
            alert("Bạn chỉ được nhập tối đa 1 hình ảnh");
            $('#images').val('');
            return false;
        }else{
            return true;
        }
    });

});
</script>

@endsection


@section('script_components')

        <script src="{{asset('public/backend/dist/js/theme.min.js')}}"></script>
        <script src="{{asset('public/backend/js/form-components.js')}}"></script>


@endsection