<?php
if (!isset($_SESSION['login_done'])) {
    $_SESSION['login_first'] = "Please Login First...!";
    header('Location: login');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<style>
    .pages {
        display: flex;
        margin-left: 550px;
    }

    .pages li {
        list-style: none;
        padding: 5px 10px;
        margin: 5px;
        border: 1px solid grey;
    }

    .pages li:hover {
        background-color: aqua;
    }

    .pages a {
        text-decoration: none;
    }

    #limit {
        margin-left: 785px;
        padding: 5px 10px;
    }

    #multi-search {
        margin-left: 400px;
    }

    #multi-search select {
        padding: 5px;
    }

    .inp-div {
        margin-left: 350px;
    }

    .inp-div a {
        text-decoration: none;
        background-color: orange;
        color: white;
        padding: 7px 10px;
        border-radius: 5px;
    }

    .active {
        background-color: aqua;
    }

    .session {
        margin-left: 900px;
        border: 1px solid green;
        width: fit-content;
        padding: 10px;
        border-radius: 5px;
        color: green;
    }

    .danger {
        margin-left: 900px;
        border: 1px solid red;
        width: fit-content;
        padding: 10px;
        border-radius: 5px;
        color: red;
    }

    .dangers {
        margin-left: 10px;
        width: fit-content;
        padding: 10px;
        border-radius: 5px;
        color: red;
    }

    #err_search {
        color: red;
    }
</style>

<body>
    <h1 class="heading">Dashboard</h1>

    <div class="btn">
        <a href="add_product?page=<?php if (isset($page))
            echo $page; ?>&limit=<?php if (isset($limit))
                  echo $limit; ?>&inp-search=<?php if (isset($value))
                        echo $value; ?><?php if (isset($gender))
                        echo '&genders=' . $gender; ?><?php if (isset($language))
                                echo '&languages=' . $language; ?><?php if (isset($city))
                                        echo '&cities=' . $city; ?>" class="add-product-btn">Add
            Product</a>
        <?php
        if (isset($_SESSION['login_done'])) {
            ?>
            <a href="logout" class="logout-btn">Logout</a>
            <?php

        } else {
            ?>
            <a href="login" class="logout-btn">Login</a>
            <?php
        }
        ?>
    </div>
    <?php
    if (isset($_SESSION['delete'])) {
        ?>
        <div class="session">
            <p><?php echo $_SESSION['delete']; ?></p>
        </div>
        <?php
        unset($_SESSION['delete']);
    } elseif (isset($_SESSION['email_copy'])) {
        ?>
        <div class="danger">
            <p><?php echo $_SESSION['email_copy']; ?></p>
        </div>
        <?php
        unset($_SESSION['email_copy']);
    } elseif (isset($_SESSION['upd_success'])) {
        ?>
        <div class="session">
            <p><?php echo $_SESSION['upd_success']; ?></p>
        </div>
        <?php
        unset($_SESSION['upd_success']);
    } elseif (isset($_SESSION['upd_failed'])) {
        ?>
        <div class="danger">
            <p><?php echo $_SESSION['upd_failed']; ?></p>
        </div>
        <?php
        unset($_SESSION['upd_failed']);
    } elseif (isset($_SESSION['login'])) {
        ?>
        <div class="session">
            <p><?php echo $_SESSION['login']; ?></p>
        </div>
        <?php
        unset($_SESSION['login']);
    }
    ?>
    <form action="" method="post" id="multi-search">
        <select name="gender" id="gender">
            <option value="">Select Gender</option>
            <option value="Male" <?php
            if (isset($_REQUEST['gender'])) {
                if ($_REQUEST['gender'] == 'Male') {
                    echo 'selected';
                }
            }
            elseif (isset($_REQUEST['genders'])) {
                if ($_REQUEST['genders'] == 'Male') {
                    echo 'selected';
                }
            }
            ?>>Male</option>
            <option value="Female" <?php
            if (isset($_REQUEST['gender'])) {
                if ($_REQUEST['gender'] == 'Female') {
                    echo 'selected';
                }
            }
            elseif (isset($_REQUEST['genders'])) {
                if ($_REQUEST['genders'] == 'Female') {
                    echo 'selected';
                }
            }
            ?>>Female</option>
            <option value="Other" <?php
            if (isset($_REQUEST['gender'])) {
                if ($_REQUEST['gender'] == 'Other') {
                    echo 'selected';
                }
            }
            ?>>Other</option>
        </select>
        <select name="language" id="language">
            <option value="">Select Language</option>
            <option value="Hindi" <?php
            if (isset($_REQUEST['language'])) {
                if ($_REQUEST['language'] == 'Hindi') {
                    echo 'selected';
                }
            }
            elseif (isset($_REQUEST['languages'])) {
                if ($_REQUEST['languages'] == 'Hindi') {
                    echo 'selected';
                }
            }
            ?>>Hindi</option>
            <option value="English" <?php
            if (isset($_REQUEST['language'])) {
                if ($_REQUEST['language'] == 'English') {
                    echo 'selected';
                }
            }
            elseif (isset($_REQUEST['languages'])) {
                if ($_REQUEST['languages'] == 'English') {
                    echo 'selected';
                }
            }
            ?>>English</option>
            <option value="Gujrati" <?php
            if (isset($_REQUEST['language'])) {
                if ($_REQUEST['language'] == 'Gujrati') {
                    echo 'selected';
                }
            }
            elseif (isset($_REQUEST['languages'])) {
                if ($_REQUEST['languages'] == 'Gujrati') {
                    echo 'selected';
                }
            }
            ?>>Gujrati</option>
        </select>
        <select name="city" id="city">
            <option value="">Select City</option>
            <option value="Ahmedabad" <?php
            if (isset($_REQUEST['city'])) {
                if ($_REQUEST['city'] == 'Ahmedabad') {
                    echo 'selected';
                }
            }
            elseif (isset($_REQUEST['cities'])) {
                if ($_REQUEST['cities'] == 'Ahmedabad') {
                    echo 'selected';
                }
            }
            ?>>Ahmedabad</option>
            <option value="Mandar" <?php
            if (isset($_REQUEST['city'])) {
                if ($_REQUEST['city'] == 'Mandar') {
                    echo 'selected';
                }
            }
            elseif (isset($_REQUEST['cities'])) {
                if ($_REQUEST['cities'] == 'Mandar') {
                    echo 'selected';
                }
            }
            ?>>Mandar</option>
            <option value="Mumbai" <?php
            if (isset($_REQUEST['city'])) {
                if ($_REQUEST['city'] == 'Mumbai') {
                    echo 'selected';
                }
            }
            elseif (isset($_REQUEST['cities'])) {
                if ($_REQUEST['cities'] == 'Mumbai') {
                    echo 'selected';
                }
            }
            ?>>Mumbai</option>
            <option value="Delhi" <?php
            if (isset($_REQUEST['city'])) {
                if ($_REQUEST['city'] == 'Delhi') {
                    echo 'selected';
                }
            }
            elseif (isset($_REQUEST['cities'])) {
                if ($_REQUEST['cities'] == 'Delhi') {
                    echo 'selected';
                }
            }
            ?>>Delhi</option>
            <option value="Malipura" <?php
            if (isset($_REQUEST['city'])) {
                if ($_REQUEST['city'] == 'Malipura') {
                    echo 'selected';
                }
            }
            elseif (isset($_REQUEST['cities'])) {
                if ($_REQUEST['cities'] == 'Malipura') {
                    echo 'selected';
                }
            }
            ?>>Malipura</option>
            <option value="Surat" <?php
            if (isset($_REQUEST['city'])) {
                if ($_REQUEST['city'] == 'Surat') {
                    echo 'selected';
                }
            }
            elseif (isset($_REQUEST['cities'])) {
                if ($_REQUEST['cities'] == 'Surat') {
                    echo 'selected';
                }
            }
            ?>>Surat</option>
        </select>
    </form>
    <form action="pagination?limit=<?php if (isset($limit))
        echo $limit ?><?php if (isset($value))
        echo '&inp-search=' . $value; ?>" method="post">
        <div class="search">
            <input type="text" id="inp-search" name="inp-search" placeholder="Search Values..." value="<?php if (isset($value))
                echo $value; ?>">
            <span>
                <button type="submit" name="search" id="search-btn">Search</button>
            </span>
            <p id="err_search"></p>
        </div>
    </form>

    <table border="1" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name <a href="sort-name-asc?inp-search=<?php if (isset($value))
                echo $value ?>&limit=<?php if (isset($limit))
                echo $limit ?><?php if (isset($gender))
                echo '&gender=' . $gender; ?><?php if (isset($language))
                        echo '&language=' . $language; ?><?php if (isset($city))
                                echo '&city=' . $city; ?><?php if (isset($page))
                                        echo '&page=' . $page; ?>"><i class="fa-solid fa-sort-up"></i></a>
                <a href="sort-name-desc?inp-search=<?php if (isset($value))
                    echo $value ?>&limit=<?php if (isset($limit))
                    echo $limit ?><?php if (isset($gender))
                    echo '&gender=' . $gender; ?><?php if (isset($language))
                            echo '&language=' . $language; ?><?php if (isset($city))
                                    echo '&city=' . $city; ?><?php if (isset($page))
                                            echo '&page=' . $page; ?>"><i class="fa-solid fa-sort-down"></i></a>
            </th>
            <th>Email <a href="sort-email-asc?inp-search=<?php if (isset($value))
                echo $value ?>&limit=<?php if (isset($limit))
                echo $limit ?><?php if (isset($gender))
                echo '&gender=' . $gender; ?><?php if (isset($language))
                        echo '&language=' . $language; ?><?php if (isset($city))
                                echo '&city=' . $city; ?><?php if (isset($page))
                                        echo '&page=' . $page; ?>"><i class="fa-solid fa-sort-up"></i></a><a href="sort-email-desc?inp-search=<?php if (isset($value))
                                                echo $value ?>&limit=<?php if (isset($limit))
                                                echo $limit ?><?php if (isset($gender))
                                                echo '&gender=' . $gender; ?><?php if (isset($language))
                                                        echo '&language=' . $language; ?><?php if (isset($city))
                                                                echo '&city=' . $city; ?><?php if (isset($page))
                                                                        echo '&page=' . $page; ?>"><i
                        class="fa-solid fa-sort-down"></i></a>
            </th>
            <th>Image </th>
            <th>Gender <a href="sort-gender-asc?inp-search=<?php if (isset($value))
                echo $value ?>&limit=<?php if (isset($limit))
                echo $limit ?><?php if (isset($gender))
                echo '&gender=' . $gender; ?><?php if (isset($language))
                        echo '&language=' . $language; ?><?php if (isset($city))
                                echo '&city=' . $city; ?><?php if (isset($page))
                                        echo '&page=' . $page; ?>"><i class="fa-solid fa-sort-up"></i></a><a href="sort-gender-desc?inp-search=<?php if (isset($value))
                                                echo $value ?>&limit=<?php if (isset($limit))
                                                echo $limit ?><?php if (isset($gender))
                                                echo '&gender=' . $gender; ?><?php if (isset($language))
                                                        echo '&language=' . $language; ?><?php if (isset($city))
                                                                echo '&city=' . $city; ?><?php if (isset($page))
                                                                        echo '&page=' . $page; ?>"><i
                        class="fa-solid fa-sort-down"></i></a>
            </th>
            <th>Language<a href="sort-lang-asc?inp-search=<?php if (isset($value))
                echo $value ?>&limit=<?php if (isset($limit))
                echo $limit ?><?php if (isset($gender))
                echo '&gender=' . $gender; ?><?php if (isset($language))
                        echo '&language=' . $language; ?><?php if (isset($city))
                                echo '&city=' . $city; ?><?php if (isset($page))
                                        echo '&page=' . $page; ?>"><i class="fa-solid fa-sort-up"></i></a><a href="sort-lang-desc?inp-search=<?php if (isset($value))
                                                echo $value ?>&limit=<?php if (isset($limit))
                                                echo $limit ?><?php if (isset($gender))
                                                echo '&gender=' . $gender; ?><?php if (isset($language))
                                                        echo '&language=' . $language; ?><?php if (isset($city))
                                                                echo '&city=' . $city; ?><?php if (isset($page))
                                                                        echo '&page=' . $page; ?>"><i
                        class="fa-solid fa-sort-down"></i></a>
            </th>
            <th>City <a href="sort-city-asc?inp-search=<?php if (isset($value))
                echo $value ?>&limit=<?php if (isset($limit))
                echo $limit ?><?php if (isset($gender))
                echo '&gender=' . $gender; ?><?php if (isset($language))
                        echo '&language=' . $language; ?><?php if (isset($city))
                                echo '&city=' . $city; ?><?php if (isset($page))
                                        echo '&page=' . $page; ?>"><i class="fa-solid fa-sort-up"></i></a><a href="sort-city-desc?inp-search=<?php if (isset($value))
                                                echo $value ?>&limit=<?php if (isset($limit))
                                                echo $limit ?><?php if (isset($gender))
                                                echo '&gender=' . $gender; ?><?php if (isset($language))
                                                        echo '&language=' . $language; ?><?php if (isset($city))
                                                                echo '&city=' . $city; ?><?php if (isset($page))
                                                                        echo '&page=' . $page; ?>"><i
                        class="fa-solid fa-sort-down"></i></a>
            </th>
            <th>Action</th>
        </tr>
        <?php
        if (!empty($product_arr)) {
            foreach ($product_arr as $products) {
                ?>
                <tr>
                    <td><?php echo $products->id; ?></td>
                    <td><?php echo $products->name; ?></td>
                    <td><?php echo $products->email; ?></td>
                    <td><img src="image/<?php echo $products->image; ?>" height="30px" width="40px" style="border-radius: 5px">
                    </td>
                    <td><?php echo $products->gender; ?></td>
                    <td><?php echo $products->language; ?></td>
                    <td><?php echo $products->city; ?></td>
                    <td>
                        <a href="add_product?id=<?php echo $products->id; ?><?php if (isset($page))
                               echo '&page=' . $page; ?><?php if (isset($limit))
                                       echo '&limit=' . $limit; ?><?php if (isset($value))
                                               echo '&inp-search=' . $value; ?><?php if (isset($gender))
                                                       echo '&genders=' . $gender; ?><?php if (isset($language))
                                                               echo '&languages=' . $language; ?><?php if (isset($city))
                                                                       echo '&cities=' . $city; ?>" class="edit-product">Edit</a>
                        <a href="delete_product?id=<?php echo $products->id; ?><?php if (isset($page))
                               echo '&page=' . $page; ?><?php if (isset($limit))
                                       echo '&limit=' . $limit; ?><?php if (isset($value))
                                               echo '&inp-search=' . $value; ?><?php if (isset($gender))
                                                       echo '&genders=' . $gender; ?><?php if (isset($language))
                                                               echo '&languages=' . $language; ?><?php if (isset($city))
                                                                       echo '&cities=' . $city; ?>"
                            onclick="return confirm('Do You Really Want To Delete?')" class="delete-product">Delete</a>
                    </td>
                </tr>
            <?php
            }
        } else {
            ?>
            <tr>
                <th id="no-data" colspan="8">No Data Found At This Moment..!</th>
            </tr>
            <?php
        }
        ?>
    </table>
    <ul class="pages">
        <?php
        if (isset($page)) {
            if ($page >= 2) {
                ?>
                <a href="pagination?page=<?php if (isset($page))
                    echo $page - 1; ?>&limit=<?php if (isset($limit))
                            echo $limit ?>&inp-search=<?php if (isset($value))
                            echo $value; ?><?php if (isset($genders))
                                  echo '&genders=' . $genders; ?><?php if (isset($languages))
                                          echo '&languages=' . $languages; ?><?php if (isset($cities))
                                                  echo '&cities=' . $cities; ?><?php if (isset($column))
                                                          echo '&column=' . $column; ?><?php if (isset($order))
                                                                  echo '&order=' . $order; ?>">
                    <li><i class="fa-solid fa-backward"></i></li>
                </a>

                <?php
            }
        }
        ?>
        <?php
        if (isset($totalPage)) {
            for ($i = 1; $i <= $totalPage; $i++) {
                ?>
                <a href="pagination?page=<?php echo $i; ?>&limit=<?php if (isset($limit))
                       echo $limit ?>&inp-search=<?php if (isset($value))
                       echo $value; ?><?php if (isset($gender))
                             echo '&gender=' . $gender; ?><?php if (isset($language))
                                     echo '&language=' . $language; ?><?php if (isset($city))
                                             echo '&city=' . $city; ?><?php if (isset($column))
                                                     echo '&column=' . $column; ?><?php if (isset($order))
                                                             echo '&order=' . $order; ?>">
                    <li <?php if (isset($page) && isset($i)) {
                        if ($page == $i) {
                            echo 'class=active';
                        }
                    }
                    ?>><?php echo $i; ?>
                    </li>
                </a>
                <?php
            }
        }
        if (isset($page) && isset($totalPage)) {
            if ($page < $totalPage) {
                ?>
                <a href="pagination?page=<?php echo $page + 1; ?>&limit=<?php if (isset($limit))
                         echo $limit ?>&inp-search=<?php if (isset($value))
                         echo $value; ?><?php if (isset($gender))
                               echo '&gender=' . $gender; ?><?php if (isset($language))
                                       echo '&language=' . $language; ?><?php if (isset($city))
                                               echo '&city=' . $city; ?><?php if (isset($column))
                                                       echo '&column=' . $column; ?><?php if (isset($order))
                                                               echo '&order=' . $order; ?>">
                    <li><i class="fa-solid fa-forward"></i></li>
                </a>

                <?php
            }
        }


        ?>
    </ul>
    <select name="limit" id="limit">
        <option value="5" <?php
        if (isset($limit)) {
            if ($limit == 5) {
                echo 'selected';
            }
        }
        ?>>5</option>
        <option value="10" <?php
        if (isset($limit)) {
            if ($limit == 10) {
                echo 'selected';
            }
        }
        ?>>10</option>
        <option value="15" <?php
        if (isset($limit)) {
            if ($limit == 15) {
                echo 'selected';
            }
        }
        ?>>15</option>
        <option value="20" <?php
        if (isset($limit)) {
            if ($limit == 20) {
                echo 'selected';
            }
        }
        ?>>20</option>
    </select>
    <div class="inp-div">
        <a href="pagination">Refresh Page</a>
    </div>
</body>
<script>
    $(document).ready(function () {
        $("#search-btn").click(function (e) {
            var valid = true;

            if ($("#inp-search").val() == "") {
                $("#err_search").text("This field can't be empty");
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            }
        });

        $("#inp-search").focus(function () {
            $("#err_search").text("");

        })
        $("#limit").change(function () {
            var limit = $(this).val();
            window.location.href = "pagination?limit=" + limit + "&inp-search=<?php if (isset($value))
                echo $value; ?><?php if (isset($gender))
                      echo '&gender=' . $gender; ?><?php if (isset($language))
                              echo '&language=' . $language; ?><?php if (isset($city))
                                      echo '&city=' . $city; ?><?php if (isset($column))
                                              echo '&column=' . $column; ?><?php if (isset($order))
                                                      echo '&order=' . $order; ?>";
        });
        $("#gender").change(function () {
            var gender = $(this).val();
            var language = $("#language").val();
            var city = $("#city").val();
            window.location.href = "multi-search?gender=" + gender + "&language=" + language + "&city=" + city + "&inp-search=<?php if (isset($value))
                echo $value; ?><?php if (isset($column))
                      echo '&column=' . $column; ?><?php if (isset($order))
                              echo '&order=' . $order; ?><?php if (isset($limit))
                                      echo '&limit=' . $limit; ?>";

        });
        $("#language").change(function () {
            var language = $(this).val();
            var gender = $("#gender").val();
            var city = $("#city").val();
            window.location.href = "multi-search?language=" + language + "&gender=" + gender + "&city=" + city + "&inp-search=<?php if (isset($value))
                echo $value; ?><?php if (isset($column))
                      echo '&column=' . $column; ?><?php if (isset($order))
                              echo '&order=' . $order; ?><?php if (isset($limit))
                                      echo '&limit=' . $limit; ?>";

        });
        $("#city").change(function () {
            var city = $(this).val();
            var gender = $("#gender").val();
            var language = $("#language").val();
            window.location.href = "multi-search?city=" + city + "&language=" + language + "&gender=" + gender + "&inp-search=<?php if (isset($value))
                echo $value; ?><?php if (isset($column))
                      echo '&column=' . $column; ?><?php if (isset($order))
                              echo '&order=' . $order; ?><?php if (isset($limit))
                                      echo '&limit=' . $limit; ?>";
        });
        setTimeout(function () {
            $('.session').fadeOut('slow');
        }, 2000);
        setTimeout(function () {
            $('.danger').fadeOut('slow');
        }, 2000);
    });
</script>

</html>