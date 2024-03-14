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
        <!-- <div class="container mx-auto mt-8 grid grid-cols-1 md:grid-cols-2 gap-8"> -->

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
        ?>

        <div class="container mx-auto mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Mobile Image -->
            <div>
                <?php
                // Render mobile image
                echo '<img src="../../admin/products/uploads/' . $row['image'] . '" alt="Mobile Image" class="w-full h-auto">';
                ?>
            </div>

            <!-- Product Details -->
            <div>
                <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
                    <!-- Product Title -->
                    <h1 class="text-2xl font-bold mb-4"><?php echo $row['model']; ?></h1>
                    <p class="text-xl text-gray-700 mb-4">RS. <?php echo $row['price']; ?></p>
                    <div class="flex items-center text-gray-600 mb-4">
                        <p class="mr-4">Storage: <?php echo $row['storage']; ?> GB</p>
                        <p class="mr-4">RAM: <?php echo $row['ram']; ?> GB</p>
                    </div>
                    <p class="mr-4 my-4">Brand: <?php echo $row['brand']; ?></p>
                     <button class="bg-blue-500 text-white px-8 py-3 rounded-lg hover:bg-blue-600">Buy Now</button>
                </div>
            </div>
        </div>

        <?php
        include '../components/footer.php';
        ?>
    </body>

    </html>


</body>

</html>