<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Home | Friendalize</title>
        <link href="styles/index.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <!-- <?php include("includes/nav-mobile.php"); ?> -->
                <div class="col-sm-10">
                    
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(1)').addClass("nav-active");
                $('.nav-mobile li:nth-child(1)').addClass("nav-active");
            });
        </script>
    </body>
</html>