<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php
    // Establish connection to database
    $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

    // Check if connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Fetch form data
    if (isset($_POST['submit'])) {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone_number = $_POST['phone_number'];

        // Insert data into customer table
        $sql = "INSERT INTO customer (fullname, email, password, phone_number) VALUES ('$fullname', '$email', '$password', '$phone_number')";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            // echo "Sign up successful!";
            header("location: loginCustomer.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    // Close database connection
    mysqli_close($conn);
    ?>

    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Sign Up</h2>
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="fullname" class="block text-gray-700 text-sm font-bold mb-2">Full Name:</label>
                    <input type="text" id="fullname" name="fullname" class="form-input w-full border border-gray-200 p-2" placeholder="Enter your full name" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" id="email" name="email" class="form-input w-full border border-gray-200 p-2" placeholder="Enter your email" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                    <input type="password" id="password" name="password" class="form-input w-full border border-gray-200 p-2" placeholder="Enter your password" required>
                </div>
                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-input w-full border border-gray-200 p-2" placeholder="Enter your phone number" required>
                </div>
                <div class="flex flex-col">
                    <button type="submit" name="submit" class="bg-blue-500 text-white px-8 py-3 rounded-lg hover:bg-blue-600">Sign Up</button>
                    <div class="flex mt-4">
                        <label for="">Do you Have an account? </label>
                        <a class="hover:underline text-blue-600 mt-4" href="signup.php">Login Now</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</body>

</html>