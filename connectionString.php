<?php

$conn = new mysqli("localhost", "root", "", "php");

// Check connection
if ($conn->connect_error) {
    die("Greska sa konekcijom: " . $conn->connect_error);
}

?>
