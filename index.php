<?php
// Start session to track login status
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeLiving_Home</title>
    <link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>

   <nav id="navbar">
    <img src="images/logo.png" style="height: 80px; width: 160px">
    <ul class="nav-links">
        <li><a href="#">Home</a></li>
        <li><a href="pages/customer_pages/luxeliving_items.php">LuxeLiving Items</a></li>
        <li><a href="pages/customer_pages/inspiration.php">Inspiration</a></li>
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
				<i class="fas fa-user-circle" style="font-size: 24px; color: #000;"></i>
            </a>
            <a href="pages/customer_pages/view_cart.php">
				<i class="fas fa-shopping-cart" style="font-size: 24px; color: #000;"></i>
            </a>
            <a href="logout.php">
				<i class="fas fa-sign-out-alt" style="font-size: 24px; color: #000;"></i>
            </a>
        <?php else: ?>
            <!-- If not logged in, show login and sign-up buttons -->
            <a href="login.php"><button class="login-btn">Login</button></a>
            <a href="pages/customer_pages/signup.php"><button class="signup-btn">Sign Up</button></a>
        <?php endif; ?>
    </div>
</nav>

	
    <div class="content">
        <!-- Add some content here to enable scrolling -->
        <section id="home_section">
			<img src="images/HD10.webp" style="width: 100%; max-height: 600px" >
		</section>
		
		<!-- Welcome section -->
        <section id="welcome_section">
			<!--<p class = "Headers">Welcome to LuxeLiving!</p> -->
			<p class="Headers">
                Welcome to LuxeLiving
                <?php if (isset($_SESSION['name'])): ?>
                    , <?php echo htmlspecialchars($_SESSION['name']); ?>!
                <?php else: ?>
                    !
                <?php endif; ?>
            </p>
			
			<p class = "paragraph_content">Explore LuxeLiving, your go-to online store for stylish furniture and home décor. Discover a wide range of products, enjoy seamless ordering, and benefit from our dedicated customer support. Transform your home with LuxeLiving today!</p>
			
			<div class = "exp_btns">
				<button class = "explore_button" onclick="scrollToSection('Category_section')">Explore</button>
        	</div>
			
		</section>
		
		<!-- About section -->
        <section id="about_section">
			
			<div class="container">
				<div class="left-side">
					<img src="images/chair.jpg" style="width: 100% ; height: 99.2% " >
				</div>
				<div class="right-side">
					<p class = "Headers"> About Us </p>
					
					<p class = "paragraph_content">Style meets comfort in the world of home décor and furniture. Founded with a passion for design and a commitment to quality, LuxeLiving aims to transform your living spaces into a true reflection of your personality and taste. At LuxeLiving, we believe that every home should be a sanctuary that embodies your unique style. Our mission is to provide a curated selection of high-quality furniture and décor pieces that inspire and elevate your home.</p>
				</div>
    		</div>
		
		</section>
		
		<!-- Category section -->
        <section id="Category_section">
			<p class = "center_header"> Categories</p><br>
			
			<div class="container_category">
				<div class="category_left-side">
					<p class = "paragraph_content">Discover a world of elegance and comfort with our exquisite range of furniture and home decor. From modern sofas to stylish chairs and unique decor pieces, we have everything you need to transform your home into a sanctuary of style and sophistication. Explore our collection and find the perfect pieces to elevate your living space</p>
					<div class = "exp_btns">
						<a href="pages/customer_pages/luxeliving_items.php" class="exp_btns explore_button">Explore </a>
					</div>
					
				</div>
				<div class="category_right-side">
					<div class="image-grid">
                        <img src="images/b2f19e0aabbdb3d3bc98e8cae92d754b.jpg" alt="Category 1">
                        <img src="images/HD2.jpg" alt="Category 2">
                        <img src="images/HD3.jpg" alt="Category 3">
                        <img src="images/HDF6.jpeg" alt="Category 4">
                    </div>
				</div>
    		</div>
			
		</section>
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
	
	<!--End of the Footer -->
	
    <script src="js/script.js"></script>
	
	
</body>
</html>