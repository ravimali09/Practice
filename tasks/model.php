<?php
class Model
{
    public $conn;
    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'php_crud');
    }
    public function insert($table, $arr)
    {
        $column_arr = array_keys($arr);
        $column = implode(",", $column_arr);

        $value_arr = array_values($arr);
        $values = implode("','", $value_arr);

        $ins = "INSERT INTO $table ($column) VALUES ('$values')";
        $run = $this->conn->query($ins);
        return $run;
    }
    public function delete_product($table, $arr)
    {
        $column_arr = array_keys($arr);
        $column = implode(",", $column_arr);

        $value_arr = array_values($arr);
        $value = implode("','", $value_arr);

        $del = "DELETE FROM $table WHERE $column = $value";
        $run = $this->conn->query($del);
        return $run;
    }
    public function select_where($table, $arr)
    {
        $column_arr = array_keys($arr);
        $column = implode(",", $column_arr);

        $value_arr = array_values($arr);
        $value = implode("','", $value_arr);

        $sel = "SELECT * FROM $table WHERE $column = '$value'";
        $run = $this->conn->query($sel);
        return $run;
    }
    public function select_where_id($table, $arr, $id)
    {
        $column_arr = array_keys($arr);
        $column = implode(",", $column_arr);

        $value_arr = array_values($arr);
        $value = implode("','", $value_arr);

        $sel = "SELECT * FROM $table WHERE $column = '$value' AND id != $id";
        $run = $this->conn->query($sel);
        return $run;
    }
    public function update_product($table, $arr, $id)
    {
        $column_arr = array_keys($arr);
        $value_arr = array_values($arr);

        $update_arr = [];
        for ($i = 0; $i < count($column_arr); $i++) {
            $update_arr[] = "$column_arr[$i] = '$value_arr[$i]'";
        }
        $update_str = implode(",", $update_arr);
        $upd = "UPDATE $table SET $update_str WHERE id = $id";
        $run = $this->conn->query($upd);
        return $run;
    }
    public function sort($table, $column, $order, $value = null, $limit, $page)
    {
        $offset = ($page - 1) * $limit;
        $search = "SELECT * FROM $table  WHERE name LIKE '%$value%' OR email LIKE '%$value%' OR gender LIKE '$value' OR language LIKE '%$value%' OR city LIKE '%$value%' ORDER BY $column $order LIMIT $offset, $limit";
        $run = $this->conn->query($search);
        $arr = [];
        while ($fetch = $run->fetch_object()) {
            $arr[] = $fetch;
        }
        return $arr;
    }
    public function pagination($table, $page, $limit, $value)
    {
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM $table WHERE name LIKE '%$value%' OR email LIKE '%$value%' OR gender LIKE '$value' OR language LIKE '%$value%' OR city LIKE '%$value%'  LIMIT $offset, $limit";
        $q_run = $this->conn->query($query);

        $arr = [];
        while ($fetch = $q_run->fetch_object()) {
            $arr[] = $fetch;
        }
        return $arr;
    }
    public function pagination_where($table, $page, $limit, $column, $order, $value)
    {
        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM $table  WHERE name LIKE '%$value%' OR email LIKE '%$value%' OR gender LIKE '$value' OR language LIKE '%$value%' OR city LIKE '%$value%' ORDER BY $column $order LIMIT $offset, $limit";
        $q_run = $this->conn->query($query);

        $arr = [];
        while ($fetch = $q_run->fetch_object()) {
            $arr[] = $fetch;
        }
        return $arr;
    }

    public function multi_search($table, $gender = null, $language = null, $city = null, $page, $limit, $value, $column, $order)
    {
        $search_conditon =
            "(name LIKE '%$value%' OR 
            email LIKE '%$value%' OR 
            gender LIKE '$value' OR 
            language LIKE '%$value%' OR 
            city LIKE '%$value%')";
        $where = [];
        if (!empty($value)) {
            $where[] = $search_conditon;
        }
        if ($city) { 
            $where[] = "city LIKE '%$city%'";
        }
        if ($gender) {
            $where[] = "gender LIKE '$gender'";
        }
        if ($language) {
            $where[] = "language LIKE '%$language%'";
        }
        $where = implode(" AND ", $where);
        $offset = ($page - 1) * $limit;
        $sel = "SELECT * FROM $table WHERE  $where ORDER BY $column $order LIMIT $offset, $limit";
        $run = $this->conn->query($sel);
        $arr = [];
        while ($fetch = $run->fetch_object()) {
            $arr[] = $fetch;
        }
        return $arr;
    } 
    public function sort_where($table, $column, $order, $limit, $gender = null, $language = null, $city = null, $page, $value)
    {
        $search_conditon =
            "(name LIKE '%$value%' OR 
            email LIKE '%$value%' OR 
            gender LIKE '$value' OR 
            language LIKE '%$value%' OR 
            city LIKE '%$value%')";
        $where = [];
        if (!empty($value)) {
            $where[] = $search_conditon;
        }
        if ($city) {
            $where[] = "city LIKE '%$city%'";
        }
        if ($gender) {
            $where[] = "gender LIKE '$gender'"; 
        }
        if ($language) {
            $where[] = "language LIKE '%$language%'";
        }
        $where = implode(" AND ", $where);
        $offset = ($page - 1) * $limit;
        $search = "SELECT * FROM $table  WHERE $where ORDER BY $column $order LIMIT $offset, $limit";
        $run = $this->conn->query($search);
        $arr = [];
        while ($fetch = $run->fetch_object()) {
            $arr[] = $fetch;
        }
        return $arr;
    }
    public function totalpage($table, $limit, $value)
    {
        $sel = "SELECT * FROM $table WHERE name LIKE '%$value%' OR email LIKE '%$value%' OR gender LIKE '$value' OR language LIKE '%$value%' OR city LIKE '%$value%'";
        $run = $this->conn->query($sel);
        $rows = $run->num_rows;
        $totalPage = ceil($rows / $limit);
        return $totalPage;
    }
    public function totalpage_where($table, $limit, $gender, $language, $city, $value)
    {
        $search_conditon =
            "(name LIKE '%$value%' OR 
            email LIKE '%$value%' OR 
            gender LIKE '$value' OR 
            language LIKE '%$value%' OR 
            city LIKE '%$value%')";
        $where = [];
        if (!empty($value)) {
            $where[] = $search_conditon;
        }
        if ($city) {
            $where[] = "city LIKE '%$city%'";
        }
        if ($gender) {
            $where[] = "gender LIKE '$gender'";
        }
        if ($language) {
            $where[] = "language LIKE '%$language%'";
        }
        $where = implode(" AND ", $where);
        $sel = "SELECT * FROM $table WHERE $where";
        $run = $this->conn->query($sel);
        $rows = $run->num_rows;
        $totalPage = ceil($rows / $limit);
        return $totalPage;
    }
    public function login_check($table, $email, $password)
    {
        $sel = "SELECT * FROM $table WHERE email = '$email' AND password = '$password'";
        $run = $this->conn->query($sel);
        $email_check = '';
        $password_check = '';
        $res = '';
        while ($fetch = $run->fetch_object()) {
            $email_check = $fetch->email;
            $password_check = $fetch->password;
        }
        if ($email == $email_check && $password == $password_check) {
            $res = 'Success';
        } else {
            $res = 'Failed';
        }
        return $res;
    }
    public function select_id($table, $id)
    {
        $sel = "SELECT * FROM $table WHERE id = $id";
        $run = $this->conn->query($sel);
        $arr = [];
        while ($fetch = $run->fetch_object()) {
            $arr[] = $fetch;
        }
        return $arr;
    }
}
$obj = new Model();
?>