<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Success</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <?php
    session_start();
    include 'components/navbar.php';
    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve order ID from session
    $orderId = $_SESSION['orderDetailsId'];

    // Check if order ID is set
    if (!$orderId) {
        header('location: homepage.php');
        exit(); // Stop further execution
    }

    $customer_id = $_SESSION['customer_id'];

    // Query to retrieve shipping information
    $sql = "SELECT * FROM shipping WHERE customer_id='$customer_id'";
    $result = mysqli_query($conn, $sql);

    // Check if query execution was successful
    if (!$result) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit(); // Stop further execution
    }

    // Check if there are rows returned
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Extract data from the fetched row
        $customer_name = $row['customer_name'];
        $customer_address = $row['customer_address'];
        $customer_city = $row['customer_city'];
        $customer_phone = $row['customer_phone'];

        // Construct the INSERT query for the orders table
        $insert_query = "INSERT INTO orders (customer_name, customer_address, customer_city, customer_phone, order_date)
                         VALUES ('$customer_name', '$customer_address', '$customer_city', '$customer_phone', CURRENT_TIMESTAMP)";

        // Execute the INSERT query
        if (mysqli_query($conn, $insert_query)) {
            // New row inserted successfully, now delete the order details
            $customer_id = $_SESSION['customer_id'];
            $delete_query = "DELETE FROM cart WHERE customer_id = $customer_id";
            if (mysqli_query($conn, $delete_query)) {
                // Row deleted successfully
                unset($_SESSION['orderDetailsId']); // Unset session variable
            } else {
                echo "Error deleting order details: " . mysqli_error($conn);
            }
        } else {
            echo "Error inserting order: " . mysqli_error($conn);
        }
    } else {
        echo "No shipping information found for order ID: $orderId";
    }
    ?>

    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Booking Successful</h2>
            <p>Your booking has been successfully processed. Thank you for your order!</p>

            <!-- Provide links for users to navigate -->
            <div class="mt-4">
                <a href="homepage.php" class="text-blue-500 hover:text-blue-700">Go back to homepage</a>
            </div>
        </div>
    </div>
</body>

</html>
