
<?php
    require_once "./connectionString.php";
 
    $data = mysqli_real_escape_string($conn, $_POST['ProductId']);
 
    if(mysqli_query($conn, "DELETE FROM product WHERE ProductId='" . $data . "'")) {
     echo '1';
    } else {
       echo "Error: " . $sql . "" . mysqli_error($conn);
    }
 
    mysqli_close($conn);
 
?>
