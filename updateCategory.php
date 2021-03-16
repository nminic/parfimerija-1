<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link rel="stylesheet" href="stylecrud.css?v=<?php echo time(); ?>">
	<link rel="icon" href="img/pretty-removebg-preview-1-144x144.png">
    
    <div class="sidenav">
    <?php include './dropDown.php';
    include './connectionString.php';?>
</div>

<?php

if (isset($_POST['azuriraj'])) {
    $categoryName = $_POST['categoryName'];


    $query = "UPDATE category
                              SET 
                              Name='" . $categoryName . "'
                              WHERE Id='" . $_POST['id'] . "'";

    if ($conn->query($query) === TRUE) {
        $message= "Uspesna izmena!";
        $upperMessage = strtoupper($message);
        echo $upperMessage;
    } else {
        echo "Greska:" . $connect->error;
    }
}
?>

<div class="main">
    <div>
        <h2>Azuriraj kategoriju</h2>
    </div>
    <fieldset style="border: 1px solid black; border-radius: 5px; padding-left: 30px">
        <form method="post" enctype="multipart/form-data">

            <label for="id">Sifra katergorije:</label><br>
            <input class="inp" value="<?php
            if (filter_input(INPUT_GET, "action") == "Izmeni") {
                $p = $_GET['Id'];
                echo $p;
            }
            ?>" type="text" name="id" readonly><br><br>

            <label for="categoryName">Naziv kategorije:</label><br>
            <input class="inp" value="<?php
            if (filter_input(INPUT_GET, "action") == "Izmeni") {
                echo $_GET['Name'];
            }
            ?>" type="text" name="categoryName" id="name"/><br><br>

            <input  type="submit" value="Ažuriraj" id="submit" name="azuriraj" /> 
            <span id="error_message" class="text-danger"></span>  <br><br>

        </form>
    </fieldset>
</div>


<script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>
