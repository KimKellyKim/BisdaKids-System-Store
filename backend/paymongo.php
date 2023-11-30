<?php

$url = "https://api4wrd-v1.kpa.ph/paymongo/v1/create"; // you will need an app_key, get it from -> https://api4wrd.kpa.ph/register

$redirect = [
    "success" => "http://localhost/BisdaKids-System-Store/backend/success.php",
    "failed" => "http://localhost/BisdaKids-System-Store/backend/failed.php"
];

$billing = [
    "email" => $_GET["email"],
    "name" =>  $_GET["firstName"] . " " .  $_GET["lastName"],
    "phone" =>  $_GET["mobile"],
    "price" => $_GET["price"],
    "address" => [
        "line1" =>  $_GET["address"],
        "line2" =>  $_GET["address2"],
        "city" =>  $_GET["city"],
        "state" =>  $_GET["state"],
        "postal_code" =>  $_GET["zip"],
        "country" =>  $_GET["country"]
    ]
];

$attributes = [
    "livemode" => false,
    "type" => "gcash",
    "amount" => $billing["price"],  
    "currency" => "PHP",
    "redirect" => $redirect,
    "billing" => $billing
];

// FYI = You can use the PAYMONGO secret key & password below;
// "secret_key" => "sk_test_HL7BiubdGVbXHXCt2nhf8fNE"
// "password" => "your-paymongo-password" 
// sample

$source = [
    "app_key" => "ccb5a1c6685dc2c80ecdda7881ca06532fd7667a", // get it from -> https://api4wrd.kpa.ph/register
    "secret_key" => "sk_test_4jSG21fBp34pCCxymoQ2znP3", // secret key from paymongo - be sure your account is fully activated
    "password" => "#09292774965Dwight", // your paymongo account password - be sure your account is fully activated
    "data" => [
        "attributes" => $attributes
    ]
];


$jsonData = json_encode($source);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// disable ssl
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($ch);
$resData = json_decode($result, true);

if ($resData["status"] == 200) {
    // Fetch dynamically obtained data
    $paymongoTransactionID = $resData["data"]["id"]; // Assuming the Paymongo transaction ID is available in the response

    // Fetch store offer ID and user ID dynamically (replace these with your actual logic)
    $storeOfferID = 'DYNAMIC_STORE_OFFER_ID';
    $userID = 'DYNAMIC_USER_ID';

    // Call JavaScript function to update Supabase
    echo "<script>updateSupabase('$paymongoTransactionID', '$storeOfferID', '$userID');</script>";

    // Redirect to Paymongo redirect URL
    header("Location: " . $resData["url_redirect"]);
    echo "okay";
} else {
    // Handle Paymongo API error
    echo $result;
}

die();
