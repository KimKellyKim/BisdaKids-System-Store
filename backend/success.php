<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//functions, for separation of logic lang
function removeDecimalDigits($price) {
    $newPrice = floor($price / 100);
    return $newPrice;
}
function user_id_query($user_name, $dbconnect){
    $query = <<<PGQUERY
    SELECT user_id
    FROM user_account
    WHERE user_name = '$user_name'
    PGQUERY;
    $result = pg_query($dbconnect, $query);
    $user_id = pg_fetch_result($result, 0, 0);
    return $user_id;
}

//initializations, components needed
session_start();
$connection_string = "host=db.nsnoztviefjxvptztmnj.supabase.co dbname=postgres user=postgres password=#bisdakids5";
$dbconnect = pg_connect($connection_string);
#If database connect attempt failed
if (!$dbconnect) {
    echo("db_connection_error");
    die;
}
//variable declarations
$store_offer_id = $_SESSION['store_offer_id'];
$user_id = user_id_query($_SESSION['user_name'],$dbconnect);
$price = removeDecimalDigits($_SESSION['price']);
$quantity = $_SESSION['quantity'];
$paymongo_id = $_GET['paymongo_id'];

$query = <<<PGQUERY
INSERT INTO system_transactions 
(store_offer_id, user_id, paymongo_id) 
VALUES ($store_offer_id, $user_id, '$paymongo_id');
PGQUERY;
$result = pg_query($dbconnect, $query);

$query = <<<PGQUERY
SELECT item_id 
FROM system_store 
WHERE store_offer_id = $store_offer_id;
PGQUERY;
$result = pg_query($dbconnect, $query);
$row = pg_fetch_assoc($result);
$item_id = $row['item_id'];

$query = <<<PGQUERY
INSERT INTO 
user_inventory (user_id, item_id, quantity)
VALUES ($user_id, $item_id, $quantity)
ON CONFLICT (user_id, item_id)
DO UPDATE SET quantity = user_inventory.quantity + EXCLUDED.quantity;
PGQUERY;
$result = pg_query($dbconnect, $query);

if (isset($_GET['ukayra_id'])) {
    /* echo "UkayraID: " . $_GET['ukayra_id'] . "<br />";

    if (isset($_GET['paymongo_id'])) {
        echo "PaymongoID: " . $_GET['paymongo_id'] . "<br />";
    }

    if (isset($_GET['method'])) {
        echo "Method: " . $_GET['method'] . "<br />";
    }

    if (isset($_GET['message'])) {
        echo "Error Message: " . $_GET['message'];
    } */
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Success</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            body {
                background-color: #f8f9fa;
            }
            .container {
                max-width: 500px;
                margin-top: 50px;
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
                    <h4 class="mb-0">Payment Successful!</h4>
                </div>
                <div class="card-body">
                    <label>Ukayra ID:</label>
                    <input type="text" name="id" value="<?php echo $_GET['ukayra_id'];?>" readonly><br>
                    <label>Paymongo ID:</label>
                    <input type="text" style="width: 70%;" name="pay_id" value="<?php echo $_GET['paymongo_id'];?>" readonly><br>
                    <label>Method:</label>
                    <input type="text" name="method" value="<?php echo $_GET['method'];?>" readonly><br><br>
                
                    <a href="http://localhost:5173/" class="btn btn-primary btn-block">Back to Main</a>
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
    ?>
    <html>
        <div>
            <h1>Server Error</h1>
        </div>
    </html>
    //echo "Success Page";
    <?php
}
?>