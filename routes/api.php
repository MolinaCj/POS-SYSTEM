<?php

use Illuminate\Http\Request;
use illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Route::group(['middleware' => 'auth:api'], function () {
//     Route::get('/employee', function (Illuminate\Http\Request $request) {
//         return response()->json([
//             'employee_name' => $request->user()->employee_name,
//             'email' => $request->user()->email,
//             'username' => $request->user()->username,
//         ]);
//     });
// });

