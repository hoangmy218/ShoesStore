<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        
        <link rel="stylesheet" href="{{asset('public/backend/plugins/bootstrap/dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/backend/plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/backend/plugins/icon-kit/dist/css/iconkit.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/backend/plugins/ionicons/dist/css/ionicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/backend/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}">
        @yield('head_repeat')
        <link rel="stylesheet" href="{{asset('public/backend/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/backend/plugins/jvectormap/jquery-jvectormap.css')}}">
        <link rel="stylesheet" href="{{asset('public/backend/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/backend/plugins/weather-icons/css/weather-icons.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/backend/plugins/c3/c3.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/backend/plugins/owl.carousel/dist/assets/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/backend/plugins/owl.carousel/dist/assets/owl.theme.default.min.css')}}">
        <link rel="stylesheet" href="{{asset('public/backend/dist/css/theme.min.css')}}">
        <script src="{{asset('public/backend/src/js/vendor/modernizr-2.8.3.min.js')}}"></script>
    </head>

    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="wrapper">
            <header class="header-top" header-theme="light">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <div class="top-menu d-flex align-items-center">
                            <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                            <div class="header-search">
                                <div class="input-group">
                                    <span class="input-group-addon search-close"><i class="ik ik-x"></i></span>
                                    <input type="text" class="form-control">
                                    <span class="input-group-addon search-btn"><i class="ik ik-search"></i></span>
                                </div>
                            </div>
                           
                        </div>
                        <div class="top-menu d-flex align-items-center">

                           
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="username">
                                        <?php
                                            $name = Session::get('nd_ten');
                                            if ($name)
                                                echo $name;
                                        ?>
                                    </span>
                                    {{-- <img class="avatar" src="{{asset('public/backend/img/user.jpg')}}" alt=""> --}}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                   <!-- start Ngân (7/5/2020) -->
                                    <a class="dropdown-item logout" ><i class="ik ik-power dropdown-icon"></i>Đăng xuất</a>
                                    <!-- end Ngân (7/5/2020) -->
                                </div>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </header>

<!-- start Ngân (7/5/2020) -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">Đăng xuất</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <span>Bạn có chắc chắn muốn đăng xuất tài khoản này?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    <button type="button" id="ok_logout_btn" class="btn btn-success">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
<!-- end Ngân (7/5/2020) -->

            <div class="page-wrap">
                <div class="app-sidebar colored">
                    <div class="sidebar-header">
                        <a class="header-brand" href="#">
                            {{-- <div class="logo-img">
                               <img src="{{asset('public/backend/src/img/brand-white.svg')}}" class="header-brand-img" alt="lavalite"> 
                            </div> --}}
                            <span class="text">Admin</span>
                        </a>
                       
                      
                    </div>
                    
                    <div class="sidebar-content">
                        <div class="nav-container">
                            <nav id="main-menu-navigation" class="navigation-main">
                               
                                <div class="nav-item">
                                    <a id="dashboard" class="" href="{{URL::to('/dashboard')}}"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                                </div>
                                <div class="nav-item">
                                    <a id="donhang" href="{{URL::to('/manage-order')}}"><i class="ik ik-file-text"></i><span>Quản lý đơn hàng</span></a>
                                </div>
                                 <div class="nav-item has-sub">
                                       <a id="nguoidung" href="javascript:void(0)"><i class="ik ik-users"></i><span>Quản lý người dùng</span> <span class="badge badge-danger"></span></a>
                                       <div class="submenu-content">
                                            <a id="vohieuhoa" href="{{URL::to('/manage-customer')}}" class="menu-item">Vô hiệu hóa người dùng</a>
                                            <a id="lichsumua" href="{{URL::to('/history-customer')}}" class="menu-item">Lịch sử mua hàng của người dùng</a>
                                        </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a id="sanpham" href="javascript:void(0)"><i class="ik ik-package"></i><span>Quản lý sản phẩm</span> <span class="badge badge-danger"></span></a>
                                    <div class="submenu-content">
                                        <a id="themsanpham" href="{{URL::to('/add-product')}}" class="menu-item">Thêm sản phẩm</a>
                                        <a id="danhsachsanpham" href="{{URL::to('/manage-product')}}" class="menu-item">Danh sách sản phẩm</a>
                                        
                                    </div>
                                </div>
                                <!--  Tiên 09/05 -->
                                <div class="nav-item has-sub">
                                    <a id="mausac" href="javascript:void(0)"><i class="ik ik-speaker ik-1x"></i><span>Quản lý màu sắc</span> <span class="badge badge-danger"></span></a>
                                    <div class="submenu-content">
                                        <a id="themmausac" href="{{URL::to('/add-color')}}" class="menu-item">Thêm màu sắc</a>
                                        <a id="danhsachmausac" href="{{URL::to('/manage-color')}}" class="menu-item">Danh sách màu sắc</a>
                                        
                                    </div>
                                </div>

                                <!--  Tiên 09/05 -->
                                <div class="nav-item has-sub">
                                    <a id="mausac" href="javascript:void(0)"><i class="ik ik-chevrons-down ik-1x"></i><span>Quản lý kích cỡ</span> <span class="badge badge-danger"></span></a>
                                    <div class="submenu-content">
                                        <a id="themkichco" href="{{URL::to('/add-size')}}" class="menu-item">Thêm kích cỡ</a>
                                        <a id="danhsachkichco" href="{{URL::to('/manage-size')}}" class="menu-item">Danh sách kích cỡ</a>
                                        
                                    </div>
                                </div>

                                <div class="nav-item has-sub">
                                    <a id="thuonghieu" href="javascript:void(0)"><i class="ik ik-award"></i><span>Quản lý thương hiệu</span> <span class="badge badge-danger"></span></a>
                                    <div class="submenu-content">
                                        <a id="themthuonghieu" href="{{URL::to('/add-brand')}}" class="menu-item">Thêm thương hiệu</a>
                                        <a id="danhsachthuonghieu" href="{{URL::to('/manage-brand')}}" class="menu-item">Danh sách thương hiệu</a>
                                        
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a id="danhmuc" href="javascript:void(0)"><i class="ik ik-list"></i><span>Quản lý danh mục</span> <span class="badge badge-danger"></span></a>
                                    <div class="submenu-content">
                                        <a id="themdanhmuc" href="{{URL::to('/add-category')}}" class="menu-item">Thêm danh mục</a>
                                        <a id="danhsachdanhmuc" href="{{URL::to('/manage-category')}}" class="menu-item">Danh sách danh mục</a>
                                        
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a id="kho" href="javascript:void(0)"><i class="ik ik-home"></i><span>Quản lý kho</span> <span class="badge badge-danger"></span></a>
                                    <div class="submenu-content">
                                        <a id="nhaphang" href="{{URL::to('/add-goods-receipt')}}" class="menu-item">Nhập hàng</a>
                                        <a id="phieunhap" href="{{URL::to('/manage-goods-receipt')}}" class="menu-item">Quản lý phiếu nhập</a>
                                       
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a id="vanchuyen" href="javascript:void(0)"><i class="ik ik-truck"></i><span>Hình thức vận chuyển</span> <span class="badge badge-danger"></span></a>
                                    <div class="submenu-content">
                                        <a id="themvanchuyen" href="{{URL::to('/add-transport')}}" class="menu-item">Thêm hình thức vận chuyển</a>
                                        <a id="danhsachvanchuyen" href="{{URL::to('/manage-transport')}}" class="menu-item">Danh sách hình thức <br> vận chuyển</a>
                                       
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a id="thanhtoan" href="javascript:void(0)"><i class="ik ik-dollar-sign"></i><span>Phương thức thanh toán</span> <span class="badge badge-danger"></span></a>
                                    <div class="submenu-content">
                                        <a id="themthanhtoan" href="{{URL::to('/add-pay')}}" class="menu-item">Thêm phương thức thanh toán</a>
                                        <a id="danhsachthanhtoan" href="{{URL::to('/manage-pay')}}" class="menu-item">Danh sách phương thức <br> thanh toán</a>
                                       
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a id="thongke" href="javascript:void(0)"><i class="ik ik-bar-chart-2"></i><span>Thống kê</span> <span class="badge badge-danger"></span></a>
                                    <div class="submenu-content">
                                        <a id="theosanpham" href="{{URL::to('/statistical_order')}}" class="menu-item">Theo sản phẩm</a>
                                        <a id="theodoanhthu" href= "{{URL::to('/statistical_Revenue')}}" class="menu-item">Theo doanh thu</a>
                                       
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a id="khuyenmai" href="javascript:void(0)"><i class="ik ik-gift"></i><span>Quản lý khuyến mãi</span> <span class="badge badge-danger"></span></a>
                                    <div class="submenu-content">
                                        <a id="themkhuyenmai" href="{{URL::to('/add-coupon')}}" class="menu-item">Thêm khuyến mãi</a>
                                        <a id="danhsachkhuyenmai" href="{{URL::to('/manage-coupon')}}" class="menu-item">Danh sách khuyến mãi</a>
                                        
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a href="javascript:void(0)" id= "quangcao"><i class="ik ik-tv"></i><span>Quản lý quảng cáo</span> <span class="badge badge-danger"></span></a>
                                    <div class="submenu-content">
                                        <a id="themquangcao" href="{{URL::to('/add-advertisement')}}" class="menu-item">Thêm quảng cáo</a>
                                        <a id="danhsachquangcao" href="{{URL::to('/manage-advertisement')}}" class="menu-item">Danh sách quảng cáo</a>
                                        
                                    </div>
                                </div>
                               
                                 <div class="nav-item">
                                    <a id="binhluan" href="{{URL::to('/manage-comment')}}"><i class="ik ik-file-text"></i><span>Quản lý bình luận</span></a>
                                </div>
                                <!-- End Ngân (1/4/2020) -->
                               {{--  <div class="nav-item">
                                    <a href="{{asset('public/backend/pages/navbar.html')}}"><i class="ik ik-menu"></i><span>Navigation</span> <span class="badge badge-success">New</span></a>
                                </div>
                                <div class="nav-item has-sub">
                                    <a href="javascript:void(0)"><i class="ik ik-layers"></i><span>Widgets</span> <span class="badge badge-danger">150+</span></a>
                                    <div class="submenu-content">
                                        <a href="{{asset('public/backend/pages/widgets.html')}}" class="menu-item">Basic</a>
                                        <a href="{{asset('public/backend/pages/widget-statistic.html')}}" class="menu-item">Statistic</a>
                                        <a href="{{asset('public/backend/pages/widget-data.html')}}" class="menu-item">Data</a>
                                        <a href="{{asset('public/backend/pages/widget-chart.html')}}" class="menu-item">Chart Widget</a>
                                    </div>
                                </div>
                                <div class="nav-lavel">UI Element</div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-box"></i><span>Basic</span></a>
                                    <div class="submenu-content">
                                        <a href="{{asset('public/backend/pages/ui/alerts.html')}}" class="menu-item">Alerts</a>
                                        <a href="{{asset('public/backend/pages/ui/badges.html')}}" class="menu-item">Badges</a>
                                        <a href="{{asset('public/backend/pages/ui/buttons.html')}}" class="menu-item">Buttons</a>
                                        <a href="{{asset('public/backend/pages/ui/navigation.html')}}" class="menu-item">Navigation</a>
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-gitlab"></i><span>Advance</span> <span class="badge badge-success">New</span></a>
                                    <div class="submenu-content">
                                        <a href="{{asset('public/backend/pages/ui/modals.html')}}" class="menu-item">Modals</a>
                                        <a href="{{asset('public/backend/pages/ui/notifications.html')}}" class="menu-item">Notifications</a>
                                        <a href="{{asset('public/backend/pages/ui/carousel.html')}}" class="menu-item">Slider</a>
                                        <a href="{{asset('public/backend/pages/ui/range-slider.html')}}" class="menu-item">Range Slider</a>
                                        <a href="{{asset('public/backend/pages/ui/rating.html')}}" class="menu-item">Rating</a>
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-package"></i><span>Extra</span></a>
                                    <div class="submenu-content">
                                        <a href="{{asset('public/backend/pages/ui/session-timeout.html')}}" class="menu-item">Session Timeout</a>
                                    </div>
                                </div>
                                <div class="nav-item">
                                    <a href="{{asset('public/backend/pages/ui/icons.html')}}"><i class="ik ik-command"></i><span>Icons</span></a>
                                </div>
                                <div class="nav-lavel">Forms</div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-edit"></i><span>Forms</span></a>
                                    <div class="submenu-content">
                                        <a href="{{asset('public/backend/pages/form-components.html')}}" class="menu-item">Components</a>
                                        <a href="{{asset('public/backend/pages/form-addon.html')}}" class="menu-item">Add-On</a>
                                        <a href="{{asset('public/backend/pages/form-advance.html')}}" class="menu-item">Advance</a>
                                    </div>
                                </div>
                                <div class="nav-item">
                                    <a href="{{asset('public/backend/pages/form-picker.html')}}"><i class="ik ik-terminal"></i><span>Form Picker</span> <span class="badge badge-success">New</span></a>
                                </div>

                                <div class="nav-lavel">Tables</div>
                                <div class="nav-item">
                                    <a href="{{asset('public/backend/pages/table-bootstrap.html')}}"><i class="ik ik-credit-card"></i><span>Bootstrap Table</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="{{asset('public/backend/pages/table-datatable.html')}}"><i class="ik ik-inbox"></i><span>Data Table</span></a>
                                </div>

                                <div class="nav-lavel">Charts</div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-pie-chart"></i><span>Charts</span> <span class="badge badge-success">New</span></a>
                                    <div class="submenu-content">
                                        <a href="{{asset('public/backend/pages/charts-chartist.html')}}" class="menu-item active">Chartist</a>
                                        <a href="{{asset('public/backend/pages/charts-flot.html')}}" class="menu-item">Flot</a>
                                        <a href="{{asset('public/backend/pages/charts-knob.html')}}" class="menu-item">Knob</a>
                                        <a href="{{asset('public/backend/pages/charts-amcharts.html')}}" class="menu-item">Amcharts</a>
                                    </div>
                                </div>

                                <div class="nav-lavel">Apps</div>
                                <div class="nav-item">
                                    <a href="{{asset('public/backend/pages/calendar.html')}}"><i class="ik ik-calendar"></i><span>Calendar</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="{{asset('public/backend/pages/taskboard.html')}}"><i class="ik ik-server"></i><span>Taskboard</span></a>
                                </div>

                                <div class="nav-lavel">Pages</div>

                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-lock"></i><span>Authentication</span></a>
                                    <div class="submenu-content">
                                        <a href="{{asset('public/backend/pages/login.html')}}" class="menu-item">Login</a>
                                        <a href="{{asset('public/backend/pages/register.html')}}" class="menu-item">Register</a>
                                        <a href="{{asset('public/backend/pages/forgot-password.html')}}" class="menu-item">Forgot Password</a>
                                    </div>
                                </div>
                                <div class="nav-item has-sub">
                                    <a href="#"><i class="ik ik-file-text"></i><span>Other</span></a>
                                    <div class="submenu-content">
                                        <a href="{{asset('public/backend/pages/profile.html')}}" class="menu-item">Profile</a>
                                        <a href="{{asset('public/backend/pages/invoice.html')}}" class="menu-item">Invoice</a>
                                    </div>
                                </div>
                                <div class="nav-item">
                                    <a href="{{asset('public/backend/pages/layouts.html')}}"><i class="ik ik-layout"></i><span>Layouts</span><span class="badge badge-success">New</span></a>
                                </div>
                                <div class="nav-lavel">Other</div>
                                <div class="nav-item has-sub">
                                    <a href="javascript:void(0)"><i class="ik ik-list"></i><span>Menu Levels</span></a>
                                    <div class="submenu-content">
                                        <a href="javascript:void(0)" class="menu-item">Menu Level 2.1</a>
                                        <div class="nav-item has-sub">
                                            <a href="javascript:void(0)" class="menu-item">Menu Level 2.2</a>
                                            <div class="submenu-content">
                                                <a href="javascript:void(0)" class="menu-item">Menu Level 3.1</a>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0)" class="menu-item">Menu Level 2.3</a>
                                    </div>
                                </div>
                                <div class="nav-item">
                                    <a href="javascript:void(0)" class="disabled"><i class="ik ik-slash"></i><span>Disabled Menu</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="javascript:void(0)"><i class="ik ik-award"></i><span>Sample Page</span></a>
                                </div>
                                <div class="nav-lavel">Support</div>
                                <div class="nav-item">
                                    <a href="javascript:void(0)"><i class="ik ik-monitor"></i><span>Documentation</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="javascript:void(0)"><i class="ik ik-help-circle"></i><span>Submit Issue</span></a>
                                </div> --}}
                            </nav>
                        </div>
                    </div>
                </div>

                @yield('content')
                
            </div>
        </div>
        
        
        

        <div class="modal fade apps-modal" id="appsModal" tabindex="-1" role="dialog" aria-labelledby="appsModalLabel" aria-hidden="true" data-backdrop="false">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ik ik-x-circle"></i></button>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="quick-search">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 ml-auto mr-auto">
                                    <div class="input-wrap">
                                        <input type="text" id="quick-search" class="form-control" placeholder="Search..." />
                                        <i class="ik ik-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="container">
                            <div class="apps-wrap">
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                                </div>
                                <div class="app-item dropdown">
                                    <a href="#" class="dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-command"></i><span>Ui</span></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-mail"></i><span>Message</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-users"></i><span>Accounts</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-shopping-cart"></i><span>Sales</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-briefcase"></i><span>Purchase</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-server"></i><span>Menus</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-clipboard"></i><span>Pages</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-message-square"></i><span>Chats</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-map-pin"></i><span>Contacts</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-box"></i><span>Blocks</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-calendar"></i><span>Events</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-bell"></i><span>Notifications</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-pie-chart"></i><span>Reports</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-layers"></i><span>Tasks</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-edit"></i><span>Blogs</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-settings"></i><span>Settings</span></a>
                                </div>
                                <div class="app-item">
                                    <a href="#"><i class="ik ik-more-horizontal"></i><span>More</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
        
            
        </script>
        
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{asset('public/backend/src/js/vendor/jquery-3.3.1.min.js')}}"><\/script>')</script>
        <script src="{{asset('public/backend/plugins/popper.js/dist/umd/popper.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
        @yield('script_repeat')
        <script src="{{asset('public/backend/plugins/screenfull/dist/screenfull.js')}}"></script>
        <script src="{{asset('public/backend/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/jvectormap/jquery-jvectormap.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/jvectormap/tests/assets/jquery-jvectormap-world-mill-en.js')}}"></script>
        <script src="{{asset('public/backend/plugins/moment/moment.js')}}"></script>
        <script src="{{asset('public/backend/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/d3/dist/d3.min.js')}}"></script>
        <script src="{{asset('public/backend/plugins/c3/c3.min.js')}}"></script>
        <script src="{{asset('public/backend/js/tables.js')}}"></script>
        <script src="{{asset('public/backend/js/widgets.js')}}"></script>
        <script src="{{asset('public/backend/js/charts.js')}}"></script>
        <script src="{{asset('public/backend/dist/js/theme.min.js')}}"></script>
        
        @yield('script_components')
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
<!-- start Ngân (7/5/2020) -->
        <script>
          $(document).ready(function(){

                  $(document).on('click','.logout', function(){
                      $('#logoutModal').modal('show');

                  });

                  $('#ok_logout_btn').click(function(){
                      $.ajax({
                          url: '<?php echo url('logout');?>',
                          type: 'get',
                          success: function(data)
                          {
                              window.location.replace("<?php echo url('/admin');?>");
                          }
                      });
                  });
               });
          </script>
<!-- end Ngân (7/5/2020) -->
    </body>
</html>
