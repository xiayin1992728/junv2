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
       Route::resource('user','UsersController',['except' => ['show']]);
       Route::get('user/data','UsersController@data')->name('admin.user.data');
       Route::get('user/search','UsersController@search')->name('admin.user.search');
       Route::resource('admin','AdminsController',['except' => ['show']]);
       Route::get('admin/data','AdminsController@data')->name('admin.admin.data');
       Route::get('admin/search','AdminsController@search')->name('admin.admin.search');
   });

});

