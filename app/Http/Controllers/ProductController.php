<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Product;
use Illuminate\Http\Request; 

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
     

    public function index()
    {
        //Shows all the data in table form
        $products = Product::paginate(8);

        

        return view("products")->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //showing of add form
        return view('addform');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        //Proccess of adding a data to the database

        
        //Validating the incoming data request
        // Manually validate the incoming request
        $incoming = $request->only(['barcode', 'item_name', 'quantity', 'price']);

        //$incoming = $request->validated();
        // $incoming = $request->validate([
        //     'barcode'=>'required',
        //     'itemName'=>'required',
        //     'quantity' => 'required',
        //     'price' => 'required'
        // ]);

        //retrieve the data from the request
        $barcode = $request->input('barcode');
        $itemName = $request->input('item_name');
        $quantity = $request->input('quantity');
        $price = $request->input('price');
        

        Product::create($incoming);

        return redirect()->route('products.store')->with('products.store', 'New product added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('editform', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id); // Find the product by ID

        // Update the product with validated data
        $product->update([
            'barcode' => $request->input('barcode'),
            'item_name' => $request->input('item_name'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
        ]);

        return redirect()->route('products')->with('success', 'Product updated successfully'); // Redirect with a success message
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  public function search(Request $request)
    //  {
    //      $query = Product::query();
 
    //      // Check if there is a search term
    //      if ($request->has('search') && $request->search != '') {
    //          $searchTerm = $request->search;
    //          $query->where('item_name', 'LIKE', "%{$searchTerm}%")
    //                ->orWhere('barcode', 'LIKE', "%{$searchTerm}%"); // Include other fields if necessary
    //      }
 
    //      $products = $query->get();
 
    //      return view('products', compact('products'));
    //  }


    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id); 

        // Delete the product
        $product->delete(); 

        // Redirect with a success message
        return redirect()->route('products.index')->with('success', 'Product deleted successfully'); 
    }
}
