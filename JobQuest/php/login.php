<?php
session_start();
include 'config.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database for the user
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];

        
        if ($user['role'] == 'admin') {
            header("Location: manage-activities.php");
        } elseif ($user['role'] == 'employer') {
            header("Location: manage-jobs.php");
        } elseif ($user['role'] == 'employee') {
            header("Location: search-jobs.php");
        }
        exit();
    } else {
        $login_error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form id="loginForm" action="login.php" method="post" class="form-container">
            <h2 class="text-center">Login</h2>

            <?php if (isset($login_error)): ?>
                <p class="error-message"><?= $login_error ?></p>
            <?php endif; ?>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
                <small class="error-message"></small>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                <small class="error-message"></small>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100"
            style="background: #b62e94; border: #d15db4">Login</button>
        </form>
    </div>
</body>
</html>
