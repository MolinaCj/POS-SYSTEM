<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Product;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
    public function index()
    {
        //
    }

    public function addToTransaction(Request $request){
       // Retrieve the product
    $product = Product::find($request->product_id);
    $quantity = $request->quantity;
    
    if (!$product) {
        return response()->json(['success' => false, 'message' => 'Product not found.']);
    }
    
    // Calculate total price
    $total = $product->price * $request->quantity;

    // Create a new transaction
    Transaction::create([
        'product_id' => $product->id,
        'item_name' => $product->item_name,
        'quantity' => $request->quantity,
        'unit_price' => $product->price,
        'total_price' => $total,
        'employee_id' => $request->employee_id,
    ]);

    // Update the product stock after the transaction
    $product->stocks -= $quantity;  // Deduct the quantity from stock
    $product->save();  // Save the updated product

    return response()->json(['success' => true]);
    }
}
