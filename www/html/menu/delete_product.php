<?php
session_start();

include '../db_config.php';

if (!isset($_SESSION["email"])) {
    header("Location: login_page.php");
}

if(isset($_GET['product_id'])){
    // delete product
    $product_id = $_GET['product_id'];
    $sql = "DELETE FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);

    header("Location: edit_menu.php?menu_id=$_SESSION[menu_id]");
}

?>