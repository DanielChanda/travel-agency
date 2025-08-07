<?php

include_once("../../app/_dbConnection.php");

if (isset($_POST['package_name']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['price']) && isset($_POST['capacity'])) {

    $package_name = $_POST['package_name'];
    $package_desc = $_POST['package_desc'];
    $package_start = $_POST['start'];
    $package_end = $_POST['end'];
    $package_price = $_POST['price'];
    $package_capacity = $_POST['capacity'];
    $package_location = $_POST['loc'];
    

    $is_hotel = 0;
    $is_transport = 0;
    $is_food = 0;
    $is_guide = 0;
    $features = array();

    if (isset($_POST['features'])) {
        $features = $_POST['features'];
    }
    foreach ($features as $feature) {
        if ($feature == 'hotel') $is_hotel = 1;
        else if ($feature == 'transport') $is_transport = 1;
        else if ($feature == 'food') $is_food = 1;
        else if ($feature == 'guide') $is_guide = 1;
    }

    // Handle image uploads
    $uploadDir = "../../img/";
    $uploadedFiles = [];

    foreach (['master-img', 'ex1', 'ex2'] as $inputName) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == 0) {
            $fileName = basename($_FILES[$inputName]['name']);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            // Validate file type
            if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetFilePath)) {
                    $uploadedFiles[$inputName] = $targetFilePath;
                } else {
                    die("Error uploading $inputName.");
                }
            } else {
                die("Invalid file type for $inputName.");
            }
        } else {
            $uploadedFiles[$inputName] = ''; // Optional: Handle if an image isn't provided
        }
    }

    // Remove "../../" from the path before saving to the database
    foreach ($uploadedFiles as $key => $path) {
        if (!empty($path)) {
            $uploadedFiles[$key] = str_replace("../../", "", $path);
        }
    }
    // Get image paths
    $master_image = $uploadedFiles['master-img'];
    $extra_image_1 = $uploadedFiles['ex1'];
    $extra_image_2 = $uploadedFiles['ex2'];

    // Create package in database
    $packagesInstance = new Packages();
    $packagesInstance->createPackage($package_name, $package_desc, $package_start, $package_end, $package_price, $package_location, $is_hotel, $is_transport, $is_food, $is_guide, $package_capacity,$master_image, $extra_image_1, $extra_image_2);

    echo "<script> location.href = '../packages.php' </script>";
}
