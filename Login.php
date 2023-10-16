<?php
session_start();
/*print_r(session_id());
    exit;*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./login.png" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <form if="fr_login" name="fr_login">
            <div class="form-group space_box ">
                <label for="username">Username.</label>
                <input type="text" class="form-control" id="username" placeholder="Enter Username" />
            </div>
            <div class="form-group space_box">
                <label for="password">Password.</label>
                <input type="text" class="form-control" id="password" placeholder="Enter Password" />
            </div>
            <hr>

            <div align="center">
                <button type="button" class="btn btn-primary" style="width: 97%;
                                margin-bottom: 10px;
                                background-color: #2B56AE;
                                border: none;" onclick="login()">
                    Login
                </button>
            </div>
        </form>
    </div>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script type=text/javascript>
    var session = "<?php echo session_id(); ?>";

    function login() {
        let username;
        let password;
        username = document.getElementById("username").value;
        password = document.getElementById("password").value;
        let request_data = {
            "email": username,
            "password": password,
            "session": session
        }
        console.log(request_data);
        let uri = "http://localhost/Project/api/get_customer_login.php";
        //url = Uniform Resource Locator
        //uri = Uniform Resource Identifie
        $.ajax({
            type: "POST",
            url: uri,
            async: false,
            data: JSON.stringify(request_data),
            success: function(response) {
                // console.log("Connect Success...");
                // console.log(response);
                // console.log(response.result);
                // console.log(response.message);
                if (response.result === 1) {
                    // console.log(response.datalist);
                    // console.log(response.datalist.email);

                    localStorage.setItem("customer_profile", JSON.stringify(response.datalist));

                    // let customer_profile = localStorage.getItem("customer_profile");
                    // customer_profile = JSON.parse(customer_profile);
                    // console.log(customer_profile);

                    window.location.replace("http://localhost/Project/home.php?menu=productlist");
                } else {
                    //console.log("go to login.php");
                    document.getElementById("username").value = "";
                    document.getElementById("password").value = "";
                    document.getElementById("username").focus();
                    alert("เข้าสู่ระบบไม่สำเร็จ");
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
</script>