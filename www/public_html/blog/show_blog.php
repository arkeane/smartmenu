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

        // get all blog posts
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
                                <p class="card-text ">' . $row["content"] . '</p>
                                <hr><h3>Comments</h3>';
                                
                                //control get error message
                                if(isset($_GET["error"])){
                                    if($_GET["error"] == "emptyfields"){
                                        echo '<p class="text-danger">Please fill in all fields!</p>';
                                    } else if($_GET["error"] == "sqlerror"){
                                        echo '<p class="text-danger">Something went wrong!</p>';
                                    }
                                }

                                //get all comments for each blog post
                                $sql2 = mysqli_prepare($conn, "SELECT * FROM blog_comments WHERE blog_id=?");
                                mysqli_stmt_bind_param($sql2, "i", $row["id"]);
                                mysqli_stmt_execute($sql2);
                                $result2 = mysqli_stmt_get_result($sql2);
                                if(mysqli_num_rows($result2) > 0){
                                    while($comments = mysqli_fetch_assoc($result2)){
                                        //control for admin
                                        if(isset($_SESSION["admin"])){

                                            echo '<p class="card-text"><small class="text-bold">SmartMenu</small></p>
                                            <p class="card-text"><small class="text-muted">' . $comments["comment_date"] . '</small></p>
                                            <p class="card-text"><small>' . $comments["comment"] . '</small></p><br>';

                                        } else {//search for restaurant name based on restaurant id
                                            $sql3 = mysqli_prepare($conn, "SELECT firstname,lastname FROM users WHERE id=?");
                                            mysqli_stmt_bind_param($sql3, "i", $comments["restaurant_id"]);
                                            mysqli_stmt_execute($sql3);
                                            $result3 = mysqli_stmt_get_result($sql3);
                                            $restaurant = mysqli_fetch_assoc($result3);
                                            
                                            echo '<span class="card-text"><small class="text-bold">' . $restaurant["firstname"] . ' ' . $restaurant["lastname"] . '</small>
                                            <small class="text-muted">' . $comments["comment_date"] . '</small>
                                            <small>' . $comments["comment"] . '</small></span><br>';   
                                        }
                                    }
                                }
                            echo '<form action="insert_comment.php" method="post">
                                <textarea class="form-control mt-3" id="comment" name="comment" required placeholder="comment"></textarea>
                                <button type="submit" class="btn btn-primary mt-3" id="submit" name="submit" value="' .$row["id"] . '">Post Comment</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</body>