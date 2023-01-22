<?php

session_start();
require '../db_config.php';

if(!isset($_POST["submit"])) {
    exit;
}

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$creditcard = $_POST["creditcard"];
$cvv = $_POST["cvv"];
$expiration = $_POST["exp"];

// get cart
$cart = json_decode($_COOKIE["cart"], true);

// get user id
$user_id = $_SESSION["db_id"];

// for each template in cart add to bought_templates
foreach($cart as $template_id) {
    $sql = mysqli_prepare($conn, "INSERT INTO bought_templates(restaurant_id, template_id) VALUES(?,?)");
    mysqli_stmt_bind_param($sql, "ii", $user_id, $template_id);
    if (!mysqli_stmt_execute($sql)) {
        echo "Error inserting data: " . mysqli_error($conn);
        exit;
    }

    // delete cart 
    setcookie("cart", "", time() - 3600, "/");

    // redirect to user profile
    header("location: ../show_profile.php");
}