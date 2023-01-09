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
$_SESSION["menu_id"] = $_GET["menu_id"];
?>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-md-1 mt-md-1 pb-1">
                                <img src="../img/pizza.svg" alt="logo" width="100" class="mb-1">
                                <?php
                                $sql = "SELECT restaurant_name FROM users WHERE id='{$_SESSION['db_id']}'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                echo "<h2 class='fw-bold mb-2 text-uppercase'>{$row['restaurant_name']}</h2>";
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

                                            $sql = "SELECT * FROM menu_recipes WHERE menu_id='{$_SESSION['menu_id']}'";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $sql = "SELECT * FROM products WHERE id='{$row['product_id']}'";
                                                $result2 = mysqli_query($conn, $sql);
                                                $row2 = mysqli_fetch_assoc($result2);

                                                echo '<tr class="alert" role="alert">
                                                        <td>' . $row2["name"] . '</td>
                                                        <td>' . $row2["type"] . '</td>
                                                        <td>' . $row2["description"] . '</td>
                                                        <td>' . $row2["price"] . '</td>';

                                                if ($row2["vegan"] == 1) {
                                                    echo '<td>✅</td>';
                                                } else {
                                                    echo '<td>❌</td>';
                                                }

                                                if ($row2["vegetarian"] == 1) {
                                                    echo '<td>✅</td>';
                                                } else {
                                                    echo '<td>❌</td>';
                                                }

                                                if ($row2["gluten_free"] == 1) {
                                                    echo '<td>✅</td>';
                                                } else {
                                                    echo '<td>❌</td>';
                                                }

                                                if ($row2["lactose_free"] == 1) {
                                                    echo '<td>✅</td>';
                                                } else {
                                                    echo '<td>❌</td>';
                                                }

                                                echo '<td><a href="/menu/delete_product.php?product_id=' . $row2["id"] . '" class="btn btn-danger">Delete</a></td>';
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                                <?php
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
                                        echo "<p class='text-white-50 mb-3'>Please fill all fields</p>";
                                        exit();
                                    }

                                    $productname = mysqli_real_escape_string($conn, $productname);
                                    $product_type = mysqli_real_escape_string($conn, $product_type);
                                    $product_description = mysqli_real_escape_string($conn, $product_description);
                                    $product_price = mysqli_real_escape_string($conn, $product_price);

                                    $sql = "INSERT INTO products (name, type, description, price, vegan, vegetarian, gluten_free, lactose_free, restaurant_id) VALUES ('$productname', '$product_type', '$product_description', '$product_price', '$vegan', '$vegetarian', '$glutenfree', '$lactosefree', '{$_SESSION['db_id']}')";
                                    if (mysqli_query($conn, $sql)) {
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

                                    header("Location: /menu/edit_menu.php?menu_id={$_SESSION['menu_id']}");
                                }
                                if (isset($_POST["add_product"])) {
                                    echo '<form action="" method="post" class="mt-3">
                                        <div class="form-outline form-white mb-4">
                                            <input type="text" name="productname" id="productname" class="form-control form-control-lg" required placeholder="Product Name" />
                                        </div>
                                    
                                        <div class="form-outline form-white mb-4">
                                            <input type="text" name="product_type" id="product_type" class="form-control form-control-lg" required placeholder="Product Type" />
                                        </div>
                                    
                                        <div class="form-outline form-white mb-4">
                                            <input type="text" name="product_description" id="product_description" class="form-control form-control-lg" required placeholder="Description" />
                                        </div>
                                    
                                        <div class="form-outline form-white mb-4">
                                            <input type="text" name="product_price" id="product_price" class="form-control form-control-lg" required placeholder="Price" />
                                        </div>
                                    
                                        <div class="form-outline form-white mb-4">
                                            <input type="checkbox" name="vegan" id="vegan"> Vegan</input>
                                            <input type="checkbox" name="vegetarian" id="vegetarian"> Vegetarian</input>
                                            <input type="checkbox" name="glutenfree" id="glutenfree"> Gluten Free</input>
                                            <input type="checkbox" name="lactosefree" id="lactosefree"> Lactose Free</input>
                                        </div>
                                    
                                        <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit_product" value="submit_product">Add Product</button>
                                        <a class="btn btn-outline-light btn-lg px-5" href="/menu/edit_menu.php?menu_id=' . $_SESSION["menu_id"] . '">Close</a>
                                    </form>';
                                } else {
                                    echo '<form action="" method="post" class="mt-3">
                                        <button class="btn btn-outline-light px-3" type="submit" name="add_product" value="add_product">New Product</button>
                                        <a class="btn btn-outline-light px-3" href="show_menu.php">Show Menu</a>
                                        <a class="btn btn-outline-light px-3" href="../show_profile.php">Cancel</a>
                                        <a class="btn btn-danger px-3" href="/menu/delete_menu.php">Delete Menu</a>
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