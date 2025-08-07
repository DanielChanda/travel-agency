<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once("../../app/_dbConnection.php");


if (isset($_POST['package_id']) && isset($_POST['package_name']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['price']) && isset($_POST['capacity']) && isset($_POST['loc']) && isset($_FILES['master-img'])) {

    $package_id = $_POST['package_id'];
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

    if ((isset($_POST['features']))) {
        $features = $_POST['features'];
    }
    
    foreach ($features as $feature) {
        if ($feature == 'hotel') $is_hotel = 1;
        else if ($feature == 'transport') $is_transport = 1;
        else if ($feature == 'food') $is_food = 1;
        else if ($feature == 'guide') $is_guide = 1;
    }
    // Handle image uploads
    function handle_upload($input_name, $existing_path = null) {
        $uploadDir = '../../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$input_name]['tmp_name'];
            $fileName = basename($_FILES[$input_name]['name']);
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (in_array($fileExt, $allowed)) {
                $newFileName = uniqid() . '_' . $fileName;
                $dest = $uploadDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $dest)) {
                    // Return relative path for DB
                    return 'uploads/' . $newFileName;
                }
            }
        }
        // If no new upload, keep existing
        return $existing_path;
    }

    // Get existing image paths from hidden fields (if any)
    $existing_master = isset($_POST['existing_master']) ? $_POST['existing_master'] : '';
    $existing_ex1 = isset($_POST['existing_ex1']) ? $_POST['existing_ex1'] : '';
    $existing_ex2 = isset($_POST['existing_ex2']) ? $_POST['existing_ex2'] : '';
    
    $master_image = handle_upload('master-img', $existing_master);
    $extra_image_1 = handle_upload('ex1', $existing_ex1);
    $extra_image_2 = handle_upload('ex2', $existing_ex2);

    $packagesInstance = new Packages();

    $packagesInstance->updatePackage(
        $package_id, $package_name, $package_desc, $package_start, $package_end,
        $package_price, $package_location, $is_hotel, $is_transport, $is_food, $is_guide,
        $package_capacity, $master_image, $extra_image_1, $extra_image_2
    );

    echo "<script> location.href = '../packages.php' </script>";
}
