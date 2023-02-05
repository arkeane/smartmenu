<!DOCTYPE html>
<html lang=en>

<head>
    <title>Cart</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>

<body class="sitewide">
    <header class="header">
        <?php
        session_start();
        require '../db_config.php';
        ?>
    </header>

    <section class="vh-100 gradient-custom">
        <div class="container-flex mt-4 mx-4">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <div class="mb-md-5 mt-md-4 pb-5">
                                    <h1 class="fw-bold mb-2 text-uppercase">Cart</h1>
                                    <?php
                                    // check if cookie is set
                                    if (!isset($_COOKIE["cart"])) {
                                        echo "<p class='text'>Your cart is empty.</p>";
                                    } else {
                                        echo '<table class="table table-dark table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Template</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-light">';
                                        $cart = json_decode($_COOKIE["cart"], true);
                                        $total = 0;
                                        foreach ($cart as $template_id) {
                                            $sql = mysqli_prepare($conn, "SELECT * FROM templates WHERE id = ?");          
                                            mysqli_stmt_bind_param($sql, "i", $template_id);
                                            mysqli_stmt_execute($sql);
                                            $result = mysqli_stmt_get_result($sql);
                                            $row = mysqli_fetch_assoc($result);
                                            $template_name = $row["name"];
                                            $template_price = $row["price"];
                                            $total += $template_price;
                                            echo "<tr>";
                                            echo "<td>$template_name</td>";
                                            echo "<td>€$template_price</td>";
                                            echo "<td><a class='btn btn-danger' href='remove_from_cart.php?template_id=$template_id'>Remove</a></td>";//cancella uno alla volta dal carrello
                                        }
                                        echo "</tbody></table><h1 class='text'>Total: €$total</h1>";
                                        echo '<form action="checkout.php" method="post">
                                        <button class="btn btn-outline-light btn-lg px-5 mt-3" type="submit" name="submit" value="submit">Checkout</button>
                                        </form>';
                                    }
                                    ?>

                                    <a class="btn btn-outline-light btn-lg px-5 mt-3" href="market.php">Return to Market</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>