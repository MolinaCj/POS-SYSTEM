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

        // Check if the requested quantity exceeds available stock
        if ($quantity > $product->stocks) {
            return response()->json([
                'success' => false,
                'message' => 'Quantity exceeds available stock. Only ' . $product->stocks . ' units available.'
            ]);
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

        // Calculate updated totals
        $transactions = Transaction::all();
        $netAmount = $transactions->sum('total_price');
        $tax = $netAmount * 0.01; // Example 12% tax
        $amountPayable = $netAmount + $tax;

        // Save these values to session (if needed)
        session([
            'net_amount' => $netAmount,
            'tax' => $tax,
            'amount_payable' => $amountPayable,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully.',
            'net_amount' => $netAmount,
            'tax' => $tax,
            'amount_payable' => $amountPayable,
        ]);

    // return response()->json(['success' => true]);
    }

    //METHOD TO READ THE CHANGE IN QUANTITY ON SALES
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

        // Calculate new net amount, tax, and amount payable
        $netAmount = Transaction::sum('total_price');
        $tax = $netAmount * 0.01;
        $amountPayable = $netAmount + $tax;

        session([
            'net_amount' => $netAmount,
            'tax' => $tax,
            'amount_payable' => $amountPayable,
        ]);
        
    
        // Return updated stock value
        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully.',
            'product_id' => $product->id,
            'new_stock' => $product->stocks,
            'new_total_price' => $transaction->total_price,
            'net_amount' => $netAmount,
            'tax' => $tax,
            'amount_payable' => $amountPayable,
        ]);
    }
}
