<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Product;
use Illuminate\Http\Request;


class TransactionControllers extends Controller
{
    public function index()
    {
    }
    
}

    // $product = Product::find($request->product_id);
    // $total = $product->price * $request->quantity;

    // Transaction::create([
    //     'product_id' => $product->id,
    //     'quantity' => $request->quantity,
    //     'unit_price' => $product->price,
    //     'total_price' => $total,
    //     'employee_id' => $request->employee_id, // Include employee_id
    // ]);

    // return response()->json(['success' => true]);

// No need to manually validate since it's handled in TransferRequest
// $transaction = new Transaction();
// $transaction->product_id = $request->product_id;
// $transaction->item_name = $request->product_name;
// $transaction->quantity = $request->quantity;
// $transaction->unit_price = $request->price;
// $transaction->save();

// return redirect()->back()->with('success', 'Product added to transaction');  