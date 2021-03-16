<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link rel="stylesheet" href="stylecrud.css?v=<?php echo time(); ?>">
	<link rel="icon" href="img/pretty-removebg-preview-1-144x144.png">




<script type="text/javascript">

$(document).ready(function ()
{//putanja do onoga sto brisem td(kolonu) a je tag u td-u
    //klase sa . a id sa #
    $('table#myTable td a.delete').click(function ()
    {
        if (confirm("Da li ste sigurni da zelite da obrisete ovaj red?"))
        {
            var id = $(this).parent().parent().attr('id');
            var data = 'Id=' + id;
            var parent = $(this).parent().parent();

            $.ajax(
                    {
                        type: "POST",
                        url: "deleteCategory.php",
                        data: data,
                        cache: false,

                        success: function ()
                        {
                            parent.fadeOut('slow', function () {
                                $(this).remove();
                            });
                        }
                    });
        }
    });

    
    $('table#myTable tr:odd').css('background', ' #FFFFFF');
});

</script>
</head>

<body>
        <div class="sidenav">
            <?php include './dropDown.php'; ?>
        </div>


        <div class="main">
            <div>
                <h2>Kategorije</h2>
            </div>
            <fieldset style="border: 1px solid black; border-radius: 5px;">
                <form method="post">
                    <?php
                    include './connectionString.php';

                    $upit = "SELECT * FROM category";
                    $rez = $conn->query($upit);

                    if (!$rez) {
                        print("Greška!" . $connect->error);
                    }

                    if (!($rez->num_rows > 0)) {
                        print("Ne postoji!");
                    } else {
                        ?>
                        <div class="input-icons"> 
                            <i class="fa fa-search icon"></i> 
                            <input class="input-field" type="text" id="myInput" onkeyup="myFunction()" placeholder="Pretrazi"><br><br>
                        </div>

                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col" onclick="sortTable(0)"><span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>Sifra kategorije</th>
                                    <th scope="col" onclick="sortTable(1)">Naziv</th>
                                    <th scope="col">Izmeni</th>
                                    <th scope="col">Obrisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $rez->fetch_object()) {
                                    echo "<tr id='{$row->Id}'><td> " . $row->Id . "</td><td> " . $row->Name . "</td> "
                                    . "<td> <a href='updateCategory.php?action=Izmeni&Id={$row->Id}&Name={$row->Name}'><i class='far fa-edit action'></i> </a></td>";
                                    ?> 
                                <td><a href="#" class="delete"><i class='fa fa-trash action'></i></a></td></tr>
                                    <?php } ?>  

                        </table> 
                    <?php } ?>  
                </form>
            </fieldset>
        </div>

    </body>
</html>
<!-- td je kolona a tr red -->

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

<script>
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
<script>
    // JavaScript program to illustrate 
    // Table sort for both columns and both directions. 
    function sortTable(n) {
        var table;
        table = document.getElementById("myTable");
        var rows, i, x, y, count = 0;
        var switching = true;

        // Order is set as ascending 
        var direction = "ascending";

        // Run loop until no switching is needed 
        while (switching) {
            switching = false;
            var rows = table.rows;

            //Loop to go through all rows 
            for (i = 1; i < (rows.length - 1); i++) {
                var Switch = false;

                // Fetch 2 elements that need to be compared 
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];

                // Check the direction of order 
                if (direction == "ascending") {

                    // Check if 2 rows need to be switched 
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase())
                    {
                        // If yes, mark Switch as needed and break loop 
                        Switch = true;
                        break;
                    }
                } else if (direction == "descending") {

                    // Check direction 
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase())
                    {
                        // If yes, mark Switch as needed and break loop 
                        Switch = true;
                        break;
                    }
                }
            }
            if (Switch) {
                // Function to switch rows and mark switch as completed 
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;

                // Increase count for each switch 
                count++;
            } else {
                // Run while loop again for descending order 
                if (count == 0 && direction == "ascending") {
                    direction = "descending";
                    switching = true;
                }
            }
        }
    }
</script> 
</body>
</html> 