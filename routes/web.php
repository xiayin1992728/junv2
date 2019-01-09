<?php

Route::namespace('IndexControllers')->group(function() {
    Route::get('/','PagesController@home')->name('index.login');
    Route::post('message','HomeController@message')->name('message');
    Route::post('user','HomeController@store')->name('user.store');

    Route::middleware(['auth:web'])->group(function() {
       Route::get('loan','PagesController@loan')->name('loan.index');
       Route::post('loan','LoanController@store')->name('loan.store');
       Route::get('verify','PagesController@verify')->name('verify.index');
       Route::post('verify','VerifyController@store')->name('verify.store');
       Route::get('feature','PagesController@feature')->name('feature.index');
       Route::get('continue','PagesController@continue')->name('continue.index');
       Route::get('second','PagesController@second')->name('second.index');
       Route::post('second','SecondController@second')->name('second.product');
    });
});


Route::namespace('AdminControllers')->prefix('admin')->group(function() {

   Route::get('login','SessionsController@login')->name('admin.login');
   Route::post('login','SessionsController@store')->name('session.store');
   Route::middleware(['auth:admin'])->group(function() {
       Route::get('/','PagesController@home')->name('admin.home');
       Route::get('welcome','PagesController@welcome')->name('welcome');

       // 前台用户
       Route::resource('user','UsersController',['except' => ['show']]);
       Route::get('user/data','UsersController@data')->name('admin.user.data');
       Route::get('user/search','UsersController@search')->name('admin.user.search');

       // 后台用户
       Route::resource('admin','AdminsController',['except' => ['show']]);
       Route::get('admin/data','AdminsController@data')->name('admin.admin.data');
       Route::get('admin/search','AdminsController@search')->name('admin.admin.search');

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
       Route::get('productPages.data','ProductPagesController@data')->name('admin.productPages.data');
       Route::get('productPages/search','ProductPagesController@search')->name('admin.productPages.search');

   });

});

