<?php
// Include your database connection file
include '../../server/connection.php';

// Check if the product_id is set in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch the product details from the database
    $product_query = "SELECT p.product_id, p.product_name, p.product_description, p.price,c.name as category_name, p.category_id, p.main_product_image, p.second_product_image, p.third_product_image
                      FROM products p
                      JOIN categories c ON p.category_id = c.category_id
                      WHERE p.product_id = '$product_id'";
    $product_result = mysqli_query($conn, $product_query);

    // Check if the product exists
    if (mysqli_num_rows($product_result) > 0) {
        $product = mysqli_fetch_assoc($product_result);
    } else {
        echo "<script>alert('Product not found!');</script>";
        echo "<script>window.location.href='view_products.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No product selected!');</script>";
    echo "<script>window.location.href='view_products.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product Details</title>
    <link rel="stylesheet" href="../../css/admin_styles.css">
</head>
<body>
    <nav id="navbar">
        <ul class="nav-links">
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="view_categories.php">Categories</a></li>
            <li><a href="view_products.php" class="active">Products</a></li>
            <li><a href="#">Customers</a></li>
            <li><a href="#">Orders</a></li>
            <li><a href="#">FAQs</a></li>
        </ul>
    </nav>

    <div class="content">
		<center><h2>View Product Details</h2></center>
        
        <form id="add_product_form">
            <div class="form-group">
                <label for="product_id">Product ID:</label>
                <input type="text" id="product_id" name="product_id" value="<?php echo $product['product_id']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" value="<?php echo $product['product_name']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="product_description">Product Description:</label>
                <textarea id="product_description" name="product_description" readonly><?php echo $product['product_description']; ?></textarea>
            </div>
			
			<div class="form-group">
                <label for="price">Product Price:</label>
                <input type="text" id="price" name="price" value="<?php echo $product['price']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="category_name">Category:</label>
                <input type="text" id="category_name" name="category_name" value="<?php echo $product['category_name']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="main_product_image">Main Product Image:</label><br>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['main_product_image']); ?>" alt="Main Product Image" style="width:200px;">
            </div>

            <div class="form-group">
                <label for="second_product_image">Second Product Image:</label><br>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['second_product_image']); ?>" alt="Second Product Image" style="width:200px;">
            </div>

            <div class="form-group">
                <label for="third_product_image">Third Product Image:</label><br>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['third_product_image']); ?>" alt="Third Product Image" style="width:200px;">
            </div>

            <div class="button-container">
                <button id="submit_product_button" type="button" onclick="window.location.href='view_products.php';">Back to Products</button>
            </div>
        </form>
    </div>
	
	<br><br>

    <script src="../../js/script.js"></script>
</body>
</html>
