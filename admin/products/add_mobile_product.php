<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['model']) && isset($_POST['brand']) && isset($_POST['price']) && isset($_POST['storage']) && isset($_POST['ram']) && isset($_FILES['image'])) {
        // Database connection
        $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }
        
        // Escape user inputs for security
        $model = mysqli_real_escape_string($conn, $_POST['model']);
        $brand = mysqli_real_escape_string($conn, $_POST['brand']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $storage = mysqli_real_escape_string($conn, $_POST['storage']);
        $ram = mysqli_real_escape_string($conn, $_POST['ram']);
        
        // File upload
        $targetDir = "uploads/";

        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        
        // Allow certain file formats
        $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                // Insert mobile product into the database
                $sql = "INSERT INTO mobile_product (model, brand, price, storage, ram, image) VALUES ('$model', '$brand', '$price', '$storage', '$ram', '$fileName')";
                if (mysqli_query($conn, $sql)) {
                    echo "Mobile product inserted successfully.";
                    header('location: ../homepage.php');
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG, GIF files are allowed.";
        }
        
        // Close database connection
        mysqli_close($conn);
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Form submission method not allowed.";
}
?>
