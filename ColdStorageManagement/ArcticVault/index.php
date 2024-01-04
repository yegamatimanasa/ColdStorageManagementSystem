

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/style2.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>login</title>
</head>
<body>
    <div class="grid-container">
           <div class="grid-item">
              <img src="https://www.ittefaqgroup.pk/wp-content/uploads/2023/08/Cold-Storage-Website_11zon-768x512.jpg"class="half-screen-image">

           </div>
          <div class="grid-item1">
                <div class="logo">
                    <a href=""><img src="./images/logo.png"></a>

                </div>

            <form action="" method="POST">
            <div class="container">
            <h2>LOGIN</h2><br>
            <label>Username : </label>
            <input type="text" placeholder="Enter Username" name="username" required minlength="5" maxlength="50">
                   <label>Password : </label>
            <div class="password-input">
                <input type="password" placeholder="Enter Password" name="password" required id="typepass" minlength="5" maxlength="50">
                <span class="password-toggle" onclick="TogglePasswordVisibility()">
                    <i class="fa fa-eye" id="eye-icon"></i>
                </span>
            </div>

            <button type="submit">Login</button>

            <a href="register.php"> Dont have an account???? Register here.....</a>
            <a href="register.php" style="margin-left: 70px;">Forgot Password?</a>
            <a href="admin-login.php"> Want to login as admin?</a>
            <!-- Display error message here -->
            <?php
include('config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the user is an admin
    $adminQuery = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND full_name = 'admin'";
    $adminResult = mysqli_query($conn, $adminQuery);

    if (mysqli_num_rows($adminResult) > 0) {
        $adminData = mysqli_fetch_assoc($adminResult);
        $_SESSION['user_type'] = 'admin';
        $_SESSION['user_id'] = $adminData['user_id'];
        header("Location: admin.php");
        exit();
    } else {
        
            // Check if the user is a student
            $customerQuery = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND full_name = 'customer'";
            $customerResult = mysqli_query($conn, $customerQuery);

            if (mysqli_num_rows($customerResult) > 0) {
                $customerData = mysqli_fetch_assoc($customerResult);
                $_SESSION['full_name'] = 'customer';
                $_SESSION['user_id'] = $customerData['user_id'];
                header("Location: login.php");
                exit();
            } else {
                // Invalid credentials
                echo "Invalid username or password";
            }
        }   
    }

?>
        </div>
             </form>
              </div>
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
</body>
</html>