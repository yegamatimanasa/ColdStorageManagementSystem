<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/style2.css" />
    <title>User Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet">
    
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
    
    <h2>Admin Login</h2>
    <form action="login_process.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Login</button>
        </div>
        
    </form>
    
    

</div>
</body>
</html>
