<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\General;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/abcd', function () {
    // return General::addNumbers(2, 4);
    // Test the function
    Log::channel('sms_response')->error("\nERROR MESSAGE OCCURED");
    $phoneNumber1 = '0234567890';       // Valid 10-digit number
    $phoneNumber2 = '233254567890';    // Valid 12-digit number
    $phoneNumber3 = '1234567890';       // Invalid number
    $phoneNumber4 = '2332545678910';   // Invalid number
    var_dump(General::does_not_contain_space('helloworld'));
    var_dump(General::validate_phone_number($phoneNumber1));
    var_dump(General::validate_phone_number($phoneNumber2));
    var_dump(General::validate_phone_number($phoneNumber3));
    var_dump(General::validate_phone_number($phoneNumber4));
    // return view('welcome');
});

Route::prefix('admin')->controller(ProductController::class)->group(function(){
    Route::get('home', 'show_create');
});
