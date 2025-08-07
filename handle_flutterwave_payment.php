<?php
include_once("./app/_dbConnection.php");

if (!isset($_SESSION)) {
    session_start();
}

// Get user email from session
$email = $_SESSION["Email"];
$response;
if (isset($_GET['status']) && $_GET['status'] === 'successful') {
    $txid = $_GET['transaction_id'];

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$txid}/verify",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer FLWSECK_TEST-f72fd9cd23e375a439088152dd8a2097-X"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $response = json_decode($response);
}

// Process Flutterwave response

$status = $_GET['status'];  // Access 'status' from the 'data' object
$transaction_id = $response->data->id ?? '';
$amount = $response->data->amount ?? '';
$customer_id = $response->data->meta->user_id ?? '';
$package_id = $response->data->meta->package_id ?? '';
$payment_method = $response->data->payment_type ?? '';

switch ($status) {
    case 'successful':
        // Process successful payment
        $transactionInstance = new Transactions();
        $transactionInstance->createNewTransaction($transaction_id, $customer_id, $package_id, $amount, date("Y-m-d H:i:s"), '', '', $payment_method);

        // Update package purchase count
        $packagesInstance = new Packages();
        $res = $packagesInstance->getPackage($package_id);

        // Check if the result contains data
        if ($res && mysqli_num_rows($res) > 0) {
            $package = mysqli_fetch_assoc($res); // Convert result to an associative array
            $count = $package['package_booked'] + 1;
            $packagesInstance->updatePackagePurchase($package_id, $count);
        } else {
            die("No package found or query failed.");
        }
        $amountPaid = $response->data->charged_amount;
        $amountToPay = $response->data->price ?? 0;
        // Check if the amount paid is greater than or equal to the amount to pay
        if ($amountPaid >= $amountToPay) {

            echo "<html>
            <head>
                <title>Payment was successful</title>
                <style>
                    body {
                        background: #f7fafc;
                        font-family: 'Segoe UI', Arial, sans-serif;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        height: 100vh;
                        margin: 0;
                    }
                    .success-container {
                        background: #fff;
                        border-radius: 12px;
                        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
                        padding: 40px 32px;
                        text-align: center;
                    }
                    .success-container h1 {
                        color: #27ae60;
                        margin-bottom: 16px;
                        font-size: 2rem;
                    }
                    .success-container p {
                        color: #333;
                        font-size: 1.1rem;
                        margin-bottom: 8px;
                    }
                    .counter {
                        font-weight: bold;
                        color: #e67e22;
                    }
                    .checkmark {
                        font-size: 3rem;
                        color: #27ae60;
                        margin-bottom: 16px;
                        display: block;
                    }
                </style>
            </head>
            <body>
                <div class='success-container'>
                    <span class='checkmark'>&#10004;</span>
                    <h1>Your Payment was Successful</h1>
                    <p>Redirecting to dashboard in <span class='counter'>5</span> seconds...</p>
                </div>
                <script>
                    let countDown = 5;
                    setInterval(() => {
                        countDown--;
                        document.querySelector('.counter').innerHTML = countDown;
                    }, 1000);
                    setTimeout(() => {
                        location.href = './auth/user_dashboard.php';
                    }, 5000);
                </script>
            </body>
            </html>";
        }
        // Success page redirection
        //echo "<meta http-equiv='refresh' content='0;url=./auth/user_dashboard.php'>";
        break;

    case 'failed':
        // Display failure message and redirect

        echo "<html>
        <head>
            <title>Purchase Failed</title>
            <style>
                body {
                    background: #f7fafc;
                    font-family: 'Segoe UI', Arial, sans-serif;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    margin: 0;
                }
                .fail-container {
                    background: #fff;
                    border-radius: 12px;
                    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
                    padding: 40px 32px;
                    text-align: center;
                }
                .fail-container h1 {
                    color: #e74c3c;
                    margin-bottom: 16px;
                    font-size: 2rem;
                }
                .fail-container p {
                    color: #333;
                    font-size: 1.1rem;
                    margin-bottom: 8px;
                }
                .counter {
                    font-weight: bold;
                    color: #e67e22;
                }
                .crossmark {
                    font-size: 3rem;
                    color: #e74c3c;
                    margin-bottom: 16px;
                    display: block;
                }
            </style>
        </head>
        <body>
            <div class='fail-container'>
                <span class='crossmark'>&#10008;</span>
                <h1>Your purchase could not be completed.</h1>
                <p>Redirecting to dashboard in <span class='counter'>5</span> seconds...</p>
            </div>
            <script>
                let countDown = 5;
                setInterval(() => {
                    countDown--;
                    document.querySelector('.counter').innerHTML = countDown;
                }, 1000);
                setTimeout(() => {
                    location.href = './auth/user_dashboard.php';
                }, 5000);
            </script>
        </body>
        </html>";
        break;

    case 'cancelled':
        // Display cancellation alert and redirect
        echo "<html><title>Payment Canceled</title><body>
                <script>
                    alert('Your payment was canceled. Please try again or choose another payment method.');
                    setTimeout(() => {
                        window.location.href = './auth/user_dashboard.php';
                    }, 3000);
                </script>
            </body></html>";
        break;

    default:
        echo "Unexpected payment status.";
        break;
}
