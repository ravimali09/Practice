<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>


<style>
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }

    body {
        background-color: aliceblue;
    }

    .form-div {
        margin: 150px auto;
        width: 35%;
        padding: 20px 5px;
        border-radius: 5px;
        ;
        background-color: rgb(216, 252, 255);
        box-shadow: 2px 4px gray;

    }

    .form-div h2 {
        text-transform: uppercase;
        text-align: center;
    }

    .inp-div {
        margin-top: 10px;
        padding: 0 15px;
    }

    .inp-div input {
        padding: 3px;
        border: 1px solid;
        border-radius: 5px;
        margin-left: 40px;
        width: 80%;
    }

    .inp-div button {
        background-color: aqua;
        width: 50%;
        padding: 5px;
        border: none;
        border-radius: 5px;
        margin-left: 25%;
    }

    .inp-div p {
        margin-left: 30%;
    }

    .inp-div a {
        text-decoration: none;
    }

    .danger {
        margin: 50px auto;
        border: 1px solid red;
        width: fit-content;
        padding: 10px;
        border-radius: 5px;
        color: red;
    }

    .err {
        color: red;
    }
</style>

<body>
    <?php
    if (isset($_SESSION['login_failed'])) {
        ?>
        <div class="danger">
            <p><?php echo $_SESSION['login_failed']; ?></p>
        </div>
        <?php
        unset($_SESSION['login_failed']);
    }
    if (isset($_SESSION['logout'])) {
        ?>
        <div class="danger">
            <p><?php echo $_SESSION['logout']; ?></p>
        </div>
        <?php
        unset($_SESSION['logout']);
    }
    if (isset($_SESSION['login_first'])) {
        ?>
        <div class="danger">
            <p><?php echo $_SESSION['login_first']; ?></p>
        </div>
        <?php
        unset($_SESSION['login_first']);
    }
    ?>
    <div class="form-div">
        <h2>Login Form</h2>
        <form action="" method="post" id="form">
            <div class="inp-div">
                <label>Email :</label>
                <input type="email" name="email" id="email" placeholder="Enter Your Email" value="<?php
                if (isset($email)) {
                    echo $email;
                }
                ?>">
                <span class="err" style="margin-left: 95px;" id="err_email"></span>
            </div>
            <div class="inp-div">
                <label>Password :</label>
                <input type="text" name="password" id="password" placeholder="Enter Your Password"
                    style="margin-left: 10px;" value="<?php
                    if (isset($norm_password)) {
                        echo $norm_password;
                    }
                    ?>">
                <span class="err" style="margin-left: 95px;" id="err_password"></span>
            </div>
            <div class="inp-div">
                <button type="submit" name="login">Login</button>
            </div>
            <div class="inp-div">
                <p>Don't have an account? <a href="add_product">Signup</a></p>
            </div>
        </form>
    </div>
</body>
<script>
    $(document).ready(function () {
        $("#email").blur(function (e) {
            var valid = true;
            var email = $("#email").val();
            var emailPattern = /^[a-zA-Z0-9.]+\@[a-zA-Z]+\.[a-zA-Z]{2,4}$/;
            if (emailPattern.test(email)) {
                $("#err_email").text("");
            }
            else {
                $("#err_email").text("Enter A Valid Email...!");
                valid = false;
            }
            if ($("#email").val() == "") {
                $("#err_email").text("Email field is required...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        });
        $("#password").blur(function (e) {
            var valid = true;
            var pass = $("#password").val();
            var passPatern = /^[a-z A-Z0-9!@#$%^&*()_+-=]{8,15}$/;
            if (passPatern.test(pass)) {
                $("#err_password").text("");
            }
            else {
                $("#err_password").text("Password length must be between 8-15 characters");
                valid = false;
            }
            if ($("#password").val() == "") {
                $("#err_password").text("Password field is required...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        });
        $("#email").focus(function () {
            $("#err_email").text("");
        });
        $("#password").focus(function () {
            $("#err_password").text("");
        });

        $("#form").submit(function (e) {
            var isValid = true;
            var email = $("#email").val();
            var emailPattern = /^[a-zA-Z0-9.]+\@[a-zA-Z]+\.[a-zA-Z]{2,4}$/;
            if (emailPattern.test(email)) {
                $("#err_email").text("");
            }
            else {
                $("#err_email").text("Enter A Valid Email...!");
                isValid = false;
            }
            if ($("#email").val() == "") {
                $("#err_email").text("Email field is required...!");
                isValid = false;
            }
            var pass = $("#password").val();
            var passPatern = /^[a-z A-Z0-9!@#$%^&*()_+-=]{8,15}$/;
            if (passPatern.test(pass)) {
                $("#err_password").text("");
            }
            else {
                $("#err_password").text("Password length must be between 8-15 characters");
                isValid = false;
            }
            if ($("#password").val() == "") {
                $("#err_password").text("Password field is required...!");
                isValid = false;
            }
            if (!isValid) {
                e.preventDefault();
            }
        });

        setTimeout(function () {
            $('.danger').fadeOut('slow');
        }, 2000);
    })
</script>

</html>