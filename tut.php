Step 1: yesma hamley click garxam.
echo '<a href="cart/addToCart.php?id=' . $row['id'] . ' "><button class="bg-gray-800 text-gray-200 px-6 mr-2 w-36 p-2 hover:bg-red-800">Add To Cart</button></a>';


Step 2: ani add to cart page banayera yesari add to cart garxam.
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
        $sql = "INSERT INTO cart (product_id, customer_id, quantity) VALUES ('$productId', '$c_id', 1)";
        $sql1 = "INSERT INTO myorder (product_id, customer_id, quantity) VALUES ('$productId', '$c_id', 1)";

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


Step 3: aba cart bhanni table maa insert bhaisakxa. Then cart page banayera cart maa bhako items lai display garxam.
<body class="bg-gray-100">

    <?php
    session_start();
    // Include database connection and header
    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $erre = $errp = '';
    include '../components/navbar.php';
    ?>

    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-4">Shopping Cart</h1>
        <div class="overflow-x-auto">
            <form action="../booking/sooking.php" method="POST">
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
                        // Fetch cart items from the database
                        $sql = "SELECT * FROM cart";
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
                            echo "<td class='border px-4 py-2'><span class='quantity'>" . $quantity . "</span>";
                            echo "<td class='border px-4 py-2'>$" . ($productPrice * $quantity) . "</td>";
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
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-4">Proceed to Payment</button>
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
            $('.delete-btn').click(function() {
                var productId = $(this).data('id');
                $.ajax({
                    url: 'delete_cart.php',
                    method: 'POST',
                    data: {
                        id: productId
                    },
                    success: function(response) {
                        // Handle success response
                        console.log('Product deleted successfully');
                        // Optionally update the UI to reflect changes
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting product:', xhr.responseText);
                        // Handle error response
                    }
                });
            });
        });

        $(document).ready(function() {
            $(".quantity-btn").click(function() {
                var type = $(this).data('type');
                var productId = $(this).data('id');
                var quantityElement = $(this).closest('tr').find('.quantity');
                var currentQuantity = parseInt(quantityElement.text());

                if (type === 'add') {
                    // Increase quantity by 1
                    var newQuantity = currentQuantity + 1;
                } else if (type === 'subtract' && currentQuantity > 1) {
                    // Decrease quantity by 1 if quantity is greater than 1
                    var newQuantity = currentQuantity - 1;
                } else {
                    // Quantity should not be less than 1
                    alert("Quantity cannot be less than 1");
                    return;
                }

                // Update quantity in the database via AJAX
                $.ajax({
                    type: "POST",
                    url: "update_cart.php",
                    data: {
                        productId: productId,
                        quantity: newQuantity
                    },
                    success: function(response) {
                        // Update quantity on the page
                        quantityElement.text(newQuantity);

                        // Update total price
                        var totalPrice = parseFloat($("#total-price").text());
                        var productPrice = parseFloat(quantityElement.closest('tr').find('td:nth-child(2)').text().replace('$', ''));
                        var totalPriceDiff = (newQuantity - currentQuantity) * productPrice;
                        totalPrice += totalPriceDiff;
                        $("#total-price").text(totalPrice.toFixed(2));
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Error occurred while updating quantity. Please try again.");
                    }
                });
            });
        });
    </script>
</body>


Step 4: Then esewa ko lagi booking page haru banayera booking garna ko lagi esewa maa request pathaidinxam.
<body>
    <?php
    $price = $_GET['amount'];
    ?>
    <form method="post" id="shippingForm">
        <input type="hidden" id="amount" name="amount" value="<?php echo (int)$price; ?>" required>
        <input type="hidden" id="tax_amount" name="tax_amount" value="0" required>
        <input type="hidden" id="total_amount" name="total_amount" value="<?php echo (int)$price; ?>" required>
        <input type="hidden" id="transaction_uuid" name="transaction_uuid" required>
        <input type="hidden" id="product_code" name="product_code" value="EPAYTEST" required>
        <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
        <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
        <input type="hidden" id="success_url" name="success_url" value="http://localhost/MobileStoreSP/customers/success.php" required>
        <input type="hidden" id="failure_url" name="failure_url" value="http://localhost/MobileStoreSP/customers/failure.php?param1=value1" required>
        <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
        <input type="hidden" id="signature" name="signature" required>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1
/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1
/hmac-sha256.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1
/enc-base64.min.js"></script>
    <script>
        var uuid = performance.now();
        var id = `${uuid}`.replace('.', '-');
        // console.log(id);

        var tuid = document.getElementById('transaction_uuid');
        var secret = '8gBm/:&EnhH.1/q';
        var signature = `total_amount=<?php echo (int)$price; ?>,transaction_uuid=${id},product_code=EPAYTEST`;

        var hash = CryptoJS.HmacSHA256(signature, secret);
        var hashInBase64 = CryptoJS.enc.Base64.stringify(hash);


        var sig = document.getElementById('signature');
        // console.log("The sig bharkharai is: ",sig);
        tuid.value = id;
        sig.value = hashInBase64;

        if (hashInBase64) {
            myFunction();
        }
        let userDetails;

        function storeFormData() {
            // Get form elements
            var fullNameInput = document.getElementById('full_name');
            var addressInput = document.getElementById('address');
            var cityInput = document.getElementById('city');
            var phoneInput = document.getElementById('phone');

            // Store form data in sessionStorage
            sessionStorage.setItem('full_name', fullNameInput.value);
            sessionStorage.setItem('address', addressInput.value);
            sessionStorage.setItem('city', cityInput.value);
            sessionStorage.setItem('phone', phoneInput.value);

        }

        // Add event listener to form submission
        document.getElementById('shippingForm').addEventListener('submit', function(event) {
            // Store form data in sessionStorage before submitting the form
            storeFormData();
        });

        function myFunction() {
            var formElem = document.getElementById('shippingForm');
            formElem.setAttribute('action', 'https://rc-epay.esewa.com.np/api/epay/main/v2/form');
            // console.log("The form elements are: ",formElem);
            formElem.submit();
        }
    </script>