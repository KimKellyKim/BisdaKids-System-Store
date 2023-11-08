<?php
function sendPaymentRequest() {
    $url = "https://api4wrd-v1.kpa.ph/paymongo/v1/create"; // You will need an app_key; get it from -> https://api4wrd.kpa.ph/register

    $redirect = [
        "success" => "/backend/success.php", // Adjust the path to your success.php file
        "failed" => "/backend/failed.php" // Adjust the path to your failed.php file
    ];

    $billing = [
        "price" => $_GET["price"],
        "quantity" => $_GET["quantity"],
        "itemName" => $_GET["itemName"],
        "username" => $_GET["username"],
        "mobile" => $_GET["mobile"],
        "email" => $_GET["email"]
    ];

    $attributes = [
        "livemode" => false,
        "type" => "gcash",
        "amount" => $billing["price"],
        "currency" => "PHP",
        "redirect" => $redirect,
        "billing" => $billing
    ];

    $source = [
        "app_key" => "ccb5a1c6685dc2c80ecdda7881ca06532fd7667a", // Get it from -> https://api4wrd.kpa.ph/register
        "secret_key" => "sk_test_4jSG21fBp34pCCxymoQ2znP3", // Secret key from Paymongo; make sure your account is fully activated
        "password" => "#09292774965Dwight", // Your Paymongo account password; ensure your account is fully activated
        "data" => [
            "attributes" => $attributes
        ]
    ];

    $jsonData = json_encode($source)

    $ch = curl_init($url)
    curl_setopt($ch, CURLOPT_POST, 1)
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData)
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'))
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true)

    // disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false)

    $result = curl_exec($ch);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE) // Get the HTTP status code

    if ($httpStatus === 200) {
        echo "Payment request successful"
    } else {
        echo "Payment request failed with HTTP status: " . $httpStatus
    }
}

sendPaymentRequest()
