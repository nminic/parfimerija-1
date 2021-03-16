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

<div class="main">
    <div>
        <h2>Dodaj kategoriju</h2>
    </div>
    <p id="show_message" style="display: none">Uspešno dodavanje!</p>
    <span id="error" style="display: none"></span>
    <fieldset style="border: 1px solid black; border-radius: 5px; padding-left: 30px">
        <form action="javascript:void(0)" id="ajax-form" method="post">
            <label for="categoryName">Naziv kategorije:</label><br>
            <input class="inp" type="text" name="categoryName" id="categoryName"/>
            <br><br>
            <input type="submit" value="Dodaj" id="submit" name="submit" /> 

        </form>
    </fieldset>
</div>
<script type="text/javascript">
    $(document).ready(function ($) {

        // hide messages 
        $("#error").hide();
        $("#show_message").hide();
        // on submit... #ajax-form je id forme
        
        $('#ajax-form').submit(function (e) {

            e.preventDefault();
            $("#error").hide();
            
            //name required val() uzima vrednost tog inputa - kategorije 
            var categoryName = $("input#categoryName").val();
            //provera da li je categoryName prazno
            if (categoryName == "") {
                $("#error").fadeIn().text("Naziv kategorije je obavezno polje.");
                $("input#categoryName").focus();
                //focus na inputu 
                return false;
            }
            // ajax
            //url gde ide, metodom post
            //data uzima sve unete podatke
            //success ako je uspesno, on pokaze message koji je gore naveden
            $.ajax({
                type: "POST",
                url: "ajax-category-save.php",
                data: $(this).serialize(), // get all form field value in serialize form
                success: function () {
                    $("#show_message").fadeIn();
                    //$("#ajax-form").fadeOut();
                }
            });
        });

        return false;
    });
</script>
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


