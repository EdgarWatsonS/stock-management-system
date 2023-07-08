<?php
session_start();
include("lib/db.class.php");
include_once "config.php";
$class = new DB($config['database'], $config['host'], $config['username'], $config['password']);
$db = $class->db_conn($config['database'], $config['host'], $config['username'], $config['password']);

$tbl_name = "stock_user"; // Table name

// username and password sent from form
$myusername = $_REQUEST['username'];
$mypassword = $_REQUEST['password'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$myusername = ($myusername);

$sql = "SELECT * FROM $tbl_name WHERE username='$myusername'";
$result = mysqli_query($db, $sql);

// Check if a row is found
if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $storedPassword = $row['password'];

    // Verify the provided password against the hashed password
    if (password_verify($mypassword, $storedPassword)) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_type'] = $row['user_type'];

        if ($row['user_type'] == "admin") {
            header("location: dashboard.php");
        } else if ($row['user_type'] == "staff") {
            header("location: user_view.php");
        } else {
            die("Not a valid user type. Check with your application administrator");
        }
    } else {
        header("location: index.php?msg=Wrong%20Username%20or%20Password&type=error");
    }
} else {
    header("location: index.php?msg=Wrong%20Username%20or%20Password&type=error");
}
?>
