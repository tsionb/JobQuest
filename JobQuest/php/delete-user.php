<?php
include 'config.php';
session_start();

$user_id = $_GET['id'];
$query = "DELETE FROM users WHERE user_id='$user_id'";
mysqli_query($conn, $query);

header("Location: manage-users.php");
exit();
?>
