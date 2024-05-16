<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Success</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Booking Successful</h2>
            <?php
            session_start();
            include 'components/navbar.php';
            $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
        
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
        
            $customer_id = $_SESSION['customer_id'];
            $cart_query = "SELECT * FROM cart WHERE customer_id = '$customer_id'";
            $cart_result = mysqli_query($conn, $cart_query);

            if (mysqli_num_rows($cart_result) > 0) {
                $cart_row = mysqli_fetch_assoc($cart_result);
                $product_name = $cart_row['product_name'];
                $quantity = $cart_row['quantity'];
            } else {
                echo '<p class="text-red-500">Error: Product not found in cart.</p>';
                exit;
            }

            // Fetch data from shipping table
            $customer_name = '';
            $address = '';
            $phone = '';

            $shipping_query = "SELECT * FROM shipping WHERE customer_id = '$customer_id'";
            $shipping_result = mysqli_query($conn, $shipping_query);

            if (mysqli_num_rows($shipping_result) > 0) {
                $shipping_row = mysqli_fetch_assoc($shipping_result);
                $customer_name = $shipping_row['customer_name'];
                $address = $shipping_row['address'];
                $phone = $shipping_row['phone'];
            } else {
                echo '<p class="text-red-500">Error: Shipping details not found.</p>';
                exit;
            }

            // Insert data into order table
            $order_insert_sql = "INSERT INTO `order` (customer_name, product_name, quantity, address, phone) VALUES ('$customer_name', '$product_name', '$quantity', '$address', '$phone')";

            if (mysqli_query($conn, $order_insert_sql)) {
                // Delete record from cart table
                $delete_cart_sql = "DELETE FROM cart WHERE customer_id = '$customer_id'";
                if (!mysqli_query($conn, $delete_cart_sql)) {
                    echo '<p class="text-red-500">Error deleting record from cart table: ' . mysqli_error($conn) . '</p>';
                }

                // Delete record from shipping table
                $delete_shipping_sql = "DELETE FROM shipping WHERE customer_id = '$customer_id'";
                if (!mysqli_query($conn, $delete_shipping_sql)) {
                    echo '<p class="text-red-500">Error deleting record from shipping table: ' . mysqli_error($conn) . '</p>';
                }

                echo '<p class="text-green-500">Your booking has been successfully processed. Thank you for your order!</p>';
            } else {
                echo '<p class="text-red-500">Error: ' . mysqli_error($conn) . '</p>';
            }

            // Close connection
            mysqli_close($conn);
            ?>
            <div class="mt-4">
                <a href="homepage.php" class="text-blue-500 hover:text-blue-700">Go back to homepage</a>
            </div>
        </div>
    </div>
</body>

</html>
