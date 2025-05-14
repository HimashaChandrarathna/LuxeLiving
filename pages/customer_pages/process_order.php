<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to place an order.'); window.location.href='login.php';</script>";
    exit();
}

include('server/connection.php'); // Include your database connection file

// Get user ID from the session
$user_id = $_SESSION['user_id'];

// Get form data
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$shipping_address = $_POST['shipping_address'];
$product_price = $_POST['product_price'];

// Calculate total amount
$total_amount = $quantity * $product_price;

// Insert the order into the orders table
$query = "INSERT INTO orders (user_id, product_id, quantity, total_amount, order_date)
          VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param('iiis', $user_id, $product_id, $quantity, $total_amount);

if ($stmt->execute()) {
    echo "<script>alert('Order placed successfully!'); window.location.href='thank_you.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
