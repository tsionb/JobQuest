<?php
session_start();
include 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    die("Access Denied! Only employees can search and apply for jobs.");
}


$query = "SELECT employee_id FROM employees WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $employee_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$message = ""; // Store success/error messages


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['apply'])) {
    $job_id = $_POST['job_id'];

    
    $check_query = "SELECT * FROM applications WHERE employee_id = ? AND job_id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "ii", $employee_id, $job_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $message = "<div class='alert alert-danger'>You have already applied for this job.</div>";
    } else {
       
        $apply_query = "INSERT INTO applications (employee_id, job_id, application_date) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $apply_query);
        mysqli_stmt_bind_param($stmt, "ii", $employee_id, $job_id);

        if (mysqli_stmt_execute($stmt)) {
            $message = "<div class='alert alert-success'>Job application submitted successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error submitting application. Please try again.</div>";
        }
    }
    mysqli_stmt_close($stmt);
}

$search_query = "";
if (isset($_GET['search'])) {
    $search_query = trim($_GET['search']);
}


$query = "SELECT job_id, title, description, salary, location, job_type, posted_at 
          FROM jobs 
          WHERE title LIKE ? OR description LIKE ? OR location LIKE ?";
$stmt = mysqli_prepare($conn, $query);
$search_param = "%" . $search_query . "%";
mysqli_stmt_bind_param($stmt, "sss", $search_param, $search_param, $search_param);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Jobs</title>
    
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
<div class="container-lg" style="overflow-x:auto;">
        <!-- <h2>Search Jobs</h2> -->

        <!-- Display Success/Error Messages -->
        <?= $message ?>

        <form method="GET" action="search-jobs.php">
            <input type="text" name="search" placeholder="Enter job title, description, or location" value="<?= htmlspecialchars($search_query) ?>">
            <button type="submit" style="background-color: #d15db4;">Search</button>
        </form>

        <table class="table table-striped" border="1">
            <tr style="background-color:rgb(194, 177, 189);">
                <th>Job Title</th>
                <th>Description</th>
                <th>Salary</th>
                <th>Location</th>
                <th>Job Type</th>
                <th>Posted At</th>
                <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['salary']) ?></td>
                <td><?= htmlspecialchars($row['location']) ?></td>
                <td><?= htmlspecialchars($row['job_type']) ?></td>
                <td><?= htmlspecialchars($row['posted_at']) ?></td>
                <td>
                    <form method="POST" action="apply-job.php">
                        <input type="hidden" name="job_id" value="<?= $row['job_id'] ?>">
                        <button type="submit" name="apply" style="background-color: #d15db4">Apply</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    </section>
</body>
</html>
