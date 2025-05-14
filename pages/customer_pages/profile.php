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
	$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - LuxeLiving</title>
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
            <!-- If logged in, show profile, cart, and logout buttons -->
            <a href="pages/customer_pages/profile.php">
               <!-- <img src="images/profile_icon.png" alt="Profile" style="height: 40px; width: 40px;"> -->
				<i class="fas fa-user-circle" style="font-size: 24px; color: #000;"></i>
            </a>
            <a href="view_cart.php">
                <!--<img src="images/cart_icon.jpg" alt="Cart" style="height: 40px; width: 40px;">-->
				<i class="fas fa-shopping-cart" style="font-size: 24px; color: #000;"></i>
            </a>
            <a href="../../logout.php">
                <!--<img src="images/logout_icon.jpg" alt="Logout" style="height: 40px; width: 40px;">-->
				<i class="fas fa-sign-out-alt" style="font-size: 24px; color: #000;"></i>
            </a>
        <?php else: ?>
            <!-- If not logged in, show login and sign-up buttons -->
            <a href="login.php"><button class="login-btn">Login</button></a>
            <a href="pages/customer_pages/signup.php"><button class="signup-btn">Sign Up</button></a>
        <?php endif; ?>
    </div>
</nav>

	<br><br><br><br>
	<br><br><br><br>
    <div class="profile-container">
        <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>

        <div class="profile-details">
            <h2>Your Profile Information</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
        </div>

        <div class="profile-actions">
            <a href="update_profile.php" class="btn">Edit Profile</a>
            <a href="../../logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
	<br><br><br><br>

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

    <script src="../../js/script.js"></script>

</body>
</html>
