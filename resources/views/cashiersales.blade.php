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
        <h5 class="mb-0">Sales Per Cashier</h5>
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
    // Cashier-level totals: sum the amount_payable for unique reference numbers
    $cashierTotalSales = $transactionsByCashier->groupBy('reference_no')->sum(function ($transactionGroup) {
        return $transactionGroup->sum('amount_payable');
    });
    $cashierTotalProductsSold = $transactionsByCashier->sum('quantity');
    $overallTotalSales += $cashierTotalSales;
    $overallTotalProductsSold += $cashierTotalProductsSold;

    // Group transactions by month
    $transactionsByMonth = $transactionsByCashier->groupBy(function ($item) {
        return \Carbon\Carbon::parse($item->timestamp)->format('Y-m');
    });
@endphp

<div class="card mb-4 cashier-group" data-cashier="{{ $cashierName }}" style="max-height: 500px; overflow-y: auto;">
    <div class="card-header bg-success text-white">
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
                                        <button class="btn btn-primary btn-sm">Details</button>
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
<div class="card mt-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Overall Totals</h5>
        <p class="mb-0">
            <strong>Total Sales:</strong> ₱{{ number_format($overallTotalSales, 2) }} |
            <strong>Total Products Sold:</strong> {{ $overallTotalProductsSold }}
        </p>
    </div>
</div>

<!-- Modal (Details) with Return Button -->
<div class="modal" id="detailsModal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Transaction Details</h5>
            <button type="button" class="close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <!-- Add content of transaction details here -->
            <p>Details go here...</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Return</button>
        </div>
    </div>
</div>
<!-- JavaScript for Modal -->
<script>
    function closeModal() {
        document.getElementById('detailsModal').style.display = 'none';
    }

    // Show the modal when the 'Details' button is clicked
    document.querySelectorAll('.btn-primary').forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('detailsModal').style.display = 'block';
        });
    });
</script>


    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>