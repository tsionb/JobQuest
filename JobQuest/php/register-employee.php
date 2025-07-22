<?php
include 'config.php';
$error="";
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $skills = $_POST['skills'];
    $experience = $_POST['experience'];

     
     $check_query = "SELECT * FROM users WHERE email = ?";
     $stmt = mysqli_prepare($conn, $check_query);
     mysqli_stmt_bind_param($stmt, "s", $email);
     mysqli_stmt_execute($stmt);
     mysqli_stmt_store_result($stmt);
 
     if (mysqli_stmt_num_rows($stmt) > 0) {
         
         $error = "This email is already registered. Please use a different email.";
     } else {

    
    $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'employee')";
    mysqli_query($conn, $query);
    $user_id = mysqli_insert_id($conn);

    
    $query = "INSERT INTO employees (user_id, phone, location, skills, experience) 
              VALUES ('$user_id', '$phone', '$location', '$skills', '$experience')";
    mysqli_query($conn, $query);

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
    <title>Employee Registration</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container-lg" style="height: 100%">
        <form id="employeeForm" action="register-employee.php" method="post" class="form-container">
            <h2 class="text-center">Employee Registration</h2>

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
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" placeholder="Phone Number">
                <small class="error-message"></small>
            </div>

            <div class="input-group">
                <label for="location">Preferred Location</label>
                <input type="text" name="location" id="location" placeholder="Preferred Location">
                <small class="error-message"></small>
            </div>

            <div class="mb-3">
                <label for="skills" class="form-label" style="font-weight: bold">Skills</label>
                <textarea class="form-control" id="skills" name="skills" rows="3" placeholder="Skills (comma-separated)"></textarea>
                <small class="error-message"></small>
            </div>

            <div class="mb-3">
              <label for="experience" class="form-label" style="font-weight: bold">Experience</label>
              <textarea class="form-control" id="experience" name="experience" rows="3" placeholder="Describe your experience"></textarea>
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
