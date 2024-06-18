<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - E-MobileMart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .quantity-btn {
            cursor: pointer;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            color: white;
        }

        .quantity-btn.add {
            background-color: #4CAF50;
        }

        .quantity-btn.subtract {
            background-color: #f44336;
        }
    </style>
</head>

<body class="bg-gray-100">

    <?php
    session_start();
    // Include database connection and header
    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
    $c_id = $_SESSION['customer_id'];

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $erre = $errp = '';
    include '../components/navbarCart.php';
    ?>

    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-4">Shopping Cart</h1>
        <div class="overflow-x-auto">
            <form action="" method="POST">
                <table class="w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Product Name</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Quantity</th>
                            <th class="px-4 py-2">Total</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         if(isset($_POST['submit'])){
                            // header("location: ../booking/sooking.php");
                            // hey gpt, i want to insert the data of the cart in the newly created table new_order here.
                                // Insert data into new_order table
                                $sql = "SELECT * FROM cart WHERE customer_id = $c_id";
                                $result = mysqli_query($conn, $sql);
                            
                                if (!$result) {
                                    die("Query failed: " . mysqli_error($conn));
                                }
                            
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $productId = $row['product_id'];
                                    $quantity = $row['quantity'];
                            
                                    $productSql = "SELECT * FROM mobile_product WHERE id = $productId";
                                    $productResult = mysqli_query($conn, $productSql);
                            
                                    if (!$productResult) {
                                        die("Product query failed: " . mysqli_error($conn));
                                    }
                            
                                    $productRow = mysqli_fetch_assoc($productResult);
                                    $mobileName = $productRow['model'];
                                    $price = $productRow['price'];
                            
                                    // Insert into new_order table
                                    $insertSql = "INSERT INTO new_order (mobile_name, quantity, price, customer_id) VALUES ('$mobileName', $quantity, $price, $c_id)";
                                    if (!mysqli_query($conn, $insertSql)) {
                                        die("Insert query failed: " . mysqli_error($conn));
                                    }
                                }
                            
                                // Redirect to the booking page
                                header("Location: ../booking/sooking.php");
                                exit;
                        }

                        // Fetch cart items from the database
                        $sql = "SELECT * FROM cart WHERE customer_id = $c_id";
                        $result = mysqli_query($conn, $sql);

                        // Check if query execution was successful
                        if (!$result) {
                            die("Query failed: " . mysqli_error($conn));
                        }

                        $totalPrice = 0; // Initialize total price variable

                        while ($row = mysqli_fetch_assoc($result)) {
                            // Get product details from the mobile_products table
                            $productId = $row['product_id'];
                            $productSql = "SELECT * FROM mobile_product WHERE id = $productId";
                            $productResult = mysqli_query($conn, $productSql);

                            // Check if product query execution was successful
                            if (!$productResult) {
                                die("Product query failed: " . mysqli_error($conn));
                            }

                            $productRow = mysqli_fetch_assoc($productResult);

                            // Calculate the total price of each product
                            $productPrice = $productRow['price'];
                            $quantity = $row['quantity'];
                            $totalPrice += ($productPrice * $quantity);
                            $_SESSION['total_price']=$totalPrice;

                            // Display cart items
                            echo "<tr>";
                            echo "<td class='border px-4 py-2'>" . $productRow['model'] . "</td>";
                            echo "<td class='border px-4 py-2'>$" . $productPrice . "</td>";
                            echo "<td class='border px-4 py-2'><span class='quantity'>" . $quantity . "</span></td>";
                            echo "<td class='border px-4 py-2 total'>$" . ($productPrice * $quantity) . "</td>";
                            echo "<td class='border px-4 py-2'>";
                            echo "<button class='quantity-btn mx-2 subtract' data-type='subtract' data-id='" . $productId . "'>-</button>";
                            echo "<button class='quantity-btn add' data-type='add' data-id='" . $productId . "'>+</button>";
                            // Add link to delete the product from cart
                            echo "<a href='delete_cart.php?id=" . $productId . "' class='bg-red-600 p-2 rounded text-white ml-2'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";

                            // Add hidden input fields for each product
                            echo "<input type='hidden' name='product_ids[]' value='" . $productId . "'>";
                            echo "<input type='hidden' name='quantities[]' value='" . $quantity . "'>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="mt-4 flex justify-end">
                    <strong>Total Price: $<span id="total-price"><?php echo $totalPrice; ?></span></strong>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-4" name="submit">Proceed to Payment</button>
                <!-- echo '<a href="booking/sooking.php?id=' . $row['id'] . ' "><button class="bg-blue-600 text-gray-100 px-6 w-32 p-2 rounded-lg hover:bg-blue-800">Buy Now</button></a>'; -->

            </form>
        </div>
    </div>

    <?php
    // Include footer
    include('../components/footer.php');
    ?>

    <script>
        $(document).ready(function() {
            $(".quantity-btn").click(function(event) {
                event.preventDefault();

                var type = $(this).data('type');
                var quantityElement = $(this).closest('tr').find('.quantity');
                var totalElement = $(this).closest('tr').find('.total');
                var currentQuantity = parseInt(quantityElement.text());
                var productPrice = parseFloat($(this).closest('tr').find('td:nth-child(2)').text().replace('$', ''));

                if (type === 'add') {
                    var newQuantity = currentQuantity + 1;
                } else if (type === 'subtract' && currentQuantity > 1) {
                    var newQuantity = currentQuantity - 1;
                } else {
                    alert("Quantity cannot be less than 1");
                    return;
                }

                // Update quantity on the page
                quantityElement.text(newQuantity);

                // Update total for the product
                var newTotal = newQuantity * productPrice;
                totalElement.text('$' + newTotal.toFixed(2));

                // Update overall total price
                var totalPriceElement = $("#total-price");
                var totalPrice = 0;
                $(".total").each(function() {
                    totalPrice += parseFloat($(this).text().replace('$', ''));
                });
                totalPriceElement.text(totalPrice.toFixed(2));
            });
        });
    </script>
</body>

</html>
