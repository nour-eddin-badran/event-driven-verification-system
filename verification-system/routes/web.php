<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Junges\Kafka\Facades\Kafka;

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

Route::get('/', function () {


//    $url = 'nour';
//
//    $params = http_build_query([
//        'token' => 1234
//    ]);
//
//    dd(sprintf('%s?%s', $url, $params));



//    dd(config('services.gotify.host'));
//    dd(config('services.gotify.app_token'));
//    $res = Http::post('http://gotify/message?token=A7QYN3Er_Fb-BUx', [
//        'message' => 'code',
//        'title' => 'Verification code'
//    ]);
//
//    dd($res->status());
    return view('welcome');
});

Route::get('/test-kafka', function () {

//    dd();
    $test = Kafka::publishOn('nour-published-topic')
//        ->withConfigOptions()
        ->withKafkaKey(\Str::uuid()->toString())
        ->withBodyKey('test', ['test'])
        ->withHeaders(['custom' => 'header'])
        ->withDebugEnabled()
        ->send();




    echo 'done!';
});
