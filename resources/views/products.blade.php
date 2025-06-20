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

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="js/products.js"></script>
</head>
<body>
    {{-- @php
    // auth()->login($user); // Correct way to log in a user
    dd(auth()->check(), auth()->user()); // Check if user is logged in immediately after login
    @endphp --}}
    <header class="header">
        @if(session('success'))
        <div class="alert alert-success"  id="successAlert">
        {{ session('success') }}
        </div>
        @endif

        <div class="top-container">
            <div class="comp-name">
                <h2 class="abc">SBC SuperMart</h2>
                <p><Address class="address">Address: xxxxx, xxxxxxx</Address></p>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                <div class="out">
                    <button type="submit" class="Btn">
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
                    <img class="img" src="images/itemlist.png" alt="">
                    <a class="txt-1 nav-link" data-target="#sec1">ITEM LIST</a>
                </div>
                <div class="opt">
                    <img class="img" src="images/transac.png" alt="">
                    <a class="txt-1 nav-link" data-target="#sec2">SALES</a>
                </div>
                <div class="opt">
                    <img class="img" src="images/settings.png" alt="">
                    <a class="txt-1 nav-link" data-target="#sec3">SALES HISTORY</a>
                </div>
                <div class="opt">
                    <img class="img" src="images/dashboard.png" alt="">
                    <a class="txt-1 nav-link" data-target="#sec4">MORE</a>
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
                    {{-- <div class="func">
                        <p class="txt-2">F12    Clear All</p>
                    </div> --}}
                </div>
            </div>
        </div>
    </aside>


    {{--------------------------------------------------------- THIS --------------------------------------------------------------------}}
    {{---------------------------------------------------------- IS ---------------------------------------------------------------------}}
    {{------------------------------------------------------- SECTION N -----------------------------------------------------------------}}
    {{-- <section id="sec1" class="section-1"></section>
    <div class="dashboard">
        <p class="dash">This is the DASHBOARD</p>
        <div class="sec1-div">
            <div class="div-1">
                <p>cont 1</p>
            </div>
            <div class="div-2">
                <p>cont 2</p>
            </div>
        </div>
    </div>
    </section> --}}

    {{--------------------------------------------------------- THIS --------------------------------------------------------------------}}
    {{---------------------------------------------------------- IS ---------------------------------------------------------------------}}
    {{------------------------------------------------------- SECTION 1 -----------------------------------------------------------------}}
    <section id="sec1" class="product-section">
        <div class="item-list">
            <div class="cashier">
                <h1 class="cashier-1">List of Products</h1>

                {{-- Products Search --}}
                <div class="search-container">
                    <form  action="{{ route('products.index') }}"  method="GET" id="searchProductsForm" class="searchProducts" style="display: flex;">
                        <input class="search-input" 
                                name="searchProducts" 
                                value="{{ request()->query('searchProducts') }}"
                                type="text" 
                                id="searchInput" 
                                placeholder="Search by barcode or product name"
                                required>
                        <i class="fas fa-search search-icon"></i>
                        <button id="searchButton" class="productSearch" type="submit">Search</button>
                        <script>
                            document.addEventListener('keydown', function(event) {
                                if (event.key === "F2") {
                                    // Prevent the default action of F1 (which typically opens help)
                                    event.preventDefault();
                                    
                                    // Focus on the search input field
                                    document.getElementById('searchInput').focus();
                                }
                            });
                        </script>
                        
                    </form>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const searchInput = document.getElementById('searchInput');
                                const searchButton = document.getElementById('searchButton');
                                const productTableBody = document.querySelector('#productsTable tbody');
                                const paginationContainer = document.getElementById('pagination');
                                const modal = document.getElementById("productModal");
                                const productForm = document.getElementById("productForm");
                                const closeModal = document.getElementById("closeModal");
                                const cancelButton = document.getElementById("cancelButton");
                                let currentPage = 1;
                                let currentQuery = '';
                            
                                // Fetch products for search or pagination
                                function fetchProducts(query = '', page = 1) {
                                    fetch(`/search-products?searchProducts=${query}&page=${page}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            // Update table rows
                                            productTableBody.innerHTML = '';
                                            if (data.products && data.products.data.length > 0) {
                                                data.products.data.forEach(product => {
                                                    const row = document.createElement('tr');
                                                    row.innerHTML = `
                                                        <td>${product.id}</td>
                                                        <td>${product.barcode}</td>
                                                        <td>${product.item_name}</td>
                                                        <td>${product.stocks}</td>
                                                        <td>
                                                            <input class="quantity" type="number" name="quantity[${product.id}]" value="1" min="1" style="width: 50px;">
                                                        </td>
                                                        <td>${product.price}</td>
                                                        <td style="display: flex; gap: 8px;">
                                                            <button class="edit-button"
                                                                data-id="${product.id}"
                                                                data-barcode="${product.barcode}"
                                                                data-name="${product.item_name}"
                                                                data-stocks="${product.stocks}"
                                                                data-price="${product.price}"
                                                                data-category="${product.category}">
                                                                Edit
                                                            </button>
                                                            <form action="{{ route('addToTransac') }}" method="POST">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="product_id" value="${product.id}">
                                                                <input type="hidden" name="item_name" value="${product.item_name}">
                                                                <input type="hidden" name="quantity" value="1">
                                                                <input type="hidden" name="unit_price" value="${product.price}">
                                                                <button class="insert-to-sales" type="submit">Add to Sales</button>
                                                            </form>
                                                        </td>
                                                    `;
                                                    productTableBody.appendChild(row);
                                                });
                                            
                                                // Attach edit button listeners
                                                attachEditButtonListeners();
                                            
                                                // Update pagination without affecting design
                                                updatePagination(data.products);
                                            } else {
                                                productTableBody.innerHTML = '<tr><td colspan="7">No products found</td></tr>';
                                                paginationContainer.innerHTML = ''; // Clear pagination if no products
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error fetching products:', error);
                                        });
                                }
                            
                                // Attach click event listeners to dynamically added "Edit" buttons
                                function attachEditButtonListeners() {
                                    document.querySelectorAll('.edit-button').forEach(button => {
                                        button.addEventListener('click', handleEditButtonClick);
                                    });
                                }
                            
                                // Handle "Edit" button click
                                function handleEditButtonClick(event) {
                                    const button = event.target;
                                    const productId = button.getAttribute('data-id');
                                    const productBarcode = button.getAttribute('data-barcode');
                                    const productName = button.getAttribute('data-name');
                                    const productStocks = button.getAttribute('data-stocks');
                                    const productPrice = button.getAttribute('data-price');
                                    const productCategory = button.getAttribute('data-category');
                                
                                    // Populate modal fields
                                    document.getElementById("barcode").value = productBarcode;
                                    document.getElementById("item_name").value = productName;
                                    document.getElementById("stocks").value = productStocks;
                                    document.getElementById("price").value = productPrice;
                                    document.getElementById("categoryFilter").value = productCategory;
                                    document.getElementById("methodField").value = "PUT";
                                    productForm.action = `/products/${productId}`;
                                
                                    modal.style.display = "block"; // Show modal
                                }
                            
                                // Update pagination without affecting existing design
                                function updatePagination(data) {
                                    const { current_page, last_page, links } = data;
                                    paginationContainer.innerHTML = ''; // Clear old pagination
                                
                                    links.forEach(link => {
                                        const pageButton = document.createElement('button');
                                        pageButton.innerHTML = link.label;
                                        pageButton.classList.add('pagination-button');
                                        if (link.active) pageButton.classList.add('active');
                                        if (link.url) {
                                            pageButton.addEventListener('click', (event) => {
                                                event.preventDefault();
                                                const urlParams = new URLSearchParams(link.url.split('?')[1]);
                                                const newPage = urlParams.get('page');
                                                fetchProducts(currentQuery, newPage);
                                            });
                                        }
                                        paginationContainer.appendChild(pageButton);
                                    });
                                }
                            
                                // Search products
                                searchButton.addEventListener('click', function (event) {
                                    event.preventDefault();
                                    currentQuery = searchInput.value.trim();
                                    fetchProducts(currentQuery, 1);
                                });
                            
                                // Fetch all products when search input is cleared
                                searchInput.addEventListener('input', function () {
                                    if (!searchInput.value.trim()) {
                                        currentQuery = '';
                                        fetchProducts('', 1);
                                        window.location.reload();
                                    }
                                });
                            
                                // Close modal functionality
                                closeModal.onclick = cancelButton.onclick = function () {
                                    modal.style.display = "none";
                                };
                            
                                // Close modal when clicking outside of it
                                window.onclick = function (event) {
                                    if (event.target === modal) {
                                        modal.style.display = "none";
                                    }
                                };
                            
                                // Fetch initial products on page load (retain server-rendered pagination and design)
                                attachEditButtonListeners(); // Attach to initially rendered products
                            });
                        </script>
                        
                      
                    <div class="filter-container">
                        <label style="margin-top: 20px" for="categoryFilter">Filter by Category:</label>
                        <form id="categoryForm" name="categoryForm" style="display: flex;">
                            <select id="categoryFilter" name="category">
                                <option value="">Select a Category</option>
                        
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category }}">
                                        {{ ($category->category) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>                        
                    </div>
                </div>
            </div>

            <div class="cont-1">
                <div class="tbl-1">
                    <div class="add-container" style="display: flex; justify-content: space-between">
                        <!-- Add Product Button -->
                        <a href="javascript:void(0)#sec1" id="addProductButton">
                            <button class="add-product">Add Product</button>
                        </a>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const modal = document.getElementById("productModal");
                                const closeModal = document.getElementById("closeModal");
                                const addButton = document.getElementById("addProductButton");
                                const cancelButton = document.getElementById("cancelButton");
                                const productForm = document.getElementById("productForm");
                                const methodField = document.getElementById("methodField");
                                const modalTitle = document.getElementById("modalTitle");
                        
                                // Show the modal for adding a product
                                addButton.onclick = function () {
                                    modalTitle.innerText = "Add Product"; // Set modal title
                                    productForm.reset(); // Clear all form fields
                                    methodField.value = "POST"; // Set method to POST for adding
                                    productForm.action = "{{ route('products.store') }}"; // Set the form action to the store route
                                    modal.style.display = "block"; // Show the modal
                                };
                            
                                // Handle edit button clicks (dynamically loaded buttons)
                                document.querySelectorAll('.edit-button').forEach(function (editButton) {
                                    editButton.addEventListener('click', function () {
                                        modalTitle.innerText = "Edit Product"; // Set modal title
                                        modal.style.display = "block"; // Show the modal
                        
                                        // Populate form fields with product data
                                        document.getElementById("product_id").value = editButton.getAttribute("data-id");
                                        document.getElementById("barcode").value = editButton.getAttribute("data-barcode");
                                        document.getElementById("item_name").value = editButton.getAttribute("data-name");
                                        document.getElementById("stocks").value = editButton.getAttribute("data-stocks");
                                        document.getElementById("price").value = editButton.getAttribute("data-price");
                                        document.getElementById("categoryFilter").value = editButton.getAttribute("data-category");
                                    
                                        methodField.value = "PUT"; // Set method to PUT for editing
                                        productForm.action = `/products/${editButton.getAttribute("data-id")}`; // Set action to the update route
                                    });
                                });
                            
                                // Close modal when X button is clicked
                                closeModal.onclick = function () {
                                    modal.style.display = "none"; // Hide the modal
                                };
                            
                                // Close modal when Cancel button is clicked
                                cancelButton.onclick = function () {
                                    modal.style.display = "none"; // Hide the modal
                                };
                            
                                // Close modal when clicking outside the modal content
                                window.onclick = function (event) {
                                    if (event.target === modal) {
                                        modal.style.display = "none"; // Hide the modal
                                    }
                                };
                            });
                        </script>                        
                        {{-- <form action="{{ route('products.clear') }}#sec1" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="clear btn-danger" onclick="return confirm('Are you sure you want to clear all products?');"">Clear All</button>
                        </form> --}}
                    </div>
                    <div id="notification" class="notification" style="display: none;"></div>
                    <div class="products-container" style="max-height: 550px; overflow-y: auto; display: block;">
                        <table id="productsTable">
                            <thead style="position: sticky; top: 0; z-index: 1; background-color: rgb(184, 184, 184);">
                                <tr>
                                    <th style="width: 40px;">No.</th>
                                    <th style="width: 100px;">Barcode</th>
                                    <th>Product Name</th>
                                    <th>Stocks</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th style="width: 50px;">Actions</th>
                                </tr>
                            </thead> 
                        <tbody id="products-table-body">
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->barcode }}</td>
                                <td>{{ $product->item_name }}</td>
                                {{-- <td id="stocks-{{ $product->id }}">{{ $product->stocks }}</td> --}}
                                <td id="stocks-{{ $product->id }}" style="{{ $product->stocks == 0 ? 'border: 2px solid red; color: red' : '' }}">
                                    {{ $product->stocks == 0 ? 'Out of Stock' : $product->stocks }}
                                </td>
                                <td>
                                    {{-- <input class="quantity" type="number" name="quantity[{{ $product->id }}]" value="1" min="1" style="width: 50px;" onchange="updateHiddenQuantity(this)"> --}}
                                    <input class="quantity" type="number" name="quantity[{{ $product->id }}]" value="1" min="0" style="width: 50px;" onchange="updateHiddenQuantity(this, {{ $product->id }})">
                                </td>
                                {{-- <td>{{ $product->quantity}}</td> --}}
                                <td>₱{{ $product->price }}</td>
                                <td style="display: flex;">
                                    <!-- Edit Button -->
                                        <button type="button" class="edit-button"
                                            data-id="{{ $product->id }}" 
                                            data-barcode="{{ $product->barcode }}" 
                                            data-name="{{ $product->item_name }}" 
                                            data-stocks="{{ $product->stocks }}" 
                                            data-price="{{ $product->price }}"
                                            data-category="{{ $product->category }}">
                                            Edit
                                        </button>
                                    <!-- Delete Form -->
                                    <form action="{{ route('products.destroy', $product->id) }}#sec1" method="POST" style="display:inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="delete" type="submit" onclick="return confirm('Are you sure you want to delete this product?');"><img class="delIcon" src="images/delete.png" alt=""></button>
                                    </form>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const notification = document.getElementById('notification');
                                    
                                            @if (session('deleteError'))
                                                notification.textContent = '{{ session('deleteError') }}';
                                                notification.style.backgroundColor = 'red';
                                                notification.style.display = 'block';
                                                setTimeout(() => notification.style.display = 'none', 3000); // Hide after 3 seconds
                                            @endif
                                    
                                            @if (session('deleteSuccess'))
                                                notification.textContent = '{{ session('deleteSuccess') }}';
                                                notification.style.backgroundColor = 'green';
                                                notification.style.display = 'block';
                                                setTimeout(() => notification.style.display = 'none', 3000); // Hide after 3 seconds
                                            @endif
                                        });
                                    </script>
                                    <form action="{{ route('addToTransac') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="item_name" value="{{ $product->item_name }}">
                                        <input type="hidden" name="quantity" value="1" min="0" data-product-id="{{ $product->id }}">
                                        <input type="hidden" name="unit_price" value="{{ $product->price }}">
                                    
                                        <button class="insert-to-sales" type="submit">Add to Sales</button>
                                    </form>
                                    <script>
                                        // Function to update the hidden quantity input
                                        function updateHiddenQuantity(quantityInput, productId) {
                                            // Find the specific hidden quantity input for this product
                                            var hiddenQuantityInput = document.querySelector(`input[name="quantity"][data-product-id="${productId}"]`);
                                            // Update the value of the hidden input with the value of the quantity input
                                            if (hiddenQuantityInput) {
                                                hiddenQuantityInput.value = quantityInput.value;
                                            }
                                        }

                                        //Script that handles the update of stocks
                                        // Attach event listener to form submission
                                        document.addEventListener('DOMContentLoaded', function () {
                                            document.querySelectorAll('form[id="addToTransacForm"]').forEach(form => {
                                                form.addEventListener('submit', function (event) {
                                                    event.preventDefault(); // Prevent the default form submission
                                                
                                                    // Get the form data
                                                    let formData = new FormData(this);
                                                
                                                    // Send an AJAX POST request
                                                    fetch(this.action, {
                                                        method: 'POST',
                                                        headers: {
                                                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                                        },
                                                        body: formData
                                                    })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.success) {
                                                            // Update the view with the new quantity
                                                            const quantityInput = this.querySelector('.quantity'); // Get the quantity input from the form
                                                            quantityInput.value = data.quantity;
                                                        
                                                            // Update the stock display, assuming you have an element with a class of 'stock' to show the product stock
                                                            const stockDisplay = document.querySelector(`.stock[data-product-id="${data.product_id}"]`);
                                                            if (stockDisplay) {
                                                                stockDisplay.textContent = `Stock: ${data.new_stock}`; // Update the displayed stock
                                                            }
                                                        } else {
                                                            console.error('Failed to update the quantity.');
                                                        }
                                                    })
                                                    .catch(error => console.error('Error:', error));
                                                });
                                            });
                                        });
                                    </script>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <ul id="pagination" class="pagination">
                        {{-- {{ $products->links() }} --}}
                        {{ $products->appends(request()->query())->links() }}
                    </ul>

                    <!-- Modal HTML -->
                    <div id="productModal" class="modal">
                        <div class="modal-content">
                            <span class="close" id="closeModal">&times;</span>
                            <h2 id="modalTitle">Add Product</h2>
                            <form id="productForm" action="{{ route('products.store') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" id="methodField" value="POST">
                                <input type="hidden" name="product_id" id="product_id" value="">
                    
                                <div>
                                    <label for="categoryFilter">Category:</label>
                                    <select id="categoryFilter" name="category">
                                        <option value="">Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category }}">
                                                {{ $category->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                    
                                <div>
                                    <label for="barcode">Barcode:</label>
                                    <input id="barcode" type="text" name="barcode" placeholder="Generating barcode" required>
                                </div>
                    
                                <div>
                                    <label for="item_name">Product Name:</label>
                                    <input id="item_name" type="text" name="item_name" required>
                                </div>
                    
                                <div>
                                    <label for="stocks">Stocks:</label>
                                    <input type="number" name="stocks" id="stocks" required min="0">
                                </div>
                    
                                <div>
                                    <label for="price">Price:</label>
                                    <input type="number" name="price" id="price" step="0.01" min="0" max="10000" required>
                                </div>
                    
                                <button type="submit" id="submitProduct">Save</button>
                                <button type="button" class="cancel" id="cancelButton">Cancel</button>
                            </form>
                        </div>
                    </div>   
                    
                    



            </div>
        </div>
    </section>

    {{--------------------------------------------------------- THIS --------------------------------------------------------------------}}
    {{---------------------------------------------------------- IS ---------------------------------------------------------------------}}
    {{------------------------------------------------------- SECTION 2 -----------------------------------------------------------------}}
    <section id="sec2" class="product-section">
        <div class="item-list">
        <div class="cashier">
            <h1 class="cashier-1">Cashier {{ session('cashier_id') }} {{ session('cashier_name') ? session('cashier_name') : 'Guest' }}</h1>
            {{-- <h1 class="cashier-1">Cashier Username</h1> --}}
            <form action="sales-search-form" method="GET">
                <div class="ewan">
                    <input id="searchSales" class="srch-2" type="text" name="query" placeholder="Scan using BARCODE" required>
                    <div id="results" class="dropdown-results"></div>
                    <script>
                        document.addEventListener('keydown', function(event) {
                            if (event.key === "F1") {
                                // Prevent the default action of F1 (which typically opens help)
                                event.preventDefault();
                                
                                // Focus on the search input field
                                document.getElementById('searchSales').focus();
                            }
                        });
                    </script>
                    
                </div>
            </form>

            {{-- adding quantity modal --}}
            <div id="quantity-modal" style="display: none; position: fixed; top: 30%; left: 50%; transform: translate(-50%, -30%); background: white; border: 1px solid #ccc; padding: 20px; z-index: 1000; box-shadow: 0 0 10px rgba(0,0,0,0.5);">
                <h3>Enter Quantity</h3>
                <input type="number" id="quantity-input" value="1" min="1" style="width: 100px; margin-bottom: 10px;">
                <br>
                <button id="add-to-transaction-table">Add</button>
                <button id="quantity-close-modal">Close</button>
            </div>
            <div id="quanity-modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>
            
            <script>
                $(document).ready(function() {
                    let selectedProductId = null;

                    // Prevent form submission
                    $('#sales-search-form').on('submit', function(e) {
                        e.preventDefault();
                    });
                
                    // Handle input for searching sales
                    $('#searchSales').on('keyup', function() {
                        let query = $(this).val(); // Get input value
                    
                        if (query.length > 0) {
                            $.ajax({
                                url: '/search-sales',
                                method: 'GET',
                                data: { query: query },
                                success: function(data) {
                                    $('#results').empty().show(); // Show results dropdown
                                    if (data.length > 0) {
                                        data.forEach(function(product) {
                                            $('#results').append(`<div class="result-item" data-id="${product.id}">${product.item_name}</div>`);
                                        });
                                    } else {
                                        $('#results').append('<div>No results found</div>'); // Optional message for no results
                                    }
                                }
                            });
                        } else {
                            $('#results').empty().hide(); // Hide results if no input
                        }
                    });
                
                    // When a search result is clicked, show the modal
                    $('#results').on('click', '.result-item', function() {
                        selectedProductId = $(this).data('id'); // Save the selected product ID
                        $('#quantity-modal').fadeIn();
                        $('#quantity-modal-overlay').fadeIn();
                    });

                    // When "Enter" is pressed in the search field, show the modal (without submitting the form)
                    $('#searchSales').on('keypress', function(e) {
                        if (e.which == 32) { // 13 is the keycode for "Enter"
                            e.preventDefault(); // Prevent form submission
                            if ($('#results .result-item').length > 0) {
                                // Select the first product from the search results and show the modal
                                selectedProductId = $('#results .result-item').first().data('id');
                                $('#quantity-modal').fadeIn();
                                $('#modal-overlay').fadeIn();
                            }
                        }
                    });
                
                    // Close the modal
                    $('#quantity-close-modal').on('click', function() {
                        $('#quantity-modal').fadeOut();
                        $('#quantity-modal-overlay').fadeOut();
                    });
                
                    // Add to transaction when "Add" button is clicked
                    $('#add-to-transaction-table').on('click', function() {
                        let quantity = $('#quantity-input').val();
                                        
                        if (!selectedProductId || quantity <= 0) {
                            alert('Invalid product or quantity!');
                            return;
                        }
                    
                        $.ajax({
                            url: '/add-to-transaction',
                            method: 'POST',
                            data: {
                                product_id: selectedProductId,
                                quantity: quantity,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    // alert('Product added to transaction!');
                                    $('#quantity-modal').fadeOut();
                                    $('#quanity-modal-overlay').fadeOut();
                                    $('#results').empty().hide();
                                    $('#searchSales').val('');

                                    location.reload();
                                
                                    // Update displayed totals dynamically
                                    $('.price').text(`₱${response.net_amount.toFixed(2)}`);
                                    $('.taxx').text(`₱${response.tax.toFixed(2)}`);
                                    $('.tot').text(`₱${response.amount_payable.toFixed(2)}`);
                                } else {
                                    alert('Failed to add product: ' + response.message);
                                }
                            },
                            error: function() {
                                alert('An error occurred while adding the product.');
                            }
                        });
                    });
                    
                    // Trigger "Add" button click when "Enter" is pressed
                    $('#quantity-input').on('keypress', function(e) {
                        if (e.which === 13) { // Enter key
                            e.preventDefault();
                            $('#add-to-transaction-table').click();
                        }
                    });
                });
            </script>
        </div>
        <div class="cont-2">
            <div class="tbl-2">
                <div class="sales-container" style="max-height: 600px; overflow-y: auto; display:block; width:100%;">
                    <table class="sales-table" id="transaction-tbl border-collapse: collapse; border-spacing: 0; width: 750px">
                        <thead style="background-color: rgb(1, 21, 112); color:white;">
                            <tr>
                                <th style="position: sticky; top: 0; background-color: rgb(1, 21, 112); width: 130px; z-index: 1;">Item Name</th>
                                <th style="position: sticky; top: 0; background-color: rgb(1, 21, 112);">Quantity</th>
                                <th style="position: sticky; top: 0; background-color: rgb(1, 21, 112);">Unit Price</th>
                                <th style="position: sticky; top: 0; background-color: rgb(1, 21, 112);">Total Price </th>
                                <th style="position: sticky; top: 0; background-color: rgb(1, 21, 112); width: 50px;">Actions</th>
                            </tr>
                        </thead>
                        @php
                            $net_amount = 0;
                        @endphp
                    <tbody style="overflow-y: auto; width: 100%;">
                        @foreach ( $transactions as $transaction )
                            @php
                                $total_price = $transaction->unit_price * $transaction->quantity;
                                $net_amount += $total_price;
                            @endphp
                            <tr style="margin: 0; padding: 0; margin: 0; padding: 0;">
                                <td style="width: 20px margin: 0;">{{ $transaction->item_name }}</td>
                                <td>
                                    {{-- {{ $transaction->quantity }} --}}
                                    {{-- <input class="quantity" type="number" name="quantity[{{ $product->id }}]" value="{{ $transaction->quantity }}" min="1" style="width: 50px"> --}}
                                    <input 
                                        class="quantity" 
                                        type="number" 
                                        name="quantity[{{ $product->id }}]" 
                                        value="{{ $transaction->quantity }}" 
                                        min="1" 
                                        style="width: 50px" 
                                        data-id="{{ $transaction->transaction_id }}"
                                    >
                                </td>
                                <td style="margin: 0;">₱{{ $transaction->unit_price }}</td>
                                <td id="total-price-{{ $transaction->transaction_id }}" style="margin: 0;">₱{{ $transaction->total_price }}</td>
                                <td style="display: flex; margin:0;">
                                    <form action="{{ route('transactions.destroy', $transaction->transaction_id) }}#sec2" method="POST" style="display:inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }} <!-- Use this method to specify the DELETE request -->
                                        <button class="deleteTransac btn-danger" type="submit"><img class="delIcon" src="images/delete.png" alt=""></button>
                                    </form>
                                    <script>
                                        document.querySelectorAll('.deleteTransac').forEach(button => {
                                            button.addEventListener('click', function (event) {
                                                event.preventDefault();

                                                const form = this.closest('form');
                                                const url = form.action;

                                                // Use confirm only once, ensuring no duplicate prompts
                                                if (!this.dataset.confirmed) {
                                                    this.dataset.confirmed = confirm('Are you sure you want to delete this product?');
                                                }

                                                if (this.dataset.confirmed === 'true') {
                                                    fetch(url, {
                                                        method: 'DELETE',
                                                        headers: {
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                                        },
                                                    })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.success) {
                                                            location.reload(); // Reload the page to reflect the changes
                                                        } else {
                                                            alert('Error deleting product.');
                                                        }
                                                    })
                                                    .catch(error => console.error('Error:', error));
                                                }
                                            });
                                        });
                                    </script>
                                </td>
                            </tr>
                            @php
                                $tax = .01 * $net_amount;
                                $amount_payable = $net_amount + $tax;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                {{-- SCRIPT TO READ THE CHANGES IN THE QUANTITY --}}
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        document.querySelectorAll('.quantity').forEach(input => {
                            input.addEventListener('change', function () {
                                const transactionId = this.getAttribute('data-id'); // Get transaction ID
                                const newQuantity = this.value; // Get the new quantity
                            
                                updateQuantity(transactionId, newQuantity, this);
                            });
                        });
                    
                        function updateQuantity(transactionId, quantity, inputElement) {
                            fetch(`/transactions/${transactionId}`, {
                                method: 'PUT', // Use PUT for updating
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                },
                                body: JSON.stringify({ quantity: quantity }),
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        console.log('Quantity updated successfully!');
                                    
                                        // Dynamically update the total price for the transaction
                                        const totalPriceElement = document.querySelector(`#total-price-${transactionId}`);
                                        if (totalPriceElement) {
                                            totalPriceElement.textContent = `₱${parseFloat(data.new_total_price).toFixed(2)}`;
                                        }
                                    
                                        // Dynamically update stock values
                                        const stockElement = document.querySelector(`#stocks-${data.product_id}`);
                                        if (stockElement) {
                                            stockElement.textContent = data.new_stock;
                                        }
                                    
                                        // Dynamically update Net Amount, Tax, and Amount Payable
                                        document.querySelector('.price').textContent = `₱${parseFloat(data.net_amount).toFixed(2)}`;
                                        document.querySelector('.taxx').textContent = `₱${parseFloat(data.tax).toFixed(2)}`;
                                        document.querySelector('.tot').textContent = `₱${parseFloat(data.amount_payable).toFixed(2)}`;
                                    
                                        // Reflect the updated quantity in the input field
                                        inputElement.value = quantity;
                                    } else {
                                        alert(data.message || 'Error updating quantity.');
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        }
                    });
                </script>     
                </div>         
            </div>
        <div class="cont-3" style="display: flex; flex-direction: column;">
            <div class="date-time">
                <input class="date" id="date" type="date">
                <input class="time" id="time" type="time">
            </div>
            <script>
                function formatTime(date) {
                    let hours = date.getHours().toString().padStart(2, '0');
                    let minutes = date.getMinutes().toString().padStart(2, '0');
                    let seconds = date.getSeconds().toString().padStart(2, '0');
                    return `${hours}:${minutes}:${seconds}`;
                }

                window.onload = function() {
                    // Get the current date
                    const currentDate = new Date();
                
                    // Format the date as YYYY-MM-DD for the date input
                    const dateString = currentDate.toISOString().split('T')[0];
                
                    // Set the value of the date and time input fields to the current date and time
                    document.getElementById('date').value = dateString;
                    document.getElementById('time').value = formatTime(currentDate);
                
                    // Update the time every second to keep it live
                    setInterval(function() {
                        const updatedTime = formatTime(new Date());
                        document.getElementById('time').value = updatedTime;
                    }, 1000);
                };
            </script>
            <div class="button">
                <button id="payment2" class="payment2" onclick="showCheckoutModal()">Proceed to Payment</button>
                <script>
                    document.addEventListener('keydown', function(event) {
                        if (event.key === "F5") {
                            // Prevent the default action of F1 (which typically opens help)
                            event.preventDefault();
                            
                            // Focus on the search input field
                            document.getElementById('payment2').click();
                        }
                    });
                </script>
                

                <button class="scanProduct btn-default">SCAN</button>

                <button id="seeHistory" class="seeHistory btn-default">See History</button>
                <script>
                    // Wait for the document to be fully loaded
                    document.addEventListener('DOMContentLoaded', function () {
                        const seeHistoryBtn = document.getElementById('seeHistory');
                        
                        // Add click event listener to the button
                        seeHistoryBtn.addEventListener('click', function() {
                            // Find the section with id "sec3" and scroll to it
                            const sec3 = document.getElementById('sec3');
                            if (sec3) {
                                sec3.scrollIntoView({ behavior: 'smooth' });
                            }
                        });
                    });
                </script>
                
                <form action="{{ route('transactions.deleteAll') }}#sec2" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="deleteAllTransac btn-danger">Clear All</button>
                </form>
                {{-- SCRIPT FOR DELETING A PRODUCT INSRTED IN THE TRANSACTION --}}
                <script>
                    document.querySelector('.deleteAllTransac').addEventListener('click', function (event) {
                        event.preventDefault();
                        const form = this.closest('form');
                        const url = form.action;

                        if (confirm('Are you sure you want to clear all products?')) {
                            fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                },
                            })
                            .then(response => response.json())  // Expecting a JSON response
                            .then(data => {
                                if (data.success) {
                                    location.reload(); // Reload the page to reflect the changes
                                } else {
                                    alert('Error clearing all products.');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                        }
                    });
                </script>
            </div>
            <div class="sub-tot">
                <div>
                    <div class="amount"><h1 class="sub">Net Amount</h1><p class="price">₱{{ number_format(session('net_amount', 0), 2) }}</p></div>
                    <div class="tax"><h1 class="tx">Tax</h1><p class="taxx">₱{{ number_format(session('tax', 0), 2) }}</p></div>
                </div>
                    <h1 class="total">Amount Payable:</h1>
                    <h3 class="tot">₱{{ number_format(session('amount_payable', 0), 2) }}</h3>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="modal">
    <div class="modal-content">
      <h2>Checkout</h2>
      <p>Amount Payable:</p>
      <input type="text" id="amountPayable" readonly>
      <p>Mode of Payment:</p>
      <select id="paymentMode" onchange="handlePaymentModeChange()">
        <option value="">Select Payment Method</option>
        <option value="cash">Cash</option>
        {{-- <option value="e_wallet">E-Wallet</option>
        <option value="credit_card">Credit Card</option> --}}
      </select>
      <button onclick="closeModal('checkoutModal')">Cancel</button>
      <button onclick="processPayment()">Proceed to Cash Payment</button> 
    </div>
    </div>

    <script>
        // Function to show the checkout modal
        function showCheckoutModal() {
            // Get all product rows in the table body (excluding the header)
            const transactionTable = document.getElementById('transaction-tbl border-collapse: collapse; border-spacing: 0; width: 750px');
            
            // Ensure transactionTable is not null
            if (!transactionTable) {
                alert('Transaction table not found.');
                return;
            }
        
            // Get all the rows inside tbody (this should be product rows)
            const transactionRows = transactionTable.querySelectorAll('tbody tr');
        
            // If there are no rows in the tbody (no products added), do not show the modal
            if (transactionRows.length === 0) {
                alert('No products in the transaction. Please add products before proceeding.');
                return;
            }
        
            // Fetch the latest amount payable dynamically
            const amountPayableElement = document.querySelector('.tot');
            const amountPayable = amountPayableElement ? amountPayableElement.textContent : '₱0.00';
        
            // Set the amount payable in the modal
            document.getElementById('amountPayable').value = amountPayable.trim();
        
            // Show the checkout modal
            document.getElementById('checkoutModal').style.display = 'flex';
        }

        // Function to handle payment mode change
        function handlePaymentModeChange() {
            const paymentMode = document.getElementById('paymentMode').value;

            if (paymentMode === 'cash') {
                // Set the total amount dynamically for the cash payment modal
                const totalAmountElement = document.getElementById('totalAmount');
                if (totalAmountElement) {
                    totalAmountElement.value = document.getElementById('amountPayable').value;
                }

                closeModal('checkoutModal');
                document.getElementById('cashPaymentModal').style.display = 'flex';
            } else if (paymentMode === 'e_wallet') {
                // Logic for e-wallet payment
                closeModal('checkoutModal');
                // Show e-wallet modal here (if implemented)
            } else if (paymentMode === 'credit_card') {
                // Logic for credit card payment
                closeModal('checkoutModal');
                // Show credit card modal here (if implemented)
            }
        }

        // Function to process payment
        function processPayment() {
            handlePaymentModeChange();
        }

        // Function to close a modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        // Attach event listener to dynamically update Net Amount, Tax, and Amount Payable
        document.addEventListener('DOMContentLoaded', function () {
            // Listen for quantity changes and update the checkout modal dynamically
            document.querySelectorAll('.quantity').forEach(input => {
                input.addEventListener('change', function () {
                    const transactionId = this.getAttribute('data-id');
                    const newQuantity = this.value;

                    // Update quantity using AJAX
                    updateQuantity(transactionId, newQuantity, this);
                });
            });

            function updateQuantity(transactionId, quantity, inputElement) {
                fetch(`/transactions/${transactionId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ quantity: quantity }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update UI dynamically
                            document.querySelector('.price').textContent = `₱${parseFloat(data.net_amount).toFixed(2)}`;
                            document.querySelector('.taxx').textContent = `₱${parseFloat(data.tax).toFixed(2)}`;
                            document.querySelector('.tot').textContent = `₱${parseFloat(data.amount_payable).toFixed(2)}`;

                            // Also update the modal's amount payable if it's open
                            const amountPayableInput = document.getElementById('amountPayable');
                            if (amountPayableInput) {
                                amountPayableInput.value = `₱${parseFloat(data.amount_payable).toFixed(2)}`;
                            }
                        } else {
                            alert(data.message || 'Error updating quantity.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
        // // Function to show the checkout modal
        // function showCheckoutModal() {
        //     // Fetch the latest amount payable dynamically
        //     const amountPayableElement = document.querySelector('.tot');
        //     const amountPayable = "₱{{ number_format($amount_payable, 2) }}";
        //   document.getElementById('amountPayable').value = amountPayable; // Set dynamic value here
        //   document.getElementById('checkoutModal').style.display = 'flex';
        // }

        // // Function to handle payment mode change
        // function handlePaymentModeChange() {
        // const paymentMode = document.getElementById('paymentMode').value;
        //     if (paymentMode === 'cash') {
        //         document.getElementById('totalAmount').value = document.getElementById('amountPayable').value;
        //         closeModal('checkoutModal');
        //         document.getElementById('cashPaymentModal').style.display = 'flex';
        //     } else if (paymentMode === 'e-wallet') {
        //         // Logic for e-wallet payment (if needed)
        //         closeModal('checkoutModal');
        //         // Display e-wallet modal here
        //     } else if (paymentMode === 'credit card') {
        //         // Logic for credit card payment (if needed)
        //         closeModal('checkoutModal');
        //         // Display credit card modal here
        //     }
        // }  
        
        // // Function to process payment
        // function processPayment() {
        //     handlePaymentModeChange();
        // }

        // // Function to close the checkout modal
        // function closeModal(modalId) {
        //   document.getElementById(modalId).style.display = 'none';
        // }
    </script>

    <!-- Cash Payment Modal -->
    <div id="cashPaymentModal" class="modal">
    <div class="modal-content">
        <h2>Cash Payment</h2>

        <p>Total Amount:</p>
        <input type="text" id="totalAmount" readonly>

        <p>Discount %:</p>
        <input type="number" id="discount" placeholder="Enter discount (%)" step="0.01">

        <p>Discounted Amount</p>
        <input type="text" id="discountedAmount" readonly>

        <p>Cash Amount:</p>
        <input type="number" id="cashAmount" placeholder="Enter cash amount">

        <p>Customer Change:</p>
        <input type="text" id="customerChange" readonly>

        <!-- Hidden input for transaction_id -->
        <input type="hidden" id="transactionId" value="{{ csrf_token() }}">

        <button onclick="returnToCheckoutModal()">Return</button>
        <button id="confirmPayment" onclick="confirmCashPayment()">Confirm Cash Payment</button>   
    </div>
    </div>

    <script>
        // Function to calculate and display the discounted amount
        function updateDiscountedAmount() {
            const totalAmount = parseFloat(document.getElementById('totalAmount').value.replace(/₱|,/g, ''));
            const discount = parseFloat(document.getElementById('discount').value) || 0; // Default to 0 if discount is not entered
        
            // Check if totalAmount is a valid number
            if (!isNaN(totalAmount)) {
                // Apply the discount as a decimal (e.g., 10 becomes 0.10)
                const discountedAmount = totalAmount - (totalAmount * (discount / 100));
            
                // Update the discounted amount field
                document.getElementById('discountedAmount').value = "₱" + discountedAmount.toFixed(2);
            } else {
                document.getElementById('discountedAmount').value = "₱0.00"; // Default value if input is invalid
            }
        }
        
        // Function to update customer change automatically
        function updateCustomerChange() {
            const cashAmount = parseFloat(document.getElementById('cashAmount').value);
            const totalAmount = parseFloat(document.getElementById('totalAmount').value.replace(/₱|,/g, ''));
            const discount = parseFloat(document.getElementById('discount').value) || 0; // Default to 0 if discount is not entered
        
            // Check if values are valid numbers
            if (!isNaN(cashAmount) && !isNaN(totalAmount)) {
                // Calculate the discounted amount
                const discountedAmount = totalAmount - (totalAmount * (discount / 100));
                
                // Calculate the change
                const change = cashAmount - discountedAmount;
            
                // Update the customer change field
                document.getElementById('customerChange').value = change >= 0 ? "₱" + change.toFixed(2) : "₱0.00";
            } else {
                document.getElementById('customerChange').value = "₱0.00"; // Default value if input is invalid
            }
        }
        
        // Add event listeners to update the fields when relevant inputs change
        document.getElementById('discount').addEventListener('input', () => {
            updateDiscountedAmount();
            updateCustomerChange();
        });
        document.getElementById('cashAmount').addEventListener('input', updateCustomerChange);
        document.getElementById('totalAmount').addEventListener('input', () => {
            updateDiscountedAmount();
            updateCustomerChange();
        });
        // // Function to update customer change automatically
        // function updateCustomerChange() {
        //     const cashAmount = parseFloat(document.getElementById('cashAmount').value);
        //     const totalAmount = parseFloat(document.getElementById('totalAmount').value.replace(/₱|,/g, ''));
        //     const discount = parseFloat(document.getElementById('discount').value) || 0; // Get the discount value, default to 0 if not entered
        
        //     // Check if both values are valid numbers
        //     if (!isNaN(cashAmount) && !isNaN(totalAmount)) {
        //         // Apply the discount as a decimal (e.g., 10 becomes 0.10)
        //         const discountedAmount = totalAmount - (totalAmount * (discount / 100));
            
        //         const change = cashAmount - discountedAmount;
            
        //         // Update the customer change field
        //         document.getElementById('customerChange').value = change >= 0 ? "₱" + change.toFixed(2) : "₱0.00";
        //     } else {
        //         document.getElementById('customerChange').value = "₱0.00"; // Default value if input is invalid
        //     }
        // }

        // // Add event listener to update change when cash amount changes
        // document.getElementById('cashAmount').addEventListener('input', updateCustomerChange);

        // Function to return to the checkout modal from the cash payment modal
        function returnToCheckoutModal() {
            document.getElementById('cashPaymentModal').style.display = 'none';
            document.getElementById('checkoutModal').style.display = 'flex';
        }

        // Function to confirm cash payment and display receipt modal
        function confirmCashPayment() {
            console.log("confirmCashPayment called"); // Check if this logs
        
            const cashAmount = parseFloat(document.getElementById('cashAmount').value);
            const totalAmount = parseFloat(document.getElementById('totalAmount').value.replace(/₱|,/g, '')); // Remove currency symbol and commas
            const discount = parseFloat(document.getElementById('discount').value) || 0; // Get the discount value, default to 0 if not entered
        
            // Validate if the cash amount is valid and sufficient
            if (isNaN(cashAmount) || cashAmount < 0) {
                alert("Please enter a valid cash amount.");
                return;
            }

            // Apply the discount as a decimal (e.g., 10 becomes 0.10)
            const discountedAmount = totalAmount - (totalAmount * (discount / 100));
        
            if (cashAmount < discountedAmount) {
                alert("Insufficient cash amount. Please enter a valid amount.");
                return;
            }
        
            const change = cashAmount - discountedAmount;
            alert("Payment successful with cash amount: ₱" + cashAmount.toFixed(2) + ". Change: ₱" + change.toFixed(2));
        
            // Hide the cash payment modal and show the receipt modal
            document.getElementById('cashPaymentModal').style.display = 'none';
        
            // Populate the receipt modal with transaction data
            console.log("Populating receipt modal...");
            populateReceiptModal();
        
            // Show the receipt modal
            console.log("Showing receipt modal...");
            document.getElementById('receiptModal').style.display = 'flex';

            // Event listener for Enter key
            document.getElementById('cashAmount').addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {  // Check if Enter key is pressed
                    event.preventDefault();  // Prevent the default action (form submission, etc.)
                    confirmCashPayment();    // Call the confirmCashPayment function
                }
            });
        }

        // Function to populate the receipt modal with transaction data
        function populateReceiptModal() {
            console.log("Populating receipt modal...");
        
            // Make an AJAX request to get the transaction data
            fetch('/api/getTransaction')  // Assuming an endpoint that returns transaction data
                .then(response => response.json())
                .then(data => {
                    const receiptItemsTableBody = document.getElementById('receiptItems');
                
                    if (receiptItemsTableBody) {
                        receiptItemsTableBody.innerHTML = ''; // Clear existing rows
                    
                        // Loop through the transactions and add them to the table
                        data.transactions.forEach(transaction => {
                            const row = document.createElement('tr');
                            row.innerHTML = ` 
                                <td class="item-quantity">${transaction.quantity}</td>
                                <td class="item-name">${transaction.item_name}</td>
                                <td class="item-unit-price">₱${parseFloat(transaction.unit_price).toFixed(2)}</td>
                                <td class="item-total">₱${parseFloat(transaction.total_price).toFixed(2)}</td>
                            `;
                            receiptItemsTableBody.appendChild(row);
                        });
                    } else {
                        console.error("Receipt items table body element not found.");
                    }
                
                    // Totals Calculation
                    const netAmount = data.transactions.reduce((acc, transaction) => acc + parseFloat(transaction.total_price), 0);
                    const tax = 0.01 * netAmount; // 1% tax
                    const discount = parseFloat(document.getElementById('discount').value) || 0;
                    const amountPayable = (netAmount + tax) - (netAmount * (discount / 100)); // Apply discount as decimal
                    const cashAmount = parseFloat(document.getElementById('cashAmount').value);
                    const change = cashAmount - amountPayable;
                
                    // Populate receipt totals
                    document.getElementById('receiptNetAmount').textContent = `₱${netAmount.toFixed(2)}`;
                    document.getElementById('receiptTax').textContent = `₱${tax.toFixed(2)}`;
                    document.getElementById('receiptDiscount').textContent = `${(discount).toFixed(2)}%`; // Display discount as percentage
                    document.getElementById('receiptAmountPayable').textContent = `₱${amountPayable.toFixed(2)}`;
                    document.getElementById('receiptCashAmount').textContent = `₱${cashAmount.toFixed(2)}`;
                    document.getElementById('receiptChange').textContent = `₱${change.toFixed(2)}`;
                })
                .catch(error => {
                    console.error('Error fetching transaction data:', error);
                });
        }
    </script>

    <!-- Receipt Modal -->
    <div id="receiptModal" class="receipt_modal" style="display:none;">
        <div class="receipt-modal-content">

             <!-- Close Button -->
        <span style="cursor: pointer;" id="receipt-close-btn" class="no-print" onclick="receiptcloseModal('receiptModal')">&times;</span>

            <div class="receipt-scrollable">
                <!-- Receipt Header -->
                <div class="receipt-header">
                    <h2>ABC Company</h2>
                    <p>123 Main St, City, Country</p>
                    <p>Reference No: <span id="receiptReferenceNo">{{ isset($reference_no) ? $reference_no : 'N/A' }}</span></p>
                    <p>Date: <span id="receiptDateTime">{{ $currentDate }}</span></p>
                    <p>Cashier: <span id="receiptCashierName">{{ session('cashier_name') ? session('cashier_name') : 'Guest' }}</span></p>
                </div>
            
                <!-- Receipt Table -->
                <table class="receipt-table">
                    <thead>
                        <tr>
                            <th>Qty</th>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="receiptItems">
                        <!-- Rows will be populated by JavaScript -->
                    </tbody>
                </table>
            
                <!-- Receipt Totals -->
                <div class="receipt-totals">
                    <p>Net Amount: <span id="receiptNetAmount">₱0.00</span></p>
                    <p>Tax: <span id="receiptTax">₱0.00</span></p>
                    <p>Discount: <span id="receiptDiscount">0.00</span></p>
                    <p>Amount Payable: <span id="receiptAmountPayable">₱0.00</span></p>
                    <p>Cash Amount: <span id="receiptCashAmount">₱0.00</span></p>
                    <p>Change: <span id="receiptChange">₱0.00</span></p>
                </div>
            
                <!-- Receipt Footer -->
                <div id="receipt-footer">
                    <p>Thank you for shopping with us.</p>
                    <p>We are happy to serve you!!!</p>
                </div>
            </div>
        
            <!-- Modal Actions -->
            <div class="receipt-modal-actions">
                <button id="print-receipt" class="no-print" onclick="printReceipt()">Print Receipt</button>
                <button id="done-receipt" class="no-print" onclick="closeModal('receiptModal')">Done</button>
            </div>
        </div>
    </div>

    <script>
        // Function to save receipt data to the database
        function saveReceipt() {
            console.log("Starting to save receipt...");

            // Get the CSRF token from the meta tag
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
            // Gather receipt data from modal
            const items = [];
            document.querySelectorAll('#receiptItems tr').forEach(row => {
                // Check if row and its cells exist
                const itemNameCell = row.querySelector('.item-name');
                const quantityCell = row.querySelector('.item-quantity');
                const unitPriceCell = row.querySelector('.item-unit-price');
                const totalPriceCell = row.querySelector('.item-total');
            
                // Log each row to see if it's being processed
                console.log("Processing row:", row);
            
                if (itemNameCell && quantityCell && unitPriceCell && totalPriceCell) {
                    const item = {
                        item_name: itemNameCell.textContent.trim(),
                        quantity: parseInt(quantityCell.textContent.trim()) || 0,
                        unit_price: parseFloat(unitPriceCell.textContent.trim().replace('₱', '')) || 0,
                        total_price: parseFloat(totalPriceCell.textContent.trim().replace('₱', '')) || 0,
                    };
                    console.log("Item processed:", item); // Log each item
                    items.push(item);
                } else {
                    console.log("Missing data in row, skipping:", row);
                }
            });
        
            // Log the gathered items
            console.log("Items gathered:", items);
        
            // Check if items array is empty
            if (items.length === 0) {
                console.log("No items found, aborting save.");
                return; // Stop execution if no items are found
            }
            const referenceNo = document.getElementById('receiptReferenceNo').textContent.trim();
            const cashierName = document.getElementById('receiptCashierName').textContent.trim();
            const netAmount = parseFloat(document.getElementById('receiptNetAmount').textContent.replace('₱', ''));
            const tax = parseFloat(document.getElementById('receiptTax').textContent.replace('₱', ''));
            const discount = parseFloat(document.getElementById('receiptDiscount').textContent.replace('₱', ''));
            const amountPayable = parseFloat(document.getElementById('receiptAmountPayable').textContent.replace('₱', ''));
            const changeAmount = parseFloat(document.getElementById('receiptChange').textContent.replace('₱', ''));
            const cashAmount = parseFloat(document.getElementById('receiptCashAmount').textContent.replace('₱', ''));
        
            // Log the values before sending to the server
            console.log("Receipt details:");
            console.log("Reference No:", referenceNo);
            console.log("Cashier:"), cashierName;
            console.log("Net Amount:", netAmount);
            console.log("Tax:", tax);
            console.log("Discount:", discount);
            console.log("Amount Payable:", amountPayable);
            console.log("Change Amount:", changeAmount);
            console.log("Cash Amount:", cashAmount);
        
            // Send data via AJAX to save in the database
            fetch('/saveReceipt', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    reference_no: referenceNo,
                    cashier_name: cashierName,
                    items: items,
                    net_amount: netAmount,
                    tax: tax,
                    discount: discount,
                    amount_payable: amountPayable,
                    change_amount: changeAmount,
                    cash_amount: cashAmount,
                })
            })
            .then(response => {
                // Log the response as text
                console.log("Full response:", response);
            
                // Check if the response is not JSON, which might indicate an error page
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error("Error page returned:", text);
                        throw new Error('Server returned an error page');
                    });
                }
            
                // Parse JSON if it's a valid response
                return response.json();
            })
            .then(data => {
                console.log("Response from server:", data);
                if (data.status === 'success') {
                    alert(data.message);  // Notify the user after saving
                    window.location.reload();  // Reload the page after successful save and clear
                } else {
                    alert('Failed to save receipt. Please try again.');
                }
            })
            .catch(error => {
                console.error("Error during save:", error);
            });
        }

        // Function to close the modal and save receipt automatically
        function closeModal(modalId) {
            saveReceipt();  // Call saveReceipt function when closing the modal
            console.log("Closing modal...");
            document.getElementById(modalId).style.display = 'none';
        }

        // Function to print the receipt
         // Function to print the receipt
         function printReceipt() {
                // Hide elements that should not be printed
                document.body.style.visibility = 'hidden';
                document.getElementById('receiptModal').style.visibility = 'visible';

                window.print();

                // Restore the visibility of the page after printing
                document.body.style.visibility = 'visible';
            }
        function receiptcloseModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
    </script>    
    </section>

    {{--------------------------------------------------------- THIS --------------------------------------------------------------------}}
    {{---------------------------------------------------------- IS ---------------------------------------------------------------------}}
    {{------------------------------------------------------- SECTION 3 -----------------------------------------------------------------}}
    <section id="sec3" class="product-section">
        <div class="history">
            <!-- Header Section -->
                <div class="history-header" style="margin-top: 20px;">
                    <h2 class="history-header">Sales History</h2>
                </div>

                <!-- Search Section -->
                <div style="display: flex; justify-content: space-between;">
                    <div class="search-section" style="display: flex; margin-top: -10px; gap: 10px; padding: 20px; flex-direction: column;">
                        <input type="text" id="searchReference" placeholder="Search by Reference No" class="search-bar" style="padding: 5px;">
                        <input type="date" id="searchDate" class="search-bar" style="padding: 5px;">
                        <script>
                           // Function to filter table rows based on selected date
                            document.getElementById('searchDate').addEventListener('input', function() {
                                filterTable();
                            });

                            // Function to filter table rows based on search input
                            document.getElementById('searchReference').addEventListener('input', function() {
                                filterTable();
                            });

                            // Function to filter the table based on both date and reference number
                            function filterTable() {
                                const selectedDate = document.getElementById('searchDate').value; // Get selected date in YYYY-MM-DD format
                                const searchQuery = document.getElementById('searchReference').value.toLowerCase(); // Get search reference text
                                const rows = document.querySelectorAll('.transaction-row');

                                rows.forEach(row => {
                                    const transactionDate = row.querySelector('td:nth-child(2)').textContent.trim(); // Get the timestamp (date) from the second column
                                    const rowDate = transactionDate.split(' ')[0]; // Extract the date (ignore time)

                                    const referenceNo = row.querySelector('td:nth-child(1)').textContent.trim().toLowerCase(); // Get the reference number from the first column

                                    // Apply both filters: date and reference number
                                    if ((selectedDate === '' || rowDate === selectedDate) && (searchQuery === '' || referenceNo.includes(searchQuery))) {
                                        row.style.display = ''; // Show row if both conditions match
                                    } else {
                                        row.style.display = 'none'; // Hide row if either condition doesn't match
                                    }
                                });
                            }
                        </script>
                    </div>
                </div>

                <!-- History Content -->
                <div class="history-content" style="max-height: 800px;">
                        <!-- Products Table for Each Transaction -->
                        @php
                            // Group histories by reference_no
                            $groupedHistories = $histories->groupBy('reference_no');
                        @endphp

                        <table class="history-table" style="width: 100%; border-collapse: collapse; margin-top: -20px; padding-top: 20px;">
                            <thead>
                                <tr style="background-color: #f2f2f2;">
                                    <th style="border: 1px solid #ccc; padding: 8px;">Reference No</th>
                                    <th style="border: 1px solid #ccc; padding: 8px;">Date</th>
                                    <th style="border: 1px solid #ccc; padding: 8px;">Items</th>
                                    <th style="border: 1px solid #ccc; padding: 8px;">Amount Payable</th>
                                    <th style="border: 1px solid #ccc; padding: 8px;">Cash Amount</th>
                                    <th style="border: 1px solid #ccc; padding: 8px;">Change</th>
                                    <th style="border: 1px solid #ccc; padding: 8px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="transactionTableBody">
                                @foreach ($groupedHistories as $referenceNo => $transactionProducts)
                                    <!-- Transaction Header Row -->
                                    <tr style="background-color: #f9f9f9;" class="transaction-row" data-reference-no="{{ $referenceNo }}">
                                        <td style="border: 1px solid #ccc;">{{ $referenceNo }}</td>
                                        <td style="border: 1px solid #ccc;">{{ $transactionProducts->first()->timestamp}}</td>
                                        <td style="border: 1px solid #ccc;">
                                            <!-- List of product names -->
                                            <ul style="list-style: none; padding-left: 0; margin: 0; height: 100px; overflow-y: auto; display: block;">
                                                @foreach ($transactionProducts as $product)
                                                    <li>{{ $product->item_name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td style="border: 1px solid #ccc;">₱{{ number_format($transactionProducts->first()->amount_payable, 2) }}</td>
                                        <td style="border: 1px solid #ccc;">₱{{ number_format($transactionProducts->first()->cash_amount, 2) }}</td>
                                        <td style="border: 1px solid #ccc;">₱{{ number_format($transactionProducts->first()->change_amount, 2) }}</td>
                                        <!-- Action Column with "See Details" Button -->
                                        <td style="border: 1px solid #ccc; text-align: center;">
                                            
                                            <!-- Modal HTML Structure -->
                                            <div id="transactionDetailsModal" class="modal custom-modal">
                                                <div class="modal-content">
                                                    <span class="close-btn">&times;</span>
                                                    <h2>Transaction Details</h2>
                                                    <div id="historyDetails"></div>
                                                
                                                    <h3>Detailed Product List for the Transaction</h3>
                                                    <table id="productDetailsTable" style="width: 100%; border-collapse: collapse;">
                                                        <thead>
                                                            <tr style="background-color: #eaeaea;">
                                                                <th style="border: 1px solid #ccc; padding: 8px; color:black;">Product Name</th>
                                                                <th style="border: 1px solid #ccc; padding: 8px; color:black;">Quantity</th>
                                                                <th style="border: 1px solid #ccc; padding: 8px; color:black;">Unit Price</th>
                                                                <th style="border: 1px solid #ccc; padding: 8px; color:black;">Total Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <button class="see-details-btn" id="see-details-{{ $referenceNo }}" data-reference-no="{{ $referenceNo }}">
                                                See Details
                                            </button>
                                            <script>
                                                let isModalOpen = false;    
                                                document.addEventListener('click', function(event) {
                                                    // Check if the clicked element is a "See Details" button and the modal is not already open
                                                    if (event.target.classList.contains('see-details-btn')) {
                                                        var referenceNo = event.target.getAttribute('data-reference-no');

                                                        // Fetch transaction details for the clicked reference number
                                                        fetch(`/get-transaction-details/${referenceNo}`)
                                                            .then(response => {
                                                                if (!response.ok) {
                                                                    throw new Error('Failed to fetch transaction details');
                                                                }
                                                                return response.json();
                                                            })
                                                            .then(data => {
                                                                // Populate modal with transaction details
                                                                var modal = document.getElementById('transactionDetailsModal');
                                                                var transactionDetailsContainer = document.getElementById('historyDetails');
                                                                var productDetailsTable = document.getElementById('productDetailsTable').getElementsByTagName('tbody')[0];

                                                                // Clear previous details
                                                                transactionDetailsContainer.innerHTML = '';
                                                                productDetailsTable.innerHTML = '';

                                                                // Add transaction details
                                                                transactionDetailsContainer.innerHTML = `
                                                                    <div class="historydetailscolumn">
                                                                        <p><strong>Reference ID:</strong> ${data.reference_no}</p>
                                                                        <p><strong>Timestamp:</strong> ${data.timestamp}</p>
                                                                        <p><strong>Net Amount:</strong> ₱${data.net_amount}</p>
                                                                        <p><strong>Tax:</strong> ₱${data.tax}</p>
                                                                        <p><strong>Discount %:</strong>${data.discount}</p>
                                                                    </div>
                                                                    <div class="historydetailscolumn2">
                                                                        <p><strong>Amount Payable:</strong> ₱${data.amount_payable}</p>
                                                                        <p><strong>Cash Amount:</strong> ₱${data.cash_amount}</p>
                                                                        <p><strong>Change:</strong> ₱${data.change_amount}</p>
                                                                        <p><strong>Cashier Name:</strong> ${data.cashier_name}</p>
                                                                    </div>
                                                                `;

                                                                // Add product details to the table
                                                                data.products.forEach(product => {
                                                                    var row = productDetailsTable.insertRow();
                                                                    row.innerHTML = `
                                                                        <td style="border: 1px solid #ccc; padding: 8px;">${product.item_name}</td>
                                                                        <td style="border: 1px solid #ccc; padding: 8px;">${product.quantity}</td>
                                                                        <td style="border: 1px solid #ccc; padding: 8px;">₱${product.unit_price}</td>
                                                                        <td style="border: 1px solid #ccc; padding: 8px;">₱${product.total_price}</td>
                                                                    `;
                                                                });

                                                                // Show the modal
                                                                modal.style.display = 'block';
                                                            })
                                                            .catch(error => {
                                                                console.error('Error fetching transaction details:', error);
                                                                alert('Failed to fetch transaction details. Please try again.');
                                                            });
                                                    }
                                                });

                                                // Close modal when clicking the 'X' button
                                                document.querySelector('.close-btn').addEventListener('click', function() {
                                                    document.getElementById('transactionDetailsModal').style.display = 'none';
                                                });

                                                // Close modal if user clicks outside of it
                                                window.addEventListener('click', function(event) {
                                                    var modal = document.getElementById('transactionDetailsModal');
                                                    if (event.target === modal) {
                                                        modal.style.display = 'none';
                                                    }
                                                });
                                            </script>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                <div>
                    <button class="return-btn" style="margin-top: -10px; margin-right: 20px;">Return</button>
                </div>
            </div>
        </div>
    </section>



    {{--------------------------------------------------------- THIS --------------------------------------------------------------------}}
    {{---------------------------------------------------------- IS ---------------------------------------------------------------------}}
    {{------------------------------------------------------- SECTION 4 -----------------------------------------------------------------}}
    <section id="sec4" class="product-section">
        <div class="settings">
            {{-- <p class="dash">SALE</p> --}}
            <div class="sec4-div">
                <div class="div-1">
                    <div class="div1-buttons">
                        <div class="salesperday-btn">
                            <a href="/salesperday">Sales per Day</a>
                        </div>
                        <div class="salesperday-btn">
                            <a href="/cashiersales">Sales per Cashier</a>
                        </div>
                        <div class="salesperday-btn">
                            <a href="/stockstatus">Stocks Status</a>
                        </div>
                        <div class="salesperday-btn">
                            <button class="addCategory">Add Category</button>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Get elements
                            const modal = document.getElementById('addCategoryModal');
                            const openModalBtn = document.querySelector('.addCategory');
                            const closeModalBtn = document.querySelector('.closeAddCategory');

                            // Open the modal when the button is clicked
                            openModalBtn.addEventListener('click', function () {
                                modal.style.display = 'flex';
                            });
                        
                            // Close the modal when the close button is clicked
                            closeModalBtn.addEventListener('click', function () {
                                modal.style.display = 'none';
                            });
                        
                            // Close the modal if the user clicks outside of the modal content
                            window.addEventListener('click', function (event) {
                                if (event.target === modal) {
                                    modal.style.display = 'none';
                                }
                            });
                        });
                    </script>
                    {{-- <div class="salesperday-btn">
                        <button class="editTaxRate">Edit Tax</button>
                    </div> --}}
                    {{-- <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Get elements
                            const modal = document.getElementById('editTaxRateModal');
                            const openModalBtn = document.querySelector('.editTaxRate');
                            const closeModalBtn = document.querySelector('.closeEditTaxRate');

                            // Open the modal when the button is clicked
                            openModalBtn.addEventListener('click', function () {
                                modal.style.display = 'flex';
                            });
                        
                            // Close the modal when the close button is clicked
                            closeModalBtn.addEventListener('click', function () {
                                modal.style.display = 'none';
                            });
                        
                            // Close the modal if the user clicks outside of the modal content
                            window.addEventListener('click', function (event) {
                                if (event.target === modal) {
                                    modal.style.display = 'none';
                                }
                            });
                        });
                    </script> --}}







                    
                    <!-- Modal for Adding Category -->
                    <div id="addCategoryModal" class="modal">
                        <div class="modal-content">
                            <span class="closeAddCategory">&times;</span>
                            <h2>Add New Category</h2>
                            <form id="categoryForm" action="{{ route('category.save') }}" method="POST">
                                {{ csrf_field() }} <!-- CSRF Token -->
                                <label for="categoryName">Category Name</label>
                                <input type="text" id="categoryName" name="category" required>
                                <button type="submit">Save Category</button>
                            </form>
                        </div>
                    </div>

                    <!-- Modal for Editing Tax -->
                    {{-- <div id="editTaxRateModal" class="modal">
                        <div class="modal-content">
                            <span class="closeEditTaxRate">&times;</span>
                            <h2>Edit Tax Rate Here</h2>
                            <form id="taxRateForm" action="{{ route('tax.rate.update') }}" method="POST">
                                {{ csrf_field() }} 
                                <input type="hidden" name="_method" value="PUT">
                                
                                <label for="taxRateValue">Tax Value %</label>
                                <input type="text" id="taxRateValue" name="taxRate" value="{{ old('taxRate', $currentTaxRate) }}" required>
                                <button type="submit">Save Changes</button>
                            </form>
                        </div>
                    </div> --}}

                    <!-- Display Totals Section -->
                    <div class="totals-section">
                        <h2>Statistics</h2>
                        <div class="totals">
                            <div class="totals-box">
                                <p>Total Cashiers</p>
                                <strong>{{ isset($totalCashiers) ? $totalCashiers : 0 }}</strong>
                            </div>
                            <div class="totals-box">
                                <p>Total Products</p>
                                <strong>{{ isset($totalProducts) ? $totalProducts : 0 }}</strong>
                            </div>
                            <div class="totals-box">
                                <p>Total Transactions Today</p>
                                <strong>{{ isset($totalTransactionsToday) ? $totalTransactionsToday : 0 }}</strong>
                            </div>
                            <div class="totals-box">
                                <p>Total Amount Sold Today</p>
                                <strong>₱{{ number_format(isset($totalAmountSoldToday) ? $totalAmountSoldToday : 0, 2) }}</strong>
                            </div>
                            <div class="totals-box">
                                <p>Total Transactions This Month</p>
                                <strong>{{ isset($totalTransactionsThisMonth) ? $totalTransactionsThisMonth : 0 }}</strong>
                            </div>
                            <div class="totals-box">
                                <p>Total Amount Sold This Month</p>
                                <strong>₱{{ number_format(isset($totalAmountSoldThisMonth) ? $totalAmountSoldThisMonth : 0, 2) }}</strong>
                            </div>
                            <div class="totals-box">
                                <p>Overall Total Transactions</p>
                                <strong>{{ isset($overallTotalTransactions) ? $overallTotalTransactions : 0 }}</strong>
                            </div>
                            <div class="totals-box">
                                <p>Overall Total Amount Sold</p>
                                <strong>₱{{ number_format(isset($overallTotalAmountSold) ? $overallTotalAmountSold : 0, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>











    {{-- //sEARCH SCRIPT


    //document.querySelector('input[name="query"]').addEventListener('input', function() {
    //        document.getElementById('search-form').submit();
//    });
//Add and edit modal script
//$('.edit-button').on('click', function() {
//const productId = $(this).data('id');
//$('#product_id').val(productId);
// Set other fields similarly
//$('#productForm').attr('action', '{{ url('products/update') }}/' + productId);
//$('#productModal').show();  Or whatever function you use to show the modal
//}); --}}

<script>
$(document).ready(function() {
    // Update pagination links to include the hash for the first page only
    $('.pagination a').each(function() {
        const href = $(this).attr('href');
        if (href && window.location.pathname === this.pathname) { // Check if on the same page
            $(this).attr('href', href + '#sec1');
        }
    });
    
    // If the current page is loaded with a hash, ensure it stays
    if (window.location.hash) {    
        $('html, body').animate({
             scrollTop: $(window.location.hash).offset().top
        }, 500);
    }

    // Smooth scrolling for section links (excluding pagination links)
    $("a").on('click', function(event) {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "" && !$(this).closest('.pagination').length) { // Exclude pagination links
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function() {
                // Add hash (#) to URL when done scrolling
                window.location.hash = hash;
            });
        }
    });

    // Stop smooth scrolling for pagination links
    $('.pagination a').on('click', function(event) {
        // Prevent default scroll behavior
        event.preventDefault();
        // Redirect to the pagination link directly
        window.location.href = $(this).attr('href');
    });
});

 //Delete script
 function confirmDelete(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        // Get the form and submit it
        document.getElementById('delete-form-' + productId).submit();
    }
}

</script>

{{-- /////////////////////=========SECTION 3 SCRIPT=========///////////////////// --}}


{{-- /////////////////////=========NOTIF SCRIPT=========///////////////////// --}}
<script>
        document.addEventListener("DOMContentLoaded", function() {
        const alert = document.getElementById('successAlert');
        if (alert) {
            // Remove the alert after the animation (5s) is complete
            setTimeout(() => {
                alert.remove();
            }, 3000); // Match animation duration
        }
    });
</script>


{{-- /////////////////////=========SEARCH PRODUCTS SCRIPT=========///////////////////// --}}

{{-- /////////////////////=========PREVENT EVERY SECTION FROM SCROLLING SCRIPT=========///////////////////// --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Disable scrolling by setting body overflow to hidden
    document.body.style.overflow = "hidden";

    // Get all navigation links
    const navLinks = document.querySelectorAll(".nav-link");

    // Add click event listener to each link
    navLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default anchor behavior

            // Get the target section from the data attribute
            const target = document.querySelector(this.dataset.target);

            // Scroll to the target section
            target.scrollIntoView({ behavior: "smooth" });
        });
    });
});
</script>

</body>
</html>