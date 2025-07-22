<?php
session_start();
include 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    die("Access Denied! Only employees can update their profile.");
}


$query = "SELECT employees.employee_id, users.name, employees.phone, employees.location, employees.skills, employees.experience, employees.resume
          FROM employees 
          JOIN users ON employees.user_id = users.user_id
          WHERE users.user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$employee = mysqli_fetch_assoc($result);

$message = ""; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $skills = $_POST['skills'];
    $experience = $_POST['experience'];

    
    $query = "UPDATE users SET name = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $name, $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);

    
    $query = "UPDATE employees SET phone = ?, location = ?, skills = ?, experience = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $phone, $location, $skills, $experience, $_SESSION['user_id']);
    
    if (mysqli_stmt_execute($stmt)) {
        $message = "<div class='alert alert-success'>Profile updated successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error updating profile. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Profile</title>
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
        <li><a class="active" href="update-profile.php">Update Profile</a></li>
        <li><a href="upload-resume.php">Upload Resume</a></li>
        <li><a href="view-applications.php">View Applications</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<section>
    <div class="container-lg">
        <h2 class="text-center">Update Profile</h2>

        <!-- Show success/error messages -->
        <?= $message ?>

        <form action="update-profile.php" method="post" class="p-4 shadow-lg bg-white rounded">
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Full Name</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($employee['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label fw-bold">Phone</label>
                <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($employee['phone']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label fw-bold">Location</label>
                <input type="text" class="form-control" name="location" value="<?= htmlspecialchars($employee['location']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="skills" class="form-label fw-bold">Skills</label>
                <textarea class="form-control" name="skills" required><?= htmlspecialchars($employee['skills']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="experience" class="form-label fw-bold">Experience</label>
                <textarea class="form-control" name="experience" required><?= htmlspecialchars($employee['experience']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="background-color: #d15db4; border: #d15db4">Update Profile</button>
        </form>
    </div>
</section>

</body>
</html>


