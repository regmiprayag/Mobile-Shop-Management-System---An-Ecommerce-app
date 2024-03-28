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
<body class="bg-gray-200">
    <?php 
     session_start();
     $erre=$errp='';

    //  echo "hello";
     if(isset($_POST['submit'])){
       $conn = mysqli_connect('localhost', 'root', '', 'summerProject');
        if(!$conn){
            $errp = "Database not connected";
        }
      $email=$_POST['email'];
      $password=$_POST['password'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erre = "Invalid email format";
    }
      $sql="SELECT * FROM customer WHERE email='$email' AND password='$password'";
      $result=mysqli_query($conn,$sql);
      $row=mysqli_fetch_array($result);

      if(is_array($row)){
        $_SESSION['email']=$row['email'];
        $_SESSION['customer_id'] = $row['id'];
      }
      else{
        $errp="Invalid username or password";
      }
      if($_SESSION['email']){
          // $errp = $_SESSION['email'];
        header('location: homepage.php');
        exit();
      }
    }
    ?>

<div class="flex items-center justify-center h-screen">
    <div class="max-w-xs w-full">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-center text-3xl font-bold text-blue-600 mb-4">Customer Login</h2>
            <form class="mb-4" method="POST">
                <div class="mb-4">
                    <input name="email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" type="email" placeholder="Email or Phone Number">
                </div>
                <div class="mb-4">
                    <input name="password" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="password" type="password" placeholder="Password">
                </div>
                <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" type="button">Log In</button>
                <span class="flex justify-center"><?php echo $errp ?></span>
            </form>
            <p class="text-center text-gray-600 text-sm mt-3">
                Don't have an account? <a class="hover:underline text-blue-600" href="#">Sign Up</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>