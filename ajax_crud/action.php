<?php
$conn = new mysqli("localhost", "root", "", "ajax_crud") or die("Connection Failed");
//----------------------->> Insert data------------------>>//

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "insert") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $language = $_POST['language'];
    $city = $_POST['city'];
    $language_str = implode(",", $language);

    $email_query = "SELECT * FROM employee WHERE email = '$email'";
    $email_run = $conn->query($email_query);
    if ($email_run->num_rows > 0) {
        echo "<p class='text-danger border border-danger p-2 rounded msg'>Email Already Exists...!</p>";
    } else {

        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $img_ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $img_name = pathinfo($image_name, PATHINFO_FILENAME);
        $final_image = $img_name . time() . "." . $img_ext;
        $path = "image/" . $final_image;

        if (move_uploaded_file($tmp_name, $path)) {
            $insert = "INSERT INTO employee (name, email, gender, language, city, image) VALUES ('$name','$email','$gender','$language_str','$city', '$final_image')";
            $result = $conn->query($insert);
            if ($result) {
                echo "<p class='text-success border border-success p-2 rounded msg'>Data Inserted Successfully...!</p>";
            } else {
                echo "<p class='text-danger border border-danger p-2 rounded msg'>Something Went Wrong...!</p>";
            }
        } else {
            echo "<p class='text-danger border border-danger p-2 rounded msg'>Image Upload Failed...!</p>";
        }
    }

}

//------------------------->> Delete Data----------------->>//

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];

    $limit = isset($_POST['limit']) ? $_POST['limit'] : 5;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;

    $query = "SELECT * FROM employee WHERE id = $id";
    $run = $conn->query($query);
    if ($run->num_rows > 0) {

        $data = [];
        while ($row = $run->fetch_object()) {
            $data = $row;
        }
    }
    $old_img = $data->image;
    $delete = "DELETE FROM employee WHERE id = $id";
    $res = $conn->query($delete);

    //----------Getting Total Page after Delete--------------//

    $res_page_query = "SELECT * FROM employee";
    $res_page_run = $conn->query($res_page_query);
    $res_page_row = $res_page_run->num_rows;
    $res_total_page = ceil($res_page_row / $limit);
    $new_page = $page > $res_total_page ? $res_total_page : $page;
    $new_page = $new_page < 1 ? 1 : $new_page;

    if ($res) {
        unlink("image/" . $old_img);
        echo json_encode([
            'success' => "<p class='text-danger border border-danger p-2 rounded msg'>Data Deleted Successfully...!</p>",
            'new_page' => $new_page
        ]);

    } else {
        echo json_encode([
            'success' => "<p class='text-danger border border-danger p-2 rounded msg'>Something Went Wrong...!</p>",
            'new_page' => $new_page
        ]);
    }
}

//----------->> Fetch Data For edit ------------->>//
if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'];
    $fetch = "SELECT * FROM employee WHERE id = $id";
    $res = $conn->query($fetch);
    if ($res->num_rows > 0) {

        $data = [];
        while ($row = $res->fetch_object()) {
            $data = $row;
        }
    }
    echo json_encode($data);
}

//-------------->>Update Data-------------->>

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $language = $_POST['language'];
    $city = $_POST['city'];
    $language_edit_str = implode(',', $language);

    $email_query = "SELECT * FROM employee WHERE email = '$email' AND id != $id";
    $email_run = $conn->query($email_query);
    if ($email_run->num_rows > 0) {
        echo "<p class='text-danger border border-danger p-2 rounded msg'>Email Already Exists...!</p>";
    } else {

        if ($_FILES['image']['name'] > 0) {
            $image_name = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];

            //Getting old image to delete
            $query = "SELECT * FROM employee WHERE id = $id";
            $run = $conn->query($query);
            if ($run->num_rows > 0) {

                $data = [];
                while ($row = $run->fetch_object()) {
                    $data = $row;
                }
            }
            $old_img = $data->image;
            unlink(filename: "image/" . $old_img);

            $img_ext = pathinfo($image_name, PATHINFO_EXTENSION); // Image Extension
            $img_name = pathinfo($image_name, PATHINFO_FILENAME); // image filename
            $final_image = $img_name . time() . "." . $img_ext;      //adding timestamp for uniqueness
            $path = "image/" . $final_image;

            if (move_uploaded_file($tmp_name, $path)) {
                $update = " UPDATE employee SET name = '$name', email = '$email', gender = '$gender', language = '$language_edit_str', city ='$city', image = '$final_image' WHERE id = $id";
                $result = $conn->query($update);
                if ($result) {
                    echo "<p class='text-success border border-success p-2 rounded msg'>Data Updated Successfully With Image...!</p>";
                } else {
                    echo "<p class='text-danger border border-danger p-2 rounded msg'>Something Went Wrong...!</p>";
                }
            }
        } else {
            $update = " UPDATE employee SET name = '$name', email = '$email', gender = '$gender', language = '$language_edit_str', city ='$city' WHERE id = $id";
            $res_upd = $conn->query($update);
            if ($res_upd) {
                echo "<p class='text-success border border-success p-2 rounded msg'>Data Updated Successfully...!</p>";
            } else {
                echo "<p class='text-danger border border-danger p-2 rounded msg'>Something Went Wrong...!</p>";
            }
        }
    }


}

//-------------------->> Show Data, Searching, Sorting, Filteration, Pagination <<---------------------//

if (isset($_POST['filter'])) {
    $value = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $language = isset($_POST['language']) ? trim($_POST['language']) : '';
    $city = isset($_POST['city']) ? trim($_POST['city']) : '';
    $limit = isset($_POST['limit']) ? (int) $_POST['limit'] : 5;
    $column = isset($_POST['column']) ? $_POST['column'] : 'id';
    $order = isset($_POST['order']) ? $_POST['order'] : 'asc';

    $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
    $offset = ($page - 1) * $limit;
    $search_condition = "(name LIKE '%$value%' OR email LIKE '%$value%' OR gender LIKE '$value' OR language LIKE '%$value%' OR city LIKE '%$value%')";
    $where = [];

    if (!empty($value))
        $where[] = $search_condition;
    if (!empty($city))
        $where[] = "city LIKE '%$city%'";
    if (!empty($gender))
        $where[] = "gender LIKE '$gender'";
    if (!empty($language))
        $where[] = "language LIKE '%$language%'";

    $where_sql = count($where) > 0 ? implode(" AND ", $where) : "1";

    $query = "SELECT * FROM employee WHERE $where_sql ORDER BY $column $order LIMIT $offset, $limit";
    $res = $conn->query($query);

    $count_query = "SELECT * FROM employee WHERE $where_sql";
    $total_res = $conn->query($count_query);
    $total_rows = $total_res->num_rows;
    $total_pages = ceil($total_rows / $limit);

    $page = $page > $total_pages ? $total_pages : $page;

    $next_order = $order === 'asc' ? 'desc' : 'asc';

    $output = "<table border='1' cellspacing='0' cellpadding='6' class='table table-responsive border border-dark'>";
    $output .= "<tr class='text-center'>
        <th style= 'border:1px solid;'>No.</th>
        <th  class='column' id='name' value='$page' data-order='$next_order'>Name</th>
        <th style= 'border:1px solid;' class='column' id='email' value='$page' data-order='$next_order'>Email</th>
        <th style= 'border:1px solid;' class='column' id='gender' value='$page' data-order='$next_order'>Gender</th>
        <th style= 'border:1px solid;' class='column' id='language' value='$page' data-order='$next_order'>Language</th>
        <th style= 'border:1px solid;' class='column' id='city' value='$page' data-order='$next_order'>City</th>
        <th style= 'border:1px solid;'>Image</th>
        <th style= 'border:1px solid;'>Action</th>
    </tr>";

    if ($res->num_rows > 0) {
        $i = $offset + 1;
        while ($data = $res->fetch_object()) {
            $output .= "<tr'>
                <td style= 'border:1px solid;'>$i</td>
                <td style= 'border:1px solid;'>$data->name</td>
                <td style= 'border:1px solid;'>$data->email</td>
                <td style= 'border:1px solid;'>$data->gender</td>
                <td style= 'border:1px solid;'>$data->language</td>
                <td style= 'border:1px solid;'>$data->city</td>
                <td style= 'border:1px solid;'><img src='image/$data->image'; height='40px' width='60px'></td>
                <td style= 'border:1px solid;'>
                    <a class='btn btn-success' onclick='editUser($data->id, $page, $limit)'>Edit</a>
                    <a class='btn btn-danger' onclick='deleteUser($data->id, $page, $limit)'>Delete</a>
                </td>
            </tr>";
            $i++;
        }
        $output .= "</table>";

        // PAGINATION SECTION
        $pagination = "<div class='pagination-wrapper' style='margin-top: 15px; text-align: center;'>";
        $pagination .= "<ul class='pagination' style='list-style: none; padding: 0; display: inline-flex;'>";

        $order = $next_order === 'asc' ? 'desc' : 'asc';

        if ($page >= 2) {
            $pagination .= "<li 
                class='page-btn' 
                style='margin: 0 5px; padding: 6px 12px; border: 1px solid black; border-radius: 5px; cursor: pointer; '
                onclick='searchFilter($page-1,$limit, `$column`, `$order`)'
            ><i class='fa-solid fa-backward'></i></li>";
        }
        for ($p = 1; $p <= $total_pages; $p++) {
            $activeStyle = ($p == $page) ? "background-color: deepskyblue; color: white;" : "background-color: white;";
            $pagination .= "<li 
                class='page-btn' 
                style='margin: 0 5px; padding: 6px 12px; border: 1px solid black; border-radius: 5px; cursor: pointer; $activeStyle'
                onclick='searchFilter($p, $limit, `$column`, `$order`)'
            >$p</li>";

        }

        if ($page < $total_pages) {

            $pagination .= "<li 
                class='page-btn' 
                style='margin: 0 5px; padding: 6px 12px; border: 1px solid black; border-radius: 5px; cursor: pointer; '
                onclick='searchFilter($page+1, $limit, `$column`, `$order`)'
            ><i class='fa-solid fa-forward'></i></li>";
        }


        $pagination .= "</ul>";
        $pagination .= "</div>";

        echo json_encode([
            'table' => $output,
            'pagination' => $pagination,
            'page' => $page
        ]);

    } else {
        $output .= "<tr><td colspan='7' class='text-center'>No Data Found</td></tr></table>";
        echo json_encode([
            'table' => $output,
            'pagination' => ""
        ]);
    }
}

?>