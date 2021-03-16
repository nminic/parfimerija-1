<?php

require_once "./connectionString.php";
//mi smo ajaxom poslali categoryName pa ga sad ubacujemo 
$name = mysqli_real_escape_string($conn, $_POST['categoryName']);

if (mysqli_query($conn, "INSERT INTO category(Name) VALUES('" . $name ."')")) {
    echo '1';
} else {
    echo "Greska: " . $sql . "" . mysqli_error($conn);
}

mysqli_close($conn);
?>