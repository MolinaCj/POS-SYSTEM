<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/stockstatus.css')}}">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Stocks Status</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Stocks Status</h1>
    
        <!-- Back Button -->
        <div class="text-end mb-3">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Return to Products</a>
        </div>
    
        <!-- Low Stock Products Section -->
        <section>
            <h2>Low Stock Products</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->item_name }}</td>
                        <td>{{ $product->stocks }}</td>
                        <td>
                            <!-- Add Stock Button -->
                            <button class="btn btn-primary add-stock-btn" data-id="{{ $product->id }}">Add Stock</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    
        <!-- Out of Stock Products Section -->
        <section>
            <h2>Out of Stock Products</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($outOfStockProducts as $product)
                    <tr>
                        <td>{{ $product->item_name }}</td>
                        <td>{{ $product->stocks }}</td>
                        <td>
                            <!-- Add Stock Button -->
                            <button class="btn btn-primary add-stock-btn" data-id="{{ $product->id }}">Add Stock</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
    
    <!-- Modal for Adding Stock -->
    <div id="stockModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="document.getElementById('stockModal').style.display='none'">&times;</span>
            <h4>Add Stock</h4>
            <input type="number" id="quantity" placeholder="Enter quantity" min="1" class="form-control mb-3">
            <button id="submitStock" class="btn btn-success" onclick="addStock()">Add</button>
        </div>
    </div>

    <script>
        // Open the modal to add stock
let selectedProductId = null;

document.querySelectorAll('.add-stock-btn').forEach(function (button) {
    button.addEventListener('click', function () {
        selectedProductId = this.getAttribute('data-id');
        document.getElementById('stockModal').style.display = 'flex';  // Ensure modal is shown with flex
    });
});

// Handle adding stock via AJAX
function addStock() {
    var quantity = document.getElementById('quantity').value;

    // Validate the quantity input
    if (!quantity || quantity < 1) {
        alert('Please enter a valid quantity.');
        return;
    }

    // Make the AJAX request to add stock
    $.ajax({
        url: '/add-stock/' + selectedProductId, // Use the product ID in the URL
        type: 'POST',
        data: {
            quantity: quantity,
            _token: '{{ csrf_token() }}'  // CSRF token for security
        },
        success: function (response) {
            alert(response.message); // Show success message

            // Close the modal
            document.getElementById('stockModal').style.display = 'none';

            // Refresh the stock status table to show updated stock
            location.reload(); // Reload the page to see updated stock status
        },
        error: function (xhr, status, error) {
            alert('Error updating stock.');
        }
    });
}

// Close the modal when clicking on the close button
document.querySelector('.close-btn').addEventListener('click', function () {
    document.getElementById('stockModal').style.display = 'none';
});

// Close the modal if clicked outside of the modal content
window.addEventListener('click', function (event) {
    if (event.target === document.getElementById('stockModal')) {
        document.getElementById('stockModal').style.display = 'none';
    }
});
    </script>
    

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>