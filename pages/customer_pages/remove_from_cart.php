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

	// Check if cart_id is set via POST
	if (isset($_POST['cart_id'])) {
		// Get the cart_id from POST
		$cart_id = $_POST['cart_id'];

		// Prepare the SQL query to delete the cart item
		$delete_query = "DELETE FROM cart WHERE cart_id = $cart_id";

		// Execute the query
		if (mysqli_query($conn, $delete_query)) {
			// Redirect back to the cart page after deletion
			header("Location: view_cart.php");
			exit;
		} else {
			echo "Error removing item: " . mysqli_error($conn);
		}
	} else {
		// If no cart_id is set, redirect to cart page
		header("Location: view_cart.php");
		exit;
	}

	// Close the database connection
	mysqli_close($conn);
?>
