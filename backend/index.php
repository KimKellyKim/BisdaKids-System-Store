<?php
// index.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the form
    $username = $_POST['username'];
    $itemData = json_decode($_POST['item_data'], true);
    $itemName = $_POST['itemName'];

    // Access item data
    $item_id = $itemData['item_id'];
    $price = $itemData['price'];
    $quantity = $itemData['offer_quantity'];
    $store_offer_id = $itemData['store_offer_id'];
    // Access other data as needed
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sample Gcash Form</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            body {
                background-color: #f8f9fa;
            }
            .container {
                max-width: 500px;
                margin-top: 20px;
            }
            .card {
                border: 1px solid #ddd;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .card-header {
                background-color: #007bff;
                color: #fff;
                border-radius: 10px 10px 0 0;
            }
            .form-control {
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Sample Gcash Form</h4>
                </div>
                <div class="card-body">
                    <form class="needs-validation" method="POST" action="get-data.php">
                        <div class="form-group">
                            <label for="firstName">Username</label>
                            <input type="text" class="form-control" name="user_name" value="<?php echo htmlspecialchars($username); ?>" readonly>
                        </div>
                        <input type="hidden" class="form-control" name="store_offer_id" value="<?php echo htmlspecialchars($store_offer_id); ?>">
                        <div class="form-group">
                            <label for="itemName">Item</label>
                            <input type="text" class="form-control" name="itemName" value="<?php echo htmlspecialchars($itemName); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" name="price" value="<?php echo htmlspecialchars($price)."00"; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Mobile</label>
                            <input type="number" class="form-control" name="mobile" placeholder="0999999999" required>
                            <div class="invalid-feedback">Please enter a valid mobile number for shipping updates.</div>
                        </div>
                        
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Send Payment</button>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
    </html>
    <?php
} else {
    // Your existing HTML form code
    ?>
    <html>
        <div>
            <h1>Server Error</h1>
        </div>
    </html>
    <?php
}
?>
