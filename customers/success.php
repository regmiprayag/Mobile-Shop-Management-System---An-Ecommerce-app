<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Success</title>
    <!-- Include any CSS stylesheets or frameworks you need -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <?php
    session_start();
    $erre = $errp = '';
    include 'components/navbar.php';

    // Get form data
    // $customer_name = $_POST['full_name'];
    // $customer_address = $_POST['address'];
    // $customer_city = $_POST['city'];
    // $customer_phone = $_POST['phone'];
    // $product_id = $_GET['id']; // Assuming you are passing product ID via URL parameter
    // $product_model = $row['model']; // Assuming $row contains product details
    // $product_price = $row['price']; // Assuming $row contains product details

    // // Prepare and execute SQL statement to insert data into orders table
    // $sql = "INSERT INTO orders (customer_name, customer_address, customer_city, customer_phone, product_id, product_model, product_price)
    //     VALUES ('$customer_name', '$customer_address', '$customer_city', '$customer_phone', '$product_id', '$product_model', '$product_price')";

    // if (mysqli_query($conn, $sql)) {
    //     // Order inserted successfully
    //     header("Location: success.php");
    //     exit;
    // } else {
    //     // Error handling if insertion fails
    //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    // }

    // // Close database connection
    // mysqli_close($conn);
    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
    // $_SESSION['orderId'];
    $orderId = $_SESSION['orderDetailsId'];
    $sql1 = "SELECT * FROM orders WHERE order_id='$orderId'";
    $result = mysqli_query($conn, $sql);

    // Display mobile products
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Extract data from the fetched row
        $customer_name = $row['customer_name'];
        $customer_address = $row['customer_address'];
        $customer_city = $row['customer_city'];
        $customer_phone = $row['customer_phone'];
        $product_id = $row['product_id'];
        $product_model = $row['product_model'];
        $product_price = $row['product_price'];

        // Construct the INSERT query for the orders table
        $insert_query = "INSERT INTO orders (customer_name, customer_address, customer_city, customer_phone, product_id, product_model, product_price, order_date)
                     VALUES ('$customer_name', '$customer_address', '$customer_city', '$customer_phone', $product_id, '$product_model', $product_price, CURRENT_TIMESTAMP)";

        // Execute the INSERT query
        if (mysqli_query($conn, $insert_query)) {
            // New row inserted successfully
        } else {
            echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
        }
    }


    // $sql1 = "INSERT INTO orders (customer_name, customer_address, customer_city, customer_phone, product_id, product_model, product_price, order_date)
    // VALUES ('$full_name', '$address', '$city', '$phone', $product_id, '$product_model', $price, CURRENT_TIMESTAMP)";

    // if (mysqli_query($conn, $sql1)) {
    //     // echo "Mobile product inserted successfully.";
    //     $orderDetailsId = mysqli_insert_id($conn);
    //     $_SESSION['orderDetailsId'] = $orderDetailsId;
    //     header('location: esewa.php?amount='.$row['price']);
    //     // header('location: https://rc-epay.esewa.com.np/api/epay/main/v2/form');
    // } else {
    //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    // }

    ?>
    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Booking Successful</h2>
            <p>Your booking has been successfully processed. Thank you for your order!</p>
            <!-- Optionally, you can display booking details here -->
            <!-- Example: -->
            <!-- <p>Booking ID: <?php echo $booking_id; ?></p> -->
            <!-- <p>Payment Amount: <?php echo $payment_amount; ?></p> -->
            <!-- Add any other relevant information here -->

            <!-- Provide links for users to navigate -->
            <div class="mt-4">
                <a href="homepage.php" class="text-blue-500 hover:text-blue-700">Go back to homepage</a>
                <!-- Optionally, provide a link to view booking details -->
                <!-- <a href="booking_details.php?booking_id=<?php echo $booking_id; ?>" class="text-blue-500 hover:text-blue-700 ml-4">View Booking Details</a> -->
            </div>
        </div>
    </div>
</body>

<!-- <script>
    let full_name = sessionStorage.getItem('full_name');
    console.log("The fllanem is: ",full_name);
</script> -->

</html>