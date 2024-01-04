<?php
// Include the database connection configuration
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form
    $username = $_POST["username"];
    $userType = $_POST["userType"];
    $password = $_POST["password"];

    // Check user type and set the role accordingly
    $role = '';
    switch ($userType) {
        case 'student':
            $role = 'customer';
            break;
        case 'admin':
            $role = 'admin';
            break;
        default:
            // Invalid user type
            echo "Invalid user type";
            exit();
    }

    // Register user with the specified role
    $insertUserQuery = "INSERT INTO users (username, password, full_name) VALUES ('$username', '$password', '$role')";
    $result = mysqli_query($conn, $insertUserQuery);

    if ($result) {
        // Registration successful
        echo ucfirst($role) . " registration successful!";
        header("Location: login.php");
        exit();
    } else {
        // Registration failed
        echo ucfirst($role) . " registration failed!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/style2.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Register</title>
</head>
<body>
<div class="grid-container">
    <div class="grid-item">
        <img src="https://admin.rxinsider.com/file/horizon_scientific_ice-bb91-1654699363.jpg" class="half-screen-image">
    </div>
    <div class="grid-item1">
        <div class="logo">
            <a href="index.html"><img src="./images/logo.png"></a>
        </div>
        <form action="" method="POST">
            <div class="container">
            <h2>REGISTER</h2>
                <label>Username:</label>
                <input type="text" placeholder="Enter Username" name="username" required minlength="5" maxlength="50">



                <label>Password:</label>
                <div class="password-input">
                    <input type="password" placeholder="Enter Password" name="password" required id="typepass" minlength="5" maxlength="50">
                    <span class="password-toggle" onclick="TogglePasswordVisibility()">
                        <i class="fa fa-eye" id="eye-icon"></i>
                    </span>
                </div>

                <label>User Type:</label>
                <select name="userType" required>
                    <option value="student">Customer</option>
                    
                </select>
                <button type="submit">Register</button>
                <a href="login.php">Already have an account? Login here...</a>
            </div>
        </form>
    </div>
    <script>
        function TogglePasswordVisibility() {
            let passwordInput = document.getElementById("typepass");
            let eyeIcon = document.getElementById("eye-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</div>
</body>
</html>
