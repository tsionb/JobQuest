<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') {
    die("Access Denied!");
}

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];

    $query = "DELETE FROM jobs WHERE job_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $job_id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: view-jobs.php");
        exit();
    } else {
        echo "Error deleting job.";
    }
}
?>

