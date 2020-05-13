

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
                        <h5>Sản phẩm</h5>
                                           {{--  <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
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
                                <a href="#">Quản lý sản phẩm</a>
                            </li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Thêm sản phẩm</li> --}}
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h3>Thêm sản phẩm</h3></div>
                <div class="card-body">
                    <form class="forms-sample" action="{{URL::to('/save-product')}}" method="POST" enctype="multipart/form-data" >
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="exampleInputName1">Tên sản phẩm</label>
                        <input type="text" name="pro_name" class="form-control" placeholder="Tên sản phẩm" required="" title="Vui lòng nhập tên sản phẩm">
                        {{-- @if($errors->first('pro_name'))
                            <p class="text-primary">Vui lòng điền tên sản phẩm!</p>
                        @endif --}}
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Đơn giá bán</label>
                        <input type="number" class="form-control" name="pro_price" id="exampleInputName1" min="100000" step="1000" max="5000000" required="" placeholder="Giá  tối thiểu 100,000 VND">

                        
                        {{-- @if($errors->first('pro_price'))
                            <p class="text-primary"> Vui lòng điền giá sản phẩm!</p>
                        @endif --}}
                    </div>
                    <div class="form-group">
                        <label for="exampleSelectGender">Thương hiệu</label>
                        <select class="form-control" required="" name="pro_brand" id="exampleSelectGender">
                        <option value="">Chọn thương hiệu</option>
                        @foreach($list_cate as $key => $cate)
                            <option value="{{$cate->th_ma}}">{{$cate->th_ten}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelectGender">Danh mục</label>
                        <select class="form-control" required="" name="pro_cate" id="exampleSelectGender">
                            <option value="">Chọn danh mục</option>
                            @foreach($list_brand as $key => $brand)
                                <option value="{{$brand->dm_ma}}">{{$brand->dm_ten}}</option>  
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                                                {{-- <div class="raw">
                                                    <div class="col-lg-8"></div>

                                                </div> --}}
                        <label  for="exampleInputEmail1">Hình ảnh</label>
                        {{-- THÊM+CHỈNH SỬA --}}
                        <input type="file" name="product_image[]"  class="selectImage" id="images"  multiple required="" pattern="Chọn ít nhât 1 hình và tối đa 3 hình ảnh" />
        
                    </div>
                        
                    
                    

                    <div class="form-group">
                        <label for="exampleTextarea1">Ghi chú</label>
                        <textarea required="" class="form-control" name="pro_note" id="exampleTextarea1" rows="4"></textarea>
                    </div>
                    <button type="submit" id="uploadImage" name="add_pro" class="btn btn-primary mr-2">Thêm</button>
                    <button id ="cancel" class="btn btn-light">Hủy</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    {{-- THÊM+CHỈNH SỬA --}}
<script src="http://www.codermen.com/js/jquery.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-latest.pack.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
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


        $('#sanpham').parent().addClass('active open');
         $("#themsanpham").addClass("active");
    
    $('#images').change(function(){
        var files = $(this)[0].files;
        var limit = 3;
        if(files.length > limit){
            alert("Bạn chỉ được nhập tối đa 3 hình ảnh");
            $('#images').val('');
            return false;
        }else{
            return true;
        }
    });

});
 $('#cancel').click(function(e){
            e.preventDefault();
            window.history.back();
        });
</script>

@endsection


@section('script_components')

        <script src="{{asset('public/backend/dist/js/theme.min.js')}}"></script>
        <script src="{{asset('public/backend/js/form-components.js')}}"></script>


@endsection