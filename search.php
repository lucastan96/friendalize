<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/essentials.php');

    $searchq = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_STRING);
    $search = search_for_users($db, $_SESSION['user_id'], $searchq);

}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Home | Friendalize</title>
        <link href="scripts/dead-simple-grid-gh-pages/css/grid.css" rel="stylesheet">
        <link href="scripts/jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="styles/index.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <div class='profile-about'>

                        <?php
                        foreach ($search as $f):
                            $first_name = $f['first_name'];
                            $last_name = $f['last_name'];
                            $id = $f['user_id'];
                            header("Location: profile.php?id=$id");
//                            echo "First Name: " . $first_name . "<br> ";
//                            echo "Last Name: " . $last_name . "<br>";
//                            echo "Email: " . $f['email'] . "<br>";
//                            echo "Age: " . $f['age'] . "<br>";
//                            echo "Date Joined: " . $f['join_date'] . "<br>";
//                            echo "Gender " . $f['gender'] . "<br>";
//                            echo $f["profile_pic"];
//                          
                        endforeach;
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <script src="scripts/viewport-resize.js"></script>
        <script src="scripts/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(1)').addClass("nav-active");
                $('.nav-mobile a:nth-child(1)').addClass("nav-active");
            });
        </script>
    </body>
</html>