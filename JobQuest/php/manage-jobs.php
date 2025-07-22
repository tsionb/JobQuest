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


$query = "SELECT job_id, title, salary, location, job_type, posted_at FROM jobs WHERE employer_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $employer_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Jobs</title>
    
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

 </div>  
    <h2>Your Job Listings</h2>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Salary</th>
            <th>Location</th>
            <th>Type</th>
            <th>Posted At</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['title'] ?></td>
            <td><?= $row['salary'] ?></td>
            <td><?= $row['location'] ?></td>
            <td><?= $row['job_type'] ?></td>
            <td><?= $row['posted_at'] ?></td>
            <td>
    <a href="edit-job.php?id=<?= $row['job_id'] ?>" class="btn btn-link">Edit</a>
    <a href="delete-job.php?id=<?= $row['job_id'] ?>" onclick="return confirm('Are you sure you want to delete job?')" class="btn btn-dark">Delete</a>
</td>

        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

