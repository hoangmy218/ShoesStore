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
                            <h5>Chỉnh sửa thông tin sản phẩm</h5>
                                           {{--  <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
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
                                <a href="{{URL::to('/manage-product')}}">Quản lý sản phẩm</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa thông tin sản phẩm</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <?php
                            $message = Session::get('fail_message');
                            if ($message){
                                echo '<span class="alert alert-danger">'.$message."</span>";
                                
                                Session::put('fail_message',null);
                            }
                            $message = Session::get('success_message');
                            if ($message){
                                echo '<span class="alert alert-success">'.$message."</span>";
                                
                                Session::put('success_message',null);
                            }
                        ?>
        <div class="card">
            <div class="card-header"><h3>Chỉnh sửa thông tin sản phẩm</h3></div>
                <div class="card-body">
                    @foreach($edit_pro as $key => $pro)
                        <form class="forms-sample" action="{{URL::to('/capnhat-sanpham/'.$pro->sp_ma)}}" method="POST" enctype="multipart/form-data" >
                        {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputName1">Tên sản phẩm</label>
                                <input type="text" name="pro_name" class="form-control" id="exampleInputName1" value="{{$pro->sp_ten}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Đơn giá bán</label>
                                <input type="number" class="form-control" name="pro_price" id="exampleInputName1" min="100000" step="1000" max="5000000" value="{{$pro->sp_donGiaBan}}">
                                
                            </div>
                            {{-- <div class="form-group">
                                <label for="exampleInputName1">Đơn giá nhập</label>
                                <input type="number" class="form-control" name="pro_pricegor" id="exampleInputName1" min="100000" step="1000" max="5000000" value="{{$pro->sp_donGiaNhap}}">
                                
                            </div> --}}
                            <div class="form-group">
                                <label for="exampleSelectGender">Thương hiệu</label>
                                <select class="form-control" name="pro_brand" id="exampleSelectGender">
                                @foreach($list_brand as $key => $brand)
                                @if($brand->th_ma==$pro->th_ma)
                                    <option selected value="{{$brand->th_ma}}">{{$brand->th_ten}}</option>
                                @else
                                    <option value="{{$brand->th_ma}}">{{$brand->th_ten}}</option>
                                @endif                                            
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleSelectGender">Danh mục</label>
                                <select class="form-control" name="pro_cate" id="exampleSelectGender">
                                @foreach($list_cate as $key => $cate)
                                @if($cate->dm_ma==$pro->dm_ma)
                                <option selected value="{{$cate->dm_ma}}">{{$cate->dm_ten}}</option>
                                @else
                                <option value="{{$cate->dm_ma}}">{{$cate->dm_ten}}</option>
                                @endif 
                                @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleSelectGender">Khuyến mãi</label>
                                <select class="form-control" required="" name="pro_km" id="exampleSelectGender">
                                    @foreach($list_km as $key => $km)
                                @if($km->km_ma==$pro->km_ma)
                                <option selected value="{{$km->km_ma}}">{{$km->km_chuDe}}</option>
                                @else
                                <option value="{{$km->km_ma}}">{{$km->km_chuDe}}</option>
                                @endif 
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh</label>
                                <input type="file" name="product_image[]"  class="selectImage" id="images" max_file_uploads="3" multiple /> 

                            </div>
                            {{-- THÊM+CHỈNH SỬA --}}
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Hình ảnh</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php $i=1; ?>
                            @foreach($hinh_anh as $key => $image)
                                <tr>

                                    <th scope="row">{{$i}}</th>
                                    
                                    <td><img src="{{URL::to('public/upload/product/'.$image->ha_ten)}}"height="100" width="100"></td>
                                    <td>
                                        <a id="xoa"><i class="ik ik-trash-2 cancel text-red" id="{{$image->ha_ma}}"></i></a>

                                        {{-- <a id="xoa" onclick="return confirm('Bạn chắc chắn muốn xóa ảnh này?')" href="{{URL::to('delete-image-product/'.$image->ha_ma)}}"><i class="ik ik-trash-2"></i></a> --}}
                                       
                                    </td>        
                                </tr>
                                
                                <?php $i++; 
                                
                                 ?>
                                
                            @endforeach 
                            {{-- THÊM+CHỈNH SỬA --}}
                            <input type="hidden" name="soluong" id="soluong" value="{{$i-1}}">
                            </tbody>
                            
                        </table>
                            <div class="form-group">
                                <label for="exampleTextarea1">Mô tả</label>
                                <textarea class="form-control" name="pro_moTa" id="exampleTextarea1" rows="4">{{$pro->sp_moTa}}</textarea>
                                </div>
                                <button type="submit" id="capnhat" name="add_pro" class="btn btn-primary mr-2">Cập nhật</button>
                                <button type="button"  class="btn btn-light cancelhuy">Hủy</button>
                     </form>
                 @endforeach
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Xóa hình ảnh</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn xóa hình ảnh này?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>

                                <button type="button" id="ok_xoaanh_btn" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- lan 13/05/2020 --}}
    <div class="modal fade" id="cancelHuy" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Hủy chỉnh sửa sản phẩm</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Bạn có chắc chắn muốn hủy chỉnh sửa?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="button" id="xacnhan" class="btn btn-success">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- lan 26/05/2020 --}}
    <div class="modal fade" id="cancelImage1" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Thông báo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Phải có ít nhất 1 hình ảnh cho sản phẩm này!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Đã hiểu</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="cancelImage2" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Thông báo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                             Vui lòng chọn tối đa 3 ảnh!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Đã hiểu</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="cancelImage3" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="demoModalLabel">Thông báo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                            Vui lòng chọn ảnh đúng định dạng (jpg, jpeg, png)!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Đã hiểu</button>
                                
                            </div>
                        </div>
                    </div>
                </div>
{{-- THÊM+CHỈNH SỬA --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

$(document).ready(function(){
    $('#images').change(function(){
        var soluong = $('#soluong').val();
        var files = $(this)[0].files;
        var limit = 3-parseInt(soluong);
        console.log(soluong);
        if(files.length > limit){
            $('#cancelImage2').modal('show');
            // alert("Bạn chỉ được nhập tối đa 3 hình ảnh");
            $('#images').val('');
            return false;
        }else{
            return true;
        }
    });
    setTimeout(function(){
           $("span.alert").remove();
        }, 5000 ); // 5 secs
     });
$(document).on('click','.cancel', function(){
            ha_ma = $(this).attr('id');
            $('#cancelModal').modal('show');
        });
$('#ok_xoaanh_btn').click(function(){
            $.ajax({
                url: '<?php echo url('delete-image-product');?>/'+ha_ma,
                type: 'get',
                success: function(data)
                {
                    window.location.replace("<?php redirect()->back();?>");
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
            $('#cancelImage1').modal('show');
            // alert("Phải có ít nhất 1 hình ảnh cho sản phẩm này");
            return false;
        }else{
            return true;
        }
    });
    
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){


        $('#sanpham').parent().addClass('active open');
         $("#danhsachsanpham").addClass("active");

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
                    $('#cancelImage3').modal('show');
                    // alert("Vui lòng nhập hình đúng định dạng (jpg, jpeg, png).")
                    $('#images').val('');
                    return false; 
                }
    });

    setTimeout(function(){
           $("span.alert").remove();
        }, 5000 );
$(document).on('click','.cancelhuy', function(){
            $('#cancelHuy').modal('show');
        });
$('#xacnhan').click(function(e){
    e.preventDefault();
     window.location.replace("<?php echo url('/manage-product');?>");
        });
});





</script>               
@endsection


@section('script_components')

        <script src="{{asset('public/backend/dist/js/theme.min.js')}}"></script>
        <script src="{{asset('public/backend/js/form-components.js')}}"></script>


@endsection