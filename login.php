<?php
session_start();
include './connectionString.php';

if (filter_input(INPUT_GET, "action") == "IsprazniKorpu") {
    foreach ($_SESSION['korpa'] as $key => $artikal) {
        unset($_SESSION['korpa'][$key]);
    }
}

$error = "";

if(isset($_POST['submit']))
{
    $email = $_POST['email'];
    $loz = $_POST['password'];
    
    $upit = "SELECT * FROM user WHERE Email = '" . $email . "' and Password = '" . $loz . "'";
    $qu = mysqli_query($conn, $upit); 
    if(!$qu)
    {
        print("Upit ne moze da se izvrsi" . $conn->error);
    }
    
    while($row = mysqli_fetch_array($qu))
    {
        $id = $row['Id'];
        $ime = $row['FirstName'];
        $prezime = $row['LastName'];
        $adresa = $row['Email'];
        $password = $row['Password'];
        $role = $row['Role'];
        $_SESSION["korisnik"]=$row["Id"];
    }
    
    if ($email !== $adresa && $loz !== $password) 
    {
        header("Location: login.php");
    }
    else if($email == $adresa && $loz !== $password)
    {
        header("Location: login.php");
    }
    else if($email !== $adresa && $loz == $password)
    {
        header("Location: login.php");
    }
    else if ($email == $adresa && $loz == $password && $role == 'admin') 
    {
        header("Location: crud.php");
                
                $_SESSION['Id'] = $id;
                $_SESSION['FirstName'] = $ime;
                $_SESSION['LastName'] = $prezime;
                $_SESSION['Email'] = $adresa;
                $_SESSION['Password'] = $password;
                $_SESSION['Role'] = $role;
    }
    else if ($email == $adresa && $loz == $password && $role == 'korisnik') 
    {
        header("Location: index.php");
                
                $_SESSION['Id'] = $id;
                $_SESSION['FirstName'] = $ime;
                $_SESSION['LastName'] = $prezime;
                $_SESSION['Email'] = $adresa;
                $_SESSION['Password'] = $password;
                $_SESSION['Role'] = $role;
    }
    else 
    {
        header("Location: index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link rel="stylesheet" href="stylelogin.css?v=<?php echo time(); ?>">
	<link rel="icon" href="img/pretty-removebg-preview-1-144x144.png">
</head>

<body>

<div class="main">

<section class="signup">
   
    <div class="container">
        <div class="signup-content">
            <form method="POST" id="signup-form" class="signup-form">
                <h2 class="form-title">Prijava</h2>
                <?php
                echo $error;
                ?><br>
                <div class="form-group">
                    <input type="email" class="form-input" name="email" id="email" placeholder="Email adresa"/>
                </div>
                <div class="form-group">
                    <input type="password" class="form-input" name="password" id="password" placeholder="Lozinka"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" id="submit" class="form-submit" value="Prijavi se"/>
                </div>
            </form>
            <p class="loginhere">
                Nemate nalog?<a href="register.php" class="loginhere-link"> Registrujte se ovde</a>
            </p>
        </div>
    </div>
</section>

</div>

</body>
</html>