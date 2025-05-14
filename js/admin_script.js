// Profile Editing Functionality
document.getElementById('editProfile').addEventListener('click', function() {
    document.querySelector('.profile-details').style.display = 'none';
    document.querySelector('.profile-form').style.display = 'block';
});

document.getElementById('cancelEdit').addEventListener('click', function() {
    document.querySelector('.profile-details').style.display = 'block';
    document.querySelector('.profile-form').style.display = 'none';
});

document.getElementById('profileForm').addEventListener('submit', function(event) {
    event.preventDefault();
    // Handle form submission logic (e.g., update profile details)
    alert('Profile updated successfully!');
    // Reload or update the displayed profile details as needed
    // Optionally, you could use AJAX to submit the form data to the server
});

// Optional: Handle password edit link
document.getElementById('editPassword').addEventListener('click', function(event) {
    event.preventDefault();
    // Implement logic to handle password edit
    alert('Implement password edit functionality here.');
});



// Product Management Functionality

// Add Product Form Submission
document.getElementById('add-product-form')?.addEventListener('submit', function(event) {
    event.preventDefault();
    // Get form data
    const productId = document.getElementById('product-id').value;
    const productName = document.getElementById('product-name').value;
    const description = document.getElementById('description').value;
    const price = document.getElementById('price').value;
    const stock = document.getElementById('stock').value;

    // Validate input (add more validation as needed)
    if (productId && productName && description && price && stock) {
        // Simulate saving data (e.g., AJAX request to save data)
        alert('Product added successfully!');
        // Redirect to view items page or refresh the product table
        window.location.href = 'view-items.html';
    } else {
        alert('Please fill out all fields.');
    }
});
