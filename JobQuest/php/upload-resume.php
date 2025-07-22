<?php
session_start();
include 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    die("Access Denied! Only employees can upload resumes.");
}

// Get employee_id
$query = "SELECT employee_id FROM employees WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $employee_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$message = ""; 


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["resume"])) {
    $upload_dir = "uploads/";
    $file_name = basename($_FILES["resume"]["name"]);
    $file_tmp = $_FILES["resume"]["tmp_name"];
    $file_size = $_FILES["resume"]["size"];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $max_size = 2 * 1024 * 1024; // 2MB

    
    $new_file_name = "resume_" . $employee_id . "_" . time() . "." . $file_ext;
    $upload_path = $upload_dir . $new_file_name;

    
    if ($file_ext !== "pdf") {
        $message = "<div class='alert alert-danger'>Error: Only PDF files are allowed.</div>";
    } 
    
    elseif ($file_size > $max_size) {
        $message = "<div class='alert alert-danger'>Error: File size exceeds 2MB.</div>";
    } 
    
    elseif (move_uploaded_file($file_tmp, $upload_path)) {
        $query = "UPDATE employees SET resume = ? WHERE employee_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $new_file_name, $employee_id);

        if (mysqli_stmt_execute($stmt)) {
            $message = "<div class='alert alert-success'>Resume uploaded successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error updating database: " . mysqli_stmt_error($stmt) . "</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "<div class='alert alert-danger'>Error uploading file.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Resume</title>
    <link rel="stylesheet" href="style-employee1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navigation Bar -->
<nav>
    <input type="checkbox" id="check">
    <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
    </label>
    <label class="logo">JobQuest</label>
    <ul>
        <li><a href="search-jobs.php">Search Jobs</a></li>
        <li><a href="update-profile.php">Update Profile</a></li>
        <li><a class="active" href="upload-resume.php">Upload Resume</a></li>
        <li><a href="view-applications.php">View Applications</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<section>
    <div class="container">
        <h2>Upload Resume (PDF Only)</h2>

        <!-- Show Message (Error or Success) -->
        <?= $message ?>

        <form action="upload-resume.php" method="post" enctype="multipart/form-data">
            <input type="file" name="resume" required>
            <button type="submit" class="btn btn-primary mt-3" style="background-color: violet;">Upload</button>
        </form>
    </div>
</section>

</body>
</html>

