//MODAL FOR ADD AND EDIT PRODUCT SCRIPT
//MODAL FOR ADD AND EDIT PRODUCT SCRIPT
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("productModal");
    const closeModal = document.getElementById("closeModal");
    const cancelButton = document.getElementById("cancelButton");
    const productForm = document.getElementById("productForm");
    const methodField = document.getElementById("methodField");

    const addButton = document.getElementById("addProductButton");

    // Show the modal for adding a product
    if (addButton) {
        addButton.onclick = function() {
            document.getElementById("modalTitle").innerText = "Add Product";
            methodField.value = "POST"; // Set method to POST for adding
            productForm.reset(); // Clear form fields
            productForm.action = '/products'; // Set the action URL for adding
            modal.style.display = "block"; // Show the modal
        };
    }

    // Show the modal for editing a product
    document.querySelectorAll('.edit-button').forEach(button => {
        button.onclick = function() {
            // Log to check if button is being clicked and data attributes
            console.log("Edit button clicked!");

            const id = this.getAttribute('data-id');
            const barcode = this.getAttribute('data-barcode');
            const name = this.getAttribute('data-name');
            const category = this.getAttribute('data-category');
            const stocks = this.getAttribute('data-stocks');
            const price = this.getAttribute('data-price');

            // Log data to make sure the values are correct
            console.log(`ID: ${id}, Name: ${name}, Price: ${price}`);

            // Set up the modal for editing
            document.getElementById("modalTitle").innerText = "Edit Product";
            methodField.value = "PUT"; // Set method to PUT for editing
            productForm.action = `/products/${id}`; // Set the action URL

            // Fill the form with the current product data
            document.getElementById("barcode").value = barcode;
            document.getElementById("item_name").value = name;
            document.getElementById("categoryFilter").value = category;
            document.getElementById("stocks").value = stocks;
            document.getElementById("pricep").value = price;

            // Show the modal
            modal.style.display = "block"; // Make the modal visible
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