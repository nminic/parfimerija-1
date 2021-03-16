<?php
session_start();


if (filter_input(INPUT_GET, "action") == "IsprazniKorpu") {
    foreach ($_SESSION['korpa'] as $key => $artikal) {
        unset($_SESSION['korpa'][$key]);
    }
}

$error = "";

if (isset($_POST['submit'])) {

    include './connectionString.php';

    $name = $_POST['name'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];
    $role="user";


    if ($password !== $re_password) {
        $error = "Lozinke se ne poklapaju!";
    } else {

        $query = "INSERT INTO user (FirstName, LastName, Email, Password, Role) VALUES ('" . $name . "', '" . $lastName . "', '" . $email . "', '" . $password . "', '" . $role . "')";

        $rez = $conn->query($query);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link rel="stylesheet" href="styleregister.css?v=<?php echo time(); ?>">
	<link rel="icon" href="img/pretty-removebg-preview-1-144x144.png">
</head>

<body>

<div class="main">

<section class="signup">
    
    
    <div class="container">
        <div class="signup-content">
            <form method="POST" id="signup-form" class="signup-form">
                <h2 class="form-title">Registracija</h2>
                <?php
                echo $error;
                ?><br>
                <div class="form-group">
                    <input type="text" class="form-input" name="name" id="name" placeholder="Ime"/>
                </div><div class="form-group">
                    <input type="text" class="form-input" name="lastName" id="lastName" placeholder="Prezime"/>
                </div>
                <div class="form-group">
                    <input type="email" class="form-input" name="email" id="email" placeholder="Email adresa"/>
                </div>
                <div class="form-group">
                    <input type="password" class="form-input" name="password" id="password" placeholder="Lozinka"/>
                </div>
                <div class="form-group">
                    <input type="password" class="form-input" name="re_password" id="re_password" placeholder="Potvrdite lozinku"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" id="submit" class="form-submit" value="Registruj se"/>
                </div>
            </form>
            <p class="loginhere">
                Imate nalog?<a href="login.php" class="loginhere-link"> Prijavite se ovde</a>
            </p>
        </div>
    </div>
</section>

</div>

</body>
</html>