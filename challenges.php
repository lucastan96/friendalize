<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/connection.php');
    require_once('includes/functions.php');

    $institution_id = get_institution_id($db, $_SESSION['user_id']);

    if ($institution_id == NULL) {
        header("Location: setup-institution.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Challenges | Friendalize</title>
        <link href="styles/challenges.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <!-- <?php include("includes/nav-mobile.php"); ?> -->
                <div class="col-sm-10 content">
                    
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(4)').addClass("nav-active");
                $('.nav-mobile li:nth-child(4)').addClass("nav-active");
            });
        </script>
    </body>
</html>