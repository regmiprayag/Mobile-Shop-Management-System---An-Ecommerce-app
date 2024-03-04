<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- Sidebar -->
    <div class="bg-gray-800 text-white w-64 flex flex-col">
        <div class="p-4 border-b border-gray-700">
            <h2 class="text-lg font-semibold">Admin Dashboard</h2>
        </div>
        <ul class="flex-grow">
            <!-- Sidebar links -->
            <li class="px-4 py-2 hover:bg-gray-700">Dashboard</li>
            <li class="px-4 py-2 hover:bg-gray-700">Products</li>
            <li class="px-4 py-2 hover:bg-gray-700">Orders</li>
            <li class="px-4 py-2 hover:bg-gray-700">Customers</li>
            <!-- Add more sidebar links as needed -->
        </ul>
        <div class="p-4 border-t border-gray-700">
            <!-- Logout button -->
            <button class="bg-red-500 text-white px-4 py-2 w-full rounded hover:bg-red-600">Logout</button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow p-8">
        <!-- Your main content here -->
        <h1 class="text-3xl font-semibold">Welcome to Admin Dashboard</h1>
        <p class="mt-4">This is where you can manage your products, orders, and customers.</p>
    </div>

</div>

</body>
</html>
