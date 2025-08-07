<?php
include_once("../app/_dbConnection.php");

$userInstance = new Users();
$res = $userInstance->getUser($_GET['user']);
$user = mysqli_fetch_assoc($res);

$packageInstance = new Packages();
$res = $packageInstance->getPackage($_GET['package']);
$package = mysqli_fetch_assoc($res);

// Flutterwave configuration
$flutterwave_secret_key = "FLWSECK_TEST-f72fd9cd23e375a439088152dd8a2097-X"; // Replace with your actual secret key
$currency = "ZMW"; // Currency for Zambia
$transaction_id = "FLW_" . uniqid(); // Unique transaction ID

// Payment data setup
$post_data = array(
    "tx_ref" => $transaction_id,
    "amount" => $package['package_price'],
    "currency" => $currency,
    "redirect_url" => "http://localhost/triptrip/handle_flutterwave_payment.php", // URL to handle payment success/failure
    "payment_options" => "card, mobilemoneyzambia", // Payment methods supported
    "customer" => array(
        "email" => $user['email'],
        "phonenumber" => "01711111111", // Sample number, replace as necessary
        "name" => $user['username']
    ),
    "customizations" => array(
        "title" => "tms Package Payment",
        "description" => "Payment for package: " . $package['package_name']
    ),
    "meta" => array(
        "user_id" => $user['id'],
        "package_id" => $package['package_id'],
        "reference" => "ref003" // Additional reference field if needed
    )
);

// Initialize cURL request to Flutterwave API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.flutterwave.com/v3/payments");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer $flutterwave_secret_key",
    "Content-Type: application/json"
));

// Execute request and handle response
$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $result = json_decode($response, true);
    if (isset($result['data']['link'])) {
        // Redirect to Flutterwave payment page
        echo "<meta http-equiv='refresh' content='0;url=" . $result['data']['link'] . "'>";
        exit;
    } else {
        echo "Payment initialization failed!";
    }
}
