<?php
session_start();
// Include database connection
$conn = mysqli_connect('localhost', 'root', '', 'summerProject');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if product ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the product ID to prevent SQL injection
    $productId = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to delete the product from the cart
    $deleteSql = "DELETE FROM cart WHERE product_id = '$productId'";

    if (mysqli_query($conn, $deleteSql)) {
        // Product deleted successfully
        // Redirect back to the cart page or show a success message
        header('Location: cart.php');
        exit();
    } else {
        // Error occurred while deleting the product
        // You can handle the error as per your requirement
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Invalid or missing request parameters
    http_response_code(400); // Bad request
    echo "Invalid request";
}
?>
