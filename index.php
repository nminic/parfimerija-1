<?php
session_start();


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
</head>
<body>

<!-- Navigation -->

<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
	<div class="container-fluid">
		<a class="navbar-brand" href="index.php"><img src="img/Webp.net-resizeimage.png"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"></span> 
		</button>

		<div class="collapse navbar-collapse" id="navbarResponsive">
		
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link" href="#">Početna</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#about">O nama</a>
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
					<a class="nav-link "href="#contact">Kontakt</a>
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

<!--- Image Slider -->
<div id="slides" class="carousel slide"  data-ride="carousel">
	<ul class="carousel-indicators">
		<li data-target="#slides" data-slide-to="0" class="active"></li>
		<li data-target="#slides" data-slide-to="1"></li>
		<li data-target="#slides" data-slide-to="2"></li>
	</ul>
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img src="img/car1.jpg" class="w-100">
			<div class="carousel-caption">
				<h1 class="display-2">Pretty Fix</h1>
				<h3>Dobrodošli u našu parfimeriju!</h3>
				<a href="#news">
					<button type="button" class="btn btn-outline-light btn-lg">Najnovija ponuda</button>
				</a>
				<a href="#about">
					<button type="button" class="btn btn-primary btn-lg">O nama</button>
				</a>
			</div>
		</div>
		<div class="carousel-item">
			<img src="img/car2.jpg" class="w-100">
			<div class="carousel-caption">
				<h1 class="display-2">Parfemi</h1>
				<a href="women.php">
					<button type="button" class="btn btn-primary btn-lg">Ženski</button>
				</a>
				<a href="men.php">
					<button type="button" class="btn btn-primary btn-lg">Muški</button>
				</a>
			</div>
			</div>
		<div class="carousel-item">
			<img src="img/car3.jpg" class="w-100">
			<div class="carousel-caption">
				<h1 class="display-2">Šminka</h1>
				<a href="makeup.php">
					<button type="button" class="btn btn-primary btn-lg">Šminka</button>
				</a>
			</div>
		</div>
	</div>
</div>

<!--- Jumbotron 
<div class="container-fluid">
	<div class="jumbotron">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
			<p class="lead">Neki tekst tu ide</p>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
			<a href="#">
				<button type="button" class="btn btn-outline-secondary btn-lg">Dugmence</button>
			</a>
		</div>
	</div>
</div>
-->

<!--- Welcome Section -->
<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">NAŠE USLUGE</h1>
		</div>
		<hr>
		<div class="col-12">
			<p class="lead">
				Sa nama je sve lakše!
			</p>
		</div>
	</div>
</div>

<!--- Three Column Section -->
<div class="container-fluid padding">
	<div class="row text-center padding">
		<div class="col-xs-12 col-sm-6 col-md-4">
			<i class="fas fa-shopping-basket"></i>
			<h3>ONLINE PRODAVNICA</h3>
			<p>Uz pomoć našeg sajta možete poručiti Vaš omiljeni parfem ili šminku. Dostava na kućnu adresu u roku od 2 do 3 dana.</p>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-4">
			<i class="fas fa-smile"></i>
			<h3>KOMUNIKACIJA</h3>
			<p>Tu smo za Vas. Tu smo da odgovorimo na sva Vaša pitanja. U slučaju bilo kakvih nepravilnosti, pošaljite nam poruku da bi kvar bio otklonjen u najkraćem roku.</p>
		</div>

		<div class="col-sm-12 col-md-4">
			<i class="fas fa-lock"></i>
			<h3>SIGURNOST</h3>
			<p>Na ovom web sajtu, kupovina je bezbedna. Uživajte kupujući!</p>
		</div>
	</div>
	<hr class="my-4">
</div>

<!--- Two Column Section -->
<div class="container-fluid padding" id="about">
	<div class="row padding">
		<div class="col-md-12 col-lg-6">
			<h2>O NAMA</h2>
			<p>Verne tradiciji dugoj 13 godina, sve generacije kupuju u našoj parfimeriji - od onih koji se vezuju za klasične, oprobane proizvode do onih koji žele najnovije, inovativne preparate.</p>
			<p>Pretty Fix je 100% domaće preduzeće. Poverenje je stvarano decenijama i rezultira starim i novim kupcima.</p>
			<p>Sa prepoznatljivim eksterijerom i enterijerom, parfimerija je svima dostupna, a svaki proizvod je kupcu na dohvat ruke.</p>
			<p>Vremenom, parfimerija je proširila svoj asortiman i postala lider u web trgovini na prostoru Balkana u periodu kad je kupovina preko interneta bila jako nesigurna. Uz pomoć stručnih lica, ostvarili smo san.</p>
			<p>Kod nas možete pronaći svetski poznate parfeme i make-up proizvode. Stalne akcije, sniženja i pokloni uz kupovinu su must-have kad je u pitanju Pretty Fix parfimerija.</p>
		</div>

		<br>

		<div class="col-lg-6">
			<img src="img/zaonama.jfif" class="img-fluid">
		</div>
	</div>
</div>

<hr class="my-4">

<!--- Fixed background -->
<figure>
	<div class="fixed-wrap">
		<div id="fixed">

		</div>
	</div>
</figure>

  
<!--- News -->
<div class="container-fluid padding" id="news">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">NOVITETI</h1>
		</div>
		<hr>
	</div>
</div>

<!--- Cards -->

<div class="container-fluid padding">
	<div class="row padding">
		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/card1.webp">
				<div class="card-body">
					<h4 class="card-title">Miss Dior</h4>
					<p>Nova očaravajuća formula</p>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/card22.jpg">
				<div class="card-body">
					<h4 class="card-title">Chloé</h4>
					<p>Note koje obaraju sa nogu</p>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/card3aa.jpg">
				<div class="card-body">
					<h4 class="card-title">Hugo Boss</h4>
					<p>Modifikovane note za veće uživanje</p>
				</div>
			</div>
		</div>
	</div>
	<hr class="my-4">
</div>

<!--- Connect -->

<div class="container-fluid padding" id="contact">
	<div class="row text-center padding">
		<div class="col-12">
			<h2>Pratite nas na društvenim mrežama</h2>
		</div>
		<div class="col-12 social padding">
			<a href="https://www.facebook.com/prettyfix0/"><i class="fab fa-facebook"></i></a>
			<a href="#"><i class="fab fa-twitter"></i></a>
			<a href="#"><i class="fab fa-google-plus-g"></i></a>
			<a href="https://www.instagram.com/_prettyfix_/"><i class="fab fa-instagram"></i></a>
			<a href="#"><i class="fab fa-youtube"></i></a>
		</div>
	</div>
</div>

<!--- Footer -->

<footer>
	<div class="container-fluid padding">
		<div class="row text-center">
			<div class="col-md-4">
				<hr class="light">
				<h5>Kontakt centar</h5>
				<hr class="light">
				<p>011-357-3946</p>
				<p>prettyfix@gmail.com</p>
				<p>Koče Kapetana 26</p>
				<p>Beograd, Srbija, 11000</p>
			</div>
			<div class="col-md-4">
				<hr class="light">
				<h5>Radno vreme</h5>
				<hr class="light">
				<p>Ponedeljak-Petak: 09-20h</p>
				<p>Subota: 10-20h</p>
				<p>Nedelja: 10-16h</p>
			</div>
			<div class="col-md-4">
			<img src="img/pretty-removebg-preview-1-144x144.png">
		</div>

		<div class="col-12">
			<hr class="light-100">
			<h5>&copy; prettyfix.com</h5>
		</div>
		</div>
	</div>
</footer>


</body>
</html>






