<?php
	// Include database connection
	include '../../server/connection.php';

	// Start session for user authentication
	session_start();

	// Check if the user is logged in
	if (!isset($_SESSION['user_id'])) {
		header("Location: ../../login.php");
		exit;
	}

	// Get the user_id from the session
	$user_id = $_SESSION['user_id'];

	// Fetch cart items for the logged-in user
	$cart_query = "SELECT c.cart_id, c.quantity, p.product_name, p.price, p.main_product_image
				   FROM cart c
				   JOIN products p ON c.product_id = p.product_id
				   WHERE c.user_id = $user_id";
	$cart_result = mysqli_query($conn, $cart_query);

	// Calculate total price for the cart
	$total_price = 0;
	$cart_items = [];

	if (mysqli_num_rows($cart_result) > 0) {
		while ($row = mysqli_fetch_assoc($cart_result)) {
			$cart_items[] = $row;
			$total_price += $row['price'] * $row['quantity'];
		}
	} else {
		echo "<script>alert('Your cart is empty.');</script>";
		echo "<script>window.location.href = 'luxeliving_items.php';</script>";
		exit;
	}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - LuxeLiving</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        /* Cart page styling */
        .cart_container {
            width: 80%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .cart-header {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .cart-items {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-items th, .cart-items td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .cart-items th {
            background-color: #380D0D;
            color: white;
        }

        .product-image {
            width: 80px;
            height: auto;
            border-radius: 10px;
        }

        .product-name {
            font-size: 1.2em;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            font-size: 1.1em;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .quantity-btn {
            background-color: #380D0D;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 1.1em;
            cursor: pointer;
            border-radius: 5px;
        }

        .quantity-btn:hover {
            background-color: #84515C;
        }

        .total-price-section {
            font-size: 1.8em;
            margin-top: 20px;
            text-align: right;
        }

        .checkout-btn {
            background-color: #380D0D;
            color: white;
            border: none;
            padding: 15px 25px;
            font-size: 1.2em;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
            width: 100%;
            text-align: center;
        }

        .checkout-btn:hover {
            background-color: #84515C;
        }

        .remove-btn {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
        }

        .remove-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>

<body>
	<nav id="navbar">
		<img src="../../images/logo.png" style="height: 80px; width: 160px">
		<ul class="nav-links">
			<li><a href="../../index.php">Home</a></li>
			<li><a href="luxeliving_items.php">LuxeLiving Items</a></li>
			<li><a href="inspiration.html">Inspiration</a></li>
			<li class="dropdown">
				<a href="javascript:void(0)" class="dropbtn">Customer Support</a>
				<div class="dropdown-content">
					<a href="pages/customer_pages/customer_support.html">Contact Us</a>
					<a href="pages/customer_pages/faqs.html">Frequently Asked Questions</a>
				</div>
			</li>
		</ul>

		<div class="login_buttons">
			<?php if (isset($_SESSION['user_id'])): ?>
				<a href="profile.php"><i class="fas fa-user-circle" style="font-size: 24px; color: #000;"></i></a>
				<a href="#"><i class="fas fa-shopping-cart" style="font-size: 24px; color: #000;"></i></a>
				<a href="../../logout.php"><i class="fas fa-sign-out-alt" style="font-size: 24px; color: #000;"></i></a>
			<?php else: ?>
				<a href="login.php"><button class="login-btn">Login</button></a>
				<a href="pages/customer_pages/signup.php"><button class="signup-btn">Sign Up</button></a>
			<?php endif; ?>
		</div>
	</nav>

	<br><br><br><br>
	<div class="cart_container">
		<h1 class="cart-header">Your Cart</h1>

		<table class="cart-items">
			<thead>
				<tr>
					<th>Image</th>
					<th>Product</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Total</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($cart_items as $item): ?>
				<tr>
					<td><img src="data:image/jpeg;base64,<?php echo base64_encode($item['main_product_image']); ?>" class="product-image" alt="Product Image"></td>
					<td class="product-name"><?php echo $item['product_name']; ?></td>
					<td>LKR <?php echo $item['price']; ?></td>
					<td>
						<form method="POST" action="update_cart.php">
							<input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
							<input type="number" name="quantity" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1">
						</form>
					</td>
					<td>LKR <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
					<td>
						<form method="POST" action="remove_from_cart.php">
							<input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
							<button type="submit" class="remove-btn">Remove</button>
						</form>

					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="total-price-section">
			Total Price: LKR <?php echo number_format($total_price, 2); ?>
		</div>

		<form method="POST" action="checkout.php">
			<button type="submit" class="checkout-btn">Proceed to Checkout</button>
		</form>
	</div>

	<br><br>
	<div class="divider"></div>

	<footer class="footer">
		<div class="footer-content">
			<div class="footer-left">
				<p class="footer_logotext">LuxeLiving</p>
			</div>
			<div class="footer-center">
				<ul class="footer-links">
					<li><a href="../../index.html">Home</a></li>
					<li><a href="#">LuxeLiving Items</a></li>
					<li><a href="#inspiration">Inspiration</a></li>
					<li><a href="#customersupport">Customer Support</a></li>
				</ul>
			</div>
			<div class="footer-right">
				<p>Contact Us:</p>
				<p>Phone: (123) 456-7890</p>
				<p>Email: info@luxeliving.com</p>
			</div>
		</div>
	</footer>
</body>
</html>
