<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="history-content" style="max-height: 800px;">
        <!-- Products Table Grouped by Date -->
        @php
            // Group histories by date
            $groupedHistories = $histories->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->timestamp)->format('Y-m-d');
            });
        @endphp
    
        @foreach ($groupedHistories as $date => $transactions)
            <h3 style="background-color: #f2f2f2; padding: 10px; margin-top: 20px;">
                Transactions on {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
            </h3>
            <table class="history-table" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background-color: #f9f9f9;">
                        <th style="border: 1px solid #ccc; padding: 8px;">Reference No</th>
                        <th style="border: 1px solid #ccc; padding: 8px;">Items</th>
                        <th style="border: 1px solid #ccc; padding: 8px;">Amount Payable</th>
                        <th style="border: 1px solid #ccc; padding: 8px;">Cash Amount</th>
                        <th style="border: 1px solid #ccc; padding: 8px;">Change</th>
                        <th style="border: 1px solid #ccc; padding: 8px;">Action</th>
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
                        <tr>
                            <td style="border: 1px solid #ccc; padding: 8px;">{{ $referenceNo }}</td>
                            <td style="border: 1px solid #ccc; padding: 8px;">
                                <ul style="list-style: none; margin: 0; padding: 0;">
                                    @foreach ($transactionProducts as $product)
                                        <li>{{ $product->item_name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td style="border: 1px solid #ccc; padding: 8px;">₱{{ number_format($transactionProducts->first()->amount_payable, 2) }}</td>
                            <td style="border: 1px solid #ccc; padding: 8px;">₱{{ number_format($transactionProducts->first()->cash_amount, 2) }}</td>
                            <td style="border: 1px solid #ccc; padding: 8px;">₱{{ number_format($transactionProducts->first()->change_amount, 2) }}</td>
                            <td style="border: 1px solid #ccc; padding: 8px; text-align: center;">
                                <button class="see-details-btn" data-reference-no="{{ $referenceNo }}">See Details</button>
                            </td>
                        </tr>
                    @endforeach
    
                    <!-- Daily Totals -->
                    <tr style="background-color: #f9f9f9; font-weight: bold;">
                        <td colspan="2" style="border: 1px solid #ccc; padding: 8px; text-align: right;">Total for {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">₱{{ number_format($dailyTotalAmount, 2) }}</td>
                        <td colspan="3" style="border: 1px solid #ccc; padding: 8px;">Total Items: {{ $dailyTotalItems }}</td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    </div>    
</body>
</html>