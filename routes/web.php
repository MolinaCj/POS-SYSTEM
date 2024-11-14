<?php

use illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\AuthController;
use App\Product;

use App\Http\Controllers\CustomAuthController;


Route::get('/', function () {
    return view('loginform');
});

Route::get('/products', function () {
    return view('loginform');
})->middleware('auth');

Auth::user(); // This will return the authenticated user

//Connecting the route and controller
Route::resource('products', 'ProductController');

Route::get('/home', 'HomeController@index')->name('home');

//Clear all route
Route::post('/products/clear', 'ProductController@clear')->name('products.clear');


//Search route for the list of products
Route::get('/search-products', 'ProductController@searchProducts')->name('search.products');

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
Route::post('/saveReceipt', 'ProductController@saveReceipt')->name('saveReceipt');

//ROUTE FOR RETRIEVING THE SALES HISTORY IN THE HISTORIES TABLE
Route::get('/transaction-history', 'ProductController@getTransactionHistory')->name('transaction.history');







///////////////////////////////////////////////////////////////////////////////////////////
//Showing login form
Route::get('/loginForm', 'Auth\AuthController@showLoginForm')->name('loginForm');

//Processing the login
Route::post('/login','Auth\AuthController@login')->name('login');

//SHowing the registration form
Route::get('/regForm', 'Auth\AuthController@showRegistrationForm')->name('regForm');

//Route for processing the registration
Route::post('/register', 'Auth\AuthController@register')->name('register');

//Route for logout
Route::post('/logout', 'Auth\AuthController@logout')->name('logout');

//SEE TRANSACTION DETAILS ROUTE
Route::get('/get-transaction-details/{referenceNo}', 'ProductController@getTransactionDetails');


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



