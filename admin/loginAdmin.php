<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="loginpage.css">
    <script src="https://cdn.tailwindcss.com"></script>
  <!-- <link href="./output.css" rel="stylesheet"> -->
</head>
<body class="">
<?php
        session_start();
        $erre=$errp='';
        if(isset($_POST['submit'])){
            // echo "hello";
           $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
            if(!$conn){
                $errp = "Database not connected";
            }
          $email=$_POST['email'];
          $password=$_POST['password'];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $erre = "Invalid email format";
        }
          $sql="SELECT * FROM admin WHERE email='$email' AND password='$password'";
          $result=mysqli_query($conn,$sql);
          $row=mysqli_fetch_array($result);

          if(is_array($row)){
            $_SESSION['email']=$row['email'];
          }
          else{
            $errp="Invalid username or password";
          }
        }
        if($_SESSION['email']){
          header('location: homepage.php');
          exit();
        }

    ?>
  <div class="bg-pink-300 mx-auto my-20 rounded-3xl p-4 w-1/3">
        <h1 class="mx-32 text-3xl mt-8">Login Now</h1>
        <form action="" method="post">
         <div class="m-4 p-2">
          <label for="" class="text-black m-2 mb-4">Email</label>
          <input type="text" class="p-2 text-lg text-black rounded-lg w-full" name="email" placeholder="hello@gmail.com" required>
          <span class="error text-black"><?php echo $erre; ?></span>
         </div>
         <div class="m-4 p-2">
         <label for="" class="text-black m-2 mb-4">Password</label>
          <input type="password" class="p-2 text-lg text-black rounded-lg w-full" name="password" placeholder="Password" required>
         </div>
          <!-- <?php echo $username; ?>"><input type="submit" class="submit" name="submit" value="Log In"></a> -->
          <a class=""><input type="submit" class="bg-blue-500 p-3 rounded-lg w-96 mx-8 mt-4 text-white mb-10" name="submit" value="Log In"></a>
          <!-- <a href=""><input type="submit" class="bg-blue-500 p-3 rounded-lg w-96 mx-8 mt-4 text-white mb-10" value="Login Now"></a> -->
          <span class="flex justify-center"><?php echo $errp ?></span>
         <!-- <p class="m-12 mx-14">Does not have an account? <a href="signupUser.php" class="text-blue-500">SignUp Now</a></p> -->
        </form>
  </div>
</body>
</html>