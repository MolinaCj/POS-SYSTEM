<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;


class TransactionController extends Controller
{
    public function index()
    {
        //
    }

    public function addToTransaction(Request $request){

        // Check if the reference number is already set in the session
        if (!session()->has('reference_no')) {
            // Initialize the reference number with a starting value (e.g., 1000000)
            $startingValue = 10;

            // Retrieve the last reference number from the session, or use the starting value
            $lastReferenceNo = session('last_reference_no', $startingValue);
        
            // Increment the reference number by 1
            $referenceNo = $lastReferenceNo + 1;
        
            // Ensure the reference number is padded to 13 digits, e.g., 000000010001
            $referenceNo = str_pad($referenceNo, 13, '0', STR_PAD_LEFT);
        
            // Store the new reference number in the session
            session(['reference_no' => $referenceNo]);
        
            // Also store the updated last reference number for future increments
            session(['last_reference_no' => $referenceNo]);
        } else {
            // Retrieve the reference number from the session
            $referenceNo = session('reference_no');
        }

        // // Check if the reference number is already set in the session
        // if (!session()->has('reference_no')) {
        //     // If not, generate a new reference number
        //     $datePart = date('ymdHi'); // Generates a 10-character string: YYMMDDHHMM
        //     $randomPart = mt_rand(100, 999); // Generates a 3-digit random number
        //     $referenceNo = $datePart . $randomPart; // Combine parts
        //     $referenceNo = substr($referenceNo, 0, 13); // Ensure it's 13 digits

        //     // Store the reference number in the session
        //     session(['reference_no' => $referenceNo]);
        // } else {
        //     // Retrieve the reference number from the session
        //     $referenceNo = session('reference_no');
        // }

       // Retrieve the product
        $product = Product::find($request->product_id);
        $quantity = $request->quantity;
        // $transactions = $request->employee_name;
        
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
            'employee_name' => $request->employee_name,
            'reference_no' => $referenceNo, // Use the same reference number
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
