<?php
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
print_r($result);


if (isset($_GET['ukayra_id'])) {
    echo "UkayraID: " . $_GET['ukayra_id'] . "<br />";

    if (isset($_GET['paymongo_id'])) {
        echo "PaymongoID: " . $_GET['paymongo_id'] . "<br />";
    }

    if (isset($_GET['method'])) {
        echo "Method: " . $_GET['method'] . "<br />";
    }

    if (isset($_GET['message'])) {
        echo "Error Message: " . $_GET['message'];
    }
} else {
    echo "Success Page";
}


echo "<a href='/'>Back to main</a>";
