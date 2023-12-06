<?php
session_start();
$_SESSION['store_offer_id'] = $_POST['store_offer_id'];
$_SESSION['user_name'] = $_POST['user_name'];
$_SESSION['price'] = $_POST['price'];
$_SESSION['quantity'] = $_POST['quantity'];

header('Location: paymongo.php?user_name=' . $_POST['user_name'] . "&mobile=" . $_POST['mobile'] . "&price=" . $_POST['price'])
?>