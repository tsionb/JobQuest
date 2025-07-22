<?php
session_start();
include 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    die("Access Denied! Only employers can access this page.");
}


$query = "SELECT employer_id FROM employers WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $employer_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);


if (!isset($_GET['id'])) {
    die("Error: No job ID provided.");
}

$job_id = $_GET['id'];


$query = "SELECT title, description, salary, location, job_type FROM jobs WHERE job_id = ? AND employer_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $job_id, $employer_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$job = mysqli_fetch_assoc($result);


if (!$job) {
    die("Error: Job not found or you do not have permission to edit this job.");
}

// Initialize messages
$success_message = $error_message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $job_type = $_POST['job_type'];

    $update_query = "UPDATE jobs SET title=?, description=?, salary=?, location=?, job_type=? WHERE job_id=? AND employer_id=?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $title, $description, $salary, $location, $job_type, $job_id, $employer_id);

    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Job updated successfully!";
    } else {
        $error_message = "Error updating job: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Job</title>
    
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
            <li><a href="post-job.php">Post Job</a></li>
            <li><a href="manage-jobs.php">Manage Jobs</a></li>
            <li><a href="update-employer.php">Update Profile</a></li>
            <li><a href="review-applications.php">Review Applications</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2 class="text-center">Edit Job</h2>

        <!-- Success & Error Messages -->
        <?php if (!empty($success_message)): ?>
            <p class="success-message"><?= $success_message ?></p>
        <?php elseif (!empty($error_message)): ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php endif; ?>

        <form action="edit-job.php?id=<?= $job_id ?>" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Job Title</label>
                <input type="text" class="form-control" name="title" id="title" value="<?= htmlspecialchars($job['title']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Job Description</label>
                <textarea class="form-control" name="description" id="description" rows="3" required><?= htmlspecialchars($job['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="text" class="form-control" name="salary" id="salary" value="<?= htmlspecialchars($job['salary']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" name="location" id="location" value="<?= htmlspecialchars($job['location']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="job_type" class="form-label">Job Type</label>
                <select class="form-control" name="job_type" id="job_type" required>
                    <option value="full-time" <?= ($job['job_type'] == 'full-time') ? 'selected' : '' ?>>Full-Time</option>
                    <option value="part-time" <?= ($job['job_type'] == 'part-time') ? 'selected' : '' ?>>Part-Time</option>
                    <option value="contract" <?= ($job['job_type'] == 'contract') ? 'selected' : '' ?>>Contract</option>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100" style="background-color: #d15db4; border: #d15db4">Update Job</button>
        </form>
    </div>
</body>
</html>


