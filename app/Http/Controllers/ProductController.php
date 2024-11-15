<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\SaveReceiptRequest;
use App\Product;
use App\SalesHistory;
use App\Transaction;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ProductController extends Controller
{
    //  public function index(Request $request)
    //  {
    //      // Get the search query from the request
    //      $search = $request->input('search');
     
    //      // Fetch products based on search input, or all if no search
    //      $products = Product::when($search, function($query) use ($search) {
    //          return $query->where('item_name', 'LIKE', "%{$search}%"); // Replace 'your_column' with the actual column name
    //      })->paginate(8); // Paginate results
     
    //      return view("products")->with('products', $products);
    //  }

    //MAIN VIEW 
    public function index(Request $request)
    {
    
        // Get the search term from the request
        $search = $request->query('searchProducts');
        
        // Fetch products, with optional search filtering
        $products = Product::when($search, function ($query, $search) {
            return $query->where('item_name', 'LIKE', '%' . $search . '%')
                         ->orWhere('barcode', 'LIKE', '%' . $search . '%');
        })->paginate(12); 

        $transactions = Transaction::all();
        $reference_no = DB::table('transactions')->latest('created_at')->value('reference_no');
        //Passing the current date in the view for receipt
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        $histories = SalesHistory::all();

        // Log key variables for debugging
        // Log::info('Products:', ['products' => $products]);
        // Log::info('Transactions:', ['transactions' => $transactions]);
        // Log::info('Histories:', ['histories' => $histories->toArray()]); // Log as an array to see contents

        

         // Get the first transaction
        $firstTransaction = $histories->first();

         // Sample values for net amount, tax, etc. Adjust according to your logic
        $net_amount = $histories->sum('total_price'); // Example calculation
        $tax = $net_amount * 0.12; // Example tax calculation (12%)
        $amount_payable = $net_amount + $tax;
        // Retrieve the cash amount from the last transaction (or however you store it)
        $cash_amount = isset($firstTransaction) ? $firstTransaction->cash_amount : 0; // Assuming cash_amount is a field in your Transaction model
        $change = $cash_amount - $amount_payable;
         
        //Shows all the data in table form
        return view('products', compact(
            'products',
             'transactions',
              'reference_no', 
              'currentDate', 
              'histories', 
              'net_amount', 
              'tax', 
              'amount_payable',
               'cash_amount', 
               'change'));
    }

    //SHOWING ADD FOR FOR CREATE PRODUCT
    public function create()
    {
        //showing of add form
        return view('addform');
    }

    //STORES THE CREARED PRODUCTS
    public function store(StoreProductRequest $request)
    {
        //Proccess of adding a data to the database
        // Manually validate the incoming request
        $incoming = $request->only(['barcode', 'item_name', 'category', 'stocks', 'price']);


        //retrieve the data from the request
        $barcode = $request->input('barcode');
        $itemName = $request->input('item_name');
        $category = $request->input('category');
        $stocks = $request->input('stocks');
        $price = $request->input('price');
        

        Product::create($incoming);

        return redirect()->route('products.store')->with('products.store', 'New product added successfully');
    }

    //FOR SHOWING OF THE PRODUCTS INSIDE THE PRODUCTS TABLE
    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json(['success' => true, 'product' => $product]);
        } else {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }
    }

    //FOR THE EDIT FORM 
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('editform', compact('product'));
    }

    //UPDATES THE DATA IN THE TABLE BASED ON THE CHANGES IN EDIT FORM
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id); // Find the product by ID

        // Update the product with validated data
        $product->update([
            'barcode' => $request->input('barcode'),
            'item_name' => $request->input('item_name'),
            'category' => $request->input('category'),
            'stocks' => $request->input('stocks'),
            'price' => $request->input('price'),
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully'); // Redirect with a success message
    }

    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id); 

        // Delete the product
        $product->delete(); 

        // Redirect with a success message
        return redirect()->route('products.index')->with('success', 'Product deleted successfully'); 
    }

    //Controller for clear all
    public function clear(Request $request){
        //This will delete all the data in the products table
        Product::truncate();
            // Redirect back with an empty collection
    // return redirect()->route('products.index')->with([
    //     'success' => 'All products have been deleted!!!',
    //     'products' => collect() // Passing an empty collection
    // ]);
        return redirect()->route('products.index')->with('success', 'All products had been deleted!!!');
    }


















    //ADD TO TRANSACTION CONTROLLER
    public function addToTransac(TransactionRequest $request)
    {
        // Check if the reference number is already set in the session
        if (!session()->has('reference_no')) {
            // Generate a new reference number
            $datePart = date('ymdHi'); // Generates a 10-character string: YYMMDDHHMM
            $randomPart = mt_rand(100, 999); // Generates a 3-digit random number
            $referenceNo = $datePart . $randomPart; // Combine parts
            $referenceNo = substr($referenceNo, 0, 13); // Ensure it's 13 digits
    
            // Store the reference number in the session
            session(['reference_no' => $referenceNo]);
        } else {
            // Retrieve the reference number from the session
            $referenceNo = session('reference_no');
        }
    
        // Process the product ID from the request
        $productId = $request->input('product_id');
        $product = Product::find($productId);
    
        // Check if product exists
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
    
        // Check stock availability
        if ($product->stocks < $request->input('quantity')) {
            return redirect()->back()->with('error', 'Insufficient stock for the selected product.');
        }
    
        // Update stock and save product
        $product->stocks -= $request->input('quantity');
        $product->save();

    
        // Create transaction
        $transaction = new Transaction();
        $transaction->product_id   = $productId;
        $transaction->item_name    = $product->item_name;
        $transaction->quantity     = $request->input('quantity');
        $transaction->unit_price   = $product->price;
        $transaction->total_price  = $transaction->quantity * $transaction->unit_price;
        $transaction->reference_no = $referenceNo; // Use the same reference number
    
        // Save transaction
        $transaction->save();

        // Calculate updated totals for net amount, tax, and amount payable
        $currentNetAmount = session('net_amount', 0);
        $currentTax = session('tax', 0);
        $currentAmountPayable = session('amount_payable', 0);

        // Assuming a tax rate of 10% as an example
        $newNetAmount = $currentNetAmount + $transaction->total_price;
        $newTax = $newNetAmount * 0.01;
        $newAmountPayable = $newNetAmount + $newTax;

        session([
            'net_amount' => $newNetAmount,
            'tax' => $newTax,
            'amount_payable' => $newAmountPayable
        ]);
    
        return redirect()->back()->with('success', 'Transaction added successfully');
    }

    //FOR THE DELETION OF PRODUCTS IMPORTED TO TRANSACTION TABLE
    public function deleteTransaction($transaction_id)
        {
            // Find the transaction by ID
            $transaction = Transaction::findOrFail($transaction_id);
        
            //dd($transaction_id);
            // Delete the transaction
            $transaction->delete();
        
            // Redirect to products.index with a success message
            return redirect()->route('products.index')->with('success', 'Transaction deleted successfully'); 
            // Alternatively, if you want to return a JSON response for AJAX requests:
            // return response()->json(['success' => true]);
        }
    
    //FOR THE DELETION OF ALL PRODUCTS IMPORTED TO TRANSACTION TABLE
    public function deleteAllTransactions()
    {
        // Use the delete() method to remove all records from the transactions table
        Transaction::query()->delete();

        // Redirect back to the products view with a success message
        return redirect()->route('products.index')->with('success', 'All transactions deleted successfully!');
    }

    //ADD TRANSACTIONS TO RECEIPT
    public function getTransaction()
    {
        try {
            $transactions = Transaction::all();  // Or fetch the transactions however you need
            //dd($transactions);  // Will dump and stop further execution
            return response()->json(['transactions' => $transactions]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch transactions'], 500);
        }
    }

    //ADD TO SALES HISTORY TABLE
    public function saveReceipt(SaveReceiptRequest $request)
    {
        try {
            // Retrieve items and other data from the request
            $items = $request->input('items');
            $reference_no = $request->input('reference_no');
            $net_amount = $request->input('net_amount');
            $tax = $request->input('tax');
            $amount_payable = $request->input('amount_payable');
            $change_amount = $request->input('change_amount');
            $cash_amount = $request->input('cash_amount');
            
            foreach ($items as $item) {
                DB::table('histories')->insert([
                    'reference_no' => $reference_no,
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['total_price'],
                    'net_amount' => $net_amount,
                    'tax' => $tax,
                    'amount_payable' => $amount_payable,
                    'change_amount' => $change_amount,
                    'cash_amount' => $cash_amount,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            // Clear transactions table
            //DB::table('transactions')->truncate();
            // DB::table('transactions')->where('transaction_id', auth()->id())->delete();
            DB::table('transactions')->delete();

            // Reset reference_no in session for next transaction
            session()->forget(['reference_no', 'net_amount', 'tax', 'amount_payable']);

            return response()->json(['status' => 'success', 'message' => 'Receipt saved successfully!']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
    }

    //FOR SEARCHING A PRODUCT
    public function searchProducts(Request $request)
    {
        $search = $request->get('searchProducts');
        $productsQuery = Product::query();
    
        // Add search filtering if a search term is provided
        if ($search) {
            $productsQuery->where('item_name', 'LIKE', "%{$search}%")
                          ->orWhere('barcode', 'LIKE', "%{$search}%");
        }
    
        // Paginate the query result
        $products = $productsQuery->paginate(12);
    
        return response()->json(['products' => $products]);
        // $search = $request->get('searchProducts');
    
        // if ($search) {
        //     $products = Product::where('item_name', 'LIKE', "%$search%")
        //                         ->orWhere('barcode', 'LIKE', "%$search%")
        //                         ->get();
        // } else {
        //     $products = Product::paginate(12); // Return all products if no search term is provided
        // }
    
        // return response()->json(['products' => $products]);


        // $query = $request->input('searchProducts');
        // $products = Product::where('item_name', 'like', "%{$query}%")
        //                 ->orWhere('barcode', 'like', "%{$query}%")
        //                 ->get();
    
        // return response()->json(['products' => $products]);
    }

    //This is the function for search
     public function ssalesSearch(Request $request)
     {
        $query = $request->get('query');
        
        $products = Product::where('barcode', 'LIKE', "%$query%")->get(['id', 'barcode']);
        
        return response()->json($products);
    }

    //Function to see the details of the transaciton
    public function getTransactionDetails($referenceNo)
    {
        // Retrieve all records with the same reference number
    $transactionRecords = SalesHistory::where('reference_no', $referenceNo)->get();

    // Check if any records exist
    if ($transactionRecords->isNotEmpty()) {
        // Fetch the first record for general transaction details
        $history = $transactionRecords->first();

        // Extract product-specific details
        $products = $transactionRecords->map(function ($record) {
            return [
                'item_name' => $record->item_name,
                'quantity' => $record->quantity,
                'unit_price' => $record->unit_price,
                'total_price' => $record->total_price,
            ];
        });

        // Return the transaction details along with products as a JSON response
        return response()->json([
            'reference_no' => $history->reference_no,
            'timestamp' => $history->timestamp,
            'net_amount' => $history->net_amount,
            'tax' => $history->tax,
            'amount_payable' => $history->amount_payable,
            'cash_amount' => $history->cash_amount,
            'change_amount' => $history->change_amount,
            'employee_name' => $history->employee_name,
            'products' => $products,
        ]);
    }

    // If no history is found for the given reference number
    return response()->json(['message' => 'Transaction not found'], 404);
    }

    //METHOD FOR THE DATE FILTER OF SALES HISTORY
    // public function filterHistory(Request $request)
    // {
    //     $searchDate = $request->input('searchDate');

    //     // Filter by date if a date is selected
    //     $query = SalesHistory::query();

    //     if ($searchDate) {
    //         $query->whereDate('timestamp', $searchDate);
    //     }

    //     // Retrieve grouped history data
    //     $groupedHistories = $query->get()->groupBy('reference_no');

    //     return view('products', compact('groupedHistories'));
    // }
}
