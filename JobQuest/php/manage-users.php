<?php
session_start();
include 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied! Only admins can access this page.");
}


if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    
    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if (!$stmt) {
        die("Query Error: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "i", $delete_id);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('User deleted successfully!'); window.location='manage-users.php';</script>";
    } else {
        echo "Error deleting user.";
    }
}


$employees_query = "SELECT users.user_id, users.name, users.email, 'Employee' AS role, employees.phone, employees.location 
                    FROM users 
                    JOIN employees ON users.user_id = employees.user_id";
$employees_result = mysqli_query($conn, $employees_query);


$employers_query = "SELECT users.user_id, users.name, users.email, 'Employer' AS role, employers.company_name, employers.location 
                    FROM users 
                    JOIN employers ON users.user_id = employers.user_id";
$employers_result = mysqli_query($conn, $employers_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage users</title>
    
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
        <h2>Manage Users</h2>
        
        <h3>Employees</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($employees_result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['user_id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['location']) ?></td>
                        <td>
                            <a href="manage-users.php?delete_id=<?= $row['user_id'] ?>" 
                               onclick="return confirm('Are you sure you want to delete this user?');"
                               class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Employers</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($employers_result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['user_id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['company_name']) ?></td>
                        <td><?= htmlspecialchars($row['location']) ?></td>
                        <td>
                            <a href="manage-users.php?delete_id=<?= $row['user_id'] ?>" 
                               onclick="return confirm('Are you sure you want to delete this user?');"
                               class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>
</body>
</html>

