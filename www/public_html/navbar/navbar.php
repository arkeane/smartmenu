<nav class="navbar navbar-dark bg-dark navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <img class="mx-3" src="/~S4832423/img/default.svg" alt="Smartmenu Logo" width="30" height="30">
        <?php
        $pagename = basename($_SERVER['PHP_SELF']);
        if ($pagename == "index.php") {
            echo '<a class="navbar-brand" href="index.php">SmartMenu</a>';
        } else {
            echo '<a class="navbar-brand" href="/~S4832423/index.php">HOME</a>';
        }
        ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php

                if (isset($_SESSION["email"])) {
                    echo '
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/~S4832423/show_profile.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/~S4832423/logout.php">Logout</a>
                            </li>';
                } else {
                    echo '
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/~S4832423/login_page.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/~S4832423/registration_page.php">Registration</a>
                            </li>';
                }
                ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/~S4832423/market/market.php">Template Market</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/~S4832423/about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/~S4832423/contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>