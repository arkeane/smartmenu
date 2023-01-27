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

<body class="sitewide">

    <?php
    session_start();
    require '../db_config.php';
    include '../navbar/navbar.php';

    ?>
    <h1 class="text-center text-light mt-5">Blog</h1>

    <div class="container-flex p-4">
        <?php

        // get all menu items
        $sql = mysqli_prepare($conn, "SELECT * FROM blog ORDER BY id DESC");
        mysqli_stmt_execute($sql);
        $result = mysqli_stmt_get_result($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="card bg-dark text-light mb-3" style="max-width: device-width;">
                <div class="row g-0">
                    <div class="col-md-8">
                        <div class="card-body">
                            <h2 class="card-title">' . $row["title"] . '</h2>
                            <h6 class="card-subtitle mb-2 text-muted">' . $row["post_date"] . '</h6>
                            <p class="card-text text-muted">' . $row["content"] . '</p>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</body>