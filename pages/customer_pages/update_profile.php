<?php
	// Start the session to access session variables
	session_start();

	// Redirect to login page if the user is not logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
		exit();
	}

	// Include database connection (modify the path as per your setup)
	include('../../server/connection.php');

	// Fetch user data from the database using the session user ID
	$user_id = $_SESSION['user_id'];
	$sql = "SELECT * FROM user WHERE user_id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$user = $result->fetch_assoc(); // Fetch user data
	} else {
		// If user is not found, log out and redirect to login page
		header('Location: logout.php');
		exit();
	}

	$stmt->close();

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Process form submission
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];

		// Update user data in the database
		$sql = "UPDATE user SET name = ?, email = ?, phone = ?, address = ? WHERE user_id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);

		if ($stmt->execute()) {
			// Redirect to profile page with success message
			header('Location: profile.php?update=success');
			exit();
		} else {
			echo "Error updating record: " . $conn->error;
		}

		$stmt->close();
	}

	$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - LuxeLiving</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
   <nav id="navbar">
    <img src="../../images/logo.png" style="height: 80px; width: 160px">
    <ul class="nav-links">
        <li><a href="../../index.php">Home</a></li>
        <li><a href="luxeliving_items.php">LuxeLiving Items</a></li>
        <li><a href="inspiration.php">Inspiration</a></li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Customer Support</a>
            <div class="dropdown-content">
                <a href="pages/customer_pages/customer_support.html">Contact Us</a>
                <a href="pages/customer_pages/faqs.html">Frequently Asked Questions</a>
            </div>
        </li>
    </ul>

    <div class="login_buttons">
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="pages/customer_pages/profile.php">
                <i class="fas fa-user-circle" style="font-size: 24px; color: #000;"></i>
            </a>
            <a href="view_cart.php">
                <i class="fas fa-shopping-cart" style="font-size: 24px; color: #000;"></i>
            </a>
            <a href="../../logout.php">
                <i class="fas fa-sign-out-alt" style="font-size: 24px; color: #000;"></i>
            </a>
        <?php else: ?>
            <a href="login.php"><button class="login-btn">Login</button></a>
            <a href="pages/customer_pages/signup.php"><button class="signup-btn">Sign Up</button></a>
        <?php endif; ?>
    </div>
</nav>

    <div class="profile-container">
        <h1>Update Your Profile</h1>

        <form action="update_profile.php" method="POST">
            <div class="profile-details">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            </div>
            
            <div class="profile-actions">
                <button type="submit" class="btn">Update Profile</button>
            </div>
        </form>
    </div>

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

    <script src="../../js/script.js"></script>

</body>
</html>
