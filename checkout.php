<?php
session_start();


if (filter_input(INPUT_GET, "action") == "delete") {
    foreach ($_SESSION['korpa'] as $key => $artikal) {
        if ($artikal['id'] == filter_input(INPUT_GET, 'id')) {
            unset($_SESSION['korpa'][$key]);
        }
    }
    $_SESSION['korpa'] = array_values($_SESSION['korpa']);
}

if (filter_input(INPUT_GET, "action") == "IsprazniKorpu") {
    foreach ($_SESSION['korpa'] as $key => $artikal) {
        unset($_SESSION['korpa'][$key]);
    }
}

if (isset($_POST['kupi'])) {
    $connect = new mysqli('localhost', 'root', '', 'satovi');

    foreach ($_SESSION["korpa"] as $key => $proizv) {
        $upit1 = "SELECT Kolicina from artikli where Kolicina>{$proizv["kolicina"]} and idArtikla={$proizv["id"]}";
        $rez1 = mysqli_query($connect, $upit1);

        if (!$rez1->num_rows > 0) {
            echo '<script>alert("Nema dovoljno kolicine!")</script>';
        } else {
            $upit = "UPDATE artikli SET Kolicina=Kolicina-{$proizv["kolicina"]} WHERE idArtikla={$proizv["id"]}";
            $rez = mysqli_query($connect, $upit);
            echo '<script>alert("Proizvodi kupljeni!")</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pretty Fix</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="icon" href="img/pretty-removebg-preview-1-144x144.png">
</head>


<body id="page-top">

<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
	<div class="container-fluid">
		<a class="navbar-brand" href="index.php"><img src="img/Webp.net-resizeimage.png"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"></span> 
		</button>

		<div class="collapse navbar-collapse" id="navbarResponsive">
		
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link" href="index.php">Početna</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php#about">O nama</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="women.php">Ženski parfemi</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="men.php">Muški parfemi</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="makeup.php">Šminka</a>
				</li>
				<li class="nav-item">
					<a class="nav-link "href="index.php#contact">Kontakt</a>
				</li>
				<li class="nav-item">
                            <?php
                            if (isset($_SESSION["korisnik"])) {
                                echo '<a class="nav-link" href="logout.php"><span>Logout</span></a>';
                            } else {
                                echo '<a class="nav-link" href="login.php"><span>Login</span></a>';
                            }
                         ?>
                 </li>

				 <li class="nav-item">
                            <?php if (isset($_SESSION["korisnik"])) { ?>
                                <a class="nav-link" href="checkout.php"><i class="fa fa-shopping-cart action"></i><?php
                                    $ukupno = 0;
                                    if (isset($_SESSION["korpa"]) and count($_SESSION["korpa"]) > 0) {
                                        foreach ($_SESSION["korpa"] as $key => $vred) {
                                            $ukupno += $vred["cena"] * $vred["kolicina"];
                                        }
                                        echo $ukupno . " EUR";
                                        ?> (<?php
                                        echo count($_SESSION["korpa"]) . " proizvoda)";
                                    } else {
                                        echo '0';
                                    }
                                    ?></a>
                                <a href="index.php?action=IsprazniKorpu" class="simpleCart_empty">Isprazni korpu</a>

                                <?php
                            } else {
                                echo '';
                            }
                            ?>
                        </li>			

			</ul>
		</div>
	</div>
</nav>

<br>
<br>

<div class="productContainer">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th colspan="5">
                        <h1>Moja korpa 
                            <?php
                            if (isset($_SESSION["korpa"]) and count($_SESSION["korpa"]) > 0) {
                                echo '(' . count($_SESSION["korpa"]) . " proizvoda)";
                            } else {
                                echo '(0)';
                            }
                            ?>
                        </h1>
                    </th>
                </tr>
                <tr>
                    <th width="40%">Naziv</th>
                    <th width="20%">Količina</th>
                    <th width="20%">Cena</th>
                    <th width="20%">Ukupna cena</th>
                    <th width="20%">Ukloni</th>
                </tr>
                <?php
                if (!empty($_SESSION['korpa'])):
                    $ukupno = 0;
                    foreach ($_SESSION['korpa'] as $key => $artikal):
                        ?>
                        <tr>
                            <td><?php echo $artikal['ime']; ?></td>
                            <td><?php echo $artikal['kolicina']; ?></td>
                            <td><?php echo $artikal['cena']; ?>€</td>
                            <td><?php echo number_format($artikal['kolicina'] * $artikal['cena'], 2); ?>€</td>
                            <td>
                                <a href="checkout.php?action=delete&id=<?php echo $artikal['id'] ?>">
                                    <i id="cross" class='fa fa-times action'></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                        $ukupno = $ukupno + ($artikal['kolicina'] * $artikal['cena']);
                    endforeach;
                    ?>
                    <tr>
                        <td colspan="5">
                            <?php
                            if (isset($_SESSION['korpa'])):
                                if (count($_SESSION['korpa']) > 0):
                                    ?>
                                    <?php
                                endif;
                            endif;
                            ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
    <script>$(document).ready(function (c) {
            $('.close2').on('click', function (c) {
                $('.cart-header2').fadeOut('slow', function (c) {
                    $('.cart-header2').remove();
                });
            });
        });
    </script>


</body>

</html>