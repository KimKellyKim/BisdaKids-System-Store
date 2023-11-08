<?php

// Check if the required GET parameters are set
if (
    isset($_GET["price"]) &&
    isset($_GET["quantity"]) &&
    isset($_GET["itemName"]) &&
    isset($_GET["username"]) &&
    isset($_GET["mobile"]) &&
    isset($_GET["email"])
) {
    $url = "https://api4wrd-v1.kpa.ph/paymongo/v1/create";

    $redirect = [
        "success" => "/backend/success.php",
        "failed" => "/backend/failed.php"
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
        "amount" => 70000,
        "currency" => "PHP",
        "redirect" => $redirect,
        "billing" => $billing
    ];

    $source = [
        "app_key" => "ccb5a1c6685dc2c80ecdda7881ca06532fd7667a",
        "secret_key" => "sk_test_4jSG21fBp34pCCxymoQ2znP3",
        "password" => "#09292774965Dwight",
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
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpStatus === 200) {
        //echo "Payment request successful";
        header("Location: success.php");
    } else {
        echo "Payment request failed with HTTP status: " . $httpStatus;
    }
} else {
    echo "Required parameters are missing in the URL.";
}

?>
