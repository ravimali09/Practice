<?php

include_once('model.php');

class Control extends Model
{
    function __construct()
    {
        session_start();
        parent::__construct();
        $path = $_SERVER['PATH_INFO'];
        switch ($path) {
            case '/':
                $student_arr = $this->select('students');
                include_once('index.php');
                break;

            case '/index':
                $student_arr = $this->select('students');
                include_once('index.php');
                break;

            case '/signup':
                if (isset($_REQUEST['signup'])) {
                    $name = $_REQUEST['name'];
                    $email = $_REQUEST['email'];
                    $password = md5($_REQUEST['password']);

                    $data = array("name" => $name, "email" => $email, "password" => $password);
                    $res = $this->insert('students', $data);
                    if ($res) {
                        echo "<script>
                        alert('Signup Success');
                        window.location='index';
                        </script>";
                    }
                }
                include_once('signup.php');
                break;
            case '/login':
                if (isset($_REQUEST['login'])) {
                    $email = $_REQUEST['email'];
                    $password = md5($_REQUEST['password']);

                    $data = array("email" => $email, "password" => $password);
                    $res = $this->select_where('students', $data);

                    $ans = $res->num_rows;
                    if ($ans == 1) {
                        $fetch = $res->fetch_object();

                        $_SESSION['student'] = $fetch->name;
                        echo "<script>
                        alert('Login Success');
                        window.location='index';
                        </script>";
                    } else {
                        echo "<script>
                        alert('Login Failed');
                        window.location='login';
                        </script>";
                    }
                }
                include_once('login.php');
                break;
            case '/logout':
                unset($_SESSION['student']);
                echo "<script>
                        alert('Logout Success');
                        window.location='login';
                        </script>";
                break;
                case '/edit':
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $where = array("id" => $id);
                        $res = $this->select_where('students', $where);
                        if ($res->num_rows > 0) {
                            $fetch = $res->fetch_object();
                        } else {
                            echo "<script>
                                alert('Record not found');
                                window.location='index';
                                </script>";
                            exit;
                        }
                
                        if (isset($_REQUEST['update'])) {
                            $name = $_REQUEST['name'];
                            $email = $_REQUEST['email'];
                
                            $data = array("name" => $name, "email" => $email);
                            $res = $this->update('students', $data, $where);
                            if ($res) {
                                echo "<script>
                                    alert('Data Update Success');
                                    window.location='index';
                                    </script>";
                            } else {
                                echo "<script>alert('Update Failed');</script>";
                            }
                        }
                    } else {
                        echo "<script>
                            alert('Invalid request');
                            window.location='index';
                            </script>";
                        exit;
                    }
                    include_once('edit.php');
                    break;

                case '/delete' :
                    if (isset($_REQUEST['id'])) {
                        $id = $_REQUEST['id'];
                        $where = array("id" => $id);
                        $res = $this->delete_where('students', $where);
                        if ($res) {
                            echo "<script>
                                    alert('Data Delete Success');
                                    window.location='index';
                                </script>";
                        }
                    }
                    break;

                
        }
    }
}
$obj = new Control;
