<?php
// Include the database connection file
include '../../server/connection.php';

// Handle delete action
if (isset($_GET['delete_id'])) {
    $category_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM categories WHERE category_id=$category_id";
    if ($conn->query($delete_query) === TRUE) {
        echo "<script>alert('Category deleted successfully!');</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch categories data from the database
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

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
    <nav id="navbar">
        <ul class="nav-links">
			<li><a href="admin_dashboard.php">Dashboard</a></li>
			<li><a href="#">Profile </a></li>
			<li><a href="view_categories.php" class="active">Categories </a></li>
			<li><a href="view_products.php">Products </a></li>
			<li><a href="#">Customers </a></li>
			<li><a href="#">Orders </a></li>
			<li><a href="#">FAQs</a></li>
            
        </ul>
    </nav>
	
	
    <div >
		<center><h1>Manage Product Categories</h1></center>
        <div class="button-container">
			<button class="back-button" ><a href="Admin_dashboard.html"> </a>Back</button>
			<a href="add_category.php" class="add-button">Add a New Category</a>
		</div>
		<center>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['category_id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td>
                                <a href="view_categories.php?delete_id=<?php echo $row['category_id']; ?>" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">No categories found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
			</table></center>
    </div><br><br>

	
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
