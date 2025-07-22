<?php
session_start();
include 'config.php';



if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied! Only admins can access this page.");
}


$query_jobs = "SELECT COUNT(*) AS total_jobs FROM jobs";
$result_jobs = mysqli_query($conn, $query_jobs);
$row_jobs = mysqli_fetch_assoc($result_jobs);
$total_jobs = $row_jobs['total_jobs'];


$query_applications = "SELECT COUNT(*) AS total_applications FROM applications";
$result_applications = mysqli_query($conn, $query_applications);
$row_applications = mysqli_fetch_assoc($result_applications);
$total_applications = $row_applications['total_applications'];

// Fetch job postings per employer
$query_jobs_per_employer = "SELECT employers.company_name, COUNT(jobs.job_id) AS job_count 
                            FROM employers 
                            LEFT JOIN jobs ON employers.employer_id = jobs.employer_id
                            GROUP BY employers.company_name";
$result_jobs_per_employer = mysqli_query($conn, $query_jobs_per_employer);

// Fetch job applications per employee
$query_applications_per_employee = "SELECT users.name, COUNT(applications.application_id) AS application_count 
                                    FROM users
                                    JOIN employees ON users.user_id = employees.user_id
                                    LEFT JOIN applications ON employees.employee_id = applications.employee_id
                                    GROUP BY users.name";
$result_applications_per_employee = mysqli_query($conn, $query_applications_per_employee);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage activities</title>
    
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
        <h2>Manage Activities</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body" style="background-color:rgb(170, 140, 163);">
                        <h5 class="card-title">Total Jobs Posted</h5>
                        <p class="card-text display-4"><?= $total_jobs ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body" style="background-color:rgba(209, 93, 180, 0.4);">
                        <h5 class="card-title">Total Applications Submitted</h5>
                        <p class="card-text display-4"><?= $total_applications ?></p>
                    </div>
                </div>
            </div>
        </div>

        <h3>Jobs Posted Per Employer</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Company Name</th>
                    <th>Jobs Posted</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_jobs_per_employer)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['company_name']) ?></td>
                        <td><?= htmlspecialchars($row['job_count']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Applications Submitted Per Employee</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Employee Name</th>
                    <th>Applications Submitted</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_applications_per_employee)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['application_count']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        
    </div>
</body>
</html>

