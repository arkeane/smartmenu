<!DOCTYPE html>
<html lang=en>

<head>
    <title>Crowdfunding</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>

<?php
session_start();
include '../db_config.php';
include '../navbar/navbar.php';

function printBool($bool)
{
    if ($bool == 1) {
        return '✅';
    } else {
        return '❌';
    }
}

if (isset($_POST["submit"])) {
    if (empty($_POST['submit'])) {
        exit;
    }
    $value = $_POST['submit'];
    if ($value === "custom") {
        if (!isset($_POST['custom_value']) || empty($_POST['custom_value'])) {
            $value = 0;
        } else {
            $value = $_POST['custom_value'];
        }
    }

    $sql = mysqli_prepare($conn, "UPDATE crowdfunding SET current_amount = current_amount + ? ORDER BY id DESC LIMIT 1");
    mysqli_stmt_bind_param($sql, "i", $value);
    if (!mysqli_stmt_execute($sql)) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $sql = mysqli_prepare($conn, "SELECT current_amount,goal FROM crowdfunding ORDER BY id DESC LIMIT 1");
    mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);
    $row = mysqli_fetch_assoc($result);
    if ($row["current_amount"] >= $row["goal"]) {
        $sql = mysqli_prepare($conn, "UPDATE crowdfunding SET success = true ORDER BY id DESC LIMIT 1");
        mysqli_stmt_execute($sql);
    }
}


?>

<body class="sitewide">
    <section class="gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-md-1 mt-md-1 pb-1">
                                <h1 class="fw-bold mb-1 text-uppercase">CrowdFunding</h1>

                                <?php

                                $sql = mysqli_prepare($conn, "SELECT * FROM crowdfunding ORDER BY id DESC LIMIT 1");
                                mysqli_stmt_execute($sql);
                                $result = mysqli_stmt_get_result($sql);
                                if (mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    $success = printBool($row["success"]);
                                    echo '<div class="align-items-center card bg-dark text-light">
                                        <div class="card-body">
                                            <h2 class="card-title">' . $row["title"] . '</h2>
                                            <p class="card-text">' . $row["description"] . '</p>
                                            <p class="card-text">' . $row["current_amount"] . '$/' . $row["goal"] . '$</p>
                                            <p class="card-text"> STATUS ' . $success . '</p>
                                            <p class="card-text"> DEADLINE -> ' . $row["end_date"] . '</p>
                                        </div>  
                                    </div> ';
                                    if ($row["end_date"] < date("Y-m-d")) {
                                        echo '<div class="alert alert-danger" role="alert">
                                        This crowdfunding is expired!
                                        </div>';
                                    } else {
                                        echo '<form action="" method="post">
                                        <div class="input-group mb-3">
                                            <button class="btn btn-outline-secondary" type="submit" name="submit" value="100">+100$</button>
                                            <button class="btn btn-outline-secondary" type="submit" name="submit" value="1000">+1000$</button>
                                            <input type="number" class="form-control" name="custom_value" placeholder="Other value">
                                            <button class="btn btn-outline-secondary" type="submit" name="submit" value="custom">Donate</button>
                                        </div>
                                    </form>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger mt-3" role="alert">
                                    There is no crowdfunding yet!
                                    </div>';
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