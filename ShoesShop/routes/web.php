<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//FRONTEND hoạt động phía user

Route::get('/','HomeController@index');
Route::get('/register','HomeController@get_register');
Route::post('/postregister', 'HomeController@post_register');
Route::get('/userLogin','HomeController@userLogin');
Route::post('/user_home','HomeController@AfterLogin');
Route::get('/Home_u', 'HomeController@Home_u');
Route::get('/log_out', 'HomeController@log_out');
Route::get('/status-order','HomeController@status_order');
 Route::get('/view-customerdetails/{dh_ma}','HomeController@view_customerdetails');

Route::group(['prefix'=>'User', 'middleware'=>'UserRole_Name'],function(){


});

//MY DA NGON NGU

Route::get('switchlang/{locale}', function ($locale) {

    // App::setLocale($locale);
 	Session::put('website_language', $locale);
    return redirect()->back();


});

//Comment   Tien 21/03
Route::post('comment/{id}','CommentController@postComment');//Tiên 13/03

Route::get('/manage-comment','CommentController@showComment'); 
Route::get('/unactive-comment/{nd_ma}/{sp_ma}/{ngayBinhLuan}', 'CommentController@unactive_comment');// Tiên 08/05
Route::get('/active-comment/{nd_ma}/{sp_ma}/{ngayBinhLuan}', 'CommentController@active_comment');// Tiên 08/05

Route::get('/getSlt','ProductController@getSlt');//Tiên 07/05

//Tien 09/05 MauSac
Route::get('/add-color','ColorController@addColor');

Route::post('/save-color','ColorController@saveColor');

Route::get('/manage-color','ColorController@showColor');

Route::get('/edit-color/{ms_ma}','ColorController@edit_Color');

Route::post('/update-color/{ms_ma}','ColorController@update_Color');

Route::get('/delete-color/{ms_ma}','ColorController@delete_Color');

//Tien 09/05  KichCo
Route::get('/add-size','SizeController@addSize');

Route::post('/save-size','SizeController@saveSize');

Route::get('/manage-size','SizeController@showSize');

Route::get('/edit-size/{kc_ma}','SizeController@edit_Size');

Route::post('/update-size/{kc_ma}','SizeController@update_Size');

Route::get('/delete-size/{kc_ma}','SizeController@delete_Size');



//LAN
Route::get('/info-customer', 'HomeController@info_customer');
Route::get('/chinhsua-thongtin', 'HomeController@chinhsua_thongtin');
Route::post('/capnhat-thongtin', 'HomeController@capnhat_thongtin');
Route::post('capnhat-thongtin/{capnhat_nd_ma}','HomeController@capnhat_thongtin');

//Product
Route::get('/product-detail/{product_id}','ProductController@details_product');//Tiên



Route::get('/all-product','ProductController@all_product');//Tiên

Route::post('/tim-kiem','HomeController@search');// Tiên 15/03

//MY - select Size Stock
Route::get('/index','StockController@index');
/*Route::get('/getStock/{id}','StockController@getStock');*/
Route::get('/getStock','StockController@getStock');
Route::get('/getSlt','StockController@getSlt');
Route::post('/getAmount','StockController@getAmount');


//MY PAYPAL
// Route::post('paypal','PaymentController@payWithPayPal');
// Route::get('status','PaymentController@getPaymentStatus');
Route::get('/thankyou','PaymentController@thankyou');
//13/3/2020
Route::post('/create-payment','PaymentController@create')->name('create-payment');
Route::get('/execute-payment','PaymentController@execute');
Route::get('/orderplace','PaymentController@orderPlace');

/*BACKEND hoat dong phia server*/

Route::get('/admin','AdminController@index');
Route::get('/dashboard', 'AdminController@show_dashboard');
Route::get('/logout', 'AdminController@logout');
Route::post('/admin_dashboard', 'AdminController@dashboard');
Route::get('/chitiet-sanpham/{ct_id}','AdminController@chitiet_sanpham');

Route::group(['prefix'=>'Admin', 'middleware'=>'AdminRole_Name'],function()   {
	
});


//Lan QL nguoi dung
Route::get('/manage-customer','AdminController@manage_customer');
Route::get('/unactive-customer/{controll_nd_ma}', 'AdminController@unactive_customer');
Route::get('/active-customer/{controll_nd_ma}', 'AdminController@active_customer');
Route::get('/history-customer', 'AdminController@history_customer');
Route::get('/view-history/{controll_nd_ma}', 'AdminController@view_history');
Route::get('/xoa-sanpham/{ct_id}','AdminController@xoa_sanpham');
Route::get('/delete-image-product/{ha_id}', 'AdminController@delete_image_product');


//Cart
Route::get('/show-cart','CartController@showCart');
Route::get('/delete-to-cart/{rowId}','CartController@delete_to_cart');//Tien
Route::post('/update-cart-quantity','CartController@update_cart_quantity');//Tien
Route::get('/update-qty/{id}','CartController@update_qty');//My
Route::post('/save-cart','CartController@save_cart');//Tien

Route::get('/removeCart','CartController@removeCart'); //my



//Checkout
Route::get('/checkout','CheckoutController@checkout');
Route::post('/save-checkout-customer', 'CheckoutController@save_checkout_customer');
Route::get('/payment','CheckoutController@payment');
Route::post('/order-place','CheckoutController@orderPlace');
Route::get('/handcash','CheckoutController@handcash'); //M
// Route::get('/paypal','CheckoutController@paypal'); //M


//Lan Showcheckout
Route::get('get-list-transport','CheckoutController@get_list_transport');
Route::get('get-price','CheckoutController@get_price');


//Order M
Route::get('/manage-order','OrderController@showOrder');
Route::get('/view-order/{dh_ma}','OrderController@viewOrder');
Route::get('/order-pdf/{dh_ma}','OrderController@orderPdf');
Route::get('/approve-order/{dh_ma}','OrderController@approveOrder');
Route::get('/ship-order/{dh_ma}','OrderController@shipOrder');
Route::get('/complete-order/{dh_ma}','OrderController@completeOrder');
Route::get('/cancel-order/{dh_ma}','OrderController@cancelOrder');


//Cus cancel Order M
Route::get('/cus-cancel-order/{dh_ma}','OrderController@cusCancelOrder');

//PDF
Route::get('/createOrderPdf/{dh_ma}','PdfController@createOrderPdf');

//Brand
Route::get('/manage-brand','BrandController@showBrand');
Route::get('/add-brand','BrandController@addBrand');
Route::post('/save-brand','BrandController@saveBrand');

	//Tien
Route::get('/edit-brand-product/{brand_product_id}','BrandController@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}','BrandController@delete_brand_product');
Route::post('/update-brand-product/{brand_product_id}','BrandController@update_brand_product');


//Category
Route::get('/manage-category','CategoryController@showCategory');
Route::get('/add-category','CategoryController@addCategory');
Route::post('/save-category','CategoryController@saveCategory');

	//NGAN

Route::get('/edit-category/{category_id}','CategoryController@editCategory');
Route::get('/delete-category/{category_id}','CategoryController@deleteCategory');

Route::post('/update-category/{category_id}','CategoryController@updateCategory');


//Product
Route::get('/manage-product','ProductController@showProduct');
Route::get('/add-product','ProductController@addProduct');
Route::post('/save-product','ProductController@saveProduct');

//Lan
Route::get('/chinhsua-sanpham/{chinhsua_sp_ma}','ProductController@chinhsua_sanpham');
Route::post('/capnhat-sanpham/{chinhsua_sp_ma}','ProductController@capnhat_sanpham');

//MY - SUPPLIER
Route::get('/add-supplier', 'SupplierController@addSupplier');
Route::post('/save-supplier','SupplierController@saveSupplier');
Route::get('/manage-suppliers','SupplierController@showSuppliers');
Route::get('/delete-supplier/{ncc_ma}','SupplierController@deleteSupplier');
Route::get('/edit-supplier/{ncc_ma}','SupplierController@editSupplier');
Route::post('/update-supplier/{ncc_ma}','SupplierController@updateSupplier');


//Goods-Receipt My
Route::get('/add-goods-receipt','ProductController@addGoodsReceipt');
Route::post('/save-goods-receipt','ProductController@saveGoodsReceipt');
Route::post('/save-price-receipt','ProductController@savePriceReceipt');
/*Route::get('/addPriceReceipt/{$masp[]}/{$pn_id}','ProductControlle@addPriceReceipt');*/
Route::get('/manage-goods-receipt','ProductController@showGoodsReceipt');
Route::get('/view-receipt/{pn_ma}','ProductController@viewReceiptDetails');
Route::get('/delete-receipt/{pn_ma}','ProductController@deleteReceipt');
Route::get('/getDateReceipt','ProductController@getDateReceipt');
Route::post('/save-edit-receipt/{pn_ma}','ProductController@saveEditReceipt');

Route::get('/update-Price','ProductController@updateSumPrice');

Route::get('/delete-goods/{ctsp_ma}','ProductController@deleteGoods');
Route::get('/getDetailGoods','ProductController@getDetailGoods');
Route::post('/save-edit-goods/{pn_ma}','ProductController@saveEditGoods');

//Phuong thuc thanh toan
Route::get('/manage-pay','PayController@manage_pay');
Route::get('/add-pay','PayController@add_pay');
Route::post('/save-pay','PayController@save_pay');
Route::get('/edit-pay/{edit_id}','PayController@edit_pay');
Route::post('/update-pay/{update_id}','PayController@update_pay');
Route::get('/delete-pay/{delete_id}','PayController@delete_pay');

//transport hình thức vận chuyển
Route::get('/manage-transport','TransportController@manage_transport');
Route::get('/add-transport','TransportController@add_transport');
Route::post('/save-transport','TransportController@save_transport');
Route::get('/edit-transport/{edit_id}','TransportController@edit_transport');
Route::post('/update-transport/{update_id}','TransportController@update_transport');
Route::get('/delete-transport/{delete_id}','TransportController@delete_transport');

// Khuyến mãi (Ngân 14/3/2020)
Route::get('/checkCoupon','CheckoutController@checkCoupon'); 
Route::get('/manage-coupon','CouponController@showCoupon');
Route::get('/add-coupon','CouponController@addCoupon');
Route::post('/save-coupon','CouponController@saveCoupon');
Route::get('/edit-coupon/{Coupon_id}','CouponController@editCoupon');
Route::get('/delete-coupon/{Coupon_id}','CouponController@deleteCoupon');
Route::post('/update-coupon/{Coupon_id}','CouponController@updateCoupon');

// Quảng cáo (Ngân 14/3/2020)
Route::get('/manage-advertisement','AdvertisementController@showAdvertisement');
Route::get('/add-advertisement','AdvertisementController@addAdvertisement');
Route::post('/save-advertisement','AdvertisementController@saveAdvertisement');
Route::get('/edit-advertisement/{advertisement_id}','AdvertisementController@editAdvertisement');
Route::get('/delete-advertisement/{advertisement_id}','AdvertisementController@deleteAdvertisement');
Route::post('/update-advertisement/{advertisement_id}','AdvertisementController@updateAdvertisement');


// (Ngân 14/4/2020)
Route::get('/active-advertisement/{advertisement_id}', 'AdvertisementController@activeAdvertisement');
Route::get('/unactive-advertisement/{advertisement_id}', 'AdvertisementController@unactiveAdvertisement');

// Khuyến mãi (Ngân 14/3/2020)
Route::get('/checkCoupon','CheckoutController@checkCoupon'); 
Route::get('/manage-coupon','CouponController@showCoupon');
Route::get('/add-coupon','CouponController@addCoupon');
Route::post('/save-coupon','CouponController@saveCoupon');
Route::get('/edit-coupon/{Coupon_id}','CouponController@editCoupon');
Route::get('/delete-coupon/{Coupon_id}','CouponController@deleteCoupon');
Route::post('/update-coupon/{Coupon_id}','CouponController@updateCoupon');


// Thống kê (Ngân 22/3/2020)
Route::get('/statistical_order','StatisticalController@showStatistical_order')->name('chart','showStatistical_order');
Route::get('/statistical_Revenue','StatisticalController@showStatistical_Revenue')->name('chart','showStatistical_Revenue');