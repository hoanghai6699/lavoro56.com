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

Route::group(['prefix'=>'dashboard','middleware'=>'checkAdmin'],function(){
	Route::get('/','AdminController@index')->name('admin');
	

	Route::group(['prefix'=>'category'],function(){
		Route::get('/','AdminCategoryController@list')->name('admin.get.list.category');
		Route::get('/add','AdminCategoryController@add')->name('admin.get.add.category');
		Route::post('/add','AdminCategoryController@create');
		Route::get('/edit/{id}','AdminCategoryController@edit')->name('admin.get.edit.category');
		Route::post('/edit/{id}','AdminCategoryController@update');
		Route::get('/delete/{id}','AdminCategoryController@delete')->name('admin.get.delete.category');
		Route::get('/action/{id}','AdminCategoryController@action')->name('admin.get.action.category');
	});
	Route::group(['prefix'=>'product'],function(){
		Route::get('/','AdminProductController@list')->name('admin.get.list.product');
		Route::get('/add','AdminProductController@add')->name('admin.get.add.product');
		Route::post('/add','AdminProductController@create');
		Route::get('/edit/{id}','AdminProductController@edit')->name('admin.get.edit.product');
		Route::post('/edit/{id}','AdminProductController@update');
		Route::get('/option/{id}','AdminProductController@option')->name('admin.get.option.product');
		Route::post('/option/{id}','AdminProductController@update_option');
		Route::get('/delete/{id}','AdminProductController@delete')->name('admin.get.delete.product');
		Route::get('/action/{id}','AdminProductController@action')->name('admin.get.action.product');
		Route::get('/action1/{id}','AdminProductController@action1')->name('admin.get.action1.product');
		Route::get('/delete-img/{id}','AdminProductController@delete_img')->name('admin.delete-img.product');
		Route::get('export', 'AdminProductController@export')->name('export');
		Route::get('importExportView', 'AdminProductController@importExportView')->name('importExportView');
		Route::post('import', 'AdminProductController@import')->name('import');
	});
	
	Route::group(['prefix'=>'article'],function(){
		Route::get('/','AdminArticleController@list')->name('admin.get.list.article');
		Route::get('/add','AdminArticleController@add')->name('admin.get.add.article');
		Route::post('/add','AdminArticleController@create');
		Route::get('/edit/{id}','AdminArticleController@edit')->name('admin.get.edit.article');
		Route::post('/edit/{id}','AdminArticleController@update');
		Route::get('/delete/{id}','AdminArticleController@delete')->name('admin.get.delete.article');
		Route::get('/action/{id}','AdminArticleController@action')->name('admin.get.action.article');
		Route::get('/action1/{id}','AdminArticleController@action1')->name('admin.get.action1.article');
	});
	Route::group(['prefix'=>'user'],function(){
		Route::get('/','AdminUserController@list')->name('admin.get.list.user');
		Route::get('/add','AdminUserController@add')->name('admin.get.add.user');
		Route::post('/add','AdminUserController@create');
		Route::get('/edit/{id}','AdminUserController@edit')->name('admin.get.edit.user');
		Route::post('/edit/{id}','AdminUserController@update');
		Route::get('/delete/{id}','AdminUserController@delete')->name('admin.get.delete.user');
		Route::get('/action/{id}','AdminUserController@action')->name('admin.get.action.user');
		Route::get('/action1/{id}','AdminUserController@action1')->name('admin.get.action1.user');
	});
	Route::group(['prefix'=>'order'],function(){
		Route::get('/','AdminOrderController@list')->name('admin.get.list.order');
		Route::get('/chua-xu-ly','AdminOrderController@chuaxuly')->name('admin.get.list.chua-xu-ly');
		Route::get('/dang-giao-hang','AdminOrderController@danggiaohang')->name('admin.get.list.dang-giao-hang');
		Route::get('/view/{id}','AdminOrderController@view')->name('admin.get.view.order');
		Route::post('/view/{id}','AdminOrderController@post_view');
		Route::get('/delete/{id}','AdminOrderController@delete')->name('admin.get.delete.order');
	});

	Route::get('/warehouse','AdminWarehouseController@list')->name('admin.get.list.warehouse');
	
	Route::post('ajax-edit-quantity','AdminProductController@postAjaxEditQuantity')->name('ajax.edit.quantity');
	//Route::post('ajax-add-coupon','AdminCouponController@postAjaxAddCoupon')->name('ajax.add.coupon');
	Route::group(['prefix'=>'report'],function(){
		Route::get('/','AdminController@report')->name('report');
		Route::post('/fetch_data','AdminController@fetch_data')->name('fetch_data');
		Route::get('/export','AdminController@export')->name('export');
	});

	Route::group(['middleware'=>'checkSupper'],function(){
		//Route::get('/report','AdminController@report')->name('admin.report');
		Route::group(['prefix'=>'sale'],function(){
			Route::get('/','AdminSaleController@list')->name('admin.get.list.sale');
			Route::get('/add','AdminSaleController@add')->name('admin.get.add.sale');
			Route::post('/add','AdminSaleController@create');
			Route::get('/edit/{id}','AdminSaleController@edit')->name('admin.get.edit.sale');
			Route::post('/edit/{id}','AdminSaleController@update');
			Route::get('/delete/{id}','AdminSaleController@delete')->name('admin.get.delete.sale');
		});

		Route::group(['prefix'=>'coupon'],function(){
			Route::get('/','AdminCouponController@list')->name('admin.get.list.coupon');
			Route::get('/add','AdminCouponController@add')->name('admin.get.add.coupon');
			Route::post('/add','AdminCouponController@create');
			Route::get('/delete/{id}','AdminCouponController@delete')->name('admin.get.delete.coupon');
		});

		Route::group(['prefix'=>'slide'],function(){
			Route::get('/','AdminSlideController@list')->name('admin.get.list.slide');
			Route::get('/add','AdminSlideController@add')->name('admin.get.add.slide');
			Route::post('/add','AdminSlideController@create');
			Route::get('/edit/{id}','AdminSlideController@edit')->name('admin.get.edit.slide');
			Route::post('/edit/{id}','AdminSlideController@update');
			Route::get('/delete/{id}','AdminSlideController@delete')->name('admin.get.delete.slide');
			Route::get('/action/{id}','AdminSlideController@action')->name('admin.get.action.slide');
		});
	});
	
});
Route::group(['middleware' => 'loginAdmin'],function(){
	Route::get('admin/login','AdminController@login')->name('login');
	Route::post('admin/login','AdminController@post_login');
});
Route::get('admin/logout','AdminController@logout')->name('logout');

Route::group(['middleware' => 'locale'], function() {
	Route::get('change-language/{language}','FrontendController@changeLanguage')->name('change-language');
	Route::get('/','FrontendController@home')->name('frontend.get.home');
	Route::group(['middleware' => 'login'],function(){
		Route::get('/login','FrontendController@home_login')->name('home.login');
		Route::post('/login','FrontendController@post_home_login');
	});
	Route::get('/register','FrontendController@register')->name('register');
	Route::post('/register','FrontendController@post_register');
	Route::get('/logout','FrontendController@home_logout')->name('home.logout');
	Route::get('/san-pham','FrontendController@sanpham')->name('frontend.get.sanpham');
	Route::get('/loai-san-pham/{id}/{tenloai}','FrontendController@loaisanpham')->name('frontend.get.loaisanpham');
	Route::get('chi-tiet-san-pham/{id}/{tenloai}','FrontendController@chitietsanpham')->name('frontend.get.chitietsanpham');
	Route::post('chi-tiet-san-pham/{id}/{tenloai}','FrontendController@postchitietsanpham');
	Route::post('/coupon','ShoppingCartController@store')->name('coupon.store');
	Route::delete('/coupon','ShoppingCartController@destroy')->name('coupon.destroy');
	Route::post('mua-hang','ShoppingCartController@ajaxMuaHang')->name('shoppingcart.ajax.muahang');
	Route::get('xoa-hang/{id}','ShoppingCartController@xoahang')->name('shoppingcart.get.xoahang');
	Route::get('gio-hang','ShoppingCartController@giohang')->name('shoppingcart.get.giohang');
	Route::get('xoa-gio-hang','ShoppingCartController@xoagiohang')->name('shoppingcart.get.xoagiohang');

	Route::get('cap-nhat','ShoppingCartController@capnhat')->name('capnhat');
	Route::group(['prefix'=>'gio-hang','middleware'=>'checkLogin'],function(){
		Route::group(['prefix'=>'thanh-toan-nhan-hang'],function(){
			Route::get('/','ShoppingCartController@thanhtoannhanhang')->name('thanh-toan-nhan-hang');
			Route::post('/','ShoppingCartController@luuthanhtoan');
			Route::get('getDistrict','FrontendController@getDistrict')->name('getDistrict');
		});
		Route::get('thanh-toan-nhan-hang','ShoppingCartController@thanhtoannhanhang')->name('thanh-toan-nhan-hang');
		Route::get('thanh-toan-atm','ShoppingCartController@thanhtoanatm')->name('thanh-toan-atm');
		Route::post('thanh-toan-nhan-hang','ShoppingCartController@luuthanhtoan');
		//vnpay
		Route::group(['prefix'=>'thanh-toan-atm'],function(){
			Route::get('/vnpay','VnpayController@vnpay')->name('vnpay');
			Route::post('/vnpay','VnpayController@create_vnpay')->name('create-vnpay');
			Route::get('/vnpay-ipn','VnpayController@vnpay_ipn')->name('vnpay-ipn');
			Route::get('/vnpay-return','VnpayController@vnpay_return')->name('vnpay-return');
		});
	});
	Route::get('complete','ShoppingCartController@complete')->name('complete');

	Route::get('/tin-tuc','FrontendController@tintuc')->name('tin-tuc');
	Route::get('/tin-tuc/{id}/{slug}','FrontendController@chitiettintuc')->name('chi-tiet-tin-tuc');
	Route::get('/lien-he','FrontendController@lienhe')->name('lien-he');
	Route::post('/lien-he','FrontendController@post_lienhe');
	Route::get('/gioi-thieu','FrontendController@gioithieu')->name('gioi-thieu');
	Route::group(['prefix'=>'don-hang'],function(){
		Route::get('/','FrontendController@donhang')->name('don-hang');
		Route::get('/chi-tiet/{id}','FrontendController@chitiet')->name('chi-tiet');
	});
	Route::get('/thay-doi-mat-khau','FrontendController@thaydoimatkhau')->name('thay-doi-mat-khau');
	Route::post('/thay-doi-mat-khau','FrontendController@post_thaydoimatkhau');
});