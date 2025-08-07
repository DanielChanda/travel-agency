<?php
include_once "../app/_dbConnection.php";

if (isset($_POST['package_id'])) {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (empty($_SESSION["logged_in"])) {
        http_response_code(403);
        exit;
    }

    // Check if the package is already finished or not
    $package_id = $_POST['package_id'];
    $packagesInstance = new Packages();
    $res = $packagesInstance->getPackage($package_id);
    $row = mysqli_fetch_assoc($res);

    if (!$row) {
        http_response_code(404);
        exit;
    }

    $package_start = $row['package_start'];
    $curr_date = date("Y-m-d");

    // Calculate the difference in days
    $datetime1 = strtotime($package_start);
    $datetime2 = strtotime($curr_date);

    $diff = ($datetime1 - $datetime2) / 86400;
    echo $diff;
    if ($diff < 1) {
        http_response_code(406);
        exit;
    }

    // Check if package is already full or not
    $package_capacity = $row['package_capacity'];
    $package_booked = $row['package_booked'];
    $available_slots = $package_capacity - $package_booked;

    echo json_encode($available_slots);
}
