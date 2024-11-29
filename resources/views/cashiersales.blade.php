<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/cashiersales.css')}}">
    <title>Sales Per Cashier</title>
</head>
<body>
<!-- Title and Search Form with Return Button -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0 display-4">Sales Per Cashier</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('sales.per.cashier') }}" class="d-flex justify-content-between align-items-center">
            <div class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Search by Cashier or Reference No." value="{{ request('search') }}">
                <button type="submit" class="btn btn-success ml-2">Search</button>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Return to Products</a>
        </form>
    </div>
</div>

<!-- Blade Template Update -->
@php
// Calculate cashier totals and overall totals
$overallTotalSales = 0;
$overallTotalProductsSold = 0;
@endphp

@foreach ($groupedHistories as $cashierName => $transactionsByCashier)
@php
    // Cashier-level totals
    $appliedTax = $transactionsByCashier->sum('total_price') * .01;
    $cashierTotalSales = $transactionsByCashier->sum('total_price') + $appliedTax;
    $cashierTotalProductsSold = $transactionsByCashier->sum('quantity');
    $overallTotalSales += $cashierTotalSales;
    $overallTotalProductsSold += $cashierTotalProductsSold;

    // Group transactions by month
    $transactionsByMonth = $transactionsByCashier->groupBy(function ($item) {
        return \Carbon\Carbon::parse($item->timestamp)->format('Y-m');
    });
@endphp

<div class="card mb-4 cashier-group" data-cashier="{{ $cashierName }}" style="max-height: 500px; overflow-y: auto;">
    <div class="card-header sticky-header bg-success text-white">
        <h5 class="mb-0">Transactions by {{ $cashierName }}</h5>
        <p class="mb-0">
            <strong>Total Sales:</strong> ₱{{ number_format($cashierTotalSales, 2) }} |
            <strong>Total Products Sold:</strong> {{ $cashierTotalProductsSold }}
        </p>
    </div>

    <div class="card-body">
        @foreach ($transactionsByMonth as $month => $transactionsByMonthGroup)
            @php
                $monthlyTotalSales = $transactionsByMonthGroup->sum('amount_payable');
                $monthlyTotalProductsSold = $transactionsByMonthGroup->sum('quantity');
            @endphp

            <h6 class="bg-info text-white p-2 mb-0">
                {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}
                | Total Sales: ₱{{ number_format($monthlyTotalSales, 2) }}
                | Total Products Sold: {{ $monthlyTotalProductsSold }}
            </h6>
        
            @foreach ($transactionsByMonthGroup->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->timestamp)->format('Y-m-d');
            }) as $date => $transactions)
                <h6 class="bg-primary text-white p-2 mb-0">
                    Transactions on {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                </h6>
                <div class="transaction-table-container">
                    <table class="table table-bordered mb-2">
                        <thead>
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
                            @foreach ($transactions->groupBy('reference_no') as $referenceNo => $transactionProducts)
                                <tr>
                                    <td>{{ $referenceNo }}</td>
                                    <td>
                                        <ul class="list-unstyled mb-0" style="max-height: 150px; overflow-y: auto; padding-right: 5px;">
                                            @foreach ($transactionProducts as $product)
                                                <li>{{ $product->item_name }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>₱{{ number_format($transactionProducts->first()->amount_payable, 2) }}</td>
                                    <td>₱{{ number_format($transactionProducts->first()->cash_amount, 2) }}</td>
                                    <td>₱{{ number_format($transactionProducts->first()->change_amount, 2) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary see-details-btn" data-reference-no="{{ $referenceNo }}" data-bs-toggle="modal" data-bs-target="#transactionDetailsModal">
                                            See Details
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @endforeach
    </div>
</div>
@endforeach

<!-- Overall Totals -->
<div class="card mt-4 fixed-bottom">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Overall Totals</h5>
        <p class="mb-0">
            <strong>Total Sales:</strong> ₱{{ number_format($overallTotalSales, 2) }} |
            <strong>Total Products Sold:</strong> {{ $overallTotalProductsSold }}
        </p>
    </div>
</div>


<!-- Modal (Details) with Return Button -->
<div id="transactionDetailsModal" class="modal custom-modal" style="z-index: 10000;">
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
<!-- JavaScript for Modal -->
{{-- <script>
    function closeModal() {
        document.getElementById('detailsModal').style.display = 'none';
    }

    // Show the modal when the 'Details' button is clicked
    document.querySelectorAll('.btn-primary').forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('detailsModal').style.display = 'block';
        });
    });
</script> --}}
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