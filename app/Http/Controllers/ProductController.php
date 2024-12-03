<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\SaveReceiptRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateTaxRateRequest;
use App\Http\Requests\AddStockRequest;
use App\Product;
use App\SalesHistory;
use App\Transaction;
use App\User;
use App\Category;
use App\Tax;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ProductController extends Controller
{
    // Constructor to apply middleware
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Exclude login routes to avoid redirect loop
            if (!session()->has('cashier_id') && !in_array($request->route()->getName(), ['loginForm', 'login'])) {
                return redirect()->route('loginForm')->with('error', 'You must log in first.');
            }
    
            return $next($request);
        });
    }
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
        // // Get the search term from the request
        $search = $request->query('searchProducts');
        
        // Fetch products, with optional search filtering
        $products = Product::when($search, function ($query, $search) {
            return $query->where('item_name', 'LIKE', '%' . $search . '%')
                         ->orWhere('barcode', 'LIKE', '%' . $search . '%');
        })->paginate(20); 

        $transactions = Transaction::all();
        $reference_no = DB::table('transactions')->latest('created_at')->value('reference_no');
        //Passing the current date in the view for receipt
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');

        $histories = SalesHistory::all();
        $categories = Category::all();

        // Fetch the tax rate from the database
        // $taxRate = Tax::first()->tax_rate;  // Assuming it's stored in the 'rate' column of the 'tax' table
        $currentTaxRate = Tax::first()->tax_rate;

         // Get the first transaction
        $firstTransaction = $histories->first();

         // Sample values for net amount, tax, etc. Adjust according to your logic
        $net_amount = $histories->sum('total_price'); // Example calculation
        $tax = $net_amount * .01; // Example tax calculation (12%)
        $amount_payable = $net_amount + $tax;
        // Retrieve the cash amount from the last transaction (or however you store it)
        $cash_amount = isset($firstTransaction) ? $firstTransaction->cash_amount : 0; // Assuming cash_amount is a field in your Transaction model
        $change = $cash_amount - $amount_payable;

        // Fetch totals
        $totalCashiers = User::count(); // Assuming your cashiers are stored in the users table
        $totalProducts = Product::count();
        $totalTransactionsToday = SalesHistory::whereDate('created_at', Carbon::today())->count();
        $totalAmountSoldToday = SalesHistory::whereDate('created_at', Carbon::today())->sum('total_price');
        $totalTransactionsThisMonth = SalesHistory::whereMonth('created_at', Carbon::now()->month)->count();
        $totalAmountSoldThisMonth = SalesHistory::whereMonth('created_at', Carbon::now()->month)->sum('total_price');
        $overallTotalTransactions = SalesHistory::count();
        $overallTotalAmountSold = SalesHistory::sum('total_price');

         
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
               'change',
               'categories',
               'taxRate',
               'currentTaxRate',
               'totalCashiers',
                'totalProducts',
                'totalTransactionsToday',
                'totalAmountSoldToday',
                'totalTransactionsThisMonth',
                'totalAmountSoldThisMonth',
                'overallTotalTransactions',
                'overallTotalAmountSold'))->with('user', auth()->user());
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
        // Extract and validate the request data
        $incoming = $request->only(['barcode', 'item_name', 'category', 'stocks', 'price']);

        // Save the product to the database
        Product::create($incoming);

        // Redirect to the products index page with a success message
        return redirect()->route('products.index')->with('success', 'New product added successfully!');
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
        $product = Product::findOrFail($id);

        $product->update([
            'barcode' => $request->input('barcode'),
            'item_name' => $request->input('item_name'),
            'category' => $request->input('category'), // Match the database column
            'stocks' => $request->input('stocks'),
            'price' => $request->input('price'),
        ]);
    
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        // Check if the product exists in any transactions
        $existsInTransactions = DB::table('transactions')->where('product_id', $id)->exists();
        
        if ($existsInTransactions) {
            // Pass an error message to the session
            return redirect()->route('products.index')->with('deleteError', 'Cannot delete product. It is part of an active transaction.');
        }
    
        // Find the product by ID
        $product = Product::findOrFail($id);
    
        // Delete the product
        $product->delete();
    
        // Pass a success message to the session
        return redirect()->route('products.index')->with('deleteSuccess', 'Product deleted successfully.');
        // // Find the product by ID
        // $product = Product::findOrFail($id); 

        // // Delete the product
        // $product->delete(); 

        // // Redirect with a success message
        // return redirect()->route('products.index')->with('success', 'Product deleted successfully'); 
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
            // Retrieve the last transaction's reference number from the database
            $lastReferenceNo = SalesHistory::latest('id')->value('reference_no');
        
            if ($lastReferenceNo) {
                // Increment the last reference number
                $referenceNo = intval($lastReferenceNo) + 1;
            } else {
                // If no previous reference number exists, start with a default value
                $referenceNo = 1000000000001; // Example: Starting point
            }
        
            // Ensure the reference number is always 13 digits
            $referenceNo = str_pad($referenceNo, 13, '0', STR_PAD_LEFT);
        
            // Store the reference number in the session
            session(['reference_no' => $referenceNo]);
        } else {
            // Retrieve the reference number from the session
            $referenceNo = session('reference_no');
        }
        // //Check if the reference number is already set in the session
        // if (!session()->has('reference_no')) {
        //     // Generate a new reference number
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

        // Retrieve cashier details from the session
        $cashierId = session('cashier_id');
        $cashierName = session('cashier_name');

        if (!$cashierId || !$cashierName) {
            return redirect()->back()->with('error', 'Cashier details are missing. Please log in again.');
        }

        // Create transaction
        $transaction = new Transaction();
        $transaction->product_id   = $productId;
        $transaction->item_name    = $product->item_name;
        $transaction->quantity     = $request->input('quantity');
        $transaction->unit_price   = $product->price;
        $transaction->total_price  = $transaction->quantity * $transaction->unit_price;
        $transaction->reference_no = $referenceNo; // Use the same reference number
        $transaction->cashier_id   = $cashierId;
        $transaction->cashier_name = $cashierName; // Save cashier details to the transaction
    
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

            // Find the corresponding product in the products table
            $product = Product::findOrFail($transaction->product_id);

            // Restore the quantity from the transaction to the product's stock
            $product->stocks += $transaction->quantity;
            $product->save();

            // Delete the transaction
            $transaction->delete();

            // Recalculate the net amount, tax, and amount payable
            $transactions = Transaction::all();
            $net_amount = $transactions->sum(function ($transaction) {
                return $transaction->unit_price * $transaction->quantity;
            });
            $tax = 0.01 * $net_amount;
            $amount_payable = $net_amount + $tax;

            // Update session values
            session([
                'net_amount' => $net_amount,
                'tax' => $tax,
                'amount_payable' => $amount_payable,
            ]);

           // Return JSON response
            return response()->json([
                'success' => true,
                'net_amount' => $net_amount,
                'tax' => $tax,
                'amount_payable' => $amount_payable
            ]);
        }
    
    //FOR THE DELETION OF ALL PRODUCTS IMPORTED TO TRANSACTION TABLE
    public function deleteAllTransactions()
    {
        // Retrieve all transactions
        $transactions = Transaction::all();

        // Loop through each transaction to restore the product stock
        foreach ($transactions as $transaction) {
            $product = Product::find($transaction->product_id);

            if ($product) {
                // Restore the quantity to the product stock
                $product->stocks += $transaction->quantity;
                $product->save();
            }
        }

        // Delete all transactions
        Transaction::query()->delete();

        // Clear session values
        session([
            'net_amount' => 0,
            'tax' => 0,
            'amount_payable' => 0,
        ]);

       // Return a JSON response with success status
        return response()->json([
            'success' => true
        ]);
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
            $discount = $request->input('discount');
            
            $cashierName = session('cashier_name');

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
                    'discount' => $discount,
                    'cashier_name' => $cashierName,
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
    }

    public function filterByCategory(Request $request)
    {
        Log::info('filterByCategory method triggered');
    
        $category = $request->input('category');
        Log::info('Selected category:', ['category' => $category]);

        // Fetch products based on the category
        $products = Product::where('category', $category)->get();
        
        // Check if products were found
        if ($products->isEmpty()) {
            Log::info('No products found for category:', ['category' => $category]);
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ]);
        }

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }

    //This is the function for search
    public function searchSales(Request $request)
    {
        $query = $request->get('query');
        
        $products = Product::where('barcode', 'LIKE', "%$query%")->get(['id', 'item_name']);
        
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
            'discount' => $history->discount,
            'amount_payable' => $history->amount_payable,
            'cash_amount' => $history->cash_amount,
            'change_amount' => $history->change_amount,
            'cashier_name' => $history->cashier_name,
            'products' => $products,
        ]);
    }

    // If no history is found for the given reference number
    return response()->json(['message' => 'Transaction not found'], 404);
    }





    //LOGIN AND REGISTRATION METHOD

    //FOW SHOWING THE LOG IN FORM
    public function showLoginForm()
    {
        return view('loginform'); // Ensure you have a view for this form
    }

    //FOR PROCESSING THE LOG IN
    public function login(LoginRequest $request)
    {
        // Retrieve the user by username
        $user = \App\User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            // If user not found or password is incorrect, redirect back with an error
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ])->withInput($request->except('password'));
        }

        // Log in the user by setting session data
        session([
            'cashier_id' => $user->cashier_id,
            'username' => $user->username,
            'cashier_name' => $user->cashier_name,
        ]);
        Log::info(session()->all());

        // Redirect to the desired route
        return redirect()->route('products.index')->with('success', 'Logged in successfully!');
    }

    //FOR SHOWING THE REGISTRATION FORM
    public function showRegistrationForm()
    {
        return view('regform'); // Ensure you have a view for this form
    }

    //PROCESS THE REGISTRATION
    public function register(RegisterRequest $request)
    {
        // Create a new user
        $user = User::create([
            'cashier_name' => $request->cashier_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Log the user in
        auth()->login($user);

        // Redirect to a desired route
        return redirect()->route('loginForm')->with('success', 'Registration successful!');
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        session()->flush();

        // Redirect to the login page after logout
        return redirect()->route('loginForm');
    }


    //NAVIGATING TO SALES PER DAY AND SALES PER CASHIER
    //showing the sales per day view
    public function salesPerDay(){

        return view ('salesperday');

    }

    //showing the sales per cashier view
    public function cashierSales(){

        return view ('cashiersales');
        
    }

    //SALES GROUP BY DAY
    public function salesGroupPerDay()
    {
        // Get all sales histories ordered by created_at in descending order (latest first)
        $histories = SalesHistory::orderBy('created_at', 'desc')->get();
        
        // Return the view with the ordered histories
        return view('salesperday', compact('histories'));
        // $histories = SalesHistory::all();
    
        // // Return grouped by day
        // return view('salesperday', compact('histories'));
    }

    //POPULATING THE TRANSACTION DETAILS IN SALES PER DAY
    public function retrieveTransactionDetails($referenceNo)
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
                'cashier_name' => $history->cashier_name,
                'products' => $products,
            ]);
        }
    
        // If no history is found for the given reference number
        return response()->json(['message' => 'Transaction not found'], 404);
    }

    public function salesGroupPerCashier(Request $request)
    {
        // Fetch all sales histories, apply search if provided, and order by latest first
        $histories = SalesHistory::when($request->search, function ($query) use ($request) {
            return $query->where('cashier_name', 'LIKE', '%' . $request->search . '%')
                         ->orWhere('reference_no', 'LIKE', '%' . $request->search . '%');
        })
        // Order the histories by created_at in descending order (latest first)
        ->orderBy('created_at', 'desc')
        ->get();
    
        // Group transactions by cashier name
        $groupedHistories = $histories->groupBy(function ($transaction) {
            return isset($transaction->cashier_name) ? $transaction->cashier_name : 'Guest';
        });
    
        // Return the grouped histories to the view
        return view('cashiersales', compact('groupedHistories'));
    }

    public function fetchCashierPerDayDetails($referenceNo)
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
                'cashier_name' => $history->cashier_name,
                'products' => $products,
            ]);
        }
    
        // If no history is found for the given reference number
        return response()->json(['message' => 'Transaction not found'], 404);
    }







    // Store new category
    public function saveCategory(CategoryRequest $request)
    {
        // The category name is already validated by the CategoryRequest
        $category = new Category();
        $category->category = $request->category;  // This uses the 'category' field from the form
        $category->save();

        // Redirect back or return a response with a success message
        return redirect()->back()->with('success', 'Category added successfully.');
    }

    // public function taxRateUpdate(UpdateTaxRateRequest $request)
    // {
    //     // Get the validated input directly from the request
    //     $validated = $request->validated();

    //     // Assuming there's only one tax record in the database
    //     $tax = Tax::first(); 

    //     if ($tax) {
    //         // Update the tax rate in the database
    //         $tax->rate = $validated['taxRate'];
    //         $tax->save();  // Save the updated tax record

    //         return redirect()->back()->with('success', 'Tax rate updated successfully!');
    //     }

    //     return redirect()->back()->with('error', 'Tax rate record not found.');
    // }

    //Show stock status view
    public function showStockStatus(){
        return view('/stockstatus');
    }

    // Method to fetch low stock and out of stock products
    public function getStockStatus()
    {
        // Fetch products with low stock (below 50) but excluding products with 0 stock
        $lowStockProducts = Product::where('stocks', '<', 50)
        ->where('stocks', '>', 0)
        ->get();

        // Fetch products that are out of stock
        $outOfStockProducts = Product::where('stocks', '=', 0)->get();

        // Pass data to the view
        return view('stockstatus', compact('lowStockProducts', 'outOfStockProducts'));
    }

    public function addStock(Request $request, $id)
    {
        // No need to manually validate as it's handled by AddStockRequest

        // Find the product by ID
        $product = Product::find($id);
        
        if ($product) {
            // Add the specified quantity to the product's stock
            $product->stocks += $request->quantity;
        
            // Save the updated product
            $product->save();
        
            // Return a success response
            return response()->json(['message' => 'Stock updated successfully.']);
        }
    
        // Return an error response if the product was not found
        return response()->json(['message' => 'Product not found.'], 404);
    }
}
