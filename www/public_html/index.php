<!DOCTYPE html>
<html lang=en>

<head>
    <title>SmartMenu</title>

    <!-- language -->
    

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>

<body class="sitewide">
    <header class="header">
        <?php
        session_start();
        include 'navbar/navbar.php';
        ?>
    </header>

    <section class="gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-md-1 mt-md-1 pb-1">
                                <h1 class="fw-bold mb-1 text-uppercase">Welcome to Smart Menu</h1>
                                <a href="smartmenu.pdf" class="btn btn-outline-light btn-lg" role="button" aria-pressed="true">Learn more</a>
                                <div class="card-group">
                                    <div class="card bg-dark p-4">
                                        <img src="img/collage_menu.png" class="card-img-top" alt="Menu Creation">
                                        <div class="card-body">
                                            <h5 class="card-title">Create Unlimited Free Menus</h5>
                                            <p class="card-text">You can create a menu based on templates and add productes with ease!</p>
                                        </div>
                                    </div>
                                    <div class="card bg-dark p-4">
                                        <img src="img/collage_template.png" class="card-img-top" alt="Template Market">
                                        <div class="card-body">
                                            <h5 class="card-title">Buy More Icons</h5>
                                            <p class="card-text">Buy all the Menu Icons that you like, Every now and then more Icons will be added, a Newsletter will be sent!</p>
                                        </div>
                                    </div>
                                    <div class="card bg-dark p-4">
                                        <img src="img/collage_qr.png" class="card-img-top" alt="QR-Code sharing">
                                        <div class="card-body">
                                            <h5 class="card-title">Share you menu with customers</h5>
                                            <p class="card-text">Easilly share your menu in your restaurant with the downloadable QR-Code</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer class="fixed-bottom bg-dark">
        <!-- Copyright -->
        <div class="container-fluid text-center mt-3">
            <p class="text-light">© 2023 Copyright: SmartMenu</p>
        </div>
        <!-- Copyright -->
    </footer>
</body>