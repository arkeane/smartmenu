<!DOCTYPE html>

<head>
    <title>Edit Menu</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script defer src="./js/main.js"></script>
</head>

<?php
session_start();

include '../db_config.php';

if (!isset($_SESSION["email"])) {
    header("Location: login_page.php");
}

if (!isset($_GET["menu_id"])) {
    header("Location: /menu/add_menu.php");
}

// check if user owns the menu
$sql = "SELECT * FROM menus WHERE id='{$_GET['menu_id']}' AND restaurant_id='{$_SESSION['db_id']}'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0) {
    header("Location: /menu/add_menu.php");
}
?>

<body>
    
</body>

</html>