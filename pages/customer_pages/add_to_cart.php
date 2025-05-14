<?php
	// Start session
	session_start();

	// Include your database connection file
	include '../../server/connection.php';

	// Check if the user is logged in
	if (!isset($_SESSION['user_id'])) {
		echo "<script>alert('You need to log in to add items to your cart.');</script>";
		echo "<script>window.location.href = '../../login.php';</script>";
		exit;
	}

	// Get the user ID from the session
	$user_id = $_SESSION['user_id'];

	// Check if the necessary POST data is provided
	if (isset($_POST['product_id'], $_POST['quantity'], $_POST['price'])) {
		$product_id = intval($_POST['product_id']);
		$quantity = intval($_POST['quantity']);
		$price = floatval($_POST['price']);
		$total_price = $price * $quantity;

		// Insert the product details into the cart table
		$cart_query = "INSERT INTO cart (user_id, product_id, quantity, price, total_price)
					   VALUES (?, ?, ?, ?, ?)";

		if ($stmt = mysqli_prepare($conn, $cart_query)) {
			// Bind the variables to the prepared statement
			mysqli_stmt_bind_param($stmt, "iiidd", $user_id, $product_id, $quantity, $price, $total_price);

			// Execute the statement
			if (mysqli_stmt_execute($stmt)) {
				echo "<script>alert('Product added to cart successfully!');</script>";
				echo "<script>window.location.href = 'luxeliving_items.php';</script>";
				
			} else {
				echo "Error: Could not add product to cart.";
			}

			// Close the statement
			mysqli_stmt_close($stmt);
		} else {
			echo "Error: Could not prepare query.";
		}
	} else {
		echo "Invalid product data.";
	}

	// Close the database connection
	mysqli_close($conn);
?>
