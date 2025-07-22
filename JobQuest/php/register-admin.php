<?php
include 'config.php';
$error = "";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $admin_code = $_POST['admin_code']; // Get the admin secret code

    // Define the correct admin secret code
    $correct_code = "code123";  

    
    if ($admin_code !== $correct_code) {
        die("Invalid Admin Code. You are not authorized to register as an admin.");
    }

    
    $check_query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        
        $error = "This email is already registered. Please use a different email.";
    } else {

    
    $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'admin')";
    mysqli_query($conn, $query);
    $user_id = mysqli_insert_id($conn);

    
    $query = "INSERT INTO admin (user_id, role) VALUES ('$user_id', 'superadmin')";
    mysqli_query($conn, $query);

    echo "Admin registered successfully!";
    header("Location: login.php");
    exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form id="adminForm" action="register-admin.php" method="post" class="form-container">
            <h2 class="text-center">Admin Registration</h2>

            <?php if (isset($error)): ?>
                <p class="error-message"><?= $error ?></p>
            <?php endif; ?>
            
            <div class="input-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" placeholder="Full Name" required>
                <small class="error-message"></small>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <small class="error-message"></small>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <small class="error-message"></small>
            </div>

            <div class="input-group">
                <label for="admin_code">Admin Secret Code</label>
                <input type="text" name="admin_code" id="admin_code" placeholder="Admin Secret Code" required>
                <small class="error-message"></small>
            </div>

            
            <button type="submit" name="submit" class="btn btn-primary w-100" style="background-color: #d15db4; border: #d15db4">Register</button><br>
            <div>
                <p>Already have an account</p><a href="login.php" style="color: #d15db4;">Login</a>
            </div>
            
            
        </form>
    </div>
</body>
</html>
