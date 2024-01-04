<?php
include('config.php');
session_start();

// Handle delete action
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["transaction_id"])) {
    $deleteTransactionId = $_GET["transaction_id"];
    $deleteQuery = "DELETE FROM transactions WHERE transaction_id = $deleteTransactionId";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if (!$deleteResult) {
        die("Delete query failed: " . mysqli_error($conn));
    }

    // Redirect to refresh the page after deletion
    header("Location: admin-dashboard.php");
    exit();
}

// Handle update action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "update" && isset($_POST["transaction_id"])) {
    $updateTransactionId = $_POST["transaction_id"];

    // Fetch existing data for the selected transaction
    $fetchQuery = "SELECT transactions.*, users.username AS user_username, products.product_name 
                   FROM transactions 
                   JOIN users ON transactions.user_id = users.user_id 
                   JOIN products ON transactions.product_id = products.product_id
                   WHERE transaction_id = $updateTransactionId";
    $fetchResult = mysqli_query($conn, $fetchQuery);

    if (!$fetchResult) {
        die("Fetch query failed: " . mysqli_error($conn));
    }

    $transactionData = mysqli_fetch_assoc($fetchResult);

    // Display a form for updating the transaction
    echo "<form method='POST' action=''>
              <input type='hidden' name='transaction_id' value='{$updateTransactionId}'>
              <label for='updated_quantity'>Updated Quantity:</label>
              <input type='text' name='updated_quantity' value='{$transactionData['quantity']}'>
              <button type='submit' name='action' value='perform_update'>Update</button>
          </form>";

} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "perform_update" && isset($_POST["transaction_id"]) && isset($_POST["updated_quantity"])) {
    $updateTransactionId = $_POST["transaction_id"];
    $updatedQuantity = $_POST["updated_quantity"];

    // Update the transaction in the database
    $updateQuery = "UPDATE transactions SET quantity = '$updatedQuantity' WHERE transaction_id = $updateTransactionId";
    $updateResult = mysqli_query($conn, $updateQuery);

    if (!$updateResult) {
        die("Update query failed: " . mysqli_error($conn));
    }

    // Redirect to refresh the page after update
    header("Location: admin-dashboard.php");
    exit();
}

// Fetch data from the database, including user and product details
$transactionQuery = "SELECT transactions.*, users.username AS user_username, products.product_name 
                   FROM transactions 
                   JOIN users ON transactions.user_id = users.user_id 
                   JOIN products ON transactions.product_id = products.product_id";
$transactionResult = mysqli_query($conn, $transactionQuery);

// Check if the query was successful
if (!$transactionResult) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
       body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h2 {
    color: #333;
    text-align: center;
}

h3 {
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th,
td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #3498db;
    color: #fff;
}

td {
    background-color: #fff;
}

button {
    padding: 8px 15px;
    background-color: #4caf50;
    color: #fff;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

a {
    text-decoration: none;
    color: #3498db;
    margin-left: 10px;
}

a:hover {
    color: #1d5cb4;
}

.container a {
    display: block;
    margin-top: 20px;
    text-align: center;
    color: #fff;
    background-color: #3498db;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
}

.container a:hover {
    background-color: #1d5cb4;
}

    </style>
</head>

<body>
    <h2>Welcome, Admin!</h2>

    <div class="container">
        <h3>Transactions</h3>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>User ID</th>
                    <th>User Username</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Unit ID</th>
                    <th>Quantity</th>
                    <th>Transaction Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the result set and display data in the table
                while ($row = mysqli_fetch_assoc($transactionResult)) {
                    echo "<tr>";
                    echo "<td>" . $row['transaction_id'] . "</td>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['user_username'] . "</td>";
                    echo "<td>" . $row['product_id'] . "</td>";
                    echo "<td>" . $row['product_name'] . "</td>";
                    echo "<td>" . $row['unit_id'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>" . $row['transaction_date'] . "</td>";
                    echo "<td>
                              <form method='POST' action=''>
                                  <input type='hidden' name='transaction_id' value='{$row['transaction_id']}'>
                                  <button type='submit' name='action' value='update'>Update</button>
                              </form>
                              <a href='admin-dashboard.php?action=delete&transaction_id={$row['transaction_id']}' onclick='return confirm(\"Are you sure you want to delete this transaction?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }

                // Free result set
                mysqli_free_result($transactionResult);
                ?>
            </tbody>
        </table>

        <br>

        <a href="index.php">Logout</a>
    </div>
</body>

</html>
