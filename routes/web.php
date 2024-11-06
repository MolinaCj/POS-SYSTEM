<?php

use illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Product;


Route::get('/', function () {
    return view('welcome');
});


//Connecting the route and controller
Route::resource('products', 'ProductController');

Route::get('/home', 'HomeController@index')->name('home');

// Authentication Routes
Route::get('loginform', 'Auth\AuthController@getLogin')->name('loginform');
Route::post('loginform', 'Auth\AuthController@postLogin');

// Registration Routes
Route::get('regform', 'Auth\AuthController@getRegister')->name('regform');
Route::post('regform', 'Auth\AuthController@postRegister');

// Logout Route
Route::get('logout', 'Auth\AuthController@logout')->name('logout');

//Clear all route
Route::post('/products/clear', 'ProductController@clear')->name('products.clear');


//Search route for the list of products
// Route::get('/search-products', 'ProductController@productsearch');

//Adding and Search Route
// Route::get('/search-transactions', 'ProductController@search');
// Route::post('/add-to-transaction', 'TransactionController@add');

//Clear all the dara in my transaction table
Route::delete('transactions/delete-all', 'ProductController@deleteAllTransactions')->name('transactions.deleteAll');

// routes/web.php
Route::get('/products/{id}', 'ProductController@show');

//Route for importing the products to sales/transaction table
Route::post('/add-to-transac', 'ProductController@addToTransac')->name('addToTransac');

//Route for deleting a product inserted to my transaction table
Route::delete('transactions/{transaction_id}', 'ProductController@deleteTransaction')->name('transactions.destroy');

//Route to insert the transation to my receipt modal
Route::get('/api/getTransaction', 'ProductController@getTransaction')->name('getTransaction');
//Route for saving the sales to sales history








///////////////////////////////////////////////////////////////////////////////////////////

//Add to transaction route
// Route::post('/transactions', 'TransactionController@transfer')->name('transactions.store');





























// Route::get('search', 'ProductController@search')->name('products.search');
// Route::get('search', function () {

//     // Check for search input
//     if (request('search')) {
//         $products = Product::where('item_name', 'like', '%' . request('search') . '%')->get();
//     } else {
//         $products = Product::all();
//     }

//     return view('products')->with('products', $products);
// });



