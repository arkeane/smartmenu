<!DOCTYPE html>
<html lang=en>

<head>
    <title>Market</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Fa star icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script defer src="../js/market.js"></script>
</head>

<body class="sitewide">
    <header class="header">
        <?php
        session_start();
        require '../db_config.php';
        include '../navbar/navbar.php';
        ?>
    </header>

    <h1 class="text-center mt-3 text-light">Buy a template</h1>

    <div class="container-fluid text-center p-3 d-flex">
        <form class="container-fluid text-center p-3 d-flex" action="" method="post">
            <input class="form-control me-2" type="text" name="searchbar" id="searchbar" placeholder="Search">
            <button class="btn btn-dark btn-outline-light btn-lg" type="submit" name="search" value="search">Search</button>
        </form>
    </div>

    <?php
    if (isset($_COOKIE["cart"])) {
        $cart = json_decode($_COOKIE["cart"], true);
    } else {
        $cart = array();
    }

    $cart_count = count($cart);
    ?>

    <div class="container-fluid text-center p-3">
        <label for="cart_counter" class="h3  text-light">Go To Cart </label><br>
        <a href="cart.php" class="btn btn-dark btn-outline-light btn-lg px-5"> 🛒: <span class="text text-red" id="cart_counter"><?php echo "$cart_count"; ?></span></a>
    </div>

    <div class="container-fluid p-4">
        <?php

        if (isset($_POST["search"])) {

            if (!isset($_POST["searchbar"]) || $_POST["searchbar"] == "") {
                header("Location: market.php?error=invalidsearch_empty");
                exit();
            } else {
                echo '<h1 class="text-center mt-3 text-light">Search results for "' . $_POST["searchbar"] . '"</h1>';
                $search = $_POST["searchbar"];
            }
            $search = mysqli_real_escape_string($conn, $search);
        }

        $sql = mysqli_prepare($conn, "SELECT * FROM templates");
        mysqli_stmt_execute($sql);
        $result = mysqli_stmt_get_result($sql);
        while ($row = mysqli_fetch_assoc($result)) {

            if (!isset($_SESSION["db_id"])) {
                $db_id = 0;
            } else {
                $db_id = $_SESSION["db_id"];
            }

            $already_bought = false;
            $sql = mysqli_prepare($conn, "SELECT * FROM bought_templates WHERE restaurant_id = ?");
            mysqli_stmt_bind_param($sql, "i", $db_id);
            mysqli_stmt_execute($sql);
            $result2 = mysqli_stmt_get_result($sql);
            while ($row2 = mysqli_fetch_assoc($result2)) {
                if ($row2["template_id"] == $row["id"]) {
                    $already_bought = true;
                }
            }

            $already_in_cart = false;
            if ($cart != null) {
                foreach ($cart as $key => $value) {
                    if ($value == $row["id"]) {
                        $already_in_cart = true;
                    }
                }
            }

            if (isset($_POST["search"])) {
                $search = strtolower(htmlspecialchars($search));
                $name = strtolower(htmlspecialchars($row["name"]));
                $description = strtolower(htmlspecialchars($row["description"]));
                // check if the template contains the search string in the name or description
                if (strpos($name, $search) === false && strpos($description, $search) === false) {
                    continue;
                }
            }

            // get the average rating of the template
            $sql = mysqli_prepare($conn, "SELECT AVG(rating) AS average FROM evaluations WHERE template_id = ?");
            mysqli_stmt_bind_param($sql, "i", $row["id"]);
            mysqli_stmt_execute($sql);
            $avgresult = mysqli_stmt_get_result($sql);
            $avgrow = mysqli_fetch_assoc($avgresult);
            $rating = $avgrow["average"];
            // convert rating to 1 decimal place
            if ($rating == null) {
                $rating = "No Reviews Yet";
            } else {
                $rating = round($rating, 1);
            }

            // count the number of evaluations made by the user for the template
            $sql = mysqli_prepare($conn, "SELECT * FROM evaluations WHERE template_id = ? AND restaurant_id = ?");
            
            mysqli_stmt_bind_param($sql, "ii", $row["id"], $db_id);
            mysqli_stmt_execute($sql);
            $evalresult = mysqli_stmt_get_result($sql);
            $evalcount = mysqli_num_rows($evalresult);
            if ($evalcount > 0) {
                $evaluated = "true";
            } else {
                $evaluated = "false";
            }

            if ($row["id"] == 1) {
                continue;
            } else if ($already_bought === true) {
                echo '<div class="card card bg-dark text-white mt-3" style="max-width: device-width;">
            <div class="row g-0">
                <div class="col-md-2 text-center">
                    <img src="' . $row["image"] . '" class="img-fluid p-4 mx-auto " alt="template_image">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"> ' . $row["name"] . '</h5>
                        <p class="card-text">' . $row["description"] . '</p>
                        <p class="card-text rating" id="rating' . $row["id"] . '">' . $rating . '</p>
                    </div>
                </div>
                <div class="container-fluid text-center p-3 card-footer">
                    <p class="card-text">Price: ' . $row["price"] . '€</p>
                    <p class="card-text" id="isadded' . $row["id"] . '">Already Bought</p>
                    <form style="display:none" id="rateform' . $row["id"] . '" action="evaluate.php" method="post">
                        <input type="hidden" name="template_id" value="' . $row["id"] . '">
                        <div class="form-outline form-white mb-4">
                            <input type="number" name="rating" id="rating" class="form-control form-control-lg" required placeholder="Rating (1-5)"/>
                        </div>
                        <button type="submit" id="submitrating" name="submitrating" class="btn btn-dark btn-outline-light btn-lg" value="submitrating">Send Review</button>
                    </form>
                    <button type="button" id="evaluate' . $row["id"] . '" name="evaluate" class="btn btn-dark btn-outline-light btn-lg" value="evaluate" onclick="Evaluate(\'' . $evaluated . '\', \'' . $row["id"] . '\')">Leave a Review</button>
                </div>
                </div>
            </div>';
            } else if ($already_in_cart === true) {
                echo '<div class="card card bg-dark text-white mt-3" style="max-width: device-width;">
            <div class="row g-0">
                <div class="col-md-2 text-center">
                    <img src="' . $row["image"] . '" class="img-fluid p-4 mx-auto " alt="template_image">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"> ' . $row["name"] . '</h5>
                        <p class="card-text">' . $row["description"] . '</p>
                        <p class="card-text rating" id="rating' . $row["id"] . '">' . $rating . '</p>
                    </div>
                </div>
                <div class="container-fluid text-center p-3 card-footer">
                    <p class="card-text">Price: ' . $row["price"] . '€</p>
                    <p class="card-text" id="isadded' . $row["id"] . '">Already in Cart</p>
                </div>
                </div>
            </div>';
            } else {
                echo '<div class="card card bg-dark text-white mt-3" style="max-width: device-width;">
            <div class="row g-0">
                <div class="col-md-2 text-center">
                    <img src="' . $row["image"] . '" class="img-fluid p-4 mx-auto" alt="template_image">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"> ' . $row["name"] . '</h5>
                        <p class="card-text">' . $row["description"] . '</p>
                        <p class="card-text rating" id="rating' . $row["id"] . '">' . $rating . '</p>
                    </div>
                </div>
                <div class="container-fluid text-center p-3 card-footer">
                    <p class="card-text">Price: ' . $row["price"] . '€</p>
                    <p class="card-text" id="isadded' . $row["id"] . '"></p>
                    <button type="button" id="addtocart' . $row["id"] . '" name="submit" class="btn btn-dark btn-outline-light btn-lg" value="' . $row["id"] . '" onclick="addToCart(this.value)">Add to cart</button>
                </div>
                </div>
            </div>';
            }
        }

        ?>
    </div>

    <footer class="fixed-bottom bg-dark">
        <!-- Copyright -->
        <div class="container-fluid text-center mt-3">
            <p class="text-light">© 2023 Copyright: SmartMenu</p>
        </div>
        <!-- Copyright -->
    </footer>
</body>