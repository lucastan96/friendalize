<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/essentials.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Explore | Friendalize</title>
        <link href="styles/explore.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <h1>Explore</h1>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(2)').addClass("nav-active");
                $('.nav-mobile a:nth-child(2)').addClass("nav-active");
            });
        </script>
    </body>
</html>