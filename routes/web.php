<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\General;

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

Route::get('/', function () {
    // return General::addNumbers(2, 4);
    // Test the function
    $phoneNumber1 = '0234567890';       // Valid 10-digit number
    $phoneNumber2 = '233254567890';    // Valid 12-digit number
    $phoneNumber3 = '1234567890';       // Invalid number
    $phoneNumber4 = '2332545678910';   // Invalid number

    var_dump(General::validate_phone_number($phoneNumber1));
    var_dump(General::validate_phone_number($phoneNumber2));
    var_dump(General::validate_phone_number($phoneNumber3));
    var_dump(General::validate_phone_number($phoneNumber4));
    // return view('welcome');
});
