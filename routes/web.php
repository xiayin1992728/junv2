<?php

Route::namespace('IndexControllers')->group(function() {
    Route::get('/','PagesController@home');
});


Route::namespace('AdminControllers')->prefix('admin')->group(function() {
   Route::get('/','PagesController@home');
});

