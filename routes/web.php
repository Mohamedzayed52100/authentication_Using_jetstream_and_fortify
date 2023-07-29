<?php

use App\Events\NewEvent;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



Route::get('update'  , function(){

    DB::beginTransaction();


    User::where('id' , 1)->update([
        'password'=>Hash::make('123456789'),
    ]);

    $user=User::find(1);
    // if(!$user)DB::rollBack();
    $user->name ='ahmed muhammed';
    $user->save();





    DB::commit();


});


Route::get('/NewEvent' , function(){
    NewEvent::dispatch();
});

Route::get('/http' , function(){
    return Http::get('http://example.com/');
});


Route::get('/log' , function(){
    return Log::error('this is message');
});