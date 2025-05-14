<?php
// Include your database connection file
include '../../server/connection.php';

// Fetch categories from the database
$category_query = "SELECT category_id, name FROM categories";
$category_result = mysqli_query($conn, $category_query);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
	$price = $_POST['price'];
    $category_id = $_POST['category_id'];
    
    // Handle image uploads
    $main_product_image = addslashes(file_get_contents($_FILES['main_product_image']['tmp_name']));
    $second_product_image = addslashes(file_get_contents($_FILES['second_product_image']['tmp_name']));
    $third_product_image = addslashes(file_get_contents($_FILES['third_product_image']['tmp_name']));

    // Insert the new product into the database
    $insert_query = "INSERT INTO products (product_name, product_description, price ,category_id, main_product_image, second_product_image, third_product_image) 
                     VALUES ('$product_name', '$product_description','$price' , '$category_id', '$main_product_image', '$second_product_image', '$third_product_image')";

    if (mysqli_query($conn, $insert_query)) {
		echo "<script>alert('A new product was added successfully! Redirecting to products page...');</script>";
        echo "<script>window.location.href = 'view_products.php';</script>";
    } else {
        echo "<script>alert('Error adding product: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - LuxeLiving Admin</title>
    <link rel="stylesheet" href="../../css/admin_styles.css">
</head>
<body>
   <nav id="navbar">
        <ul class="nav-links">
			<li><a href="admin_dashboard.php" >Dashboard</a></li>
			<li><a href="#">Profile </a></li>
			<li><a href="view_categories.php">Categories </a></li>
			<li><a href="view_products.php" class ="active">Products </a></li>
			<li><a href="#">Customers </a></li>
			<li><a href="#">Orders </a></li>
			<li><a href="#">FAQs</a></li>
            
        </ul>
    </nav>
	
  	<div><button class="back_button" ><a href="view_products.php"> Back </a></button></div><br><br><br>

    <div >
        <form id="add_product_form" action="add_product.php" method="POST" enctype="multipart/form-data">
			<h1>Add New Product</h1><br>
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" placeholder="Enter Product Name" required><br>

            <label for="product_description">Product Description:</label>
            <textarea id="product_description" name="product_description" placeholder="Enter Product Description" required></textarea><br>
			
			<label for="product_price">Product price:</label>
            <input type="text" id="price" name="price" placeholder="Enter Product Price in LKR" required><br>

            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
                <option value="">Select a category</option>
                <?php
                while ($row = mysqli_fetch_assoc($category_result)) {
                    echo "<option value='" . $row['category_id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select><br><br><br>

            <label for="main_product_image">Main Product Image:</label>
            <input type="file" id="main_product_image" name="main_product_image" accept="image/*" required><br>

            <label for="second_product_image">Second Product Image:</label>
            <input type="file" id="second_product_image" name="second_product_image" accept="image/*"><br>

            <label for="third_product_image">Third Product Image:</label>
            <input type="file" id="third_product_image" name="third_product_image" accept="image/*"><br>

            <button id="submit_product_button" type="submit">Add Product</button>
		</form>
    </div>

    <script src="../../js/admin_scripts.js"></script>
</body>
</html>
