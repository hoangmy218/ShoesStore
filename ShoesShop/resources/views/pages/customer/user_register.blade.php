@extends('shop_layout')
@section('content')

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-10 ftco-animate">
             <div class="col-md-12">
            <div class="container"><h3 class="mb-4 billing-heading" style="text-align: center; font-size: 35px;">{{ __('Đăng ký tài khoản') }}</h3> <!-- Ngân (6/3/2020), sửa tiếng việt và thêm khúc if -> endif -->
                @if(count($errors)>0)
                    <div class="alert alert-danger">
                        <strong>{{ __('Lỗi') }}</strong><br>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                  <!-- start  Ngân (11/4/2020) -->
                 <p style="color: red;"><b><?php
                $message=Session::get('message');
                 if($message){
                   echo $message; 
                  Session::put('message',null);
               }
            ?></b></p>
            <!-- end  Ngân (11/4/2020) -->
                 <form action="{{URL::to('postregister')}}" method="post" name="formRegister">
                                {{csrf_field()}} <!-- Ngân (6/3/2020) bỏ onsubmit cũ ở trong thẻ form -->
                                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

                                
                            <!-- <p>Join us today! It takes only few steps</p> 
                                Ngân (6/3/2020) -> bỏ dòng này -->
            <div class="row">
                <div class="col-md-6">
                     <div class="form-group"> <!-- Ngân (6/3/2020) -> chỗ placeholder sửa thành tiếng việt -->
                                    <input type="text" name="user_name" class="form-control" placeholder="{{ __('Họ và tên') }}" required="">
                                    <i class="ik ik-user"></i>
                                </div>
                                <div class="form-group">
                                    <input type="date" name='user_birth' class="form-control" placeholder="{{ __('Ngày sinh') }}"  required="">
                                    <i class="ik ik-user"></i>
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" name="user_phone" class="form-control" placeholder="{{ __('SĐT') }}" required="">
                                    <i class="ik ik-user"></i>
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="rdGioitinh" value="Male" checked> {{ __('Nam') }}&emsp;&emsp;&emsp;
                                    <input type="radio" name="rdGioitinh" value="Female"> {{ __('Nữ') }}<br>
                                </div>
                                 <div class="form-group">
                                    <textarea name="user_address"  class="form-control" rows="3" cols="20" placeholder="{{ __('Địa chỉ') }}" required=""></textarea>                
                                </div>
                </div>
                <div class="col-md-6">
                     <!-- <div style="background-color: red;">Cột thứ 2 tỉ lệ 2</div> -->

                                <div class="form-group">
                                    <input type="text" name="user_email" class="form-control" placeholder="{{ __('Email') }}" required="">
                                    <i class="ik ik-user"></i>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="user_password" class="form-control" placeholder="{{ __('Mật khẩu') }}" required="">
                                    <i class="ik ik-lock"></i>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="user_confirm_pass" class="form-control" placeholder="{{ __('Nhập lại mật khẩu') }}" required="">
                                    <i class="ik ik-eye-off"></i>
                                </div>
                               
                                {{-- <div class="row">
                                    <div class="col-12 text-left">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="item_checkbox" name="item_checkbox" value="option1">
                                            <span class="custom-control-label">&nbsp;I Accept <a href="#">Terms and Conditions</a></span>
                                        </label>
                                    </div>
                                </div> --}}
                                 
                                <div class="sign-btn text-center">
                                    <button type="submit" class="btn btn-theme btn-primary py-3 px-4">{{ __('Tạo tài khoản') }}</button> <!-- Ngân(6/3/2020) đổi tiếng việt tên nút-->
                                </div>
                            </form> <br> <!-- Ngân(6/3/2020) thêm <br>-->
                            <div class="register">
                                <p style="text-align: center;">{{ __('Bạn đã có tài khoản?')}}<a href="{{URL::to('/userLogin')}}" style="color: red;"> {{ __('Đăng nhập') }}</a></p> <!-- Ngân(6/3/2020) đổi tiếng việt -->
                            </div>
                        </div>


          </div> <!-- .col-md-8 -->
        </div>
      </div>
    </section> <!-- .section -->
@endsection