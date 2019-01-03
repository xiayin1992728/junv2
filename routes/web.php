<?php

Route::namespace('IndexControllers')->group(function() {
    Route::get('/','PagesController@home');
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
   Route::get('/','PagesController@home');
});

