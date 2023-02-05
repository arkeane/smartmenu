<!DOCTYPE html>
<html lang=en>

<head>
    <title>Profile</title>

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
    <?php
    session_start();
    include 'db_config.php';

    if (!isset($_SESSION["email"])) {
        header("Location: login_page.php?error=notloggedin");
    }

    if (isset($_POST['submit'])) {
        if(!isset($_POST["firstname"]) || !isset($_POST["lastname"]) || !isset($_POST["email"]) || empty($_POST["firstname"]) || empty($_POST["lastname"]) || empty($_POST["email"])){
            header("Location: update_profile.php?error=emptyfields");
            exit;
        }
        
        $restaurantname = $_POST["restaurantname"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];

        // filter email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: update_profile.php?error=invalidemail");
            exit;
        }

        $sql = mysqli_prepare($conn, "UPDATE users SET restaurant_name=?, firstname=?, lastname=?, email=? WHERE email=?");
        mysqli_stmt_bind_param($sql, "sssss", $restaurantname, $firstname, $lastname, $email, $_SESSION["email"]);
        mysqli_stmt_execute($sql);

        //unset leva specifica variabile dalla sessione
        unset($_SESSION["restaurant_name"]);
        unset($_SESSION["firstname"]);
        unset($_SESSION["lastname"]);
        $_SESSION["email"] = $email;
        header("Location: show_profile.php");
    }
    ?>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <img src="img/default.svg" alt="logo" width="100" class="mb-4">
                                <h2 class="fw-bold mb-2 text-uppercase">Update Profile</h2>
                                <?php
                                if (isset($_GET["error"])) {
                                    if ($_GET["error"] == "invalidemail") {
                                        echo '<p class="text-danger">Invalid email!</p>';
                                    }
                                }
                                ?>
                                <p class="text-white-50 mb-5">Change Informations</p>
                                <form action="" method="post">
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="restaurantname" id="typeRestaurantNameX" class="form-control form-control-lg" placeholder="Restaurant Name" required value="<?php echo $_SESSION["restaurant_name"] ?>" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="firstname" id="typeFirstNameX" class="form-control form-control-lg" required value="<?php echo $_SESSION["firstname"] ?>" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" name="lastname" id="typeLastNameX" class="form-control form-control-lg" required value="<?php echo $_SESSION["lastname"] ?>" />
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="email" name="email" id="typeEmailX" class="form-control form-control-lg" required value="<?php echo $_SESSION["email"] ?>" />
                                    </div>

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="submit" value="submit">Update Profile</button>

                                </form>
                                <a class="btn btn-outline-light btn-lg px-5" href="show_profile.php">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>