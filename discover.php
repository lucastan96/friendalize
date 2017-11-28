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
        <title>Discover | Friendalize</title>
        <link href="scripts/dead-simple-grid-gh-pages/css/grid.css" rel="stylesheet">
        <link href="styles/discover.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <h1>Discover</h1>
                    <h2 class="description">Find people in your institution or others that share the same interests as you.</h2>
                    <div class="filter-box">
                        <p>Showing all categories</p>
                        <select class="form-control form-select" id="filter-select" name="filter-select" required>
                            <option value="" selected="selected">Filter</option>
                        </select>
                    </div>
                    <div class="feed">
                        <div class="row">
                            <div class="col">
                                <div class="item">
                                    <div class="item-info">
                                        <img class="item-profile-pic" src="images/profiles/default.png" alt="Profile Pic">
                                        <div class="item-user">Elaine Pei-Ling Chong</div>
                                        <div class="item-time">Posted on 2017-10-17 12.37pm</div>
                                        <div class="item-likes"><i class="fa fa-thumbs-up" aria-hidden="true"></i>89</div>
                                    </div>
                                    <div class="item-content">
                                        <img src='images/signin/signin_2.png'>
                                    </div>
                                    <div class="item-options">
                                        <div>
                                            <p class='item-category'>Sports</p>
                                            <button class="btn btn-square btn-like"><i class="fa fa-thumbs-up" aria-hidden="true"></i>Like</button>
                                            <button class="btn btn-square btn-add" type="submit" title='Be friendalized!'>Add Elaine<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="scripts/viewport-resize.js"></script>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(2)').addClass("nav-active");
                $('.nav-mobile a:nth-child(2)').addClass("nav-active");
            });
        </script>
    </body>
</html>