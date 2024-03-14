<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
</head>

<body class="bg-gray-100">
    <?php
    $id = $_GET['id'];
    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
    if (isset($_POST['submit'])) {
        $model = $_POST['model'];
        $brand = $_POST['brand'];
        $price = $_POST['price'];
        $storage = $_POST['storage'];
        $RAM = $_POST['RAM'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Get file details
                $file_name = $_FILES['image']['name'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_size = $_FILES['image']['size'];
                $file_type = $_FILES['image']['type'];
        
                $allowed_extensions = array('jpg', 'jpeg', 'png');
                $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                if (!in_array($file_extension, $allowed_extensions)) {
                    echo "Error: Only JPG, JPEG, and PNG files are allowed.";
                    exit; // Stop further execution
                }

                // Set new image path
                $new_image_path = 'uploads/' . $file_name;

                // Move uploaded file to the new location
                if (move_uploaded_file($file_tmp, $new_image_path)) {
                    // Update the database with the new image path
                    $sql = "UPDATE mobile_product 
                            SET model='$model', brand='$brand', price='$price', storage='$storage', RAM='$RAM', image='$file_name'
                            WHERE id='$id'";
        
                    mysqli_query($conn, $sql);
        
                    if (mysqli_affected_rows($conn) == 1) {
                        header('location: ../homepage.php');
                        exit; // Add an exit after redirection to stop executing the rest of the script
                    } else {
                        echo "Sorry could not update";
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            echo "Image is empty";
        }
    }

    $sql1 = "SELECT * FROM mobile_product WHERE id=$id";
    $res = mysqli_query($conn, $sql1);
    $d = mysqli_fetch_assoc($res);
    // echo $d['image'];
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
                    <a href="../homepage.php">
                        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Home</li>
                    </a>
                    <a href="../mobile_products.php">
                        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Mobiles</li>
                    </a>
                    <a href="../orders.php">
                        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Orders</li>
                    </a>
                    <a href="../customers.php">
                        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Customers</li>
                    </a>
                    <!-- Add more sidebar links as needed -->
                </ul>
                <div class="p-4 border-t border-gray-700">
                    <a href="logoutAdmin.php"><button class="bg-red-600 w-full px-4 h-10 mt-2 rounded-lg text-white hover:bg-blue-600">Logout</button></a>
                </div>
            </div>
        </div>

        <div class="container mx-auto p-8">
            <h1 class="text-3xl font-semibold mb-4">Edit Mobile Details</h1>
            <div class="max-w-md bg-white shadow-md rounded-lg overflow-hidden mx-auto">
                <form class="p-6" action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="model" class="block text-gray-700 text-sm font-bold mb-2">Model:</label>
                        <input type="text" id="model" name="model" value='<?php echo $d['model']; ?>' class="form-input w-full border border-gray-200 p-2" placeholder="Enter model" required>
                    </div>
                    <div class="mb-4">
                        <label for="brand" class="block text-gray-700 text-sm font-bold mb-2">Brand:</label>
                        <input type="text" id="brand" name="brand" value='<?php echo $d['brand']; ?>' class="form-input w-full border border-gray-200 p-2" placeholder="Enter brand" required>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price in $:</label>
                        <input type="number" id="price" name="price" value='<?php echo $d['price']; ?>' class="form-input w-full border border-gray-200 p-2" placeholder="Enter price" required>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Storage:</label>
                        <input type="number" id="price" name="storage" value='<?php echo $d['storage']; ?>' class="form-input w-full border border-gray-200 p-2" placeholder="Enter price" required>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 text-sm font-bold mb-2">RAM:</label>
                        <input type="number" id="price" name="RAM" value='<?php echo $d['ram']; ?>' class="form-input w-full border border-gray-200 p-2" placeholder="Enter price" required>
                    </div>
                    <!-- <div class="mb-4">
                        <label for="image" class="block text-gray-700 font-bold mb-2">Image:</label>
                        <input type="file" id="image" name="image" src='<?php echo $d['image']; ?>' class="border rounded w-full py-2 px-3" accept="image/*">
                    </div> -->
                    <!-- <div class="flex">
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 font-bold mb-2">Current Image:</label>
                            <img src="uploads/<?php echo $d['image']; ?>" alt="Current Image" class="mb-2 h-20" style="max-width: 200px;">
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 font-bold mb-2">Image:</label>
                            <input type="file" id="image" name="image" class="border rounded w-full py-2 px-3" accept="image/*">
                        </div>
                    </div> -->
                    <div class="flex">
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 font-bold mb-2">Current Image:</label>
                            <img src="uploads/<?php echo $d['image']; ?>" alt="Current Image" class="mb-2 h-20" style="max-width: 200px;">
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 font-bold mb-2">New Image:</label>
                            <input type="file" id="image" name="image" class="border rounded w-full py-2 px-3" accept="image/*" value="">
                        </div>
                    </div>

                    <div class="flex justify-between gap-4">
                        <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>