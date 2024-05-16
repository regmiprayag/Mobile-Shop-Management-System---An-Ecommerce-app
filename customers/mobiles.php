<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
<?php
    session_start();
    $erre = $errp = '';
    include 'components/navbar.php';
    $customer_id = $_SESSION['customer_id'];
    ?>
    <div class="flex">
        <div class="container mx-auto p-8">
            <h1 class="text-3xl font-semibold mb-4">Mobile Products</h1>

            <!-- Display all mobile products in table format -->
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Model</th>
                        <th class="px-4 py-2">Brand</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Storage</th>
                        <th class="px-4 py-2">RAM</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP code to fetch and display mobile products -->
                    <?php
                    // Include database connection
                    // include 'db_connection.php';
                    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
                    //    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

                    // Fetch all mobile products from the database
                    $sql = "SELECT * FROM mobile_product";
                    $result = mysqli_query($conn, $sql);

                    // Display mobile products in table rows
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td class="border px-4 py-2">' . $row['model'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['brand'] . '</td>';
                            echo '<td class="border px-4 py-2">$' . $row['price'] . '</td>';
                            echo '<td class="border px-4 py-2">' . $row['storage'] . ' GB</td>';
                            echo '<td class="border px-4 py-2">' . $row['ram'] . ' GB</td>';
                            echo '<td class="border px-4 py-2">';
                            echo '<a href="cart/addToCart.php?id=' . $row['id'] . ' "><button class="bg-gray-800 text-gray-200 px-6 mr-2 w-36 p-2 hover:bg-red-800">Add To Cart</button></a>';
                            echo '</td>';
                            echo '</tr>';
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