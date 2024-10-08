<?php

use illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Product;

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
    return view('welcome');
});


//Connecting the route and controller
Route::resource('products', 'ProductController');
Route::get('products/search', 'ProductController@search')->name('products.search');

//Route::get('/product/create', 'ProductController@create')->name('products.create');

Route::get('/home', 'HomeController@index')->name('home');

// Authentication Routes
Route::get('loginform', 'Auth\AuthController@getLogin')->name('loginform');
Route::post('loginform', 'Auth\AuthController@postLogin');
// Route::get('products', 'ProductController@index')->name('products');

// Registration Routes
Route::get('regform', 'Auth\AuthController@getRegister')->name('regform');
Route::post('regform', 'Auth\AuthController@postRegister');

// Logout Route
Route::get('logout', 'Auth\AuthController@logout')->name('logout');

//Clear all route

//Search route
// Route::get('search', function () {

//     // Check for search input
//     if (request('search')) {
//         $products = Product::where('item_name', 'like', '%' . request('search') . '%')->get();
//     } else {
//         $products = Product::all();
//     }

//     return view('products')->with('products', $products);
// });



