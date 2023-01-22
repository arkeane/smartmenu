<!-- http(s)://api.qrserver.com/v1/create-qr-code/?data=[URL-encoded-text]&size=[pixels]x[pixels] -->

<!DOCTYPE html>
<html lang=en>

<head>
    <title>Menu</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


</head>

<body class="menu">

    <?php
    session_start();
    require '../db_config.php';

    // check if user is logged in
    if (isset($_SESSION["email"])) {

        // check if user is menu owner
        $sql = mysqli_prepare($conn, "SELECT * FROM menus WHERE id=?");
        mysqli_stmt_bind_param($sql, "i", $_GET["menu_id"]);
        mysqli_stmt_execute($sql);
        $result = mysqli_stmt_get_result($sql);
        $menu = mysqli_fetch_assoc($result);
        $restaurant_id = $menu["restaurant_id"];

        if ($_SESSION["db_id"] == $restaurant_id) {
            include '../navbar/navbar.php';
            // create qr code with link to this menu
            $qrcode = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode("https://saw21.dibris.unige.it/~S4832423/menu/show_menu.php?menu_id=" . $_GET["menu_id"]) . "&size=200x200";

            echo '<div class="container-flex p-2 text-center"><h1 class="text-light">QR-Code</h1>';

            // show image 
            echo '<img src="' . $qrcode . '" alt="QR Code" class="img-fluid p-3 img-thumbnail"><br>';

            // download button
            echo '<a href="' . $qrcode . '" download="QR-Code.png" class="btn btn-dark btn-outline-light btn-lg">Download</a>';
        }
    }

    ?>

    <div class="container-flex p-5">
        <div class="card bg-dark mx-auto container-sm text-center">
            <div class="card-body container-flex p2 text-center">
                <?php
                // print menu Icon and menu name
                $sql = mysqli_prepare($conn, "SELECT * FROM menus WHERE id=?");
                mysqli_stmt_bind_param($sql, "i", $_GET["menu_id"]);
                mysqli_stmt_execute($sql);
                $result = mysqli_stmt_get_result($sql);
                $menu = mysqli_fetch_assoc($result);
                $menu_name = $menu["name"];
                $menu_id = $menu["id"];

                // get menu icon from templates table
                $sql = mysqli_prepare($conn, "SELECT * FROM templates WHERE id=?");
                mysqli_stmt_bind_param($sql, "i", $menu["template_id"]);
                mysqli_stmt_execute($sql);
                $result = mysqli_stmt_get_result($sql);
                $template = mysqli_fetch_assoc($result);
                $menu_icon = $template["image"];

                // get restaurant name
                $sql = mysqli_prepare($conn, "SELECT * FROM users WHERE id=?");
                mysqli_stmt_bind_param($sql, "i", $menu["restaurant_id"]);
                mysqli_stmt_execute($sql);
                $result = mysqli_stmt_get_result($sql);
                $restaurant = mysqli_fetch_assoc($result);
                $restaurant_name = $restaurant["restaurant_name"];

                echo '<img src="' . $menu_icon . '" alt="logo" width="100" class="p-2">';
                echo '<h1 class="text-light">' . $menu_name . '</h1>';
                echo '<h2 class="text text-light">' . $restaurant_name . '</h2>';

                ?>
            </div>
            <h6 class="text-light">Informations</h6>
            <ul class="list text-light">
                <li>🌱 = Vegan</li>
                <li>🥗 = Vegetarian</li>
                <li>🥖</i> = Contains Gluten</li>
                <li>🥛 = Contains Lactose</li>
            </ul>
        </div>
    </div>
    </div>
    <div class="container-flex p-4">
        <?php

        // get all menu items
        $sql = mysqli_prepare($conn, "SELECT * FROM menu_recipes WHERE menu_id=?");
        mysqli_stmt_bind_param($sql, "i", $_GET["menu_id"]);
        mysqli_stmt_execute($sql);
        $result = mysqli_stmt_get_result($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            // get product
            $sql = mysqli_prepare($conn, "SELECT * FROM products WHERE id=?");
            mysqli_stmt_bind_param($sql, "i", $row["product_id"]);
            mysqli_stmt_execute($sql);
            $result2 = mysqli_stmt_get_result($sql);
            $product = mysqli_fetch_assoc($result2);
            echo '<div class="card bg-dark text-light mb-3" style="max-width: device-width;">
                <div class="row g-0">
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">' . $product["name"] . '</h5>
                            <h6 class="card-text">' . $product["type"] . '</h6>
                            <p class="card-text"><small class="text-muted">' . $product["description"] . '</small></p>
                            <ul class="list-inline">';
            if ($product["vegan"] == 1) {
                echo '<li class="list-inline-item small">🌱</i></li>';
            }
            if ($product["vegetarian"] == 1) {
                echo '<li class="list-inline-item small">🥗</i></li>';
            }
            if ($product["gluten_free"] == 0) {
                echo '<li class="list-inline-item small">🥖</i></li>';
            }
            if ($product["lactose_free"] == 0) {
                echo '<li class="list-inline-item small">🥛</li>';
            }
            echo '</ul>
                            <p class="card-text">' . $product["price"] . ' €</p>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</body>