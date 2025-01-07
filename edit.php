<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Edit Student</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Name:</label>
                <input type="text" class="form-control" value="<?php echo isset($fetch->name) ? $fetch->name : ''; ?>" name="name" required>
            </div>
            <div class="mb-3 mt-3">
                <label>Email:</label>
                <input type="email" class="form-control" value="<?php echo isset($fetch->email) ? $fetch->email : ''; ?>" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update">Save</button>
        </form>
        <a href="index" class="btn btn-warning mt-3">Back</a>
    </div>

</body>

</html>