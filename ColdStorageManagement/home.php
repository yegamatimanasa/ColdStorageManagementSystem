<?php
include('config.php');
// Start the session
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

    // Query to select records from StorageUnits table
    $storageUnitsQuery = "SELECT * FROM StorageUnits";
    $storageUnitsResult = mysqli_query($conn, $storageUnitsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/style3.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>User Dashboard</title>
</head>
<body>
    <section id="banner">
        <ul>
            <div class="logo">
                <a href="login.php">
                    <img src="./images/logo.png">
                </a>
            </div>
            <li><a href="index.php"><i class="fa-solid fa-right-from-bracket fa-bounce"></i> Logout</a></li>
            
            
        </ul>

        <div style="margin-left:12%;padding:10px 26px;height:auto;margin-right:12%;color:white;">
            <h2>Storage Units Information</h2>
            <?php
            while ($storageUnit = mysqli_fetch_assoc($storageUnitsResult)) {
                echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 15px;">';
                echo '<h3> ' . $storageUnit['unit_name'] . '</h3>';
                echo '<p><strong>Temperature Capability (Degree):</strong> ' . $storageUnit['temperature_capability'] . '</p>';
                echo '<p><strong>Price Per Peroduct Stored:</strong> ' . $storageUnit['price_per_product'] . '</p>';
                

                // Define temperature range
                $minTemperature = $storageUnit['temperature_capability'] - 0;
                $maxTemperature = $storageUnit['temperature_capability'] + 8;

                // Query to select products within the temperature range
                $productsQuery = "SELECT * FROM Products WHERE temperature_requirement >= '$minTemperature' AND temperature_requirement <= '$maxTemperature'";
                $productsResult = mysqli_query($conn, $productsQuery);

                // Display matching products
                echo '<table class="table table-hover table-dark">';
                echo '<thead>';
                echo '<tr>';
                echo '<th scope="col">#</th>';
                echo '<th scope="col">Product Name</th>';
                echo '<th scope="col">Temperature Requirement (Degree)</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                $rowNumber = 1; // Initialize row number
                
                while ($product = mysqli_fetch_assoc($productsResult)) {
                    echo '<tr>';
                    echo '<th scope="row">' . $rowNumber . '</th>';
                    echo '<td>' . $product['product_name'] . '</td>';
                    echo '<td>' . $product['temperature_requirement'] . '</td>';
                    echo '</tr>';
                    
                    $rowNumber++; // Increment row number for each iteration
                }
                
                echo '</tbody>';
                echo '</table>';
                echo '<form action="order.php" method="get">';
                echo '<input type="hidden" name="unit_id" value="' . $storageUnit['unit_id'] . '">';
                echo '<input type="hidden" name="temperature_capability" value="' . $storageUnit['temperature_capability'] . '">';
                echo '<input type="hidden" name="price_per_product" value="' . $storageUnit['price_per_product'] . '">';
                echo '<button type="submit" class="btn btn-primary">Buy</button>';
                echo '</form>';
                echo '</div>';
            }
            ?>
        </div>
    </section>
</body>
</html>

<?php
} else {
    echo "User ID not set in the session.";
}
?>