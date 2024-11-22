//MODAL FOR ADD AND EDIT PRODUCT SCRIPT
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
            const category = this.getAttribute('data-category');
            const stocks = this.getAttribute('data-stocks');
            const price = this.getAttribute('data-price');

            document.getElementById("modalTitle").innerText = "Edit Product";
            methodField.value = "PUT"; // Set method to PUT for editing
            productForm.action = `/products/${id}`; // Set the action URL
            document.getElementById("barcode").value = barcode;
            document.getElementById("item_name").value = name;
            document.getElementById("category").value = category;
            document.getElementById("stocks").value = stocks;
            document.getElementById("pricep").value = price;

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


// Notification Script



/////////////////////=========SECTION 3 SCRIPT=========/////////////////////