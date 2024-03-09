<?php
    $id=$_GET['id'];
    $conn=mysqli_connect('localhost','root','','summerProject');
    
    if(!$conn){
        echo "Database not connected";
    }

    $sql="DELETE FROM mobile_product WHERE id=$id";
    mysqli_query($conn,$sql);
    header('location: ../mobile_products.php');
    mysqli_close($conn);
?>