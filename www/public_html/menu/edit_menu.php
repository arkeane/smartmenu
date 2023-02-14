<!DOCTYPE html>
<html lang=en>

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

    <script defer src="../js/gpt_description.js"></script>
</head>

<?php

function printBool($bool)
{
    if ($bool == 1) {
        echo '<td>✅</td>';
    } else {
        echo '<td>❌</td>';
    }
}

session_start();

include '../db_config.php';

if (!isset($_SESSION["email"])) {
    header("Location: ../login_page.php?error=notloggedin");
}

if (!isset($_GET["menu_id"])) {
    header("Location: add_menu.php");
}

// check if user owns the menu
$sql = mysqli_prepare($conn, "SELECT * FROM menus WHERE id=? AND restaurant_id=?");
mysqli_stmt_bind_param($sql, "ii", $_GET['menu_id'], $_SESSION['db_id']);
mysqli_stmt_execute($sql);
$result = mysqli_stmt_get_result($sql);
if (mysqli_num_rows($result) == 0) {
    header("Location: add_menu.php");
}
$_SESSION["menu_id"] = $_GET["menu_id"];
?>

<body class="sitewide">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-md-1 mt-md-1 pb-1">

                                <?php
                                $sql = mysqli_prepare($conn, "SELECT template_id, name, id FROM menus WHERE id=?");
                                mysqli_stmt_bind_param($sql, "i", $_GET['menu_id']);
                                mysqli_stmt_execute($sql);
                                $result = mysqli_stmt_get_result($sql);
                                $row = mysqli_fetch_assoc($result);
                                $template_id = $row["template_id"];
                                $menu_name = $row["name"];
                                $menu_id = $row["id"];

                                // get template image
                                $sql = mysqli_prepare($conn, "SELECT image FROM templates WHERE id=?");
                                mysqli_stmt_bind_param($sql, "i", $template_id);
                                mysqli_stmt_execute($sql);
                                $result = mysqli_stmt_get_result($sql);
                                $row = mysqli_fetch_assoc($result);
                                $image = $row["image"];

                                echo '<img src="' . $image . '" alt="logo" width="100" class="mb-1">';
                                echo "<h2 class='fw-bold mb-2 text-uppercase'>$menu_name</h2>";
                                echo "<p class='text-white-50 mb-3'>Please Insert Products</p>";

                                ?>
                                <div class="table-responsive" style="border-radius: 1rem;">
                                    <table class="table table-dark table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Vegan</th>
                                                <th scope="col">Vegetarian</th>
                                                <th scope="col">Gluten Free</th>
                                                <th scope="col">Lactose Free</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-light">
                                            <?php

                                            $sql = mysqli_prepare($conn, "SELECT * FROM menu_recipes WHERE menu_id=?");
                                            mysqli_stmt_bind_param($sql, "i", $_SESSION['menu_id']);
                                            mysqli_stmt_execute($sql);
                                            $result = mysqli_stmt_get_result($sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $sql = mysqli_prepare($conn, "SELECT * FROM products WHERE id=?");
                                                mysqli_stmt_bind_param($sql, "i", $row['product_id']);
                                                mysqli_stmt_execute($sql);
                                                $result2 = mysqli_stmt_get_result($sql);
                                                $row2 = mysqli_fetch_assoc($result2);

                                                echo '<tr class="alert" role="alert">
                                                        <td>' . $row2["name"] . '</td>
                                                        <td>' . $row2["type"] . '</td>
                                                        <td>' . $row2["description"] . '</td>
                                                        <td>' . $row2["price"] . '</td>';

                                                printBool($row2["vegan"]);
                                                printBool($row2["vegetarian"]);
                                                printBool($row2["gluten_free"]);
                                                printBool($row2["lactose_free"]);

                                                echo '<td><a href="delete_product.php?product_id=' . $row2["id"] . '" class="btn btn-danger">Delete</a></td>';
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                                <?php
                                if (isset($_POST["add_product"])) {
                                    // retrieve token from secret_gpt_key.txt in public_html parent folder
                                    require("../secret_gpt_key.php");
                                    $token = $secret_gpt_key;
                                    echo '<form action="add_product.php" method="post" class="mt-3">
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="productname" id="productname" class="form-control form-control-lg" required placeholder="Product Name" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="product_type" id="product_type" class="form-control form-control-lg" required placeholder="Product Type" />
                                    </div>

                                    <div class="form-outline form-white mb-4 d-flex">
                                        <input type="text" name="product_description" id="product_description" class="form-control form-control-lg" required placeholder="Description" />
                                        <a class="btn btn-outline-light btn-lg" id="ai_desc" onclick="genDescription(\'' . $token . '\')">Generate AI description</a>
                                    </div>
                                    

                                    <div class="form-outline form-white mb-4">
                                        <input type="number" name="product_price" id="product_price" class="form-control form-control-lg" required placeholder="Price" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="checkbox" name="vegan" id="vegan"> Vegan</input>
                                        <input type="checkbox" name="vegetarian" id="vegetarian"> Vegetarian</input>
                                        <input type="checkbox" name="glutenfree" id="glutenfree"> Gluten Free</input>
                                        <input type="checkbox" name="lactosefree" id="lactosefree"> Lactose Free</input>
                                    </div>

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit_product" value="submit_product">Add Product</button>
                                    <a class="btn btn-outline-light btn-lg px-5" href="edit_menu.php?menu_id=' . $_SESSION["menu_id"] . '">Close</a>
                                    </form>';
                                } else {
                                    echo '<form action="" method="post" class="mt-3">
                                        <button class="btn btn-outline-light px-3" type="submit" name="add_product" value="add_product">New Product</button>
                                        <a class="btn btn-outline-light px-3" href="show_menu.php?menu_id=' . $_SESSION["menu_id"] . '">Show Menu</a>
                                    <a class="btn btn-outline-light px-3" href="../show_profile.php">Cancel</a>
                                    <a class="btn btn-danger px-3" href="delete_menu.php">Delete Menu</a>
                                </form>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>