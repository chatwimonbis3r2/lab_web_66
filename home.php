<?php
ob_start();
session_start();
require "config/config_db.php";
$strSQL = "SELECT id,name FROM customer WHERE session ='" . session_id() . "' ";
$query = @mysqli_query($conn, $strSQL);
$resultQuery = @mysqli_fetch_array($query);
if ($resultQuery['id'] != "") {
    //print_r("show form");
} else {
    //print_r("go to login");
    @mysqli_close($conn);
    header("location: http://localhost/Project/Login.php");
    exit;
}
ob_end_clean();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./css/main.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body onload="getEnvironment()">
    <header>
        <h1>Header</h1>
        <div align="right">
            <i class="bi bi-cart4"></i>
            [<label id="customer_cart_snum">88</label>]
            [<label id="customer_cart_stotal">88</label>]
            <label id="customer_profile_name">customer_profile</label>
            <input type="hidden" id="customer_profile_id" />
            <input type="hidden" id="customer_profile_email" />
        </div>
    </header>

    <div class="row">
        <nav class="column menu">
            <h2>Menu</h2>
            <ul>
                <li><a href="./home.php?menu=productlist">productlist</a></li>
                <li><a href="./home.php?menu=X">X</a></li>
                <li><a href="#">Menu 3</a></li>
            </ul>
        </nav>
        <div class="column content">
            <?php
            if (@$_GET['menu'] === "productlist") {
                include "_product_list.php";
            } else {
            }

            ?>
        </div>
    </div>
    <!-- <footer>Footer</footer> -->
</body>

</html>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    function getEnvironment() {
        let customer_profile = localStorage.getItem("customer_profile");
        customer_profile = JSON.parse(customer_profile);
        document.getElementById("customer_profile_name").innerHTML = customer_profile.name;
        document.getElementById("customer_profile_id").value = customer_profile.id;
        document.getElementById("customer_profile_email").value = customer_profile.email;
       
        getProductList();

        let customer_cart = localStorage.getItem("customer_cart");
        customer_cart = JSON.parse(customer_cart);
        document.getElementById("customer_cart_snum").innerHTML = customer_cart.snum;
        document.getElementById("customer_cart_stotal").innerHTML = customer_cart.stotal;
    }
</script>