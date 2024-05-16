<?php
session_start();

// Include database connection
$conn = mysqli_connect('localhost', 'root', '', 'summerProject');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$c_id = $_SESSION['customer_id'];

// Check if action is add and product ID is provided
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Check if the product is already in the cart
    $checkSql = "SELECT * FROM cart WHERE product_id = '$productId' AND customer_id = '$c_id'";
    $result = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($result) > 0) {
        // Product already in cart, display message
        echo '<script>alert("Item already available in your cart.");</script>';
        echo '<script>window.location.href = "../homepage.php";</script>';

    } else {
        // Insert the product into the cart table
        $product_name = $_SESSION['product_model'];
        $sql = "INSERT INTO cart (product_id, customer_id, quantity, product_name) VALUES ('$productId', '$c_id', 1, '$product_name')";
        $sql1 = "INSERT INTO myorder (product_id, customer_id, quantity,product_name) VALUES ('$productId', '$c_id', 1, '$product_name')";

        if (mysqli_query($conn, $sql)) {
            // echo "Product added to cart successfully.";
            // Redirect back to the homepage
            echo '<script>alert("Item added in your cart.");</script>';
            echo '<script>window.location.href = "../homepage.php";</script>';

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>
