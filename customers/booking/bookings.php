<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking page</title>
</head>

<body class="bg-gray-100">
    <?php
    session_start();
    $erre = $errp = '';
    include '../components/navbar.php';
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking Page</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body class="bg-gray-100">
        <?php
        $id = $_GET['id'];
        // Connect to the database
        $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch mobile products from the database
        $sql = "SELECT * FROM mobile_product WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $url = "https://uat.esewa.com.np/epay/main";
        $data = [
            'amt' => 100,
            'pdc' => 0,
            'psc' => 0,
            'txAmt' => 0,
            'tAmt' => 100,
            'pid' => 'ee2c3ca1-696b-4cc5-a6be-2c40d929d453',
            'scd' => 'EPAYTEST',
            'su' => 'http://merchant.com.np/page/esewa_payment_success?q=su',
            'fu' => 'http://merchant.com.np/page/esewa_payment_failed?q=fu'
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        ?>

        <?php
        if (isset($_POST['submit'])) {
            // echo "Hello";
            $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
            if (!$conn) {
                $errp = "Database not connected";
            }
            $full_name = $_POST['full_name'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $phone = $_POST['phone'];
            $product_id = $row['id'];
            $product_model = $row['model'];
            $price = $row['price'];

            $sql1 = "INSERT INTO orderDetails (customer_name, customer_address, customer_city, customer_phone, product_id, product_model, product_price, order_date)
            VALUES ('$full_name', '$address', '$city', '$phone', $product_id, '$product_model', $price, CURRENT_TIMESTAMP)";

            if (mysqli_query($conn, $sql1)) {
                // echo "Mobile product inserted successfully.";
                $orderDetailsId = mysqli_insert_id($conn);
                $_SESSION['orderDetailsId'] = $orderDetailsId;
                header('location: esewa.php?amount=' . $row['price']);
                // header('location: https://rc-epay.esewa.com.np/api/epay/main/v2/form');
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
        ?>

        <div class="container mx-auto mt-8 flex">
            <!-- Mobile Image -->
            <div class="mx-4">
                <?php
                // Render mobile image
                echo '<img src="../../admin/products/uploads/' . $row['image'] . '" alt="Mobile Image" class="w-96 h-96">';
                ?>
                <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
                    <!-- Product Title -->
                    <h1 class="text-2xl font-bold mb-4"><?php echo $row['model']; ?></h1>
                    <p class="text-xl text-gray-700 mb-4">RS. <?php echo $row['price']; ?></p>
                    <div class="flex items-center text-gray-600 mb-4">
                        <p class="mr-4">Storage: <?php echo $row['storage']; ?> GB</p>
                        <p class="mr-4">RAM: <?php echo $row['ram']; ?> GB</p>
                    </div>
                    <p class="mr-4 my-4">Brand: <?php echo $row['brand']; ?></p>
                </div>
            </div>

            <!-- Product Details -->
            <div>


                <!-- <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
                    <input type="hidden" id="amount" name="amount" value="<?php echo (int)$row['price']; ?>" required>
                    <input type="hidden" id="tax_amount" name="tax_amount" value="0" required>
                    <input type="hidden" id="total_amount" name="total_amount" value="<?php echo (int)$row['price']; ?>" required>
                    <input type="hidden" id="transaction_uuid" name="transaction_uuid" required>
                    <input type="hidden" id="product_code" name="product_code" value="EPAYTEST" required>
                    <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
                    <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
                    <input type="hidden" id="success_url" name="success_url" value="https://esewa.com.np" required>
                    <input type="hidden" id="failure_url" name="failure_url" value="https://google.com" required>
                    <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
                    <input type="hidden" id="signature" name="signature" required>
                    <br> -->
                <!-- <button type=" submit" class="bg-blue-500 text-white px-8 py-3 rounded-lg hover:bg-blue-600">Buy Now</button> -->
                <!-- </form> -->
            </div>

            <div class="mx-20">
                <div class="mx-auto bg-white p-8 rounded-lg shadow-md w-96">
                    <h2 class="text-2xl font-bold mb-4">Shipping Details</h2>
                    <!-- action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" id="shippingForm"-->
                    <form method="POST">
                        <div class="mb-4">
                            <label for="full_name" class="block text-gray-700 text-sm font-bold mb-2">Full Name:</label>
                            <input type="text" id="full_name" name="full_name" class="form-input w-full border border-gray-200 p-2" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-4">
                            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
                            <textarea id="address" name="address" class="form-textarea w-full border border-gray-200 p-2" placeholder="Enter your address" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="city" class="block text-gray-700 text-sm font-bold mb-2">City:</label>
                            <input type="text" id="city" name="city" class="form-input w-full border border-gray-200 p-2" placeholder="Enter your city" required>
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                            <input type="text" id="phone" name="phone" class="form-input w-full border border-gray-200 p-2" placeholder="Enter your phone number" required>
                        </div>
                        <button type="submit" name="submit" class="bg-blue-500 text-white px-8 py-3 rounded-lg hover:bg-blue-600">Order Now</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include '../components/footer.php';
        ?>
    </body>
    </html>
</body>

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
    var signature = `total_amount=<?php echo (int)$row['price']; ?>,transaction_uuid=${id},product_code=EPAYTEST`;

    var hash = CryptoJS.HmacSHA256(signature, secret);
    var hashInBase64 = CryptoJS.enc.Base64.stringify(hash);

    var sig = document.getElementById('signature');
    // console.log(sig);
    tuid.value = id;
    sig.value = hashInBase64;

    // console.log("hello prayag");
    let userDetails;

    // let name = document.getElementById("full_name").value;
    // console.log("Name= ",name);

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
</script>

</html>