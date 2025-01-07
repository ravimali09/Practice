<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Login Form</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label>Email:</label>
                <input type="email" class="form-control" placeholder="Enter email" name="email" required>
            </div>
            <div class="mb-3">
                <label>Password:</label>
                <input type="password" class="form-control" placeholder="Enter password" name="password" required>
            </div>
            <div>
                <p>Don't have an account? <a href="signup" class="text-info" style="text-decoration: none;">Signup</a></p>
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
        </form>
    </div>

</body>

</html>