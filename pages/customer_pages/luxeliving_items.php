<?php
// Include your database connection file
include '../../server/connection.php';

// Fetch products from the database
$product_query = "SELECT p.product_id, p.product_name, p.product_description, p.price, c.name as category_name, p.main_product_image, p.second_product_image, p.third_product_image
                  FROM products p
                  JOIN categories c ON p.category_id = c.category_id";
$product_result = mysqli_query($conn, $product_query);

session_start();
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeLiving Items</title>
	<link rel="stylesheet" href="../../css/styles.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	
	<style>
	.view-button {
            background-color: #380D0D;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-transform: uppercase;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            display: inline-block;
            text-decoration: none;
        }

        .view-button:hover {
            background-color: #84515C;
        }

		.view-button a{
           color: white;
		   text-decoration: none;
        }
		
		.search-container {
			margin-bottom: 20px;
			text-align: center;
		}

		#search-input {
			width: 50%;
			padding: 10px;
			border: 1px solid #ddd;
			border-radius: 5px;
			font-size: 16px;
		}
	</style>
</head>

<body>
   <nav id="navbar">
    <img src="../../images/logo.png" style="height: 80px; width: 160px">
    <ul class="nav-links">
        <li><a href="../../index.php">Home</a></li>
        <li><a href="#">LuxeLiving Items</a></li>
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
            <a href="profile.php">
				<i class="fas fa-user-circle" style="font-size: 24px; color: #000;"></i>
            </a>
            <a href="view_cart.php">
				<i class="fas fa-shopping-cart" style="font-size: 24px; color: #000;"></i>
            </a>
            <a href="../../logout.php">
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
	<section id="home_section">
		<img src="../../images/HD10.webp" style="width: 100%; max-height: 600px">
	</section>

	<section id="welcome_section">
		<p class="Headers">Explore our Products !!!</p>
		<p class="paragraph_content">Welcome to LuxeLiving, where elegance meets comfort. Our carefully curated selection of home decor items is designed to bring a touch of sophistication to your living spaces. Whether you're looking for modern minimalism or classic charm, our collection features a variety of styles to suit every taste. Explore our exquisite range of decor pieces, each crafted with attention to detail and quality. Transform your home into a haven of luxury with LuxeLiving items that are not only beautiful but also functional. Start browsing now and find the perfect additions to elevate your home's aesthetic.</p>
	</section>
	
			<!-- Search Bar -->
	<div class="search-container">
		<input type="text" id="search-input" placeholder="Search for products..." onkeyup="searchProducts()">
	</div>
	
	<div class="item-full">
		<div class="items-container">
			<h2>LuxeLiving Items</h2>
			<br><br>
			<div class="items-grid">
				<?php
				if (mysqli_num_rows($product_result) > 0) {
					while ($row = mysqli_fetch_assoc($product_result)) {
						// Convert blob image to base64 to display it as an image source
						$main_image = base64_encode($row['main_product_image']);
						echo '
						<div class="item-card">
							<img src="data:image/jpeg;base64,' . $main_image . '" alt="' . $row['product_name'] . '" class="item-image">
							<h3 class="item-title">' . $row['product_name'] . '</h3>
							<h4>' . $row['category_name'] . '</h4>
							<p class="item-description">' . $row['product_description'] . '</p>
							<p class="item-price">LKR ' . $row['price'] . '</p>
							<div class="item-actions">
								<button class="view-button"><a href="product_details.php?product_id=' . $row['product_id'] . '">View</a></button>
							</div>
						</div>';
					}
				} else {
					echo '<p>No products available at the moment.</p>';
				}
				?>
			</div>
		</div>
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

<script src="../../js/script.js"></script>

<script>
// JavaScript to handle search functionality
function searchProducts() {
    let input = document.getElementById('search-input').value.toLowerCase();
    let items = document.getElementsByClassName('item-card');

    for (let i = 0; i < items.length; i++) {
        let itemName = items[i].getElementsByClassName('item-title')[0].textContent.toLowerCase();
        let itemCategory = items[i].getElementsByTagName('h4')[0].textContent.toLowerCase();
        let itemDescription = items[i].getElementsByClassName('item-description')[0].textContent.toLowerCase();

        // Check if the input matches the name, category, or description
        if (itemName.includes(input) || itemCategory.includes(input) || itemDescription.includes(input)) {
            items[i].style.display = "block";  // Show the item if there's a match
        } else {
            items[i].style.display = "none";   // Hide the item if no match
        }
    }
}
</script>
</body>
</html>
