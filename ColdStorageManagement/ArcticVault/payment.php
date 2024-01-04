<?php
include('config.php');
session_start();

// Check if the user ID is set in the session
if (isset($_SESSION['user_id'])) {
    // Retrieve the user ID from the session
    $userID = $_SESSION['user_id'];

    // Query to select specific records based on the User ID
    $userQuery = "SELECT * FROM users WHERE user_id = '$userID'";
    $userResult = mysqli_query($conn, $userQuery);

    // Fetch user data
    $userData = mysqli_fetch_assoc($userResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/style3.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Payment Dashboard</title>
</head>
<body>
    <section id="banner">
        <ul>
            <div class="logo">
                <a href="home.php">
                    <img src="./images/logo.png">
                </a>
            </div>
            <li><a href="index.php"><i class="fa-solid fa-right-from-bracket fa-bounce"></i> Logout</a></li>
            
        </ul>

        <div style="margin-left:12%; padding: 10px 26px; height:auto; margin-right:12%; color:white;">
            <h2>Payment Details</h2>

            <!-- Display total price -->
            <div class="mb-3">
                <label for="totalPrice" class="form-label">Total Price</label>
                <input type="text" class="form-control" id="totalPrice" name="totalPrice" value="<?php echo isset($_GET['totalPrice']) ? $_GET['totalPrice'] : ''; ?>" readonly>
            </div>

            <!-- Display username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $userData['username']; ?>" readonly>
            </div>

            <!-- Payment Form -->
            <form action="succes.php" method="post">
                <div class="mb-3">
                    <label for="cardDetails" class="form-label">Card Details</label>
                    <input type="number" class="form-control" id="cardDetails" name="cardDetails" required>
                </div>
                <div class="mb-3">
    <label for="cvv" class="form-label">CVV</label>
    <input type="password" class="form-control" id="cvv" name="cvv" pattern="[0-9]{3}" maxlength="3" title="Please enter a 3-digit CVV" required>
    <small id="cvvHelp" class="form-text text-muted">Enter the 3-digit CVV from the back of your card.</small>
</div>


                <div class="mb-3">
                    <label for="cardDetails" class="form-label">Name on Card</label>
                    <input type="text" class="form-control" id="cardDetails" name="cardDetails" pattern="[A-Za-z\s]+" title="Please enter alphabets only" required>
                </div>
                <!-- Add more payment fields as needed -->

                <button type="submit" class="btn btn-primary">Submit Payment</button>
            </form>
        </div>
    </section>
</body>
</html>

<?php
} else {
    echo "User ID not set in the session.";
}
?>
