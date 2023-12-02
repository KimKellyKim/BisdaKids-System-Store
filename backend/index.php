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
    <html>
    <head>
    <title>trial paymongo gcash bisdakids</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        @media (min-width: 1200px) {
            .container {
                max-width: 780px;
            }
        }
    </style>
    </head>
    <div class="container">
        <div class="row">
            <div class="col-md-12 order-md-1"><br><br>
                <h4 class="mb-3">Billing address</h4>
                <form class="needs-validation" method="POST" action="get-data.php">
                    <div class="mb-3">
                        <label for="firstName">Username</label>
                        <input type="text" class="form-control" name="user_name" value="<?php echo htmlspecialchars($username); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="store_offer_id">Store Offer Id</label>
                        <input type="text" class="form-control" name="store_offer_id" value="<?php echo htmlspecialchars($store_offer_id); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="itemName">Item</label>
                        <input type="text" class="form-control" name="itemName" value="<?php echo htmlspecialchars($itemName); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" name="price" value="<?php echo htmlspecialchars($price)."00"; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email">Mobile</label>
                        <input type="number" class="form-control" name="mobile" placeholder="0999999999">
                        <div class="invalid-feedback"> Please enter a valid mobile number for shipping updates. </div>
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
