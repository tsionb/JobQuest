<?php
session_start();
include 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    die("Access Denied! Only employers can access this page.");
}


$employer_id = null;
$query = "SELECT employer_id FROM employers WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $employer_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);


if (!$employer_id) {
    die("Error: Employer not found in the database.");
}

$success_message = $error_message = "";


if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $job_type = $_POST['job_type'];

    $query = "INSERT INTO jobs (employer_id, title, description, salary, location, job_type) 
              VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isssss", $employer_id, $title, $description, $salary, $location, $job_type);

    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Job Posted Successfully!";
    } else {
        $error_message = "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Post Jobs</title>
    
    <link rel="stylesheet" href="style-employee1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script defer src="script.js"></script>

    <style>
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .success-message {
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 15px;
        }
        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
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
        <h2 class="text-center">Post a Job</h2>

        <!-- Success & Error Messages -->
        <?php if (!empty($success_message)): ?>
            <p class="success-message"><?= $success_message ?></p>
        <?php elseif (!empty($error_message)): ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php endif; ?>

        <form action="post-job.php" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Job Title</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Job Title" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Job Description</label>
                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Job Description" required></textarea>
            </div>

            <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="text" class="form-control" name="salary" id="salary" placeholder="Salary" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" name="location" id="location" placeholder="Location" required>
            </div>

            <div class="mb-3">
                <label for="job_type" class="form-label">Job Type</label>
                <select class="form-control" name="job_type" id="job_type" required>
                    <option value="full-time">Full-Time</option>
                    <option value="part-time">Part-Time</option>
                    <option value="contract">Contract</option>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100" style="background-color: #d15db4;">Post Job</button>
        </form>
    </div>
</body>
</html>


