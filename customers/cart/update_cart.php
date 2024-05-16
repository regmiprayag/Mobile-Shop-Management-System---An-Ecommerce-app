<?php
session_start();

// Include database connection
$conn = mysqli_connect('localhost', 'root', '', 'summerProject');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary parameters are provided
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        // Sanitize inputs to prevent SQL injection
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

        // Update the quantity in the cart table
        $sql = "UPDATE cart SET quantity = $quantity WHERE product_id = $product_id";

        if (mysqli_query($conn, $sql)) {
            // Update successful
            echo "Quantity updated successfully.";
        } else {
            // Update failed
            echo "Error updating quantity: " . mysqli_error($conn);
        }
    } else {
        // Missing parameters
        echo "Product ID and quantity must be provided.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}

// Close database connection
mysqli_close($conn);
?>
