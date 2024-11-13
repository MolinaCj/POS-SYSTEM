{{-- resources/views/partials/product_table_rows.blade.php --}}
<tr>
    <th>
        <th>No.</th>
        <th>Barcode</th>
        <th>Product Name</th>
        <th>Stocks</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Actions</th>
    </th>
</tr>
@foreach ($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->barcode }}</td>
        <td>{{ $product->item_name }}</td>
        <td>{{ $product->stocks }}</td>
        <td>
            <input class="quantity" type="number" name="quantity[{{ $product->id }}]" value="1" min="1" style="width: 50px;" onchange="updateHiddenQuantity(this, {{ $product->id }})">
        </td>
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
