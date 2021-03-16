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

$category = "SELECT * FROM category";

$rez = $conn->query($category);



if (isset($_FILES['photo'])) {
    $productName = $_POST['productName'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $errors = array();
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $_FILES['photo']['name'];

    $file_size = $_FILES['photo']['size'];
    $file_tmp = $_FILES['photo']['tmp_name'];

    $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
    $data = file_get_contents($file_tmp);
    $endoceData = base64_encode($data);
    //$base64 = 'data:image/' . $type . ';base64,' . base64_encode($endoceData);
    if ($file_size > 2097152) {
        $errors[] = 'Dozvoljena velicina slike je 2mb';
    }
    if (empty($errors)) {
        if (move_uploaded_file($file_tmp, 'img/' . $file_name)) {

            $query = "UPDATE product SET
      ProductName='" . $productName . "',
      Amount='" . $amount . "',
      CategoryId='" . $category . "',
      Photo='" . $endoceData . "',
      Price='" . $price . "'
      WHERE ProductId='" . $_POST['id'] . "'";

            if ($conn->query($query) === TRUE) {
                $message = "Uspesna izmena!";
                $upperMessage = strtoupper($message);
                echo $upperMessage;
            } else {
                echo "Greska:" . $connect->error;
            }
        }
    } else {
        foreach ($errors as $error) {
            echo $error, '<br/>';
        }
    }
}
?>
<div class="main">
    <div>
        <h2>Ažuriraj prozivod</h2>
    </div>
    <fieldset style="border: 1px solid black; border-radius: 5px; padding-left: 30px">
        <form method="post" enctype="multipart/form-data">

            <label for="id">Sifra proizvoda:</label><br>
            <input class="inp" value="<?php
            if (filter_input(INPUT_GET, "action") == "Izmeni") {
                $p = $_GET['ProductId'];
                echo $p;
            }
            ?>" type="text" name="id" readonly><br><br>

            <label for="productName">Naziv proizvoda:</label><br>
            <input class="inp" value="<?php
            if (filter_input(INPUT_GET, "action") == "Izmeni") {
                echo $_GET['ProductName'];
            }
            ?>" type="text" name="productName" id="name"/><br><br>

            <label for="amount">Kolicina proizvoda:</label><br>
            <input class="inp" value="<?php
            if (filter_input(INPUT_GET, "action") == "Izmeni") {
                echo $_GET['Amount'];
            }
            ?>" type="text" name="amount" /><br><br>

            <label for="photo">Slika proizvoda:</label><br>
            <input type="file" value="<?php
            if (filter_input(INPUT_GET, "action") == "Izmeni") {
                echo $_GET['Photo'];
            }
            ?>" name="photo"><br><br>


            <label for="category">Kategorija proizvoda:</label><br>
            <select class="inp" value="<?php
            if (filter_input(INPUT_GET, "action") == "Izmeni") {
                echo $_GET['CategoryId'];
            }
            ?>" name="category" id="category">
                    <?php
                    while ($row = $rez->fetch_assoc()) {
                        echo "<option value=" . $row["Id"] . ">" . $row["Name"] . "</option>";
                    }
                    ?>
            </select><br><br>

            <label for="price">Cena proizvoda:</label><br>
            <input class="inp" value="<?php
            if (filter_input(INPUT_GET, "action") == "Izmeni") {
                echo $_GET['Price'];
            }
            ?>" type="text" name="price" /><br><br>
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


