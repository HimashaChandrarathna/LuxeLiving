<?php
session_start();

// Include the database connection
include('server/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];  // Plain-text password

    // Query to check if the user exists
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify plain-text password (no hashing)
        if ($password == $row['password']) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name']; // Assuming 'name' is a column in your user table

            // Redirect to index page
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Incorrect password. Please try again.";
        }
    } else {
        $error_message = "No account found with that email.";
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
    <title>LuxeLiving Log In</title>
    <link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
   <nav id="navbar">
        <img src="images/logo.png" style="height: 80px; width: 160px">
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="pages/customer_pages/luxeliving_items.php">LuxeLiving Items</a></li>
            <li><a href="pages/customer_pages/inspiration.php">Inspiration</a></li>
            <li class="dropdown"><a href="javascript:void(0)" class="dropbtn">Customer Support</a>
                <div class="dropdown-content">
                    <a href="pages/customer_pages/customer_support.html">Contact Us</a>
                    <a href="pages/customer_pages/faqs.html">Frequently Asked Questions</a>
                </div>
            </li>
        </ul>
        <div class="login_buttons">
            <button class="hidden_button"></button>
            <button class="hidden_button"></button>
        </div>
    </nav> 
    
    <div class="login_form_full">
        <div class="login-container" id="login-container">
            <h1>Login</h1>
            <form id="login-form" action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Your Email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your Password" required>
                </div> 
                <button type="submit" class="login-btn">Login</button>
            </form>
            <div id="error-message" style="color: red;"> <?php if(!empty($error_message)) echo $error_message; ?></div>
            <div class="links">
                <a href="/forgot-password">Forgot Password?</a>
                <a href="pages/customer_pages/signup.php">Sign Up</a>
            </div>
        </div>
    </div>
    
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
    
    <!--End of the Footer 
    
    <script src="js/script.js"></script> -->
</body>
</html>
