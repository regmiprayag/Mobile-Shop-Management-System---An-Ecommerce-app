<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php
        $erru=$errp='';

    ?>
    
    <div class="bg-pink-300 mx-auto my-20 rounded-3xl p-4 w-1/3">
        <h1 class="mx-32 text-3xl mt-8">SignUp Now</h1>
        <form action="" method="post">
         <div class="m-4 p-2">
          <label for="" class="text-black m-2 mb-4">Name</label>
          <input type="text" class="p-2 text-lg text-black rounded-lg w-full" name="username" placeholder="Username" required>
          <span class="error"><?php echo $erru; ?></span>
        </div>
         <div class="m-4 p-2">
          <label for="" class="text-black m-2 mb-4">Email</label>
          <input type="text" class="p-2 text-lg text-black rounded-lg w-full" name="email" placeholder="name@gmail.com" required>
          <span class="error"><?php echo $erru; ?></span>
        </div>
        <div class="m-4 p-2">
            <label for="" class="text-black m-2 mb-4">Password</label>
            <input type="password" class="p-2 text-lg text-black rounded-lg w-full" name="password" placeholder="Password" required>
        </div>
        <div class="m-4 p-2">
         <label for="" class="text-black m-2 mb-4">Address</label>
         <input type="text" class="p-2 text-lg text-black rounded-lg w-full" name="address" placeholder="" required>
         <span class="error"><?php echo $erru; ?></span>
       </div>
        <div class="m-4 p-2">
         <label for="" class="text-black m-2 mb-4">Mobile Number</label>
         <input type="text" class="p-2 text-lg text-black rounded-lg w-full" name="mobile" placeholder="" required>
         <span class="error"><?php echo $erru; ?></span>
          <button type="submit" class="bg-blue-500 p-3 rounded-lg w-96 mt-10 text-white">Signup Now</button>
          <span><?php echo $errp ?></span>
         <p class="m-12 mx-14">Already have an account? <a href="loginUser.php" class="text-blue-500">Login Now</a></p>
        </form>
    </div>

</body>
</html>