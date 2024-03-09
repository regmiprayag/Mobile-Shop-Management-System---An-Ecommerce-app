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
                    <a href="customers.php">
                        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Customers</li>
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
                            echo '<a href="./products/edit_mobile_product.php?id=' . $row['id'] . '" class="bg-blue-500 text-white px-3 py-1 rounded-lg mr-2">Edit</a>';
                            echo '<a href="./products/delete_mobile_product.php?id=' . $row['id'] . '" class="bg-red-500 text-white px-3 py-1 rounded-lg">Delete</a>';
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