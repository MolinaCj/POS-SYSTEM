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
    <header class="header">
        @if(session('success'))
        <div class="alert alert-success"  id="successAlert">
        {{ session('success') }}
        </div>
        @endif

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
                    <img class="img" src="images/itemlist.png" alt="">
                    <a class="txt-1" href="#sec1">ITEM LIST</a>
                </div>
                <div class="opt">
                    <img class="img" src="images/transac.png" alt="">
                    <a class="txt-1" href="#sec2">SALES</a>
                </div>
                <div class="opt">
                    <img class="img" src="images/settings.png" alt="">
                    <a class="txt-1" href="#sec3">SALES HISTORY</a>
                </div>
                <div class="opt">
                    <img class="img" src="images/dashboard.png" alt="">
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
    <section id="sec1" class="section-1">
        <div class="item-list">
            <div class="cashier">
                <h1 class="cashier-1">List of Products</h1>
                        <div class="ewan">
                            <input id="search-1" class="srch-1" type="text" name="firstQuery" placeholder="Search by code or product" required>
                        </div>
            </div>
            <div class="cont-2">
                <div class="tbl">
                    <!-- Add Product Button -->
                    <a href="javascript:void(0)#sec1;" id="addProductButton">
                        <button class="add-product">Add Product</button>
                    </a>
                    <table id="product-table">
                            <tr>
                                <th style="width: 40px;">No.</th>
                                <th style="width: 100px;">Barcode</th>
                                <th>Product Name</th>
                                <th>Stocks</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th style="width: 50px;">Actions</th>
                            </tr> 
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->barcode }}</td>
                                <td>{{ $product->item_name }}</td>
                                <td>{{ $product->stocks }}</td>
                                <td>
                                    {{-- <input class="quantity" type="number" name="quantity[{{ $product->id }}]" value="1" min="1" style="width: 50px;" onchange="updateHiddenQuantity(this)"> --}}
                                    <input class="quantity" type="number" name="quantity[{{ $product->id }}]" value="1" min="1" style="width: 50px;" onchange="updateHiddenQuantity(this, {{ $product->id }})">
                                </td>
                                {{-- <td>{{ $product->quantity}}</td> --}}
                                <td>{{ $product->price }}</td>
                                <td style="display: flex;">
                                    <!-- Edit Button -->
                                        <a href="javascript:void(0);" class="edit-button"
                                        data-id="{{ $product->id }}" 
                                        data-barcode="{{ $product->barcode }}" 
                                        data-name="{{ $product->item_name }}" 
                                        data-stocks="{{ $product->stocks }}" 
                                        data-price="{{ $product->price }}"
                                        data-category="{{ $product->category }}">
                                        <button class="edit">Edit</button>
                                        </a>
                                    <!-- Delete Form -->
                                    <form action="{{ route('products.destroy', $product->id) }}#sec1" method="POST" style="display:inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="delete" type="submit" onclick="return confirm('Are you sure you want to delete this product?');"><img class="delIcon" src="images/delete.png" alt=""></button>
                                    </form>
                                    <form action="{{ route('addToTransac') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="item_name" value="{{ $product->item_name }}">
                                        <input type="hidden" name="quantity" value="1" min="1" data-product-id="{{ $product->id }}">
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
                    </table>

                    <ul class="pagination">
                        {{-- {{ $products->links() }} --}}
                        {{ $products->appends(request()->query())->links() }}
                    </ul>

                    <!-- Modal HTML -->
                        <div id="productModal" class="modal">
                            <div class="modal-content">
                                <span class="close" id="closeModal">&times;</span>
                                <h2 id="modalTitle">Add Product</h2>
                                <form id="productForm" action="{{ route('products.store') }}#sec1" method="POST">
                                    <input type="hidden" name="product_id" id="product_id" value="">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" id="methodField" value="POST">
                                    <div>
                                        <label for="barcode" >Barcode:</label>
                                        <input type="text" name="barcode" id="barcode">
                                    </div>
                                    <div>
                                        <label for="item_namep">Product Name:</label>
                                        <input type="text" name="item_name" id="item_namep">
                                    </div>
                                    <div>
                                        <label for="category">Category:</label>
                                        <select name="category" id="category">
                                            <option value="noodles">Noodles</option>
                                            <option value="bread">Bread</option>
                                            <option value="canned_goods">Canned Goods</option>
                                            <option value="hygiene">Hygiene</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="stocks">Stocks:</label>
                                        <input type="number" name="stocks" id="stocks" required min="0">
                                    </div>
                                    <div>
                                        <label for="pricep" >Price:</label>
                                        <input type="number" name="price" id="pricep" step="0.01" min="0" max="10000">
                                    </div>
                                    <button type="submit" id="submitProduct" form="productForm">Save</button>
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
                    <form action="{{ route('products.clear') }}#sec1" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="clear btn-danger" onclick="return confirm('Are you sure you want to clear all products?');"">Clear All</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{--------------------------------------------------------- THIS --------------------------------------------------------------------}}
    {{---------------------------------------------------------- IS ---------------------------------------------------------------------}}
    {{------------------------------------------------------- SECTION 2 -----------------------------------------------------------------}}
    <section id="sec2" class="section-2">
        <div class="item-list">
        <div class="cashier">
            <h1 class="cashier-1">Cashier 1</h1>
            <form action="" method="GET">
                <div class="ewan">
                    <input id="search-2" class="srch-2" type="text" name="query" placeholder="Search by code or product" required>
                    <div id="results" class="dropdown-results"></div>
                </div>
            </form>
        </div>
        <div class="cont-2">
            <div class="tbl">
                <div style="max-height: 600px; overflow-y: auto; display:block; width:100%;">
                    <table id="transaction-tbl border-collapse: collapse; border-spacing: 0;">
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
                                    <input class="quantity" type="number" name="quantity[{{ $product->id }}]" value="{{ $transaction->quantity }}" min="1" style="width: 50px">
                                </td>
                                <td style="margin: 0;">{{ $transaction->unit_price }}</td>
                                <td style="margin: 0;">{{ $transaction->total_price }}</td>
                                <td style="display: flex; margin:0;">
                                    <form action="">
                                        <button></button>
                                    </form> 
                                    <form action="{{ route('transactions.destroy', $transaction->transaction_id) }}#sec2" method="POST" style="display:inline;">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }} <!-- Use this method to specify the DELETE request -->
                                        <button class="delete btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this product?');"><img class="delIcon" src="images/delete.png" alt=""></button>
                                    </form>
                                </td>
                            </tr>
                            @php
                                $tax = .01 * $net_amount;
                                $amount_payable = $net_amount + $tax;
                            @endphp
                        @endforeach
                    </tbody>
                </table>     
                </div>         
            </div>
        <div class="cont-3">
            <div class="date-time">
                <p><input class="date" type="date"></p>
                <p><input class="time" type="time"></p>
            </div>
            <div class="button">
                <button class="scan btn-default">SCAN</button>
                <button class="payment" onclick="showCheckoutModal()">Proceed to Payment</button>
                <form action="{{ route('transactions.deleteAll') }}#sec2" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="deleteAll btn-danger" onclick="return confirm('Are you sure you want to clear all products?');"">Clear All</button>
                </form>
            </div>
            <div class="sub-tot">
                <div>
                    <div class="amount"><h1 class="sub">Net Amount</h1><p class="price">₱{{number_format($net_amount, 2)}}</p></div>
                    <div class="tax"><h1 class="tx">Tax</h1><p class="taxx">₱{{number_format($tax, 2)}}</p></div>
                </div>
                    <h1 class="total">Amount Payable:</h1>
                    <h3 class="tot">₱{{number_format($amount_payable, 2)}}</h3>
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
        <option value="e_wallet">E-Wallet</option>
        <option value="credit_card">Credit Card</option>
      </select>
      <button onclick="closeModal('checkoutModal')">Cancel</button>
      <button onclick="processPayment()">Proceed to Cash Payment</button> 
    </div>
    </div>

    <script>
        // Function to show the checkout modal
        function showCheckoutModal() {
            const amountPayable = "₱{{ number_format($amount_payable, 2) }}";
          document.getElementById('amountPayable').value = amountPayable; // Set dynamic value here
          document.getElementById('checkoutModal').style.display = 'flex';
        }

        // Function to handle payment mode change
        function handlePaymentModeChange() {
        const paymentMode = document.getElementById('paymentMode').value;
            if (paymentMode === 'cash') {
                document.getElementById('totalAmount').value = document.getElementById('amountPayable').value;
                closeModal('checkoutModal');
                document.getElementById('cashPaymentModal').style.display = 'flex';
            } else if (paymentMode === 'e-wallet') {
                // Logic for e-wallet payment (if needed)
                closeModal('checkoutModal');
                // Display e-wallet modal here
            } else if (paymentMode === 'credit card') {
                // Logic for credit card payment (if needed)
                closeModal('checkoutModal');
                // Display credit card modal here
            }
        }  
        
        // Function to process payment
        function processPayment() {
            handlePaymentModeChange();
        }

        // Function to close the checkout modal
        function closeModal(modalId) {
          document.getElementById(modalId).style.display = 'none';
        }
    </script>

    <!-- Cash Payment Modal -->
    <div id="cashPaymentModal" class="modal">
    <div class="modal-content">
        <h2>Cash Payment</h2>
        <p>Total Amount:</p>
        <input type="text" id="totalAmount" readonly>
        <p>Cash Amount:</p>
        <input type="number" id="cashAmount" placeholder="Enter cash amount">
        <p>Customer Change:</p>
        <input type="text" id="customerChange" readonly>

        <!-- Hidden input for transaction_id -->
        <input type="hidden" id="transactionId" value="{{ csrf_token() }}">

        <button onclick="returnToCheckoutModal()">Return</button>
        <button onclick="confirmCashPayment()">Confirm Cash Payment</button>
    </div>
    </div>

    <script>

       // Function to update customer change automatically
        function updateCustomerChange() {
            const cashAmount = parseFloat(document.getElementById('cashAmount').value);
            const totalAmount = parseFloat(document.getElementById('totalAmount').value.replace(/₱|,/g, ''));

            // Check if both values are valid numbers
            if (!isNaN(cashAmount) && !isNaN(totalAmount)) {
                const change = cashAmount - totalAmount;
                // Update the customer change field
                document.getElementById('customerChange').value = change >= 0 ? "₱" + change.toFixed(2) : "₱0.00";
            } else {
                document.getElementById('customerChange').value = "₱0.00"; // Default value if input is invalid
            }
        }

        // Add event listener to update change when cash amount changes
        document.getElementById('cashAmount').addEventListener('input', updateCustomerChange);

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

            // Validate if the cash amount is valid and sufficient
            if (isNaN(cashAmount) || cashAmount < 0) {
                alert("Please enter a valid cash amount.");
                return;
            }
        
            if (cashAmount < totalAmount) {
                alert("Insufficient cash amount. Please enter a valid amount.");
                return;
            }
        
            const change = cashAmount - totalAmount;
            alert("Payment successful with cash amount: ₱" + cashAmount.toFixed(2) + ". Change: ₱" + change.toFixed(2));

            // Hide the cash payment modal and show the receipt modal
            document.getElementById('cashPaymentModal').style.display = 'none';
        
            // Populate the receipt modal with transaction data
            console.log("Populating receipt modal...");
            populateReceiptModal();

            // Show the receipt modal
            console.log("Showing receipt modal...");
            document.getElementById('receiptModal').style.display = 'flex';
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
                                <td>${transaction.quantity}</td>
                                <td>${transaction.item_name}</td>
                                <td>₱${parseFloat(transaction.unit_price).toFixed(2)}</td>
                                <td>₱${parseFloat(transaction.total_price).toFixed(2)}</td>
                            `;
                            receiptItemsTableBody.appendChild(row);
                        });
                    } else {
                        console.error("Receipt items table body element not found.");
                    }

                    // Totals Calculation
                    const netAmount = data.transactions.reduce((acc, transaction) => acc + parseFloat(transaction.total_price), 0);
                    const tax = 0.01 * netAmount; // 1% tax
                    const amountPayable = netAmount + tax;
                    const cashAmount = parseFloat(document.getElementById('cashAmount').value);
                    const change = cashAmount - amountPayable;

                    // Populate receipt totals
                    document.getElementById('receiptNetAmount').textContent = `₱${netAmount.toFixed(2)}`;
                    document.getElementById('receiptTax').textContent = `₱${tax.toFixed(2)}`;
                    document.getElementById('receiptAmountPayable').textContent = `₱${amountPayable.toFixed(2)}`;
                    document.getElementById('receiptCashAmount').textContent = `₱${cashAmount.toFixed(2)}`;
                    document.getElementById('receiptChange').textContent = `₱${change.toFixed(2)}`;
                })
                .catch(error => {
                    console.error('Error fetching transaction data:', error);
                });
        }
    </script>
    

    {{-- <script>
        function returnToCheckoutModal() {
            document.getElementById('cashPaymentModal').style.display = 'none';
            document.getElementById('checkoutModal').style.display = 'flex';
        }
    
        function confirmCashPayment() {
            const cashAmount = parseFloat(document.getElementById('cashAmount').value);
            const totalAmount = parseFloat(document.getElementById('totalAmount').value.replace(/₱|,/g, '')); // Remove currency symbol and commas
    
            if (isNaN(cashAmount) || cashAmount < 0) {
                alert("Please enter the right cash amount.");
                return;
            }
    
            if (cashAmount < totalAmount) {
                alert("Insufficient cash amount. Please enter a valid amount.");
                return;
            }
    
            const change = cashAmount - totalAmount;
            alert("Payment successful with cash amount: ₱" + cashAmount.toFixed(2) + ". Change: ₱" + change.toFixed(2));
    
            // Hide cash payment modal and show receipt modal
            document.getElementById('cashPaymentModal').style.display = 'none';
    
            // Show the receipt modal here
            document.getElementById('receiptModal').style.display = 'flex';

             // Populate the receipt modal with transaction data
            populateReceiptModal();
        }
    
        // Function to update customer change automatically
        function updateCustomerChange() {
            const cashAmount = parseFloat(document.getElementById('cashAmount').value);
            const totalAmount = parseFloat(document.getElementById('totalAmount').value.replace(/₱|,/g, ''));
    
            if (!isNaN(cashAmount) && !isNaN(totalAmount)) {
                const change = cashAmount - totalAmount;
                document.getElementById('customerChange').value = change >= 0 ? "₱" + change.toFixed(2) : "₱0.00";
            } else {
                document.getElementById('customerChange').value = "₱0.00";
            }
        }
    
        // Add event listener to update change when cash amount changes
        document.getElementById('cashAmount').addEventListener('input', updateCustomerChange);

    </script>     --}}


    {{-- <script src="/path/to/checkoutModal.js"></script>
    <script src="/path/to/cashPaymentModal.js"></script> --}}


    <!-- Receipt Modal -->

    <!-- Receipt Modal -->
    <div id="receiptModal" class="receipt_modal" style="display:none;">
        <div class="receipt-modal-content">
            <div class="receipt-scrollable">
                <!-- Receipt Header -->
                <div class="receipt-header">
                    <h2>ABC Company</h2>
                    <p>123 Main St, City, Country</p>
                    <p>Reference No: <span id="receiptReferenceId">{{ isset($reference_no) ? $reference_no : 'N/A' }}</span></p>
                    <p>Date: <span id="receiptDateTime">{{ $currentDate }}</span></p>
                    <p>Cashier: <span id="receiptCashierName">{{ Auth::user() ? Auth::user()->name : 'N/A' }}</span></p>
                </div>
            
                <!-- Receipt Table -->
                <table class="receipt-table">
                    <thead>
                        <tr>
                            <th>Qty</th>
                            <th>Item</th>
                            <th>Unit Price</th>
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
                    <p>Amount Payable: <span id="receiptAmountPayable">₱0.00</span></p>
                    <p>Cash Amount: <span id="receiptCashAmount">₱0.00</span></p>
                    <p>Change: <span id="receiptChange">₱0.00</span></p>
                </div>
            
                <!-- Receipt Footer -->
                <div class="receipt-footer">
                    <p>Thank you for shopping with us.</p>
                    <p>We are happy to serve you!!!</p>
                </div>
            </div>
        
            <!-- Modal Actions -->
            <div class="receipt-modal-actions">
                <button class="print-receipt" onclick="printReceipt()">Print Receipt</button>
                <button class="done-receipt" onclick="closeModal('receiptModal')">Done</button>
            </div>
        </div>
    </div>

    {{-- <div id="receiptModal" class="receipt_modal" style="display:none;">
        <div class="receipt-modal-content">
            <div class="receipt-scrollable">
                <!-- Receipt Header -->
                <div class="receipt-header">
                    <h2>ABC Company</h2>
                    <p>123 Main St, City, Country</p>
                    <p>Reference No: <span id="receiptReferenceId">{{ isset($reference_no) ? $reference_no : 'N/A' }}</span></p>
                    <p>Date: <span id="receiptDateTime">{{ $currentDate }}</span></p>
                    <p>Cashier: <span id="receiptCashierName">{{ Auth::user() ? Auth::user()->name : 'N/A' }}</span></p>
                </div>
    
                <!-- Receipt Table -->
                <table class="receipt-table">
                    <thead>
                        <tr>
                            <th>Qty</th>
                            <th>Item</th>
                            <th>Unit Price</th>
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
                    <p>Amount Payable: <span id="receiptAmountPayable">₱0.00</span></p>
                    <p>Cash Amount: <span id="receiptCashAmount">₱0.00</span></p>
                    <p>Change: <span id="receiptChange">₱0.00</span></p>
                </div>
    
                <!-- Receipt Footer -->
                <div class="receipt-footer">
                    <p>Thank you for shopping with us.</p>
                    <p>We are happy to serve you!!!</p>
                </div>
            </div>
    
            <!-- Modal Actions -->
            <div class="receipt-modal-actions">
                <button class="print-receipt" onclick="printReceipt()">Print Receipt</button>
                <button class="done-receipt" onclick="closeModal('receiptModal')">Done</button>
            </div>
        </div>
    </div>     --}}

    <script>
        // Function to print the receipt
        function printReceipt() {
            const receiptContent = document.querySelector('#receiptModal .receipt-scrollable').innerHTML;
            const newWindow = window.open('', '_blank', 'width=600,height=800');
            newWindow.document.write(`
                <html>
                <head><title>Print Receipt</title></head>
                <body onload="window.print(); window.close();">
                ${receiptContent}
                </body>
                </html>
            `);
            newWindow.document.close();
        }

        // Function to close the modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
    </script>

{{-- // function populateReceiptModal() {
    //     console.log("Transaction Table:", document.querySelector('#transaction-tbl'));  // Check if the table exists
    //     console.log("Populating receipt modal...");
        
    //     const transactions = [];
    //     const rows = document.querySelectorAll('#transaction-tbl tbody tr'); // Get rows from tbody
    //     console.log("Rows found:", rows.length);
        
    //     rows.forEach((row, index) => {
    //         const itemNameElement = row.querySelector('td:nth-child(1)');
    //         const quantityInput = row.querySelector('input[name^="quantity"]');
    //         const unitPriceElement = row.querySelector('td:nth-child(3)');
    //         const totalPriceElement = row.querySelector('td:nth-child(4)');
            
    //         if (itemNameElement && unitPriceElement && totalPriceElement) {
    //             const itemName = itemNameElement.textContent.trim();
    //             const quantity = quantityInput ? quantityInput.value : row.querySelector('td:nth-child(2)').textContent.trim();
    //             const unitPrice = parseFloat(unitPriceElement.textContent.replace(/₱|,/g, ''));
    //             const totalPrice = parseFloat(totalPriceElement.textContent.replace(/₱|,/g, ''));
                
    //             console.log(`Row ${index} data:`, { itemName, quantity, unitPrice, totalPrice });
                
    //             transactions.push({ itemName, quantity, unitPrice, totalPrice });
    //         } else {
    //             console.warn(`Row ${index} is missing expected elements.`);
    //         }
    //     });
        
    //     console.log("Transactions data collected:", transactions);
        
    //     // Check for receiptItems table body presence
    //     const receiptItemsTableBody = document.getElementById('receiptItems');
    //     console.log("Receipt items table body found:", receiptItemsTableBody !== null);
        
    //     if (receiptItemsTableBody) {
    //         receiptItemsTableBody.innerHTML = ''; // Clear any existing rows
            
    //         transactions.forEach(transaction => {
    //             const row = document.createElement('tr');
    //             row.innerHTML = `
    //                 <td>${transaction.quantity}</td>
    //                 <td>${transaction.itemName}</td>
    //                 <td>₱${transaction.unitPrice.toFixed(2)}</td>
    //                 <td>₱${transaction.totalPrice.toFixed(2)}</td>
    //             `;
    //             receiptItemsTableBody.appendChild(row);
    //         });
    //     } else {
    //         console.error("Receipt items table body element not found.");
    //     }
        
    //     // Totals Calculation
    //     const netAmount = transactions.reduce((acc, transaction) => acc + transaction.totalPrice, 0);
    //     const tax = 0.01 * netAmount; // 1% tax
    //     const amountPayable = netAmount + tax;
    //     const cashAmount = parseFloat(document.getElementById('cashAmount').value);
    //     const change = cashAmount - amountPayable;
        
    //     // Populate receipt totals
    //     document.getElementById('receiptNetAmount').textContent = `₱${netAmount.toFixed(2)}`;
    //     document.getElementById('receiptTax').textContent = `₱${tax.toFixed(2)}`;
    //     document.getElementById('receiptAmountPayable').textContent = `₱${amountPayable.toFixed(2)}`;
    //     document.getElementById('receiptCashAmount').textContent = `₱${cashAmount.toFixed(2)}`;
    //     document.getElementById('receiptChange').textContent = `₱${change.toFixed(2)}`;
    // }

    // function populateReceiptModal() {

    //     console.log("populateReceiptModal called"); // Check if this logs
    //     // Get transaction data from the transactions table (your rows)
    //     const transactions = [];
    //     const rows = document.querySelectorAll('#transaction-tbl tbody tr');  // Assuming this is the ID for your transactions table
        
    //     rows.forEach(row => {
    //         const itemName = row.querySelector('td:nth-child(1)').textContent.trim();
    //         const quantity = row.querySelector('input[name^="quantity"]').value;
    //         const unitPrice = parseFloat(row.querySelector('td:nth-child(3)').textContent.replace(/₱|,/g, ''));
    //         const totalPrice = parseFloat(row.querySelector('td:nth-child(4)').textContent.replace(/₱|,/g, ''));

    //         console.log({ itemName, quantity, unitPrice, totalPrice });  // Log each transaction row to check data
    //         transactions.push({ itemName, quantity, unitPrice, totalPrice });
    //     });

    //     console.log("Transactions data:", transactions); // Log transactions to verify

    //     // Populate the receipt items in the modal
    //     const receiptItemsTableBody = document.getElementById('receiptItems');
    //     receiptItemsTableBody.innerHTML = ''; // Clear any existing rows

    //     transactions.forEach(transaction => {
    //         console.log("Adding transaction to receipt:", transaction); // Log each transaction
    //         const row = document.createElement('tr');
    //         row.innerHTML = `
    //             <td>${transaction.quantity}</td>
    //             <td>${transaction.itemName}</td>
    //             <td>₱${transaction.unitPrice.toFixed(2)}</td>
    //             <td>₱${transaction.totalPrice.toFixed(2)}</td>
    //         `;
    //         receiptItemsTableBody.appendChild(row);
    //     });

    //     // Calculate and populate the totals
    //     const netAmount = transactions.reduce((acc, transaction) => acc + transaction.totalPrice, 0);
    //     const tax = 0.01 * netAmount; // 1% tax
    //     const amountPayable = netAmount + tax;
    //     const cashAmount = parseFloat(document.getElementById('cashAmount').value);
    //     const change = cashAmount - amountPayable;

    //     // Populate receipt totals
    //     document.getElementById('receiptNetAmount').textContent = `₱${netAmount.toFixed(2)}`;
    //     document.getElementById('receiptTax').textContent = `₱${tax.toFixed(2)}`;
    //     document.getElementById('receiptAmountPayable').textContent = `₱${amountPayable.toFixed(2)}`;
    //     document.getElementById('receiptCashAmount').textContent = `₱${cashAmount.toFixed(2)}`;
    //     document.getElementById('receiptChange').textContent = `₱${change.toFixed(2)}`;
    // } --}}



    </section>

    {{--------------------------------------------------------- THIS --------------------------------------------------------------------}}
    {{---------------------------------------------------------- IS ---------------------------------------------------------------------}}
    {{------------------------------------------------------- SECTION 3 -----------------------------------------------------------------}}
    <section id="sec3" class="section-3">
        <div class="history">
            <p>This is the SALES HISTORY</p>
        </div>
    </section>



    {{--------------------------------------------------------- THIS --------------------------------------------------------------------}}
    {{---------------------------------------------------------- IS ---------------------------------------------------------------------}}
    {{------------------------------------------------------- SECTION 4 -----------------------------------------------------------------}}
    <section id="sec4" class="section-4">
        <div class="settings">
            <p class="dash">This is the SETTINGS</p>
            <div class="sec4-div">
                <div class="div-1">
                    <p>cont 1</p>
                </div>
                <div class="div-2">
                    <p>cont 2</p>
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
</body>
</html>