<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link rel="stylesheet" href="stylecrud.css?v=<?php echo time(); ?>">
	<link rel="icon" href="img/pretty-removebg-preview-1-144x144.png">

<style>
    fieldset{
        font-family: Helvetica, Arial, sans-serif;
        margin-right: 50%;
    }
</style>

<div class="sidenav">
    <?php
    include './dropDown.php';
    include './connectionString.php';
    ?>
</div>

<?php
$category = "SELECT * FROM category";

$rez = $conn->query($category);


if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $categoryName = $_POST['categoryName'];
    $price = $_POST['price'];

    if (isset($_FILES['photo'])) {
        $errors = array();
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['photo']['name'];

        $file_size = $_FILES['photo']['size'];
        $file_tmp = $_FILES['photo']['tmp_name'];

        $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
        $data = file_get_contents($file_tmp);
        $endoceData = base64_encode($data);
        if ($file_size > 2097152) {
            $errors[] = 'Dozvoljena velicina slike je 2mb';
        }

        if (empty($errors)) {
            if (move_uploaded_file($file_tmp, 'img/' . $file_name)) {

                $query = "INSERT INTO product (ProductName, Amount, Photo , Price, CategoryId) VALUES ('{$name}', '{$amount}', '{$endoceData}', '{$price}', '{$categoryName}')";

                $qc = mysqli_query($conn, $query);
                echo 'Uspesno dodavanje!';
            }
        } else {
            foreach ($errors as $error) {
                echo $error, '<br/>';
            }
        }
    }
}
?>

<div class="main">
    <div>
        <h2>Kreiraj prozivod</h2>
    </div>
    <p id="show_message" style="display: none">Uspešno kreiranje!</p>
    <span id="error" style="display: none"></span>
    <fieldset style="border: 1px solid black; border-radius: 5px; padding-left: 30px">
        <form  method="post" enctype="multipart/form-data">

            <label for="productName">Naziv proizvoda:</label><br>
            <input class="inp" type="text" name="name" id="name"/>
            <br>
            <label for="amount">Količina proizvoda:</label><br>
            <input class="inp" type="text" name="amount" id="amount"/>
            <br>
            <label for="photo">Slika proizvoda:</label><br>
            <input class="inp" type="file" name="photo" id="photo"/>
            <br>
            <label for="categoryName">Kategorija:</label><br>
            <select name="categoryName" id="categoryName"> 
                <?php
                while ($row = $rez->fetch_assoc()) {
                    echo "<option value=" . $row["Id"] . ">" . $row["Name"] . "</option>";
                }
                ?>
            </select>
            <br>
            <label for="price">Cena proizvoda:</label><br>
            <input class="inp" type="text" name="price" id="price"/>
            <br><br>

            <input  type="submit" value="Dodaj" id="submit" name="submit" /> 

        </form>
    </fieldset>
</div>
<script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;
        //addEventListener 
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


