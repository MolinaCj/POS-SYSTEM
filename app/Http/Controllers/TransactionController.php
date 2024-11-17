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

    public function updateSalesQuantity(Request $request, $id)
    {
        $transaction = Transaction::where('transaction_id', $id)->firstOrFail();

        // Calculate the quantity difference
        $quantityDifference = $request->quantity - $transaction->quantity;
    
        // Update product stock
        $product = Product::where('id', $transaction->product_id)->firstOrFail();
        $product->stocks -= $quantityDifference;
        $product->save();
    
        // Update transaction quantity
        $transaction->quantity = $request->quantity;
        $transaction->total_price = $transaction->quantity * $transaction->unit_price;
        $transaction->save();
    
        // Return updated stock value
        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully.',
            'product_id' => $product->id,
            'new_stock' => $product->stocks,
            'new_total_price' => $transaction->total_price,
        ]);
    }
}
