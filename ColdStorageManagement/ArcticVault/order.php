<?php
include('config.php');
session_start();

// Check if the necessary data is set in the URL
if (isset($_GET['unit_id'], $_GET['temperature_capability'], $_GET['price_per_product'])) {
    // Retrieve data from the URL
    $unitId = $_GET['unit_id'];
    $temperatureCapability = $_GET['temperature_capability'];
    $pricePerProduct = $_GET['price_per_product'];

    // Query to select records for the specific storage unit
    $storageUnitQuery = "SELECT * FROM StorageUnits WHERE unit_id = '$unitId'";
    $storageUnitResult = mysqli_query($conn, $storageUnitQuery);
    $storageUnit = mysqli_fetch_assoc($storageUnitResult);

    // Query to select products within the temperature range
    $minTemperature = $temperatureCapability - 0;
    $maxTemperature = $temperatureCapability + 8;
    $productsQuery = "SELECT * FROM Products WHERE temperature_requirement >= '$minTemperature' AND temperature_requirement <= '$maxTemperature'";
    $productsResult = mysqli_query($conn, $productsQuery);

    // Initialize variables
    $productName = '';
    $totalPrice = 0;

    // Check if a product is selected
    if (isset($_POST['product'], $_POST['quantity'])) {
        $productId = $_POST['product'];
        $quantity = intval($_POST['quantity']);

        // Retrieve product data
        $productQuery = "SELECT * FROM Products WHERE product_id = '$productId'";
        $productResult = mysqli_query($conn, $productQuery);
        $productData = mysqli_fetch_assoc($productResult);

        // Set product name and calculate total price
        $productName = $productData['product_name'];
        $totalPrice = $quantity * $pricePerProduct;

        // Save transaction data to the Transactions table
        $userId = $_SESSION['user_id'];
        $transactionDate = date('Y-m-d');
        $insertTransactionQuery = "INSERT INTO Transactions (user_id, product_id, unit_id, quantity, transaction_date) VALUES ('$userId', '$productId', '$unitId', '$quantity', '$transactionDate')";
        $result = mysqli_query($conn, $insertTransactionQuery);

        if ($result) {
            // Redirect to the payment page with total price
            header("Location: payment.php?totalPrice=$totalPrice");
            exit;
        } else {
            echo "Error saving transaction data.";
        }
    }
} else {
    echo "Required data not set in the URL.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/style3.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Order Page</title>
</head>
<body>
    <section id="banner">
        <ul>
            <div class="logo">
                <a href="home.php">
                    <img src="./images/logo.png">
                </a>
            </div>
            <li><a href="index.php  "><i class="fa-solid fa-right-from-bracket fa-bounce"></i> Logout</a></li>
            
        </ul>

        <div style="margin-left:12%; padding: 10px 26px; height:auto; margin-right:12%; color:white;">
            <h2>Order Details</h2>
            <form action="" method="post" id="orderForm">
                <div class="mb-3">
                    <label for="storageUnit" class="form-label">Storage Unit</label>
                    <input type="text" class="form-control" id="storageUnit" name="storageUnit" value="<?php echo $storageUnit['unit_name']; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="temperatureCapability" class="form-label">Temperature Capability</label>
                    <input type="text" class="form-control" id="temperatureCapability" name="temperatureCapability" value="<?php echo $temperatureCapability; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="product" class="form-label">Select Product</label>
                    <select class="form-select" name="product" id="product" required>
                        <?php
                        while ($product = mysqli_fetch_assoc($productsResult)) {
                            echo '<option value="' . $product['product_id'] . '">' . $product['product_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required min="0">
                </div>

                <div class="mb-3">
                    <label for="totalPrice" class="form-label">Total Price</label>
                    <input type="text" class="form-control" id="totalPrice" name="totalPrice" readonly>
                </div>

                <script>
                    // JavaScript to calculate total price
                    document.getElementById('quantity').addEventListener('input', function () {
                        var quantity = this.value;
                        var pricePerProduct = <?php echo $pricePerProduct; ?>;
                        var totalPrice = quantity * pricePerProduct;
                        document.getElementById('totalPrice').value = totalPrice.toFixed(2);
                    });
                </script>

                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        </div>
    </section>
</body>
</html>
