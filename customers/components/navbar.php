<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <?php
    // Check if the user is logged in (you might have a session variable set for this purpose)
    // $isLoggedIn = isset($_SESSION['email']);

    // // Display the logout button if the user is logged in
    // if ($isLoggedIn) {
    //     echo '<a href="logout.php">Logout</a>';
    // } else {
    //     // Display login button or login form if the user is not logged in
    //     echo '<a href="login.php">Login</a>';
    // }
    ?>

    <nav class="bg-gray-800 shadow-md">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div>
                    <a class="text-white text-xl font-bold hover:text-gray-300" href="#">Mobile Store</a>
                </div>
                <div class="hidden md:flex md:items-center md:space-x-4 gap-4">
                    <a class="text-gray-300 hover:text-white" href="#">Home</a>
                    <a class="text-gray-300 hover:text-white" href="#">Mobiles</a>
                    <a class="text-gray-300 hover:text-white" href="#">Orders</a>
                    <a class="text-gray-300 hover:text-white" href="#">Profile</a>
                    <div class="bg-gray-400">
                        <?php
                            $isLoggedIn = isset($_SESSION['email']);
                            if ($isLoggedIn) {
                                echo '<a href="logoutCustomer.php" class="bg-red-700 px-6 p-2 rounded-lg hover:bg-red-800"><button class="text-gray-300">Logout</button></a>';
                            } 
                            else {
                                // Display login button or login form if the user is not logged in
                                echo '<a href="loginCustomer.php" class="bg-blue-600 px-6 p-2 rounded-lg hover:bg-blue-800"><button class="text-gray-300">Login</button></a>';
                            }
                        ?>
                        <!-- <a href="loginCustomer.php" class="bg-blue-600 px-6 p-2 rounded-lg hover:bg-blue-800"><button class="text-gray-300">Login</button></a> -->
                    </div>
                </div>
                <div class="md:hidden">
                    <button class="text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

</body>

</html>