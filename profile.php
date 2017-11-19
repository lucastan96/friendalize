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
        <title>Profile | Friendalize</title>
        <link href="styles/profile.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <div class='col-sm-4 profile-info'>
                        <img class='profile-pic' src='images/profiles/default.png' alt='Profile Picture'>
                        <h1>Lucas Tan</h1>
                        <a class='btn btn-default btn-profile' href='settings' role='button'>Edit Details<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        <div class='profile-about'>
                            <h5>Institute</h5>
                            <p>Dundalk Institute of Technology</p>
                            <h5>Friends</h5>
                            <p>125</p>
                            <h5>Age</h5>
                            <p>21</p>
                            <h5>Email</h5>
                            <p>lucastan96@gmail.com</p>
                            <h5>Hobbies</h5>
                            <p>Sports, Music</p>
                        </div>
                        <h5>Member since 20th October 2017</h5>
                    </div>
                    <div class='col-sm-8 profile-posts'>
                        <h2>Posts</h2>
                        <div class="feed">
                            <div class="row">
                                <div class="col">
                                    <div class="item">
                                        <div class="item-info">
                                            <img class="item-profile-pic" src="images/profiles/default.png" alt="Profile Pic">
                                            <div class="item-user">Lucas Tan</div>
                                            <div class="item-time">Posted on 2017-10-17 12.50pm</div>
                                            <div class="item-likes"><i class="fa fa-thumbs-up" aria-hidden="true"></i>26</div>
                                        </div>
                                        <div class="item-content">
                                            <p>Table tennis on Friday anyone?</p>
                                        </div>
                                        <div class="item-options">
                                            <form class='form-horizontal item-comment' action='comment-add-p.php' method='post'>
                                                <input class="form-control form-input" type="text" name="comment" id="comment" placeholder="Type a comment..." required>
                                                <div>
                                                    <p class='item-category'>Sports</p>
                                                    <button class="btn btn-square btn-like"><i class="fa fa-thumbs-up" aria-hidden="true"></i>Like</button>
                                                    <button class="btn btn-square btn-post" type="submit" title='Post comment'>Comment<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.navbar-right li:nth-child(1)').addClass("navbar-active");
            });
        </script>
    </body>
</html>