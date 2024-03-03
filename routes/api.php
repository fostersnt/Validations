<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

<<<<<<< HEAD
Route::get('users', function () {
    $users = User::query()->get();
    Log::info("\nUSERS DATA ACCESSED");
    return response()->json($users);
=======

Route::get('users', function(){
    $users = User::query()->get();
    return response()->json([$users]);
>>>>>>> 6a595e14baa2fcc37f8087fe08eb3b8ada740bc5
});
