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

    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
    $orderId = $_SESSION['orderDetailsId'];
    // Assuming $orderDetailsId contains the ID of the row to be deleted
    $sql2 = "DELETE FROM orderDetails WHERE order_Id = $orderId";

    // Execute the query
    if (mysqli_query($conn, $sql2)) {
        // Row deleted successfully
    } else {
        echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
    }

    ?>
    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Payment Failed</h2>
            <p>Sorry, the payment transaction could not be completed successfully.</p>
            <p>Please try again later or contact customer support for assistance.</p>

            <!-- Provide links for users to navigate -->
            <div class="mt-4">
                <a href="homepage.php" class="text-blue-500 hover:text-blue-700">Go back to homepage</a>
            </div>
        </div>
    </div>
</body>

</html>