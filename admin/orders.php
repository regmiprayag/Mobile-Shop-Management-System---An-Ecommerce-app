<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Orders</title>
</head>

<body class="bg-gray-100">
    <?php
        if(isset($_POST['submit'])){
            // echo "hello prayg";
           $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
            $order_id = $_POST['order_id'];

            // Update the status to "Delivered" in the database
            $sql = "UPDATE orders SET status = 'Delivered' WHERE order_id = $order_id";
        
            if (mysqli_query($conn, $sql)) {
                // Status updated successfully
                // echo "Status updated to Delivered.";
            } else {
                // Error updating status
                echo "Error: " . mysqli_error($conn);
            }
            // Close the database connection
            mysqli_close($conn);
        }
    ?>

    <div class="flex">
        <div class="flex h-screen">

            <!-- Sidebar -->
            <div class="bg-indigo-900 text-white w-64 flex flex-col">
                <div class="p-4 border-b border-gray-700">
                    <h2 class="text-lg font-semibold">Admin Dashboard</h2>
                </div>
                <ul class="flex-grow">
                    <!-- Sidebar links -->
                    <a href="homepage.php">
                        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Home</li>
                    </a>
                    <a href="mobile_products.php">
                        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Mobiles</li>
                    </a>
                    <a href="orders.php">
                        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Orders</li>
                    </a>
                    <!-- Add more sidebar links as needed -->
                </ul>
                <div class="p-4 border-t border-gray-700">
                    <!-- Logout button -->
                    <!-- <button class="bg-red-500 text-white px-4 py-2 w-full rounded hover:bg-red-600">Logout</button> -->
                    <a href="logoutAdmin.php"><button class="bg-red-600 w-full px-4 h-10 mt-2 rounded-lg text-white hover:bg-blue-600">Logout</button></a>
                </div>
            </div>
        </div>
        <div class="container mx-auto p-8">
            <h1 class="text-3xl font-semibold mb-4">Orders</h1>

            <!-- Display all mobile products in table format -->
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Customer Name</th>
                        <th class="px-4 py-2">Customer Address</th>
                        <th class="px-4 py-2">Customer City</th>
                        <th class="px-4 py-2">Customer Phone</th>
                        <!-- <th class="px-4 py-2">Product ID</th> -->
                        <!-- <th class="px-4 py-2">Product Model</th> -->
                        <th class="px-4 py-2">Order Date</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP code to fetch and display mobile products -->
                    <?php
                    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
                    $sql = "SELECT * FROM orders";
                    $result = mysqli_query($conn, $sql);

                    // Display mobile products in table rows
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo '<td class="border px-4 py-2">' . $row["customer_name"] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row["customer_address"] . "</td>";
                            echo '<td class="border px-4 py-2">' . $row["customer_city"] . "</td>";
                            echo '<td class="border px-4 py-2">' . $row["customer_phone"] . "</td>";
                            // echo '<td class="border px-4 py-2">' . $row["product_id"] . "</td>";
                            // echo '<td class="border px-4 py-2">' . $row["product_model"] . "</td>";
                            // echo '<td class="border px-4 py-2">' . $row["order_date"] . "</td>";
                            echo '<td class="border px-4 py-2">' . date("Y-m-d", strtotime($row["order_date"])) . "</td>";
                            if($row['status'] == 'Pending'){
                                echo '<div>';
                                echo '<form action="" method="POST">';
                                ?>
                                <input type="hidden" name="order_id" value='<?php echo $row['order_id']; ?>'>
                                <?php
                                // echo '<input type="hidde" name="order_id" value = "" />';
                                // echo '<td class="border bg-red-400 px-4 py-2">' . '<button class="">'. $row["status"] .'</button>' . "</td>";
                                echo '<td class="p-2">' . $row["status"] .  '<button type="submit" name="submit" class="border bg-blue-400 px-4 py-2 mx-2 text-gray-800"> Change </button>'  . "</td>";
                                echo '</form>';
                                echo "</div>";
                            }
                            else{
                                echo '<td class="border bg-green-400 px-4 py-2">' . $row["status"] . "</td>";
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo '<tr><td class="border px-4 py-2" colspan="6">No mobile products found.</td></tr>';
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