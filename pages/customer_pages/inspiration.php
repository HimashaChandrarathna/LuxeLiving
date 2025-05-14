<?php
	// Start session to track login status
	session_start();;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspiration - LuxeLiving</title>
    <link rel="stylesheet" href="../../css/styles.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>

   <nav id="navbar">
    <img src="../../images/logo.png" style="height: 80px; width: 160px">
    <ul class="nav-links">
        <li><a href="../../index.php">Home</a></li>
        <li><a href="luxeliving_items.php">LuxeLiving Items</a></li>
        <li><a href="#">Inspiration</a></li>
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
            <a href="profile.php">
               <!-- <img src="images/profile_icon.png" alt="Profile" style="height: 40px; width: 40px;"> -->
				<i class="fas fa-user-circle" style="font-size: 24px; color: #000;"></i>
            </a>
            <a href="pages/customer_pages/cart.php">
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

	
	<div class="vlog-full">
     <div class="vlog-container">
        <h2>Our Latest Vlogs</h2>
        <div class="vlog-grid">
            <div class="vlog-card">
                <div class="vlog-thumbnail">
                    <img src="../../images/DSC00058.JPG-copy.jpg-3-2048x1316-1.jpg" alt="Vlog 1">
                </div>
                <div class="vlog-info">
                    <h3>Transforming Your Living Room</h3>
                    <p class="paragraph_content_small">Join us as we explore creative ways to transform your living room into a cozy and stylish space. From selecting the perfect color palette to choosing the right furniture, we've got you covered.</p>
                    <a href="vlog1-link.html" class="watch-btn">Watch Now</a>
                </div>
            </div>
            <div class="vlog-card">
                <div class="vlog-thumbnail">
                    <img src="../../images/HD8.jpg" alt="Vlog 2">
                </div>
                <div class="vlog-info">
                    <h3>DIY Home Decor Ideas</h3>
                    <p class="paragraph_content_small">Discover easy and budget-friendly DIY home decor projects that can add a personal touch to your space. We'll show you step-by-step how to create unique decor pieces that will impress your guests.</p>
                    <a href="vlog2-link.html" class="watch-btn">Watch Now</a>
                </div>
            </div>
            <div class="vlog-card">
                <div class="vlog-thumbnail">
                    <img src="../../images/636591648923347785-HR-378-125-015-128-333-1421L4-N6877-B3212RS.webp" alt="Vlog 3">
                </div>
                <div class="vlog-info">
                    <h3>Maximizing Small Spaces</h3>
                    <p class="paragraph_content_small">Living in a small space doesn't mean you have to compromise on style. Learn our top tips for maximizing your small living areas without sacrificing comfort or aesthetics.</p>
                    <a href="vlog3-link.html" class="watch-btn">Watch Now</a>
                </div>
            </div>
            <div class="vlog-card">
                <div class="vlog-thumbnail">
                    <img src="../../images/HD6.jpg" alt="Vlog 4">
                </div>
                <div class="vlog-info">
                    <h3>Seasonal Decor Trends</h3>
                    <p class="paragraph_content_small">Stay ahead of the curve with our latest vlog on seasonal decor trends. Find out what colors, patterns, and accessories are in vogue this season and how you can incorporate them into your home.</p>
                    <a href="vlog4-link.html" class="watch-btn">Watch Now</a>
                </div>
            </div>
        </div>
		 </div></div>

	<br><br>
	<div class="divider"></div>
	<!-- Footer-->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <p class="footer_logotext">LuxeLiving</p>
            </div>
            <div class="footer-center">
                <ul class="footer-links">
				    <li><a href="../../index.html">Home</a></li>
					<li><a href="luxeliving_items.html">LuxeLiving Items</a></li>
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
	
	<!--End of the Footer -->
	
	<script src="../../js/script.js"></script>	
	
</body>
</html>
