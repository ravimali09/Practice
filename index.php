<!DOCTYPE html>
<html lang="en">

<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

  <?php
  if (isset($_SESSION['student'])) {
  ?>
    <h3 class="text-center bg-info p-2">Welcome <?php echo $_SESSION['student']; ?></h3>
  <?php
  } else {
    echo "<script>
      alert('Please Login First');
      window.location='login';
      </script>";
  }
  ?>
  <div class="container mt-3">
    <?php
    if (isset($_SESSION['student'])) {
    ?>
      <a href="logout" class="btn btn-danger my-3" style="margin-left: 900px;">Logout</a>
    <?php
    } else {
    ?>
      <a href="login" class="btn btn-warning my-3">Login</a>
    <?php
    }
    ?>
    <h2>Student's Data</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (!empty($student_arr)) {
          foreach ($student_arr as $students) {
        ?>
            <tr>
              <td><?php echo $students->name;?></td>
              <td><?php echo $students->email;?></td>
              <td><?php echo $students->password;?></td>
              <td>
                <a href="edit?id=<?php echo $students->id;?>" class="btn btn-success">Edit</a>
                <a href="delete?id=<?php echo $students->id;?>" class="btn btn-danger">Delete</a>
              </td>
            </tr>
        <?php
          }
        }
        ?>
      </tbody>
    </table>
  </div>

</body>

</html>