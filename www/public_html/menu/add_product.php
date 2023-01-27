<?php
session_start();
require '../db_config.php';

if (!isset($_SESSION["email"])) {
    header("Location: ../login_page.php?error=notloggedin");
}

if (isset($_POST["submit_product"])) {
    // add product to products
    $productname = $_POST["productname"];
    $product_type = $_POST["product_type"];
    $product_description = $_POST["product_description"];
    $product_price = $_POST["product_price"];
    $vegan = isset($_POST["vegan"]) ? 1 : 0;
    $vegetarian = isset($_POST["vegetarian"]) ? 1 : 0;
    $glutenfree = isset($_POST["glutenfree"]) ? 1 : 0;
    $lactosefree = isset($_POST["lactosefree"]) ? 1 : 0;

    if (!isset($productname) || !isset($product_type) || !isset($product_description) || !isset($product_price)) {
        header("Location: edit_menu.php?menu_id={$_SESSION['menu_id']}");
        exit();
    }

    // check if product_price is a integer
    if (!is_numeric($product_price)) {
        header("Location: edit_menu.php?menu_id={$_SESSION['menu_id']}");
        exit();
    }

    // use prepared statement to prevent sql injection
    $insertproductquery = mysqli_prepare($conn, "INSERT INTO products (name, type, description, price, vegan, vegetarian, gluten_free, lactose_free, restaurant_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param($insertproductquery, "sssiiiiii", $productname, $product_type, $product_description, $product_price, $vegan, $vegetarian, $glutenfree, $lactosefree, $_SESSION['db_id']);

    if (mysqli_stmt_execute($insertproductquery)) {
        echo "<p class='text-white-50 mb-3'>Product Added</p>";
    } else {
        echo "<p class='text-white-50 mb-3'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
    }

    // add product to menu
    $product_id = mysqli_insert_id($conn);
    $sql = "INSERT INTO menu_recipes (menu_id, product_id) VALUES ('{$_SESSION['menu_id']}', '$product_id')";
    if (!mysqli_query($conn, $sql)) {
        echo "<p class='text-white-50 mb-3'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
    }

    header("Location: edit_menu.php?menu_id={$_SESSION['menu_id']}");
}
