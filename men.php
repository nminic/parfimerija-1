<?php
session_start();
$proizvodi = array();

include './connectionString.php';

if (filter_input(INPUT_POST, "dodaj")) {
    if (isset($_SESSION["korpa"])) {
        $count = count($_SESSION["korpa"]);
        $proizvodi = array_column($_SESSION["korpa"], "id");

        if (!in_array(filter_input(INPUT_GET, 'id'), $proizvodi)) {
            $_SESSION["korpa"][$count] = array(
                "id" => filter_input(INPUT_GET, "id"),
                "ime" => filter_input(INPUT_POST, "ime"),
                "cena" => filter_input(INPUT_POST, "cena"),
                "kolicina" => filter_input(INPUT_POST, "kolicina")
            );
        } else {
            for ($i = 0; $i < count($proizvodi); $i++) {
                $upit = "UPDATE product SET Amount = Amount - {$_SESSION['korpa'][$i]['kolicina']} WHERE ProductId = {$_SESSION['korpa'][$i]['id']}";
                $rez = mysqli_query($conn, $upit);

                if (!$rez) {
                    echo 'Greska!';
                }
                if ($_SESSION["korpa"][$i]["kolicina"] <= 0) {
                    echo 'nema';
                }

                if ($proizvodi[$i] == filter_input(INPUT_GET, "id")) {
                    $_SESSION["korpa"][$i]["kolicina"] += filter_input(INPUT_POST, "kolicina");
                }
            }
        }
    } else {
        $_SESSION["korpa"][0] = array(
            "id" => filter_input(INPUT_GET, "id"),
            "ime" => filter_input(INPUT_POST, "ime"),
            "cena" => filter_input(INPUT_POST, "cena"),
            "kolicina" => filter_input(INPUT_POST, "kolicina")
        );
    }
}

if (filter_input(INPUT_GET, "action") == "IsprazniKorpu") {
    foreach ($_SESSION['korpa'] as $key => $artikal) {
        unset($_SESSION['korpa'][$key]);
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

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>  

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

<div class="productContainer2">
<div class="row">
        <?php
        include './connectionString.php';
        
        $upit = 'SELECT * FROM product WHERE CategoryId=1';
        $rez = $conn->query($upit);

        

        if ($rez):
            if (mysqli_num_rows($rez) > 0):
                while ($product = mysqli_fetch_assoc($rez)):
                    ?>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <form method="post" action="men.php?action=add&id=<?php echo $product['ProductId'] ?>">
                            <div class="artikli" style="margin-top: 30px; margin-bottom: 40px;">
                                <img  src="data:image/png;base64,<?php echo $product['Photo']; ?>" style='width:200px; height:200px;' >
                                <h4 class="text-info" id="naslov"><?php echo $product['ProductName']; ?></h4>
                                <h4><?php echo $product['Price']; ?>€</h4>
                                <input type="text" name="kolicina" class="form-control" value="1" style="width:40px">
                                <input type="hidden" name="ime" value="<?php echo $product['ProductName']; ?>">
                                <input type="hidden" name="cena" value="<?php echo $product['Price']; ?>">
                                <?php
                                if (isset($_SESSION['korisnik'])):
                                    ?>
                                    <input type="submit" name="dodaj" id="dodaj" style="margin-top:5px;" class="btn btn-info" value="Dodaj u korpu"> 
                                    <?php
                                endif;
                                ?>
                            </div>
                        </form>
                    </div>
                    <?php
                endwhile;
            endif;
        endif;
        
        ?>
        </div>
    </div>

    </body>

</html>


