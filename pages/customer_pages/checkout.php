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

	// Get user_id from session
	$user_id = $_SESSION['user_id'];

	// Fetch cart items for the logged-in user
	$cart_query = "SELECT c.cart_id, c.quantity, p.product_name, p.price
				   FROM cart c
				   JOIN products p ON c.product_id = p.product_id
				   WHERE c.user_id = $user_id";
	$cart_result = mysqli_query($conn, $cart_query);

	$cart_items = [];
	$total_price = 0;

	if (mysqli_num_rows($cart_result) > 0) {
		while ($row = mysqli_fetch_assoc($cart_result)) {
			$cart_items[] = $row;
			$total_price += $row['price'] * $row['quantity'];
		}
	} else {
		echo "Your cart is empty.";
		exit;
	}

	// Handle form submission
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Get user input
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$address = mysqli_real_escape_string($conn, $_POST['address']);
		$phone = mysqli_real_escape_string($conn, $_POST['phone']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);

		// Insert order details into the orders table
		$order_query = "INSERT INTO orders (user_id, total_price, order_date) 
						VALUES ($user_id, $total_price, NOW())";
		if (mysqli_query($conn, $order_query)) {
			$order_id = mysqli_insert_id($conn);

			// Insert each cart item into the order_items table
			foreach ($cart_items as $item) {
				$order_item_query = "INSERT INTO order_items (order_id, product_name, price, quantity) 
									 VALUES ($order_id, '{$item['product_name']}', {$item['price']}, {$item['quantity']})";
				mysqli_query($conn, $order_item_query);
			}

			// Clear the cart for the user
			$clear_cart_query = "DELETE FROM cart WHERE user_id = $user_id";
			mysqli_query($conn, $clear_cart_query);

			// Redirect to a thank you or order confirmation page
			header("Location: order_confirmation.php");
			exit;
		} else {
			echo "Error processing order: " . mysqli_error($conn);
		}
	}

	// Close the database connection
	mysqli_close($conn);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - LuxeLiving</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        /* Checkout page styling */
        .checkout_container {
            width: 80%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .checkout-header {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .checkout-details, .checkout-form {
            margin-bottom: 20px;
        }

        .checkout-form input, .checkout-form textarea {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .checkout-form button {
            background-color: #380D0D;
            color: white;
            border: none;
            padding: 15px 25px;
            font-size: 1.2em;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }

        .checkout-form button:hover {
            background-color: #84515C;
        }

        .order-summary {
            font-size: 1.2em;
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
				<a href="view_cart.php"><i class="fas fa-shopping-cart" style="font-size: 24px; color: #000;"></i></a>
				<a href="../../logout.php"><i class="fas fa-sign-out-alt" style="font-size: 24px; color: #000;"></i></a>
			<?php else: ?>
				<a href="login.php"><button class="login-btn">Login</button></a>
				<a href="pages/customer_pages/signup.php"><button class="signup-btn">Sign Up</button></a>
			<?php endif; ?>
		</div>
	</nav>

	<br><br><br><br>
	<div class="checkout_container">
		<h1 class="checkout-header">Checkout</h1>

		<div class="checkout-details">
			<h2>Order Summary</h2>
			<ul class="order-summary">
				<?php foreach ($cart_items as $item): ?>
				<li><?php echo $item['product_name']; ?> - LKR <?php echo $item['price']; ?> x <?php echo $item['quantity']; ?></li>
				<?php endforeach; ?>
			</ul>
			<p>Total Price: LKR <?php echo number_format($total_price, 2); ?></p>
		</div>

		<div class="checkout-form">
			<form method="POST" action="">
				<label for="name">Full Name:</label>
				<input type="text" id="name" name="name" required>

				<label for="address">Address:</label>
				<textarea id="address" name="address" rows="4" required></textarea>

				<label for="phone">Phone Number:</label>
				<input type="tel" id="phone" name="phone" required>

				<label for="email">Email:</label>
				<input type="email" id="email" name="email" required>

				<button type="submit">Place Order</button>
			</form>
		</div>
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
