<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\TransactionRequest;
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
    
         $products = Product::paginate(12);
         $transactions = Transaction::all();

        $histories = SalesHistory::all();
        $reference_no = DB::table('transactions')->latest('created_at')->value('reference_no');

         //Passing the current date in the view for receipt
         $currentDate = Carbon::now()->format('Y-m-d H:i:s');

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
        return view('products', compact('products', 'transactions', 'reference_no', 'currentDate', 'histories', 'net_amount', 'tax', 'amount_payable', 'cash_amount', 'change'));
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
        $transaction->product_id = $productId;
        $transaction->item_name = $product->item_name;
        $transaction->quantity = $request->input('quantity');
        $transaction->unit_price = $product->price;
        $transaction->total_price = $transaction->quantity * $transaction->unit_price;
        $transaction->reference_no = $referenceNo; // Use the same reference number
    
        // Save transaction
        $transaction->save();
    
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

    //ADD TO SALES HISTORY TABLE
    public function saveToSalesHistory(Request $request)
    {
        DB::beginTransaction();

        try {
            // Insert each product into the saleshistory table
            // Get the reference number from an existing transaction
            $reference_no = DB::table('transactions')->value('reference_no');

            foreach ($request->transactions as $transaction) {
                DB::table('sales_history')->insert([
                    'reference_id' => $reference_no,
                    // 'employee_name' => Auth::user()->name,
                    'item_name'  => $transaction['item_name'],
                    'quantity'   => $transaction['quantity'],
                    'unit_price' => $transaction['unit_price'],
                    'total_price'=> $transaction['total_price'],
                    'net_amount' => $request->amount_payable,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            DB::table('sales_history')->insert([
                'reference_id'   => $request->products[0]['reference_id'],
                // 'employee_name'  => Auth::user()->name,
                'net_amount'     => $request->amount_payable,
                //'tax'            => $request->amount_payable * 0.01, // Example 12% tax calculation
                // 'amount_payable' => $request->amount_payable,
                'cash_amount'    => $request->cash_amount,
                'change'         => $request->change,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now()
            ]);

            // Clear the transactions table
            DB::table('transactions')->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }









    //FOR SEARCHING A PRODUCT
     public function productsearch(Request $request){
        $firstQuery = $request->get('firstQuery');

        $products = Product::where('item_name', 'LIKE', "%$firstQuery%")->get(['id', 'item_name']);

        return response()->json($products);
     }

     public function search(Request $request)
     {
        $query = $request->get('query');
        
        $products = Product::where('item_name', 'LIKE', "%$query%")->get(['id', 'item_name']);
        
        return response()->json($products);

        // $query = $request->input('query');
        //$products = Product::query()
        //      ->where('item_name', 'LIKE', "%{$query}%")
        //      ->orWhere('barcode', 'LIKE', "%{$query}%")
        //      ->all();
 
        //  return view('products.index', compact('products'));
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

}
