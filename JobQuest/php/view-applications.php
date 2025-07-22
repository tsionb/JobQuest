<?php
session_start();
include 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    die("Access Denied! Only employees can view applications.");
}

$query = "SELECT employee_id FROM employees WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Query Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $employee_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);


$query = "SELECT jobs.title AS job_title, jobs.location, jobs.salary, jobs.job_type
          FROM applications
          JOIN jobs ON applications.job_id = jobs.job_id
          WHERE applications.employee_id = ?";

$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Query Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $employee_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>view applications</title>
    
    <link rel="stylesheet" href="style-employee1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    

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
            <li><a class="active" href="search-jobs.php">Search Jobs</a></li>
            <li><a href="update-profile.php">Update Profile</a></li>
            <li><a href="upload-resume.php">Upload Resume</a></li>
            <li><a href="view-applications.php">View Applications</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

 </div>
    <section>
    <div class="container">
        <h2>My Job Applications</h2>

        <table border="1">
            <tr>
                <th>Job Title</th>
                <th>Location</th>
                <th>Salary</th>
                <th>Job Type</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['job_title']) ?></td>
                <td><?= htmlspecialchars($row['location']) ?></td>
                <td><?= htmlspecialchars($row['salary']) ?></td>
                <td><?= htmlspecialchars($row['job_type']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</section>
</body>
</html>

