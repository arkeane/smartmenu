<?php
include '../db_config.php';

session_start();

if (!isset($_SESSION["email"])) {
    header("Location: ../login_page.php?error=notloggedin");
}

if (isset($_POST['submit'])) {
    $menu_name = $_POST["menu_name"];
    $template_id = $_SESSION["template_id"];

    if(!isset($menu_name) || $menu_name == ""){
        die("Please fill in all fields");
    }

    // check if menu name is unique for restaurant_id
    $sql = mysqli_prepare($conn, "SELECT * FROM menus WHERE name=? AND restaurant_id=?");
    mysqli_stmt_bind_param($sql, "si", $menu_name, $_SESSION['db_id']);
    mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);
    if (mysqli_num_rows($result) > 0) {
        header("Location: add_menu.php?error=menu_name_exists");
        exit;
    }

    $sql = mysqli_prepare($conn, "INSERT INTO menus (name, restaurant_id, template_id) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($sql, "sii", $menu_name, $_SESSION['db_id'], $template_id);
    if (!mysqli_stmt_execute($sql)) {
        echo "Error inserting data: " . mysqli_error($conn);
        exit;
    }

    // destroy session variable
    unset($_SESSION["template_id"]);
    header("Location: edit_menu.php?menu_id=" . mysqli_insert_id($conn));
}
