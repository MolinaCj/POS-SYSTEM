// Modal JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("productModal");
    const closeModal = document.getElementById("closeModal");
    const addButton = document.getElementById("addProductButton");
    const cancelButton = document.getElementById("cancelButton");
    const productForm = document.getElementById("productForm");
    const methodField = document.getElementById("methodField");

    // Show the modal for adding a product
    addButton.onclick = function() {
        document.getElementById("modalTitle").innerText = "Add Product";
        methodField.value = "POST"; // Set method to POST for adding
        productForm.reset(); // Clear form fields
        productForm.action = '/products'; // Set the action URL for adding
        modal.style.display = "block"; // Show the modal
    };

    // Show the modal for editing a product
    document.querySelectorAll('.edit-button').forEach(button => {
        button.onclick = function() {
            const id = this.getAttribute('data-id');
            const barcode = this.getAttribute('data-barcode');
            const name = this.getAttribute('data-name');
            const quantity = this.getAttribute('data-quantity');
            const price = this.getAttribute('data-price');

            document.getElementById("modalTitle").innerText = "Edit Product";
            methodField.value = "PUT"; // Set method to PUT for editing
            productForm.action = `/products/${id}`; // Set the action URL
            document.getElementById("barcode").value = barcode;
            document.getElementById("item_name").value = name;
            document.getElementById("quantity").value = quantity;
            document.getElementById("price").value = price;

            modal.style.display = "block"; // Show the modal
        };
    });

    // Close modal function
    closeModal.onclick = function() {
        modal.style.display = "none"; // Hide the modal
    };

    // Cancel button functionality
    cancelButton.onclick = function() {
        modal.style.display = "none"; // Hide the modal
    };

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none"; // Hide the modal
        }
    };
});

// document.addEventListener('DOMContentLoaded', function() {
//     const modal = document.getElementById("productModal");
//     const closeModal = document.getElementById("closeModal");
//     const addButton = document.getElementById("addProductButton");
//     const cancelButton = document.getElementById("cancelButton");
//     const productForm = document.getElementById("productForm");
//     const methodField = document.getElementById("methodField");

//     // Show the modal for adding a product
//     addButton.onclick = function() {
//         document.getElementById("modalTitle").innerText = "Add Product";
//         methodField.value = "POST"; // Set method to POST for adding
//         productForm.reset(); // Clear form fields
//         modal.style.display = "block"; // Show the modal
//     };

//     // Show the modal for editing a product
//     document.querySelectorAll('.edit-button').forEach(button => {
//         button.onclick = function() {
//             const id = this.getAttribute('data-id');
//             const barcode = this.getAttribute('data-barcode');
//             const name = this.getAttribute('data-name');
//             const quantity = this.getAttribute('data-quantity');
//             const price = this.getAttribute('data-price');

//             document.getElementById("modalTitle").innerText = "Edit Product";
//             methodField.value = "PUT"; // Set method to PUT for editing
//             productForm.action = `/products/${id}`; // Set the action URL
//             document.getElementById("barcode").value = barcode;
//             document.getElementById("item_name").value = name;
//             document.getElementById("quantity").value = quantity;
//             document.getElementById("price").value = price;

//             modal.style.display = "block"; // Show the modal
//         };
//     });

    // function redirectAfterSubmit(event) {
    //     event.preventDefault(); // Prevent the default form submission
    
    //     const form = document.getElementById('productForm');
    //     const formData = new FormData(form);
    
    //     fetch(form.action, {
    //         method: 'POST', // Use POST, Laravel will understand it’s an update via the token
    //         body: formData,
    //         headers: {
    //             'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value // Include CSRF token
    //         }
    //     })
    //     .then(response => {
    //         if (response.ok) {
    //             window.location.href = 'http://127.0.0.1:8000/products#sec2'; // Redirect on success
    //         } else {
    //             // Handle errors if needed
    //             console.error('Error:', response.statusText);
    //         }
    //     })
    //     .catch(error => console.error('Error:', error));
    // }
    

//     // Close the modal
//     closeModal.onclick = function() {
//         modal.style.display = "none";
//     };

//     // Cancel button
//     cancelButton.onclick = function() {
//         modal.style.display = "none";
//     };

//     // Close modal when clicking outside of it
//     window.onclick = function(event) {
//         if (event.target == modal) {
//             modal.style.display = "none";
//         }
//     };
// });

//Scroll behavior for section

