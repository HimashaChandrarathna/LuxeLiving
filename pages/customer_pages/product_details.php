<?php
    // Include your database connection file
    include '../../server/connection.php';

    // Start session for user authentication
    session_start();

    // Get the product_id from the URL
    $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

    // Fetch the product details from the database
    $product_query = "SELECT p.product_name, p.product_description, p.price, p.main_product_image, p.second_product_image, p.third_product_image, c.name as category_name 
                      FROM products p
                      JOIN categories c ON p.category_id = c.category_id
                      WHERE p.product_id = $product_id";
    $product_result = mysqli_query($conn, $product_query);

    // Fetch product details
    if (mysqli_num_rows($product_result) == 1) {
        $row = mysqli_fetch_assoc($product_result);
    } else {
        echo "Product not found.";
        exit;
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['product_name']; ?> - LuxeLiving</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        /* CSS styles for the product details page */
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        .product-images {
            flex: 1;
            padding-right: 20px;
        }

        .main-image {
            width: 100%;
            height: auto;
            max-width: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        .small-images {
            display: flex;
            margin-top: 15px;
            gap: 10px;
        }

        .small-image {
            width: 100px;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
        }

        .product-info {
            flex: 1;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .product-info h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .product-info h3 {
            font-size: 1.5em;
            color: #888;
            margin-bottom: 20px;
        }

        .product-price {
            font-size: 1.8em;
            color: black;
            margin-bottom: 20px;
        }

        .quantity-section {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .quantity-btn {
            background-color: #380D0D;
            color: white;
            border: none;
            padding: 10px;
            font-size: 1.2em;
            cursor: pointer;
            border-radius: 5px;
        }

        .quantity-section input {
            width: 50px;
            text-align: center;
            font-size: 1.2em;
            border: 1px solid #ddd;
            margin: 0 10px;
            border-radius: 5px;
        }

        .total-price {
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        .product-description {
            margin-top: 30px;
            font-size: 1.2em;
            line-height: 1.6;
            color: #000000;
        }

        .order-btn, .add-to-cart-btn {
            background-color: #380D0D;
            color: white;
            border: none;
            padding: 15px 25px;
            font-size: 1.2em;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
            display: block;
            width: 100%;
        }

        .order-btn:hover, .add-to-cart-btn:hover {
            background-color: #84515C;
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
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="profile.php"><i class="fas fa-user-circle" style="font-size: 24px; color: #000;"></i></a>
            <a href="view_cart.php"><i class="fas fa-shopping-cart" style="font-size: 24px; color: #000;"></i></a>
            <a href="../../logout.php"><i class="fas fa-sign-out-alt" style="font-size: 24px; color: #000;"></i></a>
        <?php else: ?>
            <a href="login.php"><button class="login-btn">Login</button></a>
            <a href="pages/customer_pages/signup.php"><button class="signup-btn">Sign Up</button></a>
        <?php endif; ?>
    </div>
</nav>

<br><br><br><br><br>
<div class="container">
    <!-- Left side: Images -->
    <div class="product-images">
        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['main_product_image']); ?>" class="main-image" alt="Main Image">
        <div class="small-images">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['second_product_image']); ?>" class="small-image" alt="Second Image">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['third_product_image']); ?>" class="small-image" alt="Third Image">
        </div>
    </div>

    <!-- Right side: Product details -->
    <div class="product-info">
        <h1><?php echo $row['product_name']; ?></h1>
        <h3><?php echo $row['category_name']; ?></h3>
        <p class="product-price">Price: LKR <span id="price"><?php echo $row['price']; ?></span></p>

        <!-- Quantity section -->
        <div class="quantity-section">
            <label for="quantity">Quantity:</label>
            <button class="quantity-btn" onclick="updateQuantity(-1)">-</button>
            <input type="number" id="quantity" value="1" min="1" max="10">
            <button class="quantity-btn" onclick="updateQuantity(1)">+</button>
        </div>

        <!-- Total price -->
        <p class="total-price">Total Price: LKR <span id="total-price"><?php echo $row['price']; ?></span></p>

        <!-- Description -->
        <p class="product-description"><?php echo $row['product_description']; ?></p>

        <!-- Order button -->
        <button class="order-btn" id="order-btn" onclick="handleOrderClick()">Order Now</button>

        <!-- Add to Cart form -->
        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
            <input type="hidden" name="quantity" id="cart-quantity" value="1">
            <button type="submit" class="add-to-cart-btn">Add to Cart</button>
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

<script>
    // Function to update the total price based on quantity
    function updateQuantity(change) {
        let quantity = parseInt(document.getElementById('quantity').value);
        quantity = quantity + change;
        if (quantity < 1) {
            quantity = 1;
        }
        document.getElementById('quantity').value = quantity;

        let price = parseFloat(document.getElementById('price').innerText);
        document.getElementById('total-price').innerText = (price * quantity).toFixed(2);

        // Update hidden input for cart form
        document.getElementById('cart-quantity').value = quantity;
    }

    // Function to handle the Order Now button click
    function handleOrderClick() {
        const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
        if (isLoggedIn) {
            // Redirect to order page if logged in
            window.location.href = '/ordernow.php';
        } else {
            // Show an alert if not logged in
            alert('You need to log in to place an order.');
        }
    }
</script>

</body>
</html>
