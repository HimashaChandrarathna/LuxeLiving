<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to place an order.'); window.location.href='login.php';</script>";
    exit();
}

$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
</head>
<body>
    <h2>Place Your Order</h2>
    <form action="process_order.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <input type="hidden" name="product_price" value="<?php echo $product_price; ?>">

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" min="1" required>

        <label for="shipping_address">Shipping Address:</label>
        <input type="text" name="shipping_address" id="shipping_address" required>

        <button type="submit">Submit Order</button>
    </form>
</body>

<!-- Navigation (with profile icon if logged in) -->
<nav>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="cart.php">Cart</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="profile.php"><img src="profile-icon.png" alt="Profile" width="30" height="30"></a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="signup.php">Sign Up</a></li>
        <?php endif; ?>
    </ul>
</nav>

<h2>Place Your Order</h2>

<form action="process_order.php" method="POST">
    <!-- Hidden fields to pass product data -->
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    <input type="hidden" name="product_name" value="<?php echo $product_name; ?>">
    <input type="hidden" name="product_price" value="<?php echo $product_price; ?>">

    <!-- Quantity Input -->
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" id="quantity" min="1" required>

    <!-- Shipping Address Input -->
    <label for="shipping_address">Shipping Address:</label>
    <input type="text" name="shipping_address" id="shipping_address" required>

    <!-- Submit Button -->
    <button type="submit">Submit Order</button>
</form>

</body>
</html>

