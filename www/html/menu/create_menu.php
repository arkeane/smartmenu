<?php
include '../db_config.php';

session_start();

if (!isset($_SESSION["email"])) {
    die("You are not logged in");
}

if (isset($_POST['submit'])) {
    $menu_name = $_POST["menu_name"];
    $template_id = $_SESSION["template_id"];

    if(!isset($menu_name) || $menu_name == ""){
        die("Please fill in all fields");
    }

    $menu_name = mysqli_real_escape_string($conn, $menu_name);

    // check if menu name is unique for restaurant_id 
    $sql = "SELECT * FROM menus WHERE name='$menu_name' AND restaurant_id='{$_SESSION['db_id']}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        header("Location: add_menu.php?error=menu_name_exists");
        exit;
    }

    $sql = "INSERT INTO menus (name, restaurant_id, template_id) VALUES ('$menu_name', '$_SESSION[db_id]', '$template_id')";
    mysqli_query($conn, $sql);

    // destroy session variable
    unset($_SESSION["template_id"]);
    header("Location: edit_menu.php?menu_id=" . mysqli_insert_id($conn));
}
?>