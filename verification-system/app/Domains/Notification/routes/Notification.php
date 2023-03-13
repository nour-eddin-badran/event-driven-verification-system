<?php

use Illuminate\Support\Facades\Route;

Route::prefix('notification')->group(function () {
       Route::get('/', function(){
           return 'test';
       });
});
