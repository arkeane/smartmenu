<!DOCTYPE html>

<head>
    <title>Profile</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- style.css -->
    <link rel="stylesheet" href="./css/style.css">

    <!-- Bootstrap core JavaScript -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script defer src="./js/main.js"></script>
</head>

<body>
    <?php
    session_start();
    include 'db.php';

    if (!isset($_SESSION["email"])) {
        header("Location: error.html");
    }

    if (isset($_POST['submit'])) {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];

        $sessionemail = $_SESSION["email"];

        if ($firstname != $_SESSION["firstname"]) {
            $conn = new mysqli($servername, $username, $db_password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "UPDATE users SET firstname='$firstname' WHERE email='$sessionemail'";
            mysqli_query($conn, $sql);
        }

        if ($lastname != $_SESSION["lastname"]) {
            $conn = new mysqli($servername, $username, $db_password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "UPDATE users SET lastname='$lastname' WHERE email='$sessionemail'";
            mysqli_query($conn, $sql);
        }

        if ($email != $_SESSION["email"]) {
            $conn = new mysqli($servername, $username, $db_password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "UPDATE users SET email='$email' WHERE email='$sessionemail'";
            mysqli_query($conn, $sql);
        }

        header("Location: show_profile.php");
    }
    ?>

    <form action="" method="post">
        <input type="text" name="firstname" value="<?php echo $_SESSION["firstname"] ?>">
        <input type="text" name="lastname" value="<?php echo $_SESSION["lastname"] ?>">
        <input type="email" name="email" value="<?php echo $_SESSION["email"] ?>">
        <input type="submit" name="submit" value="submit">
    </form>

</body>

</html>