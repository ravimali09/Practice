<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    include_once 'model.php';
    $sel = "SELECT * FROM product WHERE id=$id";
    $res = mysqli_query($this->conn, $sel);
    $data = mysqli_fetch_assoc($res);
    $data['language'] = explode(",", $data['language']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="insert.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<style>
    .form-div {
        margin: 150px auto;
    }

    .session {
        margin: 50px auto;
        border: 1px solid green;
        width: fit-content;
        padding: 10px;
        border-radius: 5px;
        color: green;
    }

    .danger {
        margin: 50px auto;
        border: 1px solid red;
        width: fit-content;
        padding: 10px;
        border-radius: 5px;
        color: red;
    }
</style>

<body>
    <?php
    if (isset($_SESSION['insert'])) {
        ?>
        <div class="session">
            <p><?php echo $_SESSION['insert']; ?></p>
        </div>
        <?php
        unset($_SESSION['insert']);
    }
    ?>
    <div class="form-div">
        <h2>Registration Form</h2>
        <form action="<?php 
        if (isset($_GET['id'])) {
            echo "update_product?id=".$_GET['id']."&page=".$page."&limit=". $limit.'&inp-search='.$value.'&genders='.$genders.'&languages='.$languages.'&cities='.$cities;
        } else {
            echo 'add_product?page='. $page.'&inp-search='.$value.'&limit='.$limit.'&genders='.$genders.'&languages='.$languages.'&cities='.$cities;
        }
        ?>" method="post" enctype="multipart/form-data" id="form">
            <div class="inp-div">
                <label>Name :</label>
                <input type="text" name="name" id="Name" placeholder="Enter Your Name" value="<?php
                if (!isset($_SESSION['insert'])) {
                    if (isset($name))
                        echo $name;
                    elseif (isset($data['name']))
                        echo $data['name']; 
                }
                ?>">
                <span class="err" id="errName" style="margin-left: 105px;"></span>
            </div>
            <div class="inp-div">
                <label>Email :</label>
                <input type="email" name="email" id="Email" style="margin-left: 50px;" placeholder="Enter Your Email"
                    value="<?php
                    if (isset($email))
                        echo $email;
                        elseif (isset($data['email']))
                        echo $data['email'];
                    ?>">
                <span class="err" style="margin-left: 105px;" id="errEmail">
                    <?php
                    if (isset($_SESSION['email'])) {
                        ?>
                        <span class="err">
                            <?php echo $_SESSION['email']; ?>
                        </span>
                        <?php
                        unset($_SESSION['email']);
                    }
                    ?>  
                </span>
                    
            </div>
            <div class="inp-div">
                <label>Password :</label>
                <input type="text" name="password" id="Password" style="margin-left: 20px;" placeholder="Enter Password"
                    value="<?php
                    if (isset($norm_pass))
                        echo $norm_pass;
                        elseif (isset($data['norm_pass']))
                        echo $data['norm_pass'];
                    ?>">
                <span class="err" style="margin-left: 105px;" id="errPassword"></span>

            </div>
            <div class="inp-div">
                <label>Confirm Password :</label>
                <input type="text" name="password2" id="Confirm_Password" style="margin-left: 0px; width: 68%;"
                    placeholder="Confirm Password" value="<?php
                    if (isset($norm_pass))
                        echo $norm_pass;
                        elseif (isset($data['norm_pass']))
                        echo $data['norm_pass'];
                    ?>">
                <span class="err" style="margin-left: 105px;" id="errConfirm_Password"></span>

            </div>

            <div class="inp-div img-div">
                <label>Image :</label>
                <input type="file" name="image" id="Image" style="margin-left: 45px;">
                <span class="err" style="margin-left: 105px;" id="errImage"></span>

            </div>
            <div class="gender">
                <label>Gender :</label>
                <input type="radio" name="gender" id="Male" value="Male" <?php
                if (isset($data['gender'])) {
                    if ($data['gender'] == 'Male') {
                        echo 'checked';
                    }
                }
                elseif (isset($gender)) {
                    if ($gender == 'Male') {
                        echo 'checked';
                    }
                }
                ?>> <label for="Male">Male</label>
                <input type="radio" name="gender" id="Female" value="Female" <?php
                if (isset($data['gender'])) {
                    if ($data['gender'] == 'Female') {
                        echo 'checked';
                    }
                }
                elseif (isset($gender)) {
                    if ($gender == 'Female') {
                        echo 'checked';
                    }
                }
                ?>> <label for="Female">Female</label>
                <input type="radio" name="gender" id="Other" value="Other" <?php
                if (isset($data['gender'])) {
                    if ($data['gender'] == 'Other') {
                        echo 'checked';
                    }
                }
                elseif (isset($gender)) {
                    if ($gender == 'Other') {
                        echo 'checked';
                    }
                }
                ?>> <label for="Other">Other</label>
                <span class="err" id="errGender"></span>

            </div>
            <div class="lang">
                <label>Language :</label>
                <input type="checkbox" name="language[]" id="Hindi" value="Hindi" <?php
                if (isset($data['language'])) {
                    if (in_array("Hindi", $language)) {
                        echo 'checked';
                    }
                }
                if (isset($language2)) {
                    if (in_array('Hindi', $language2)) {
                        echo 'checked';
                    }
                }
                ?>> <label for="Hindi" id="Hindi_lbl">Hindi</label>
                <input type="checkbox" id="English" name="language[]" value="English" <?php
                if (isset($data['language'])) {
                    if (in_array("English", $language)) {
                        echo 'checked';
                    }
                }
                if (isset($language2)) {
                    if (in_array('English', $language2)) {
                        echo 'checked';
                    }
                }
                ?>> <label for="English">English</label>
                <input type="checkbox" id="Gujrati" name="language[]" value="Gujrati" <?php
                if (isset($data['language'])) {
                    if (in_array("Gujrati", $language)) {
                        echo 'checked';
                    }
                }
                if (isset($language2)) {
                    if (in_array('Gujrati', $language2)) {
                        echo 'checked';
                    }
                }
                ?>> <label for="Gujrati">Gujrati</label>
                <span class="err" id="errLang"></span>
            </div>
            <div class="city">
                <label>City :</label>
                <select name="city" id="city">
                    <option value="">Select City</option>
                    <option value="Ahmedabad" <?php
                    if (isset($data['city'])) {
                        if ($data['city'] == 'Ahmedabad') {
                            echo 'selected';
                        }
                    }
                    elseif (isset($city)) {
                        if ($city == 'Ahmedabad') {
                            echo 'selected';
                        }
                    }
                    ?>>Ahmedabad</option>
                    <option value="Mandar" <?php
                    if (isset($data['city'])) {
                        if ($data['city'] == 'Mandar') {
                            echo 'selected';
                        }
                    }
                    elseif (isset($city)) {
                        if ($city == 'Mandar') {
                            echo 'selected';
                        }
                    }
                    ?>>Mandar</option>
                    <option value="Mumbai" <?php
                    if (isset($data['city'])) {
                        if ($data['city'] == 'Mumbai') {
                            echo 'selected';
                        }
                    }
                    elseif (isset($city)) {
                        if ($city == 'Mumbai') {
                            echo 'selected';
                        }
                    }
                    ?>>Mumbai</option>
                    <option value="Delhi" <?php
                    if (isset($data['city'])) {
                        if ($data['city'] == 'Delhi') {
                            echo 'selected';
                        }
                    }
                    elseif (isset($city)) {
                        if ($city == 'Delhi') {
                            echo 'selected';
                        }
                    }
                    ?>>Delhi</option>
                    <option value="Malipura" <?php
                    if (isset($data['city'])) {
                        if ($data['city'] == 'Malipura') {
                            echo 'selected';
                        }
                    }
                    elseif (isset($city)) {
                        if ($city == 'Malipura') {
                            echo 'selected';
                        }
                    }
                    ?>>Malipura</option>
                    <option value="Surat" <?php
                    if (isset($data['city'])) {
                        if ($data['city'] == 'Surat') {
                            echo 'selected';
                        }
                    }
                    elseif (isset($city)) {
                        if ($city == 'Surat') {
                            echo 'selected';
                        }
                    }
                    ?>>Surat</option>
                </select>
                <span class="err" id="errCity"></span>

            </div>
          
             <div class="inp-div">
              <?php
             if(!empty($product_arr)){
                foreach($product_arr as $products){
                     if(isset($_REQUEST['id']))
                     {
                    ?>
                    <img src="image/<?php echo $products->image;?>" height="80px" width="80px" style="border-radius: 5px; margin-left: 100px;">
                    <?php
                    }
             }
            }

            
              ?>  
            </div>
           
            <div class="inp-div">
                <button type="submit" name="submit" id="submit">Submit</button>
            </div>
            <div class="inp-div">
                <p>Already have an account? <a href="login">Login</a></p>
            </div>
            <div class="inp-div">
               <?php
               if(isset($_REQUEST['id'])){
                ?>
                 <a href="pagination?page=<?php echo $page;?>&limit=<?php if (isset($limit))
                       echo $limit?>&inp-search=<?php if (isset($value))
                        echo $value; ?><?php if (isset($genders))
                        echo '&gender=' . $genders; ?><?php if (isset($languages))
                                echo '&language=' . $languages; ?><?php if (isset($cities))
                                        echo '&city=' . $cities; ?>">Back</a>
                <?php
               }
               else{
                ?>
                 <a href="pagination?page=<?php if(isset($page)) echo $page;?>&limit=<?php if(isset($limit)) 
                        echo $limit;?>&inp-search=<?php if(isset($value)) 
                          echo $value;?><?php if (isset($genders))
                          echo '&gender=' . $genders; ?><?php if (isset($languages))
                                  echo '&language=' . $languages; ?><?php if (isset($cities))
                                          echo '&city=' . $cities; ?>">Back</a>
                <?php
               }
               ?>
            </div>  
            
        </form>
    </div>
</body>

<script>
    $(document).ready(function () {
        $("input").blur(function (e) {
            var valid = true;
            var inp_id = $(this).attr('id');
            if ($(this).val() == "") {
                $("#err" + inp_id).text(inp_id + " field is required...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        })
        $("input").focus(function (e) {
            var valid = true;
            var inp_id = $(this).attr('id');
            if ($(this).val() == "") {
                $("#err" + inp_id).text("");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        })

        $("#Email").focus(function(){
                $("#errEmail").text("");
            });

        //----------------IMAGE EDIT----------------->>

        $("#Image").blur(function (e) {
            var isValid = true;
            var image = $("#Image").val();
            var imgPattern = /\.(jpg|JPG|jpeg|JPEG|png|PNG|gif|PNG)$/;
            if ($("#Image").val() == "") {
                $("#errImage").text("");

            }
            else if (!imgPattern.test(image)) {
                $("#errImage").text("Only JPG, JPEG, PNG and GIF images allowed");
                isValid = false;

            }
            else {
                $("#errImage").text("");
            }
        });
        $("#Image").change(function (e) {
            var isValid = true;
            var image = $("#Image").val();
            var imgPattern = /\.(jpg|JPG|jpeg|JPEG|png|PNG|gif|PNG)$/;

            if ($("#Image").val() == "") {
                $("#errImage").text("");

            }
            else if (!imgPattern.test(image)) {
                $("#errImage").text("Only JPG, JPEG, PNG and GIF images allowed");
                isValid = false;

            }
            else {
                $("#errImage").text("");
            }
        });

        ///  ///   IMAGE  INSERT ///  ///

        <?php
        if (!isset($_GET['id'])) {
            ?>
            if ($("#Image").blur(function (e) {
                var valid = true;
                var image = $("#Image").val();
                var imgPattern = /\.(jpg|JPG|jpeg|JPEG|png|PNG|gif|PNG)$/;

                if ($("#Image").val() == "") {
                    $("#errImage").text("Image field is required...!");
                    valid = false;

                }
                else if (!imgPattern.test(image)) {
                    $("#errImage").text("Only JPG, JPEG, PNG and GIF images allowed");
                    valid = false;

                }
                else {
                    $("#errImage").text("");
                }
                if (!valid) {
                    e.preventDefault();
                }
            }));
            if ($("#Image").change(function (e) {
                var valid = true;
                var image = $("#Image").val();
                var imgPattern = /\.(jpg|JPG|jpeg|JPEG|png|PNG|gif|PNG)$/;

                if ($("#Image").val() == "") {
                    $("#errImage").text("Image field is required...!");
                    valid = false;

                }
                else if (!imgPattern.test(image)) {
                    $("#errImage").text("Only JPG, JPEG, PNG and GIF images allowed");
                    valid = false;

                }
                else {
                    $("#errImage").text("");
                }
                if (!valid) {
                    e.preventDefault();
                }
            }));
            <?php
        }
        ?>

        /// ///    GENDER    ///   /// 



        if ($("input[name='gender']").blur(function (e) {
            var valid = true;
            if ($(this).val() != "") {
                $("#errGender").text("");
            }
            else {
                $("#errGender").text("Gender field is required...!");
                valid = false;
            }
            if (!$("input[name='gender']:checked").val()) {
                $("#errGender").text("Gender field is required...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        }));
        if ($("input[name='gender']").change(function (e) {
            var valid = true;
            if ($(this).val() != "") {
                $("#errGender").text("");
            }
            else {
                $("#errGender").text("Gender field is required...!");
                valid = false;
            }
            if (!$("input[name='gender']:checked").val()) {
                $("#errGender").text("Gender field is required...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        }));



        ///  ///     LANGUAGE    ///  ///

        if ($("input[name='language[]']").blur(function (e) {
            var valid = true;
            if ($(this).val() != "") {
                $("#errLang").text("");
            }
            else {
                $("#err_lang").text("Language field is required...!");
                valid = false;
            }
            if (!$("input[name='language[]']:checked").val()) {
                $("#errLang").text("Language field is required...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        }));
        if ($("input[name='language[]']").change(function (e) {
            var valid = true;
            if ($(this).val() != "") {
                $("#errLang").text("");
            }
            else {
                $("#err_lang").text("Language field is required...!");
                valid = false;
            }
            if (!$("input[name='language[]']:checked").val()) {
                $("#errLang").text("Language field is required...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        }));


        ///  /// CITY  ///  ///

        if ($("#city").blur(function (e) {
            var valid = true;
            if ($(this).val() != "") {
                $("#errCity").text("");
            }
            else {
                $("#errCity").text("City field is required...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        }));
        if ($("#city").change(function (e) {
            var valid = true;
            if ($(this).val() != "") {
                $("#errCity").text("");
            }
            else {
                $("#errCity").text("City field is required...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        }));


        // ----------------------- Name Validation -------------------------->>

        $("#Name").blur(function (e) {
            var valid = true;
            var name = $("#Name").val();
            var namePattern = /^[a-zA-Z ]{3,15}$/;
            if (namePattern.test(name)) {
                $("#errName").text("");
            }
            else {
                $("#errName").text("Name must contain alphabets only. Min = 3, Max = 15 Alphabets");
                valid = false;
            }
            if ($("#Name").val() == "") {
                $("#errName").text("Name field is required...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        });



        //---------------- Email Validation ------------------->>

        $("#Email").blur(function (e) {
            var valid = true;
            var mail = $("#Email").val();
            var emailPattern = /^[a-zA-Z0-9.]+\@[a-zA-Z]+\.[a-zA-Z]{2,4}$/;
            var a = emailPattern.test(mail);
            if (a == true) {
                $("#errEmail").text("");
            }
            else {
                $("#errEmail").text("Enter A Valid Email...!");
                valid = false;
            }
            if ($("#Email").val() == "") {
                $("#errEmail").text("Email field is required...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        });




        //----------------------- Password Validation----------------------->>

        $("#Password").blur(function (e) {
            var valid = true;
            var pass = $("#Password").val();
            var pass2 = $("#Confirm_Password").val();
            var passPatern = /^[a-zA-Z0-9!@#$%^&*()_+-=]{8,15}$/;
            if (passPatern.test(pass)) {
                $("#errPassword").text("");
            }
            else {
                $("#errPassword").text("Password length must be between 8-15 characters");
                valid = false;
            }
            if ($("#Password").val() == "") {
                $("#errPassword").text("Password field is required...!");
                valid = false;
            }
            if (pass != pass2 && pass2!='') {
                $("#errPassword").text("Password Does Not Match...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        });
        $("#Confirm_Password").blur(function (e) {
            var valid = true;
            var pass = $("#Password").val();
            var pass2 = $("#Confirm_Password").val();
            var passPattern = /^[a-zA-Z0-9!@#$%^&*()_+-=]{8,15}$/;
            var a = passPattern.test(pass);
            if (a == true) {
                $("#errConfirm_Password").text("");
            }
            else {
                $("#errConfirm_Password").text("Password length must be between 8-15 characters");
                valid = false;
            }
            if (pass != pass2) {
                $("#errConfirm_Password").text("Password Does Not Match...!");
                $("#errPassword").text("Password Does Not Match...!");
                valid = false;
            }else{
                $("#errPassword").text("");
            }
            if ($("#Confirm_Password").val() == "") {
                $("#errConfirm_Password").text("Confirm_Password field is required...!");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        });



        //------------------------ON SUBMIT -------------------->>

        $("#form").submit(function (obj) {
            var isValid = true;
            $(".err").text("");
            if ($("#Name").val() == "") {
                $("#errName").text("Name field is required...!");
                isValid = false;
            }
            if ($("#Email").val() == "") {
                $("#errEmail").text("Email field is required...!");
                isValid = false;
            }
            if ($("#Password").val() == "") {
                $("#errPassword").text("Password field is required...!");
                isValid = false;
            }
            if ($("#Confirm_Password").val() == "") {
                $("#errConfirm_Password").text("Confirm_Password field is Required...!");
                isValid = false;
            }
            $("#Email").focus(function(){
                $("#errEmail").text("");
            });


            var name = $("#Name").val();
            var namePattern = /^[a-zA-Z ]{3,15}$/;
            if (namePattern.test(name)) {
                $("#errName").text("");
            }
            else {
                $("#errName").text("Name must contain alphabets only. Min = 3, Max = 15 Alphabets");
                isValid = false;
            }
            if ($("#Name").val() == "") {
                $("#errName").text("Name field is required...!");
                isValid = false;
            }


            var mail = $("#Email").val();
            var emailPattern = /^[a-zA-Z0-9.]+\@[a-zA-Z]+\.[a-zA-Z]{2,4}$/;
            var a = emailPattern.test(mail);
            if (a == true) {
                $("#errEmail").text("");
            }
            else {
                $("#errEmail").text("Enter A Valid Email...!");
                isValid = false;
            }
            if ($("#Email").val() == "") {
                $("#errEmail").text("Email field is required...!");
                isValid = false;
            }



            var pass = $("#Password").val();
            var pass2 = $("#Confirm_Password").val();
            var passPatern = /^[a-zA-Z0-9!@#$%^&*()_+-=]{8,15}$/;
            if (passPatern.test(pass)) {
                $("#errPassword").text("");
            }
            else {
                $("#errPassword").text("Password length must be between 8-15 characters");
                isValid = false;
            }
            if (passPatern.test(pass2)) {
                $("#errConfirm_Password").text("");
            }
            else {
                $("#errConfirm_Password").text("Password length must be between 8-15 characters");
                isValid = false;
            }
            if (pass != pass2) {
                $("#errConfirm_Password").text("Password Does Not Match...!");
                isValid = false;
            }
            if ($("#Password").val() == "") {
                $("#errConfirm_Password").text("Confirm_Password field is required");
                isValid = false;
            }



            var image = $("#Image").val();
            var imgPattern = /\.(jpg|JPG|jpeg|JPEG|png|PNG|gif|PNG)$/;

            if ($("#Image").val() == "") {
                $("#errImage").text("");

            }
            else if (!imgPattern.test(image)) {
                $("#errImage").text("Only JPG, JPEG, PNG and GIF images allowed");
                isValid = false;

            }
            else {
                $("#errImage").text("");
            }


            <?php
            if (!isset($_GET['id'])) {
                ?>
                var image = $("#Image").val();
                var imgPattern = /\.(jpg|JPG|jpeg|JPEG|png|PNG|gif|PNG)$/;

                if ($("#Image").val() == "") {
                    $("#errImage").text("Image field is required...!");
                    isValid = false;

                }
                else if (!imgPattern.test(image)) {
                    $("#errImage").text("Only JPG, JPEG, PNG and GIF images allowed");
                    isValid = false;

                }
                else {
                    $("#errImage").text("");
                }
                <?php
            }
            ?>
            if (!$("input[name='gender']:checked").val()) {
                $("#errGender").text("Gender field is required...!");
                isValid = false;
            }
            if (!$("input[name='language[]']:checked").val()) {
                $("#errLang").text("Language field is required...!");
                isValid = false;
            }
            if ($("#city").val() == "") {
                $("#errCity").text("City field is required...!");
                isValid = false;
            }
            if (!isValid) {
                obj.preventDefault();
            }
           
        });
    })
</script>

</html>