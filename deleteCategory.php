<?php
    require_once "./connectionString.php";
 
    $data = mysqli_real_escape_string($conn, $_POST['Id']);
 
    if(mysqli_query($conn, "DELETE FROM category WHERE Id='" . $data . "'")) {
     echo '1';
    } else {
       echo "Error: " . $sql . "" . mysqli_error($conn);
    }
 
    mysqli_close($conn);
 
?>