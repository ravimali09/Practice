<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
</body>

</html>
<?php
include_once 'model.php';
class Control extends Model
{
    public function __construct()
    {
        session_start();
        Model::__construct();
        $path = $_SERVER['PATH_INFO'];

        switch ($path) {
            case '/pagination':
                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                } else {
                    $value = '';
                }
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else {
                    $limit = 5;
                }
                $column = isset($_REQUEST['column']) ? $_REQUEST['column'] : 'id';
                $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : 'asc';

                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';

                $genders = isset($_REQUEST['genders']) ? $_REQUEST['genders'] : '';
                $languages = isset($_REQUEST['languages']) ? $_REQUEST['languages'] : '';
                $cities = isset($_REQUEST['cities']) ? $_REQUEST['cities'] : '';

                if ($city || $gender || $language) {
                    $product_arr = $this->multi_search('product', $gender, $language, $city, $page, $limit, $value, $column, $order);
                    $totalPage = $this->totalpage_where('product', $limit, $gender, $language, $city, $value);
                } elseif ($column && $order) {
                    $product_arr = $this->pagination_where('product', $page, $limit, $column, $order, $value);
                    $totalPage = $this->totalpage('product', $limit, $value);

                } else {
                    $product_arr = $this->pagination('product', $page, $limit, $value);
                    $totalPage = $this->totalpage('product', $limit, $value);
                }
                include_once 'dashboard.php';
                break;

            case '/multi-search':
                $column = isset($_REQUEST['column']) ? $_REQUEST['column'] : 'id';
                $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : 'asc';
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else {
                    $limit = 5;
                }
                $value = isset($_REQUEST['inp-search']) ? trim($_REQUEST['inp-search']) : '';
                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';

                if ($city || $gender || $language) {
                    $product_arr = $this->multi_search('product', $gender, $language, $city, $page, $limit, $value, $column, $order);
                    $totalPage = $this->totalpage_where('product', $limit, $gender, $language, $city, $value);
                } else {
                    $product_arr = $this->pagination('product', $page, $limit, $value);
                    $totalPage = $this->totalpage('product', $limit, $value);
                }
                include_once 'dashboard.php';
                break;
            case '/add_product':

                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                } else {
                    $value = '';
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else {
                    $limit = 5;
                }
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                $genders = isset($_REQUEST['genders']) ? $_REQUEST['genders'] : '';
                $languages = isset($_REQUEST['languages']) ? $_REQUEST['languages'] : '';
                $cities = isset($_REQUEST['cities']) ? $_REQUEST['cities'] : '';

                if (isset($_REQUEST['submit'])) {
                    $name = trim($_REQUEST['name']);
                    $email = trim($_REQUEST['email']);
                    $password = md5(trim($_REQUEST['password']));
                    $norm_pass = trim($_REQUEST['password']);
                    $image = trim($_FILES['image']['name']);
                    $img_ext = pathinfo($image, PATHINFO_EXTENSION);
                    $img_name = pathinfo($image, PATHINFO_FILENAME);
                    $final_image = $img_name . time() . "." . $img_ext;
                    $gender = $_REQUEST['gender'];
                    $language = $_REQUEST['language'];
                    $city = $_REQUEST['city'];
                    $language_str = implode(",", $language);
                    $email_check = array("email" => $email);
                    $email_res = $this->select_where('product', $email_check);

                    if ($email_res->num_rows > 0) {
                        $_SESSION['email'] = 'Email Already Exists...!';

                    } else {
                        $data = array("name" => $name, "email" => $email, "password" => $password, "image" => $final_image, "gender" => $gender, "language" => $language_str, "city" => $city, "norm_pass" => $norm_pass);
                        $res = $this->insert('product', $data);
                        if ($res) {
                            $path = "image/" . $final_image;
                            $tmp = $_FILES['image']['tmp_name'];
                            move_uploaded_file($tmp, $path);

                            $_SESSION['insert'] = 'Product Inserted Successfully...!';
                            header('Location: add_product?page=' . $page . '&inp-search=' . $value . '&limit=' . $limit.'&genders='.$genders.'&languages='.$languages.'&cities='.$cities);
                            exit;
                        }
                    }
                }
                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $data = array("id" => $id);
                    $resdata = $this->select_where('product', $data);
                    $fetch = $resdata->fetch_object();
                    $language = explode(",", $fetch->language);
                    $product_arr = $this->select_id('product', $id);
                }

                include_once 'add_product.php';
                break;

            case '/delete_product':
                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                } else {
                    $value = '';
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else {
                    $limit = 5;
                }
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';

                $genders = isset($_REQUEST['genders']) ? $_REQUEST['genders'] : '';
                $languages = isset($_REQUEST['languages']) ? $_REQUEST['languages'] : '';
                $cities = isset($_REQUEST['cities']) ? $_REQUEST['cities'] : '';

                if (isset($_REQUEST['id'])) {
                    $id = $_REQUEST['id'];
                    $data = array("id" => $id);
                    $resdata = $this->select_where('product', $data);
                    $fetch = $resdata->fetch_object();
                    $img = $fetch->image;
                    $res = $this->delete_product('product', $data);

                    if ($res) {
                        unlink("image/" . $img);
                        $_SESSION['delete'] = 'Product Deleted Successfully...!';
                        $totalPage = $this->totalpage('product', $limit, $value);
                        header('Location: pagination?page=' . $totalPage . '&limit=' . $limit . '&inp-search=' . $value.'&genders='.$genders.'&languages='.$languages.'&cities='.$cities);
                        exit;
                    }
                }
                break;
            case '/update_product':
                if (isset($_REQUEST['inp-search'])) {
                    $value = $_REQUEST['inp-search'];
                } else {
                    $value = '';
                }
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else {
                    $limit = 5;
                }
                $genders = isset($_REQUEST['genders']) ? $_REQUEST['genders'] : '';
                $languages = isset($_REQUEST['languages']) ? $_REQUEST['languages'] : '';
                $cities = isset($_REQUEST['cities']) ? $_REQUEST['cities'] : '';

                if (isset($_REQUEST['submit'])) {
                    $id = trim($_REQUEST['id']);
                    $data = array("id" => $id);
                    $name = trim($_REQUEST['name']);
                    $email = trim($_REQUEST['email']);
                    $password = md5(trim($_REQUEST['password']));
                    $norm_pass = trim($_REQUEST['password']);
                    $gender = $_REQUEST['gender'];
                    $language = $_REQUEST['language'];
                    $city = $_REQUEST['city'];
                    $language_str = implode(",", $language);

                    $email_check = array("email" => $email);
                    $email_res = $this->select_where_id('product', $email_check, $id);

                    if ($email_res->num_rows > 0) {
                        $_SESSION['email'] = 'Email Already Exists...!';
                    } else {
                        if ($_FILES['image']['name'] > 0) {
                            $image = $_FILES['image']['name'];
                            $resdata = $this->select_where('product', $data);
                            $fetch = $resdata->fetch_object();
                            $old_img = $fetch->image;
                            $img_ext = pathinfo($image, PATHINFO_EXTENSION);
                            $img_name = pathinfo($image, PATHINFO_FILENAME);
                            $final_image = $img_name . time() . "." . $img_ext;
                            $data_arr = array("name" => $name, "email" => $email, "password" => $password, "image" => $final_image, "gender" => $gender, "language" => $language_str, "city" => $city, "norm_pass" => $norm_pass);
                            $res = $this->update_product('product', $data_arr, $id);
                            if ($res) {
                                $path = "image/" . $final_image;
                                $tmp = $_FILES['image']['tmp_name'];
                                move_uploaded_file($tmp, $path);
                                unlink("image/" . $old_img);
                                $_SESSION['upd_success'] = 'Product Updated Successfully...!';
                                header('Location: pagination?page=' . $page . '&limit=' . $limit . '&inp-search=' . $value.'&genders='.$genders.'&languages='.$languages.'&cities='.$cities);
                                exit;
                            } else {
                                $_SESSION['upd_failed'] = 'Product Updatation Failed...!';
                                header(header: 'Location: pagination?page=' . $page . '&limit=' . $limit . '&inp-search=' . $value);
                                exit;
                            }
                        } else {
                            $data_arr = array("name" => $name, "email" => $email, "password" => $password, "gender" => $gender, "language" => $language_str, "city" => $city);
                            $res = $this->update_product('product', $data_arr, $id);

                            if ($res) {
                                $_SESSION['upd_success'] = 'Product Updated Successfully...!';
                                header('Location: pagination?page=' . $page . '&limit=' . $limit . '&inp-search=' . $value.'&genders='.$genders.'&languages='.$languages.'&cities='.$cities);
                                exit;
                            } else {
                                $_SESSION['upd_failed'] = 'Product Updatation Failed...!';
                                header('Location: pagination?page=' . $page . '&limit=' . $limit . '&inp-search=' . $value);
                                exit;
                            }
                        }
                    }
                }
                $product_arr = $this->select_id('product', $id);

                include_once 'add_product.php';
                break;
            case '/login':
                $email = isset($_REQUEST['email']) ? trim($_REQUEST['email']) : '';
                $norm_password = isset($_REQUEST['password']) ? trim($_REQUEST['password']) : '';
                if (isset($_REQUEST['login'])) {
                    $email = trim($_REQUEST['email']);
                    $password = md5(trim($_REQUEST['password']));
                    $norm_password = $x_REQUEST['password'];
                    $data = array("email" => $email, "password" => $password);
                    $res = $this->login_check('product', $email, $password);
                    if ($res == 'Failed') {
                        $_SESSION['login'] = 'Login Success...!';
                        $_SESSION['login_done'] = 'Login Success...!';
                        header('Location: pagination');
                        exit;
                    } else {
                        $_SESSION['login_failed'] = ' Login Failed Due To Wrong Credentials...!';
                        header('Location: login?email=' . $email . '&password=' . $norm_password);
                        exit;
                    }
                }
                session_destroy();
                include_once 'login.php';
                break;


            case '/logout':
                unset($_SESSION['login_done']);
                $_SESSION['logout'] = 'Logout Success...!';
                header('Location: login');
                exit;

            case '/sort-name-asc':
                $column = 'name';
                $order = 'asc';
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else
                    $limit = 5;
                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';


                if ($city || $gender || $language) {
                    $product_arr = $this->sort_where('product', $column, $order, $limit, $gender, $language, $city, $page, $value);
                    $totalPage = $this->totalpage_where('product', $limit, $gender, $language, $city, $value);
                } else {
                    $product_arr = $this->sort('product', $column, $order, $value, $limit, $page);
                    $totalPage = $this->totalpage('product', $limit, $value);
                }
                include_once 'dashboard.php';
                break;
            case '/sort-name-desc':
                $column = 'name';
                $order = 'desc';

                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else
                    $limit = 5;
                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';


                if ($city || $gender || $language) {
                    $product_arr = $this->sort_where('product', $column, $order, $limit, $gender, $language, $city, $page, $value);
                    $totalPage = $this->totalpage_where('product', $limit, $gender, $language, $city, $value);
                } else {
                    $product_arr = $this->sort('product', $column, $order, $value, $limit, $page);
                    $totalPage = $this->totalpage('product', $limit, $value);
                }
                include_once 'dashboard.php';
                break;
            case '/sort-email-asc':
                $column = 'email';
                $order = 'asc';
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else
                    $limit = 5;
                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';


                if ($city || $gender || $language) {
                    $product_arr = $this->sort_where('product', $column, $order, $limit, $gender, $language, $city, $page, $value);
                    $totalPage = $this->totalpage_where('product', $limit, $gender, $language, $city, $value);
                } else {
                    $product_arr = $this->sort('product', $column, $order, $value, $limit, $page);
                    $totalPage = $this->totalpage('product', $limit, $value);
                }
                include_once 'dashboard.php';
                break;
            case '/sort-email-desc':
                $column = 'email';
                $order = 'desc';
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else
                    $limit = 5;
                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';


                if ($city || $gender || $language) {
                    $product_arr = $this->sort_where('product', $column, $order, $limit, $gender, $language, $city, $page, $value);
                    $totalPage = $this->totalpage_where('product', $limit, $gender, $language, $city, $value);
                } else {
                    $product_arr = $this->sort('product', $column, $order, $value, $limit, $page);
                    $totalPage = $this->totalpage('product', $limit, $value);
                }
                include_once 'dashboard.php';
                break;
            case '/sort-gender-asc':
                $column = 'gender';
                $order = 'asc';
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else
                    $limit = 5;
                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';


                if ($city || $gender || $language) {
                    $product_arr = $this->sort_where('product', $column, $order, $limit, $gender, $language, $city, $page, $value);
                    $totalPage = $this->totalpage_where('product', $limit, $gender, $language, $city, $value);
                } else {
                    $product_arr = $this->sort('product', $column, $order, $value, $limit, $page);
                    $totalPage = $this->totalpage('product', $limit, $value);
                }
                include_once 'dashboard.php';
                break;
            case '/sort-gender-desc':
                $column = 'gender';
                $order = 'desc';
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else
                    $limit = 5;
                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';


                if ($city || $gender || $language) {
                    $product_arr = $this->sort_where('product', $column, $order, $limit, $gender, $language, $city, $page, $value);
                    $totalPage = $this->totalpage_where('product', $limit, $gender, $language, $city, $value);
                } else {
                    $product_arr = $this->sort('product', $column, $order, $value, $limit, $page);
                    $totalPage = $this->totalpage('product', $limit, $value);
                }
                include_once 'dashboard.php';
                break;
            case '/sort-lang-asc':
                $column = 'language';
                $order = 'asc';
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else
                    $limit = 5;
                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';


                if ($city || $gender || $language) {
                    $product_arr = $this->sort_where('product', $column, $order, $limit, $gender, $language, $city, $page, $value);
                    $totalPage = $this->totalpage_where('product', $limit, $gender, $language, $city, $value);
                } else {
                    $product_arr = $this->sort('product', $column, $order, $value, $limit, $page);
                    $totalPage = $this->totalpage('product', $limit, $value);
                }
                include_once 'dashboard.php';
                break;
            case '/sort-lang-desc':
                $column = 'language';
                $order = 'desc';
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else
                    $limit = 5;
                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';


                if ($city || $gender || $language) {
                    $product_arr = $this->sort_where('product', $column, $order, $limit, $gender, $language, $city, $page, $value);
                    $totalPage = $this->totalpage_where('product', $limit, $gender, $language, $city, $value);
                } else {
                    $product_arr = $this->sort('product', $column, $order, $value, $limit, $page);
                    $totalPage = $this->totalpage('product', $limit, $value);
                }
                include_once 'dashboard.php';
                break;
            case '/sort-city-asc':
                $column = 'city';
                $order = 'asc';
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else
                    $limit = 5;
                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';


                if ($city || $gender || $language) {
                    $product_arr = $this->sort_where('product', $column, $order, $limit, $gender, $language, $city, $page, $value);
                    $totalPage = $this->totalpage_where('product', $limit, $gender, $language, $city, $value);
                } else {
                    $product_arr = $this->sort('product', $column, $order, $value, $limit, $page);
                    $totalPage = $this->totalpage('product', $limit, $value);
                }
                include_once 'dashboard.php';
                break;
            case '/sort-city-desc':
                $column = 'city';
                $order = 'desc';
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                } else {
                    $page = 1;
                }
                if (isset($_REQUEST['inp-search'])) {
                    $value = trim($_REQUEST['inp-search']);
                }
                if (isset($_REQUEST['limit'])) {
                    $limit = $_REQUEST['limit'];
                } else
                    $limit = 5;
                $gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
                $language = isset($_REQUEST['language']) ? $_REQUEST['language'] : '';
                $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';


                if ($city || $gender || $language) {
                    $product_arr = $this->sort_where('product', $column, $order, $limit, $gender, $language, $city, $page, $value);
                    $totalPage = $this->totalpage_where('product', $limit, $gender, $language, $city, $value);
                } else {
                    $product_arr = $this->sort('product', $column, $order, $value, $limit, $page);
                    $totalPage = $this->totalpage('product', $limit, $value);
                }
                include_once 'dashboard.php';
                break;
        }
    }
}
$obj = new Control();
?>