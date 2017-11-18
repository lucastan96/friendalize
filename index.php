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
        <title>Home | Friendalize</title>
        <link href="styles/index.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <h1>Home</h1>
                    <form class="form-horizontal form-post" action='post-p.php' method='post'>
                        <div>
                            <input class="form-control form-input" type="text" name="post" id="post" placeholder="Share a post..." required>
                        </div>
                        <div>
<!--                            <select id="post_category" name="post_category" required>
                                <option value="" selected="selected">Category</option>
                            </select>-->
                            <button class="btn btn-square btn-submit" type="submit">Post<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(1)').addClass("nav-active");
                $('.nav-mobile a:nth-child(1)').addClass("nav-active");
            });
        </script>
    </body>
</html>