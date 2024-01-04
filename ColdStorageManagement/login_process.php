<?php
session_start();

// Establish a connection to the database (replace these details with your database credentials)
$conn = new mysqli("localhost", "root", "", "artic");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from the login form
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the user exists in the database
$sql = "SELECT * FROM admins WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verify the password
    if (password_verify($password, $row['password'])) {
        // Password is correct, redirect to home.php
        $_SESSION['username'] = $username;
        header("Location: admin-dashboard.php");
    } else {
        echo "Invalid password. <a href='index.php'>Try again</a>";
    }
} else {
    echo "User not found. <a href='register-admin.php'>Register</a>";
}

$conn->close();
?>
