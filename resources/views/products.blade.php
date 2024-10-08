<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products List</title>
    <link rel="stylesheet" href="{{asset('css/products.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script src="js/products.js"></script>
    <style>
        /* body{
            height: cal(100vh);
        }
        h1 {
            text-align: center;
            font-size: 50px;
            font-family: Arial, Helvetica, sans-serif;
            color: #000000;
            font-weight: bold;
        }
        .table{
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        table{
            width: 1000px;
            border-style: none;
            margin: auto;
            border-collapse: collapse;
        }
        th, td{
            border-style: none;
            font-family: Arial, Helvetica, sans-serif;
            padding: 10px;
        }
        td{
            border-bottom: 1px dashed #838383;
        }
        th{
            text-align: left;
        }
        tr:nth-child(even){
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .add{
            border: none;
            width: 140px;
            height: 40px;
            margin-top: 10px;
            margin-left: 1320px;
            color: white;
            background-color: rgb(39, 39, 212);
            border-radius: 5px;
            cursor: pointer;
        }
        .add:hover{
            background-color: rgba(255, 255, 255, 0.692);
            color: black;
            border: 2px solid rgb(39, 39, 212);
        }
        a{
            text-decoration: none;
        }
        .edit{
            border: none;
            background-color: transparent;
            cursor: pointer;
            font-weight: bold;
        }
        .edit:hover{
            color: rgb(39, 39, 212);
        }
        .delIcon{
            --bezier: cubic-bezier(0.22, 0.61, 0.36, 1);
            --edge-light: hsla(0, 0%, 50%, 0.8);
            --text-light: rgba(255, 255, 255, 0.4);
            --back-color: 240, 40%;

            width: 20px;
            height: 20px;
            color: red
        }
        .delIcon:hover {
            --edge-light: hsla(0, 0%, 50%, 1);
            text-shadow: 0px 0px 10px var(--text-light);
            box-shadow: inset 0.4px 1px 4px var(--edge-light),
                2px 4px 8px hsla(0, 0%, 0%, 0.295);
            transform: scale(1.1);
        }
        .delete{
            border: none;
            background-color: transparent;
            cursor: pointer;
        } */
    </style>
</head>
<body>
    <header class="header">
        <div class="top-container">
            <div class="comp-name">
                <h2 class="abc">ABC Company</h2>
                <p><Address class="address">Address: xxxxx, xxxxxxx</Address></p>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="GET">
                {{ csrf_field() }}
                <div class="out">
                    <button class="Btn">
                        <div class="sign">
                          <svg viewBox="0 0 512 512">
                            <path
                              d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"
                            ></path>
                          </svg>
                        </div>
                        <div class="textlogout">Logout</div>
                      </button>
                </div>
            </form>
        </div>
    </header>
    <aside class="left-container">
        <div>
            <img class="logo" src="images/logo.png" alt="">
            <hr>
        </div>
        <div class="content">
            <div class="options">
                <div class="opt">
                    <img class="img" src="images/dashboard.png" alt="">
                    <a class="txt-1" href="#sec1">DASHBOARD</a>
                </div>
                <div class="opt">
                    <img class="img" src="images/itemlist.png" alt="">
                    <a class="txt-1" href="#sec2">ITEM LIST</a>
                </div>
                <div class="opt">
                    <img class="img" src="images/transac.png" alt="">
                    <a class="txt-1" href="#sec3">TRANSACTIONS</a>
                </div>
                <div class="opt">
                    <img class="img" src="images/settings.png" alt="">
                    <a class="txt-1" href="#sec4">SETTINGS</a>
                </div>
                <div class="functions">
                    <div class="func">
                        <p class="txt-2">F1     Scan Toggle</p>
                    </div>
                    <div class="func">
                        <p class="txt-2">F2     Search</p>
                    </div>
                    <div class="func">
                        <p class="txt-2">F5     Payment</p>
                    </div>
                    <div class="func">
                        <p class="txt-2">F12    Clear All</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>


    {{-- SECTION 1 --}}
    <section id="sec1" class="section-1"></section>
    <div class="dashboard">
        <p class="dash">This is the DASHBOARD</p>
    </div>
    </section>

    {{-- SECTION 2 --}}
    <section id="sec2" class="section-2">
        <div class="item-list">
            <div class="cashier">
                <h1 class="cashier-1">List of Products</h1>
                <input id="searchInput" class="srch" type="search" placeholder="Search">
                {{-- <button type="button" class="srch" data-toggle="modal" data-target="#searchModal">
                    Open Search
                </button>

                <!-- Modal for search funtionality -->

                <!-- Modal for search functionality -->
                    <div id="searchModal" class="modal">
                        <div class="modal-content">
                            <span class="close" data-dismiss="modal" aria-label="Close">&times;</span>
                            <h2 id="searchModalLabel">Search</h2>
                            <form action="{{ route('products') }}" method="GET" id="searchForm">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="search">Search:</label>
                                    <input 
                                        class="form-control" 
                                        type="search" 
                                        name="search" 
                                        placeholder="Search" 
                                        value="{{ request('search') }}"
                                        id="search"
                                    >
                                </div>
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div> --}}

                {{-- <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="searchModalLabel">Search</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('products') }}" method="GET" id="searchForm">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input 
                                            class="form-control" 
                                            type="search" 
                                            name="search" 
                                            placeholder="Search" 
                                            value="{{ request('search') }}"
                                        >
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" form="searchForm" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="cont-2">
                <div class="tbl">
                    <!-- Add Product Button -->
                    <a href="javascript:void(0);" id="addProductButton">
                        <button class="add-product">Add Product</button>
                    </a>
                    <table>
                            <tr>
                                <th style="width: 40px;">No.</th>
                                <th style="width: 100px;">Barcode</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th style="width: 50px;">Actions</th>
                            </tr>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->barcode }}</td>
                                <td>{{ $product->item_name }}</td>
                                <td>{{ $product->quantity}}</td>
                                <td>{{ $product->price }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <a href="javascript:void(0);" class="edit-button" data-id="{{ $product->id }}" data-barcode="{{ $product->barcode }}" data-name="{{ $product->item_name }}" data-quantity="{{ $product->quantity }}" data-price="{{ $product->price }}">
                                        <button class="edit">Edit</button>
                                    </a>
                                    <!-- Delete Form -->
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="delete" type="submit" onclick="return confirm('Are you sure you want to delete this product?');"><img class="delIcon" src="images/delete.png" alt=""></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                    </table>
                        
                    <div class="space"></div>
                    <ul class="pagination">
                        {{-- {{ $products->links() }} --}}
                        {{ $products->appends(request()->query())->links() }}
                    </ul>

                    <!-- Modal HTML -->
                        <div id="productModal" class="modal">
                            <div class="modal-content">
                                <span class="close" id="closeModal">&times;</span>
                                <h2 id="modalTitle">Add Product</h2>
                                <form id="productForm" action="{{ route('products.update', '') }}" method="POST">
                                    <input type="hidden" name="product_id" id="product_id" value="">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" id="methodField" value="POST">
                                    <div>
                                        <label for="barcode">Barcode:</label>
                                        <input type="text" name="barcode" id="barcode" required>
                                    </div>
                                    <div>
                                        <label for="item_name">Product Name:</label>
                                        <input type="text" name="item_name" id="item_name" required>
                                    </div>
                                    <div>
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" name="quantity" id="quantity" required>
                                    </div>
                                    <div>
                                        <label for="price">Price:</label>
                                        <input type="number" name="price" id="price" required>
                                    </div>
                                    <button type="submit" id="submitProduct">Save</button>
                                    <button type="button" class="cancel" id="cancelButton">Cancel</button>
                                </form>
                            </div>
                        </div>               
                </div>
            <div class="cont-3">
                <div class="date-time">
                    <p><input class="date" type="date"></p>
                    <p><input class="time" type="time"></p>
                </div>
                <div class="button">
                    <button class="scan">SCAN</button>
                    <button class="payment">Payment</button>
                    <button type="submit" class="clear btn-danger">Clear All</button>
                </div>
                <div class="sub-tot">
                    <div>
                        <div class="amount"><h1 class="sub">Sub Total</h1><p class="price">₱1000.00</p></div>
                        <div class="tax"><h1 class="tx">Tax</h1><p class="taxx">₱0.00</p></div>
                    </div>
                        <h1 class="total">Payable Amount:</h1>
                        <h3 class="tot">₱1000.00</h3>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 3 --}}
    <section id="sec3" class="section-3">
        <div class="purchases">
            <p>This is the PURCHASES</p>
        </div>
    </section>

    {{-- SECTION 4 --}}
    <section id="sec4" class="section-4">
        <div class="settings">
            <p>This is the SETTINGS</p>
        </div>
    </section>

<script>
    //Add and edit modal script
    $('.edit-button').on('click', function() {
    const productId = $(this).data('id');
    $('#product_id').val(productId);
    // Set other fields similarly
    $('#productForm').attr('action', '{{ url('products/update') }}/' + productId);
    $('#productModal').show(); // Or whatever function you use to show the modal
});



        $(document).ready(function() {
             // Update pagination links to include the hash for the first page only
             $('.pagination a').each(function() {
                 const href = $(this).attr('href');
                 if (href && window.location.pathname === this.pathname) { // Check if on the same page
                     $(this).attr('href', href + '#sec2');
                 }
             });

             // If the current page is loaded with a hash, ensure it stays
             if (window.location.hash) {
                 $('html, body').animate({
                     scrollTop: $(window.location.hash).offset().top
                 }, 500);
             }

             // Smooth scrolling for section links
             $("a").on('click', function(event) {
                 // Make sure this.hash has a value before overriding default behavior
                 if (this.hash !== "" && this.closest('.pagination') === null) { // Exclude pagination links
                     // Prevent default anchor click behavior
                     event.preventDefault();

                     // Store hash
                     var hash = this.hash;

                     // Using jQuery's animate() method to add smooth page scroll
                     $('html, body').animate({
                         scrollTop: $(hash).offset().top
                     }, 800, function(){
                         // Add hash (#) to URL when done scrolling
                         window.location.hash = hash;
                     });
                 }
             });
         });

         //Clear all the table data

         </script>
</body>













{{-- <body>
    <div class="container">
        <d iv class="left-cont">
            <img class="logo" src="images/logo.png" alt="">
            <hr>
            <div class="options">
                <ul>
                    <li><span class="icon"><img class="img" src="images/dashboard.png" alt=""></span><span class="text">DASHBOARD</span></li>
                    <li><span class="icon"><img class="img" src="images/itemlist.png" alt=""></span><span class="text">ITEM LIST</span></li>
                    <li><span class="icon"><img class="img" src="images/transac.png" alt=""></span><span class="text">TRANSACTIONS</span></li>
                    <li><span class="icon"><img class="img" src="images/settings.png" alt=""></span><span class="text">SETTINGS</span></li>
                </ul>
            </div>
            <div class="functions">
                <ul>
                    <li><span class="icon">F1</span><span class="text">SCAN TOGGLE</span></li>
                    <li><span class="icon">F2</span><span class="text">SCAN</span></li>
                    <li><span class="icon">F5</span><span class="text">PAYMENT</span></li>
                    <li><span class="icon">F12</span><span class="text">CLEAR ALL</span></li>
                </ul>
            </div>
        </d>
        <div>
            <div class="cont-top">
                <div><h1 class="str-name">ABC Company</h1></div>
                <form id="logout-form" action="{{ route('logout') }}" method="GET">
                    {{ csrf_field() }}
                    <div class="out">
                        <button class="Btn">
                            <div class="sign">
                              <svg viewBox="0 0 512 512">
                                <path
                                  d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"
                                ></path>
                              </svg>
                            </div>
                            <div class="textlogout">Logout</div>
                          </button>
                    </div>
                </form>
            </div>
            <P class="add">Address:Abc, xxxxx, xxxxxxx</P>
            <div class="cashier">
                <h1 class="cashier-1">List of Products</h1>
                <input class="srch" type="search" placeholder="Search">
            </div>
            <div class="cont-2">
                <div class="tbl">
                    <table>
                        <tr>
                            <th style="width: 40px;">No.</th>
                            <th style="width: 100px;">Barcode</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th style="width: 50px;">Actions</th>
                        </tr>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->barcode }}</td>
                            <td>{{ $product->item_name }}</td>
                            <td>{{ $product->quantity}}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('products.edit', $product->id) }}">
                                    <button class="edit">Edit</button>
                                </a>
                                <!-- Delete Form -->
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="delete" type="submit" onclick="return confirm('Are you sure you want to delete this product?');"><img class="delIcon" src="images/delete.png" alt=""></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        
                    </table>
                    <ul class="pagination">
                        {{ $products->links() }}
                    </ul>                    
                </div>
                <div class="cont-3">
                    <div class="date-time">
                        <p><input class="date" type="date"></p>
                        <p><input class="time" type="time"></p>
                    </div>
                    <div class="button">
                        <button class="scan">SCAN</button>
                        <button class="payment">Payment</button>
                        <button class="clear">CLEAR ALL</button>
                    </div>
                    <div class="sub-tot">
                        <div>
                            <div class="amount"><h1 class="sub">Sub Total</h1><p class="price">₱1000.00</p></div>
                            <div class="tax"><h1 class="tx">Tax</h1><p class="taxx">₱0.00</p></div>
                        </div>
                            <h1 class="total">Payable Amount:</h1>
                            <h3 class="tot">₱1000.00</h3>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="table">
        <h1>Product List</h1>
        
        <table>
                <tr>
                    <th>ID</th>
                    <th>Barcode</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->barcode }}</td>
                    <td>{{ $product->item_name }}</td>
                    <td>{{ $product->quantity}}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('products.edit', $product->id) }}">
                            <button class="edit">Edit</button>
                        </a>
                        <!-- Delete Form -->
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="delete" type="submit" onclick="return confirm('Are you sure you want to delete this product?');"><img class="delIcon" src="https://img.icons8.com/?size=100&id=gjhtZ8keOudc&format=png&color=FA5252" alt=""></button>
                        </form>
                    </td>
                </tr>
                @endforeach
        </table>
            <a href="/products/create"><button class="add">Add new product</button></a>
    </div> --}}
</body>
</html>