<?php

// Include the database connection file
include '../../server/connection.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_REQUEST['name'];
    $description = $_REQUEST['description'];

        // Insert into the appropriate table
        $sqlquery = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";

        // If the connection is successful, run the query
        if ($conn->query($sqlquery) === TRUE) {
			echo "<script>alert('A new Category was added successfully! Redirecting to Category page...');</script>";
            echo "<script>window.location.href = 'view_categories.php';</script>";
        } else {
            // If the query is not successful, display the error message
            echo "Error: " . $sqlquery . "<br>" . $conn->error;
        }
   

    // Close connectionxz
    mysqli_close($conn);
}

?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeLiving Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/admin_styles.css">
</head>

<body>
  <nav id="navbar">
        <ul class="nav-links">
			<li><a href="admin_dashboard.php" >Dashboard</a></li>
			<li><a href="#">Profile </a></li>
			<li><a href="view_categories.php" class ="active">Categories </a></li>
			<li><a href="view_products.php" >Products </a></li>
			<li><a href="#">Customers </a></li>
			<li><a href="#">Orders </a></li>
			<li><a href="#">FAQs</a></li>
            
        </ul>
    </nav>
	
  	<div><button class="back_button" ><a href="view_categories.php"> Back </a></button></div><br><br><br>
	
	<div>
		<form id= "add_category_form" action="add_category.php" method="POST">
			<h2>Add a new Product Category</h2><br>
			<label for="name">Category Name:</label><br>
			<input type="text" id="name" name="name" required><br><br>

			<label for="description">Description:</label><br>
			<textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>

			<input type="submit" id= "submit_category_button" value="Add Category">
		</form>
	</div>
	
	
</body>
</html>