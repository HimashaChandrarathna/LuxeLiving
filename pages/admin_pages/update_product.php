<?php
// Include your database connection file
include '../../server/connection.php';

// Get the product ID from the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch product details from the database
    $product_query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($product_query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product_result = $stmt->get_result();

    if ($product_result->num_rows == 1) {
        $product = $product_result->fetch_assoc();
    } else {
        echo "<script>alert('Product not found!'); window.location.href = 'view_products.php';</script>";
        exit();
    }
}

// Handle form submission
if (isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    // Handle image uploads
    $main_product_image = !empty($_FILES['main_product_image']['tmp_name']) ? file_get_contents($_FILES['main_product_image']['tmp_name']) : $product['main_product_image'];
    $second_product_image = !empty($_FILES['second_product_image']['tmp_name']) ? file_get_contents($_FILES['second_product_image']['tmp_name']) : $product['second_product_image'];
    $third_product_image = !empty($_FILES['third_product_image']['tmp_name']) ? file_get_contents($_FILES['third_product_image']['tmp_name']) : $product['third_product_image'];

    // Update the product in the database
    $update_query = "UPDATE products SET 
                        product_name = ?, 
                        product_description = ?, 
                        price = ?, 
                        category_id = ?, 
                        main_product_image = ?, 
                        second_product_image = ?, 
                        third_product_image = ? 
                    WHERE product_id = ?";

    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssdisbbi", 
        $product_name, 
        $product_description, 
        $price, 
        $category_id, 
        $main_product_image, 
        $second_product_image, 
        $third_product_image, 
        $product_id);

    // Bind binary data separately
    $stmt->send_long_data(4, $main_product_image);
    $stmt->send_long_data(5, $second_product_image);
    $stmt->send_long_data(6, $third_product_image);

    if ($stmt->execute()) {
        echo "<script>alert('Product was updated successfully! Redirecting to products page...');</script>";
        echo "<script>window.location.href = 'view_products.php';</script>";
    } else {
        echo "<script>alert('Error updating product: " . $stmt->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
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
    </nav><br>    

    <center><h2>Update Product</h2></center>
    <form id="add_product_form" action="update_product.php?product_id=<?= $product_id ?>" method="POST" enctype="multipart/form-data">
        <label for="product_id">Product ID (Read-only):</label>
        <input type="text" name="product_id" value="<?= $product['product_id'] ?>" readonly><br>

        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" value="<?= $product['product_name'] ?>" required><br>

        <label for="product_description">Product Description:</label>
        <textarea name="product_description" required><?= $product['product_description'] ?></textarea><br>

        <label for="price">Price:</label>
        <input type="text" name="price" value="<?= $product['price'] ?>" required><br>

        <label for="category_id">Category:</label>
        <select name="category_id">
            <?php
            // Fetch categories from the database
            $category_query = "SELECT * FROM categories";
            $category_result = mysqli_query($conn, $category_query);
            while ($category = mysqli_fetch_assoc($category_result)) {
                $selected = $product['category_id'] == $category['category_id'] ? 'selected' : '';
                echo "<option value='" . $category['category_id'] . "' $selected>" . $category['name'] . "</option>";
            }
            ?>
        </select><br><br>

        <label for="main_product_image">Main Image:</label>
        <input type="file" name="main_product_image"><br>
        <?php if ($product['main_product_image']): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($product['main_product_image']) ?>" alt="Main Image" style="width:100px;"><br>
        <?php endif; ?>

        <label for="second_product_image">Second Image:</label>
        <input type="file" name="second_product_image"><br>
        <?php if ($product['second_product_image']): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($product['second_product_image']) ?>" alt="Second Image" style="width:100px;"><br>
        <?php endif; ?>

        <label for="third_product_image">Third Image:</label>
        <input type="file" name="third_product_image"><br>
        <?php if ($product['third_product_image']): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($product['third_product_image']) ?>" alt="Third Image" style="width:100px;"><br>
        <?php endif; ?>

		<br>
        <input id="submit_product_button" type="submit" name="update_product" value="Update Product">
		<br><br>
        <center><input id="cancel_button" type="button" value="Cancel" onclick="window.location.href='view_products.php';"></center>
    </form>
</body>
</html>
