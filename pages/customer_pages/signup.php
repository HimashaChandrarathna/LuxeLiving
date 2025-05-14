<?php

// Include the database connection file
include '../../server/connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
	$address = $_POST['address'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the email already exists
    $email_check_query = "SELECT * FROM user WHERE email='$email' LIMIT 1";
    $result = $conn->query($email_check_query);

    if ($result->num_rows > 0) {
        // Email already exists
        echo "<script>alert('This email is already registered. Please use a different email or log in.');</script>";
    } else {
        // Validate passwords match
        if ($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match. Please try again.');</script>";
        } else {
            // Handle profile image upload
            $profile_image = null;
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
                // Read the image file into a variable
                $profile_image = addslashes(file_get_contents($_FILES['profile_image']['tmp_name']));
            }

            // Prepare SQL query to insert user data without hashing the password
            $sql = "INSERT INTO user (name, email,address, phone, password, profile_image) 
                    VALUES ('$name', '$email', '$address', '$phone', '$password', '$profile_image')";

            // Execute the query
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Registration successful! Redirecting to login page...');</script>";
                echo "<script>window.location.href = '../../login.php';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // Close the database connection
            $conn->close();
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
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
          <!-- <li><a href="pages/customer_pages/customer_support.html">Customer Support</a></li> -->
			
			<li class="dropdown"><a href="javascript:void(0)" class="dropbtn">Customer Support</a>
				<div class="dropdown-content">
				  <a href="customer_support.html">Contact Us</a>
				  <a href="faqs.html">Frequently Asked Questions</a>
				</div>
  			</li>
			
        </ul>
		<div class="login_buttons">
			<button class="hidden_button"></button>
            <button class="hidden_button"></button>
        </div>
    </nav>
	
	<br><br><br>
	<br><br><br><br><br>
	<div class="signup_form_full">
		<div class="signup-container">
			<h1>Sign Up</h1>
			<form action="signup.php" method="POST" enctype="multipart/form-data">
				<div class="form-group profile-image-group">
					<label for="profile-image">Profile Image:</label>
					<div class="profile-image-wrapper">
						<img src="../../images/profile.jpg" alt="User Avatar" class="profile-avatar" id="profile-avatar">
						<input type="file" id="profile_image" name="profile_image" accept="image/*">
					</div>
				</div>
				<div class="form-group">
					<label for="name">Full Name</label>
					<input type="text" id="name" name="name" placeholder="Enter your Name" required>
				</div>
				<div class="form-group">
					<label for="email">Email Address</label>
					<input type="email" id="email" name="email" placeholder="Enter your Email" required>
				</div>
				<div class="form-group">
					<label for="address">Address</label>
					<input type="address" id="address" name="address" placeholder="Enter your address" required>
				</div>
				<div class="form-group">
					<label for="phone">Contact Number</label>
					<input type="number" id="phone" name="phone" placeholder="Enter your phone number" required>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" placeholder="Enter your Password" required>
				</div>
				<div class="form-group">
					<label for="confirm_password">Confirm Password</label>
					<input type="password" id="confirm_password" name="confirm_password" placeholder="Please Re-Enter your Password" required>
				</div>
				<button type="submit" class="signup-btn">Sign Up</button>
			</form>
			<div class="links">
				<p>Already have an account? <a href="../../login.php">Login</a></p>
			</div>
		</div>
	</div>
	
	<br><br><br>
	<br><br><br><br><br>
	<br><br><br><br><br>
	<div class="divider"></div>
	<!-- Footer-->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <p class="footer_logotext">LuxeLiving</p>
            </div>
            <div class="footer-center">
                <ul class="footer-links">
				    <li><a href="#home">Home</a></li>
					<li><a href="pages/customer_pages/luxeliving_items.html">LuxeLiving Items</a></li>
					<li><a href="#inspiration">Inspiration</a></li>
					<li><a href="pages/customer_pages/customer_support.html">Customer Support</a></li>					
                </ul>
            </div>
            <div class="footer-right">
                <p>Contact Us:</p>
                <p>Phone: (123) 456-7890</p>
                <p>Email: info@luxeliving.com</p>
            </div>
        </div>
    </footer>
	
	<!--End of the Footer -->
	
    <script src="../../js/script.js"></script>
	
</body>
</html>
