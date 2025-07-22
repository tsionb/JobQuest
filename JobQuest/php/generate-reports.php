<?php
session_start();
include 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied! Only admins can access this page.");
}


$query_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = mysqli_query($conn, $query_users);
$row_users = mysqli_fetch_assoc($result_users);
$total_users = $row_users['total_users'];


$query_employees = "SELECT COUNT(*) AS total_employees FROM employees";
$result_employees = mysqli_query($conn, $query_employees);
$row_employees = mysqli_fetch_assoc($result_employees);
$total_employees = $row_employees['total_employees'];


$query_employers = "SELECT COUNT(*) AS total_employers FROM employers";
$result_employers = mysqli_query($conn, $query_employers);
$row_employers = mysqli_fetch_assoc($result_employers);
$total_employers = $row_employers['total_employers'];


$query_jobs = "SELECT COUNT(*) AS total_jobs FROM jobs";
$result_jobs = mysqli_query($conn, $query_jobs);
$row_jobs = mysqli_fetch_assoc($result_jobs);
$total_jobs = $row_jobs['total_jobs'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>generate reports</title>
    
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
            <li><a class="active" href="manage-users.php">manage users</a></li>
            <li><a href="manage-activities.php">manage activities</a></li>
            <li><a href="generate-reports.php">generate reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

 </div>
    <div class="container mt-4">
        <h2>System Reports</h2>
        
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Report Category</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Users</td>
                    <td><?= $total_users ?></td>
                </tr>
                <tr>
                    <td>Total Employees</td>
                    <td><?= $total_employees ?></td>
                </tr>
                <tr>
                    <td>Total Employers</td>
                    <td><?= $total_employers ?></td>
                </tr>
                <tr>
                    <td>Total Jobs Posted</td>
                    <td><?= $total_jobs ?></td>
                </tr>
            </tbody>
        </table>

        <!-- <a href="admin-dashboard.php" class="btn btn-primary" style="background-color: #d15db4;">Back to Dashboard</a> -->
    </div>
</body>
</html>

