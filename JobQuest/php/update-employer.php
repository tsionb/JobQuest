<?php
session_start();
include 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    die("Access Denied! Only employers can update their profile.");
}


$query = "SELECT employers.employer_id, users.name, employers.company_name, employers.location, employers.industry
          FROM employers 
          JOIN users ON employers.user_id = users.user_id
          WHERE users.user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$employer = mysqli_fetch_assoc($result);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $company_name = $_POST['company_name'];
    $location = $_POST['location'];
    $industry = $_POST['industry'];

    
    $query = "UPDATE users SET name = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $name, $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);

    
    $query = "UPDATE employers SET company_name = ?, location = ?, industry = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $company_name, $location, $industry, $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);

    echo "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>update profile</title>
    
    <link rel="stylesheet" href="style-employee1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="script.js"></script>

</head>
<body>
 <div>
 <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <label class="logo">JobQuest</label>
        <ul>
        <li><a class="active" href="post-job.php">Post Job</a></li>
            <li><a href="manage-jobs.php">Manage Jobs</a></li>
            <li><a href="update-employer.php">Update Profile</a></li>
            <li><a href="review-applications.php">Review Applications</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Update Employer Profile</h2>
        <form action="update-employer-profile.php" method="post" style="margin: 10px;">
          <div class="mb-3">
            <label for="name">Full Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($employer['name']) ?>" required>
            </div>
            <div class="mb-3">
            <label for="name">Company Name</label>
            <input type="text" name="company_name" value="<?= htmlspecialchars($employer['company_name']) ?>" required>
            </div>
            <div class="mb-3">
            <label for="name">Location</label>
            <input type="text" name="location" value="<?= htmlspecialchars($employer['location']) ?>" required>
            </div>
            <div class="mb-3">
            <label for="name">Industry</label>
            <input type="text" name="industry" value="<?= htmlspecialchars($employer['industry']) ?>" required><br>
            </div>
            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
