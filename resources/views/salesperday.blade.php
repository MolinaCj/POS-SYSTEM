<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/salesperday.css')}}">

    <title>Sales Per Day</title>
</head>
<body>
    <div class="container my-5">
        <!-- Title -->
        <div class="text-center mb-4">
            <h1 class="text-primary">Sales Per Day</h1>
        </div>

        <!-- Filters Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Search Bar -->
                <input type="text" id="searchReference" class="form-control me-2" placeholder="Search by Reference No...">
                <input type="date" id="searchDate" class="form-control me-2" name="date">
                {{-- <input type="text" class="form-control me-2" name="search" placeholder="Search using reference no..." value="{{ request('findsales') }}">
                <input type="date" class="form-control me-2" name="date" value="{{ request('findbydate') }}"> --}}
                <script>
                    document.getElementById('searchDate').addEventListener('input', filterTransactions);
                    document.getElementById('searchReference').addEventListener('input', filterTransactions);
                                    
                    function filterTransactions() {
                        const selectedDate = document.getElementById('searchDate').value; // Get the selected date
                        const searchQuery = document.getElementById('searchReference').value.toLowerCase(); // Get the reference number search query
                    
                        const groups = document.querySelectorAll('.transaction-group'); // Get all transaction groups (cards)
                    
                        groups.forEach(group => {
                            const groupDate = group.dataset.date; // Date of the transaction group
                            const rows = group.querySelectorAll('.transaction-row'); // Rows inside the group
                            let groupMatches = false; // Flag to determine if the group matches the filters
                        
                            rows.forEach(row => {
                                const referenceNo = row.dataset.reference.toLowerCase(); // Reference number for the row
                                const rowMatchesDate = !selectedDate || groupDate === selectedDate; // Check if row matches the selected date
                                const rowMatchesReference = !searchQuery || referenceNo.includes(searchQuery); // Check if row matches the search query
                            
                                // Show or hide the row based on the filters
                                if (rowMatchesDate && rowMatchesReference) {
                                    row.style.display = '';
                                    groupMatches = true; // Set group flag if any row matches
                                } else {
                                    row.style.display = 'none';
                                }
                            });
                        
                            // Show or hide the group based on whether any row matched
                            group.style.display = groupMatches ? '' : 'none';
                        });
                    }
                </script>                

            <!-- Return Button -->
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Return</a>
        </div>

        <!-- History Content -->
        <div class="history-content scrollable-table">
            @php
                $groupedHistories = $histories->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item->timestamp)->format('Y-m-d');
                });
            @endphp
        
            @foreach ($groupedHistories as $date => $transactions)
                <div class="card mb-4 transaction-group" data-date="{{ $date }}">
                    <!-- Card Header with Date -->
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Transactions on {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h5>
                    </div>
        
                    <!-- Card Body with Table -->
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Reference No</th>
                                    <th>Items</th>
                                    <th>Amount Payable</th>
                                    <th>Cash Amount</th>
                                    <th>Change</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $dailyTotalAmount = 0;
                                    $dailyTotalItems = 0;
                                @endphp
        
                                @foreach ($transactions->groupBy('reference_no') as $referenceNo => $transactionProducts)
                                    @php
                                        $dailyTotalAmount += $transactionProducts->first()->amount_payable;
                                        $dailyTotalItems += $transactionProducts->sum('quantity');
                                    @endphp
                                    <tr class="transaction-row" data-reference="{{ $referenceNo }}">
                                        <td>{{ $referenceNo }}</td>
                                        <td>
                                            <ul class="list-unstyled mb-0 scrollable-items">
                                                @foreach ($transactionProducts as $product)
                                                    <li>{{ $product->item_name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>₱{{ number_format($transactionProducts->first()->amount_payable, 2) }}</td>
                                        <td>₱{{ number_format($transactionProducts->first()->cash_amount, 2) }}</td>
                                        <td>₱{{ number_format($transactionProducts->first()->change_amount, 2) }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary see-details-btn" data-reference-no="{{ $referenceNo }}" data-bs-toggle="modal" data-bs-target="#transactionDetailsModal">
                                                See Details
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
        
                                <!-- Daily Totals -->
                                <tr class="table-secondary font-weight-bold">
                                    <td colspan="2" class="text-end">Total for {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</td>
                                    <td>₱{{ number_format($dailyTotalAmount, 2) }}</td>
                                    <td colspan="3">Total Items: {{ $dailyTotalItems }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>        

    <!-- Modal HTML Structure -->
    <div id="transactionDetailsModal" class="modal custom-modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 style="text-align: center; margin-bottom: 20px;">Transaction Details</h2>

            <!-- General Transaction Information -->
            <div id="historyDetails" style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
                <!-- Details will be dynamically loaded here -->
            </div>

            <!-- Product Details Section -->
            <h3 style="text-align: center; margin-bottom: 10px; border-bottom: 2px solid #ccc; padding-bottom: 5px;">Detailed Product List</h3>
            <table id="productDetailsTable" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background-color: #f8f9fa; text-align: left;">
                        <th style="border: 1px solid #ddd; padding: 10px;">Product Name</th>
                        <th style="border: 1px solid #ddd; padding: 10px;">Quantity</th>
                        <th style="border: 1px solid #ddd; padding: 10px;">Unit Price</th>
                        <th style="border: 1px solid #ddd; padding: 10px;">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Product details will be dynamically loaded here -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('click', function(event) {
        // Check if the clicked element is a "See Details" button
        if (event.target.classList.contains('see-details-btn')) {
            var referenceNo = event.target.getAttribute('data-reference-no');

            // Fetch transaction details
            fetch(`/fetch-transaction-details/${referenceNo}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch transaction details');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate modal
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
                            <p><strong>Discount %:</strong> ${data.discount ?? 'N/A'}</p>
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

        location.reload();
    });

    // Close modal if user clicks outside of it
    window.addEventListener('click', function(event) {
        var modal = document.getElementById('transactionDetailsModal');
        if (event.target === modal) {
            modal.style.display = 'none';

            location.reload();
        }
    });
    </script>

    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>