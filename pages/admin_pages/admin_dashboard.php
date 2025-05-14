<?php
// Include the connection to the database
include_once '../../server/connection.php';

// Initialize variables to store the counts
$product_count = 0;
$order_count = 0;
$user_count = 0;

// Fetch product count
$product_query = "SELECT COUNT(*) AS count FROM products";
$product_result = mysqli_query($conn, $product_query);
if ($product_result) {
    $product_row = mysqli_fetch_assoc($product_result);
    $product_count = $product_row['count'];
}

/* Fetch order count
$order_query = "SELECT COUNT(*) AS count FROM orders";
$order_result = mysqli_query($conn, $order_query);
if ($order_result) {
    $order_row = mysqli_fetch_assoc($order_result);
    $order_count = $order_row['count'];
}*/

// Fetch registered user count
$user_query = "SELECT COUNT(*) AS count FROM user";
$user_result = mysqli_query($conn, $user_query);
if ($user_result) {
    $user_row = mysqli_fetch_assoc($user_result);
    $user_count = $user_row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeLiving Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/admin_styles.css">
</head>
<body>
    <nav id="navbar">
        <ul class="nav-links">
            <li><a href="#" class="active">Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="view_categories.php">Categories</a></li>
            <li><a href="view_products.php">Products</a></li>
            <li><a href="#">Customers</a></li>
            <li><a href="#">Orders</a></li>
            <li><a href="#">FAQs</a></li>
        </ul>
    </nav>
    
    <div class="content">
        <h1>Welcome to LuxeLiving Admin Dashboard</h1>
        
        <div class="cards">
            <div class="card">
                <h3>Product Count</h3>
                <p><?php echo $product_count; ?></p>
            </div>
            <div class="card">
                <h3>Order Count</h3>
                <p><!--<?php echo $order_count; ?>--> 0 </p>
            </div>
            <div class="card">
                <h3>Registered User Count</h3>
                <p><?php echo $user_count; ?></p>
            </div>
        </div>
    </div>
</body>
</html>
