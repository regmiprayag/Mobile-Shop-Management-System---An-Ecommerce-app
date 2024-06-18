<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homepage</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <div class="bg-indigo-900 text-white w-64 flex flex-col">
      <div class="p-4 border-b border-gray-700">
        <h2 class="text-lg font-semibold">Admin Dashboard</h2>
      </div>
      <ul class="flex-grow">
        <!-- Sidebar links -->
        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Home</li>
        <a href="mobile_products.php">
          <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Mobiles</li>
        </a>
        <a href="orders.php">
          <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Orders</li>
        </a>
        <a href="sales.php">
          <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer">Total Sales</li>
        </a>
        <!-- Add more sidebar links as needed -->
      </ul>
      <div class="p-4 border-t border-gray-700">
        <!-- Logout button -->
        <!-- <button class="bg-red-500 text-white px-4 py-2 w-full rounded hover:bg-red-600">Logout</button> -->
        <a href="logoutAdmin.php"><button class="bg-red-600 w-full px-4 h-10 mt-2 rounded-lg text-white hover:bg-blue-600">Logout</button></a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto p-8">
      <h1 class="text-3xl font-semibold mb-4">Products</h1>

      <!-- Display all products -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Products will be displayed here -->
      </div>

      <!-- Button to add a new product -->
      <button id="openFormBtn" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Mobile Product</button>

      <div class="container mx-auto p-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
          <?php
          // Include database connection
          $conn = mysqli_connect('localhost', 'root', '', 'summerProject');

          // Fetch all mobile products from the database
          $sql = "SELECT * FROM mobile_product";
          $result = mysqli_query($conn, $sql);

          // Display mobile products in card format
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
          ?>
              <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white">
                <img src="products/uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['model']; ?>" class="w-full">
                <div class="px-6 py-4">
                  <div class="font-bold text-xl mb-2"><?php echo $row['model']; ?></div>
                  <p class="text-gray-700 text-base"><?php echo $row['brand']; ?></p>
                  <p class="text-gray-700 text-base">$<?php echo $row['price']; ?></p>
                </div>
              </div>
          <?php
            }
          } else {
            echo '<p>No mobile products found.</p>';
          }
          // Close database connection
          mysqli_close($conn);
          ?>
        </div>
      </div>
    </div>

    <!-- Pop-up form -->
    <div id="popupForm" class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-75 flex justify-center items-center hidden">
      <div class="bg-white p-6 rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Add Mobile Product</h2>
        <form id="addProductForm" action="./products/add_mobile_product.php" method="POST" enctype="multipart/form-data">
          <div class="mb-4">
            <label for="model" class="block text-gray-700 font-bold mb-2">Model:</label>
            <input type="text" id="model" name="model" class="border rounded w-full py-2 px-3" required>
          </div>
          <div class="mb-4">
            <label for="brand" class="block text-gray-700 font-bold mb-2">Brand:</label>
            <input type="text" id="brand" name="brand" class="border rounded w-full py-2 px-3" required>
          </div>
          <div class="mb-4">
            <label for="price" class="block text-gray-700 font-bold mb-2">Price:</label>
            <input type="number" id="price" name="price" class="border rounded w-full py-2 px-3" required>
          </div>
          <div class="mb-4">
            <label for="storage" class="block text-gray-700 font-bold mb-2">Storage:</label>
            <input type="number" id="storage" name="storage" class="border rounded w-full py-2 px-3" required>
          </div>
          <div class="mb-4">
            <label for="ram" class="block text-gray-700 font-bold mb-2">RAM:</label>
            <input type="number" id="ram" name="ram" class="border rounded w-full py-2 px-3" required>
          </div>
          <div class="mb-4">
            <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity:</label>
            <input type="number" id="quantity" name="quantity" class="border rounded w-full py-2 px-3" required>
          </div>
          <div class="mb-4">
            <label for="image" class="block text-gray-700 font-bold mb-2">Image:</label>
            <input type="file" id="image" name="image" class="border rounded w-full py-2 px-3" accept="image/*" required>
          </div>
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Product</button>
          <button id="closeFormBtn" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2">Cancel</button>
        </form>
      </div>
    </div>

    <!-- JavaScript to show/hide the pop-up form -->
    <script>
      // Get the elements
      const openFormBtn = document.getElementById('openFormBtn');
      const closeFormBtn = document.getElementById('closeFormBtn');
      const popupForm = document.getElementById('popupForm');

      // Event listener for opening the form
      openFormBtn.addEventListener('click', function() {
        popupForm.classList.remove('hidden');
      });

      // Event listener for closing the form
      closeFormBtn.addEventListener('click', function() {
        popupForm.classList.add('hidden');
      });
    </script>
  </div>
</body>

</html>