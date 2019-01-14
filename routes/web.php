<?php

Route::namespace('IndexControllers')->group(function() {

    Route::middleware(['guest:web'])->group(function() {
        Route::get('/{arg?}','PagesController@home')->where(['arg' => '[a-zA-z0-9=]{28}'])->name('index.login');
        Route::post('message','HomeController@message')->name('message');
        Route::post('user','HomeController@store')->name('home.user.store');
    });

    Route::middleware(['auth:web','checkLink'])->group(function() {
       Route::get('loan','PagesController@loan')->name('loan.index');
       Route::post('loan','LoanController@store')->name('loan.store');
       Route::get('verify','PagesController@verify')->name('verify.index');
       Route::post('verify','VerifyController@store')->name('verify.store');
       Route::get('feature','PagesController@feature')->name('feature.index');
       Route::get('continue','PagesController@continue')->name('continue.index');
       Route::get('audit','PagesController@audit')->name('audit.index');
       Route::get('second','PagesController@second')->name('second.index');
       Route::post('second','SecondController@second')->name('second.product');
       Route::get('find','PagesController@find')->name('find.index');
    });
});


Route::namespace('AdminControllers')->prefix('admin')->group(function() {

   Route::get('login','SessionsController@login')->name('admin.login');
   Route::post('login','SessionsController@store')->name('session.store');
   Route::middleware(['auth:admin'])->group(function() {
       Route::get('/','PagesController@home')->name('admin.home');
       Route::get('welcome','PagesController@welcome')->name('welcome');
       Route::delete('logout','SessionsController@logout')->name('admin.logout');
       // 前台用户
       Route::resource('user','UsersController',['except' => ['show']]);
       Route::get('user/data','UsersController@data')->name('admin.user.data');
       Route::get('user/search','UsersController@search')->name('admin.user.search');

       // 后台用户
       Route::resource('admin','AdminsController',['except' => ['show']]);
       Route::get('admin/data','AdminsController@data')->name('admin.admin.data');
       Route::get('admin/search','AdminsController@search')->name('admin.admin.search');

       // 推广员
       Route::get('salesman/{id}','SalesmansController@index')->name('admin.salesman.index');
       Route::get('salesman/{id}/data','SalesmansController@data')->name('admin.salesman.data');
       Route::get('salesman/{id}/search','SalesmansController@search')->name('admin.salesman.search');

       // 权限
       Route::resource('permissions','PermissionsController',['except' => ['show']]);
       Route::get('permissions.data','PermissionsController@data')->name('admin.permissions.data');
       // 角色
       Route::resource('roles','RolesController',['except' =>['show']]);
       Route::get('roles.data','RolesController@data')->name('admin.roles.data');

       // 产品
       Route::resource('products','ProductsController',['except' => ['show']]);
       Route::put('products/status/{products}','ProductsController@status')->name('admin.products.status');
       Route::get('products/data','ProductsController@data')->name('admin.products.data');
       Route::get('products/search','ProductsController@search')->name('admin.products.search');
       Route::post('products/logo','ProductsController@uploads')->name('admin.products.logo');

       // 产品页面
       Route::resource('productPages','ProductPagesController',['except' => ['show']]);
       Route::get('productPages/data','ProductPagesController@data')->name('admin.productPages.data');
       Route::get('productPages/search','ProductPagesController@search')->name('admin.productPages.search');
       Route::get('productPages/product','ProductPagesController@getProductPages')->name('admin.productPages.product');
       // 渠道
      /* Route::resource('channels','ChannelsController',['except' => ['show']]);
       Route::get('channels/data','ChannelsController@data')->name('admin.channels.data');
       Route::get('channels/search','ChannelsController@search')->name('admin.channels.search');*/

       // 推广
       Route::resource('spreads','SpreadsController',['except' => ['show']]);
       Route::get('spreads/data','SpreadsController@data')->name('admin.spreads.data');
       Route::get('spreads/search','SpreadsController@search')->name('admin.spreads.search');

       Route::resource('countPeoples','CountPeoplesController',['only' => ['index']]);
       Route::get('countPeoples/data','CountPeoplesController@data')->name('admin.countPeoples.data');
       Route::get('countPeoples/search','CountPeoplesController@search')->name('admin.countPeoples.search');

       // 设置
       Route::get('carousel','CarouselController@index')->name('admin.carousel.index');
       Route::post('carousel','CarouselController@store')->name('admin.carousel.store');
       Route::post('carousel/uploads','CarouselController@upload')->name('admin.carousel.upload');

   });

});

