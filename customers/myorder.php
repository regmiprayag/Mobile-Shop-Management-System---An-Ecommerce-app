<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Items</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <?php
    session_start();
    $erre = $errp = '';
    include 'components/navbar.php';
    $customer_id = $_SESSION['customer_id'];
    ?>
    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">My Orders</h2>
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Order ID</th>
                        <th class="px-4 py-2">Product Name</th>
                        <th class="px-4 py-2">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Establish connection to database
                    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

                    // Check if connection was successful
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    // Fetch data from myorder table
                    $sql = "SELECT * FROM myorder WHERE customer_id = $customer_id";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row of the result set
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Display order details in table rows
                            echo "<tr>";
                            echo "<td class='border px-4 py-2'>" . $row['myorder_id'] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row['product_name'] . "</td>";
                            echo "<td class='border px-4 py-2'>" . $row['quantity'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // No rows found in myorder table
                        echo "<tr><td colspan='3'>No orders found</td></tr>";
                    }

                    // Close database connection
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>