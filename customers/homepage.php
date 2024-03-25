<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="bg-gray-100">
    <?php
        session_start();
        $erre = $errp = '';
        include 'components/navbar.php';

    ?>

    <div class="m-4"> 
        <img src="https://media.istockphoto.com/id/1193842936/photo/mobile-communication-concept-global-communication-network.webp?b=1&s=170667a&w=0&k=20&c=oHUUjJBFUM47PBu24btnPFkPiZUd1Cs2jG_2mV4oGds=" class="w-4/5 mx-auto" alt="">
    </div>

<div class="flex justify-center m-8 text-3xl bg-white">All Mobiles </div>
<div class="container mx-auto py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <?php
            // Connect to the database
            $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch mobile products from the database
            $sql = "SELECT * FROM mobile_product";
            $result = mysqli_query($conn, $sql);

            // Display mobile products
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="bg-white shadow-md p-4 rounded w-full">';
                    echo '<img src="../admin/products/uploads/' . $row['image'] . '" alt="' . $row['model'] . '" class="mx-auto mb-4">';
                    echo '<p class="text-center text-xl">' . $row['model'] . '</p>';
                    echo '<p class="text-center">' .'$ '. $row['price'] . '</p>';
                    // echo '<p class="text-center">' . $row['model'] . '</p>';
                    echo '<div class="mt-4 w-full flex">';
                    if(isset($_SESSION['email'])) { 
                        // User is logged in
                        // echo '<a href="./products/edit_mobile_product.php?id=' . $row['id'] . '" class="bg-blue-500 text-white px-3 py-1 rounded-lg mr-2">Edit</a>';
                        // echo "";
                        // echo '<a href="booking/cart.php?id='.$row['id'].' "><i class="fa fa-shopping-cart" style="font-size:24px">Add To Cart</i></a>';
                        
                        echo '<a href="cart/cart.php?id='.$row['id'].' "><button class="bg-gray-800 text-gray-200 px-6 mr-2 w-36 p-2 hover:bg-red-800">Add To Cart</button></a>';
                        echo '<a href="booking/bookings.php?id='.$row['id'].' "><button class="bg-blue-600 text-gray-100 px-6 w-32 p-2 rounded-lg hover:bg-blue-800">Buy Now</button></a>';
                    } else {
                        // User is not logged in, redirect to login page
                        echo '<a href="loginCustomer.php"><button class="w-full text-gray-300 bg-blue-600 px-6 p-2 rounded-lg hover:bg-blue-800">Buy Now</button></a>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No mobile products found.";
            }

            // Close connection
            mysqli_close($conn);
            ?>
        </div>
    </div>

    <?php
        include 'components/footer.php';
    ?>
</body>
</html>