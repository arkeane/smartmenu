<!DOCTYPE html>

<head>
    <title>SmartMenu</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="/css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script defer src="./js/main.js"></script>
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <img class="mx-3" src="./img/pizza.svg" alt="logo" width="30" height="30">
                <a class="navbar-brand" href="index.php">SmartMenu</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <?php
                    session_start();

                    if (isset($_SESSION["email"])) {
                        echo '<ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="show_profile.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="Logout.php">Logout</a>
                            </li>
                        </ul>';
                    } else {
                        echo '<ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="login.html">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="registration.html">Registration</a>
                            </li>
                        </ul>';
                    }
                    ?>

                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>


    <footer class="fixed-bottom bg-dark">
        <!-- Copyright -->
        <div class="container-fluid text-center mt-3">
            <p class="text-light">© 2023 Copyright: SmartMenu</p>
        </div>
        <!-- Copyright -->
    </footer>
</body>