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
    session_start();
    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    include '../components/navbarCart.php';
    ?>

    <?php
    $total_price = $_SESSION['total_price'];
    $customer_id = $_SESSION['customer_id'];

    if (isset($_POST['submit'])) {
        $full_name = $_POST['full_name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $phone = $_POST['phone'];

        $sql = "INSERT INTO shipping (customer_name, customer_address, customer_city, customer_phone, order_date,customer_id)
            VALUES ('$full_name', '$address', '$city', '$phone', CURRENT_TIMESTAMP,$customer_id)";


        // echo $_SESSION['totalPrice'];

        if (mysqli_query($conn, $sql)) {
            $orderDetailsId = mysqli_insert_id($conn);
            $_SESSION['orderDetailsId'] = $orderDetailsId;
            header('location: esewa.php?amount=' .$total_price);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    ?>

    <div class="container mx-auto mt-8 flex">
        <div class="mx-auto">
            <div class="mx-auto bg-white p-8 rounded-lg shadow-md w-96">
                <h2 class="text-2xl font-bold mb-4">Shipping Details</h2>
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
    // Include footer
    include('../components/footer.php');
    ?>
</body>

</html>
