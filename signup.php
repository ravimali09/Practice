<!DOCTYPE html>
<html lang="en">

<head>
    <title>Signup</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Signup Form</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Name:</label>
                <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
            </div>
            <div class="mb-3 mt-3">
                <label>Email:</label>
                <input type="email" class="form-control" placeholder="Enter email" name="email" required>
            </div>
            <div class="mb-3">
                <label>Password:</label>
                <input type="password" class="form-control" placeholder="Enter password" name="password" required>
            </div>
            <div>
                <p>Already have an account? <a href="login" class="text-info" style="text-decoration: none;">Login</a></p>
            </div>
            <button type="submit" class="btn btn-primary" name="signup">Signup</button>
        </form>
    </div>

</body>

</html>