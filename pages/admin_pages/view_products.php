<?php
// Include your database connection file
include '../../server/connection.php';

// Handle delete request
if (isset($_GET['delete_product_id'])) {
    $delete_product_id = $_GET['delete_product_id'];

    // Delete the product from the database
    $delete_query = "DELETE FROM products WHERE product_id = '$delete_product_id'";
    
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Product deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting product: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch products from the database
$product_query = "SELECT p.product_id, p.product_name, p.product_description, p.price ,c.name as category_name, p.main_product_image, p.second_product_image, p.third_product_image
                  FROM products p
                  JOIN categories c ON p.category_id = c.category_id";
$product_result = mysqli_query($conn, $product_query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeLiving Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/admin_styles.css">
</head>
<body>
   <!-- <div class="sidebar">
        <img src="../../images/HD1.jpg" alt="Profile Image">
        <h2>LuxeLiving Admin</h2>
        <a href="#" class ="active">Dashboard</a>
        <a href="#">Profile </a>
		<a href="view_categories.php">Categories </a>
        <a href="view_products.php">Products </a>
        <a href="#">Customers </a>
        <a href="#">Orders </a>
        <a href="#">FAQs</a>
    </div>-->
	
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
    
	<center><h1>Manage Products</h1></center>
	<div class="button-container">
        <button class="back-button" ><a href="Admin_dashboard.html"> </a>Back</button>
        <a href="add_product.php" class="add-button">Add a New Product</a>
    </div>
	
	
    <div>
        <table >
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Description</th>
				<th>Price(LKR)</th>
                <th>Category</th>
                <th>Main Image</th>
                <th>Second Image</th>
                <th>Third Image</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($product_result)) {
                echo "<tr>";
                echo "<td>" . $row['product_id'] . "</td>";
                echo "<td>" . $row['product_name'] . "</td>";
                echo "<td>" . $row['product_description'] . "</td>";
				echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['category_name'] . "</td>";
                echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['main_product_image']) . "' alt='Main Image'></td>";
                echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['second_product_image']) . "' alt='Second Image'></td>";
                echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['third_product_image']) . "' alt='Third Image'></td>";
                echo "<td class='action_buttons'>";
				echo "<a href='view_a_product.php?product_id=" . $row['product_id'] . "' class='view'>View</a>";
                echo "<a href='update_product.php?product_id=" . $row['product_id'] . "' class='update'>Update</a>";
                echo "<a href='view_products.php?delete_product_id=" . $row['product_id'] . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
	
	<script src="../../js/script.js"></script>
</body>
</html>

