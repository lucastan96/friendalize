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
                    <h1>Home <small> &nbsp; Find people in your instistution or others that share same interests as you</small></h1>

                        <form action='explore.php' method='post' >
                            <div>
                                <input class="search" name ="search" type ="text" size ="140"  placeholder="currently showing all categories here"/>
                                <button class="btn btn-square btn-post" type="submit" title='Post comment'>Filter<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                            </div>
                        </form>

                    <br><br>
                    <div class="feed3">
                        <div class="row">
                            <div class="col3">
                                <div class="item">
                                    <div class="item-info">
                                        <img class="item-profile-pic" src="images/profiles/default.png" alt="Profile Pic">
                                        <div class="item-user">Farwa Javed</div>
                                        <div class="item-time">Posted on 2017-10-17 12.15am</div>
                                        <div class="likes"><i class="fa fa-thumbs-up" aria-hidden="true"></i>345</div>
                                    </div>
                                    <div class="item-content">
                                        <img src="images/explore/1.png" style="width: 100%">
                                    </div>
                                    <div class="item-options">
                                        <form class='form-horizontal item-comment' action='comment-add-p.php' method='post'>
                                            <div>
                                                <p class='item-category'>City</p>
                                                <button class="btn btn-square btn-like"><i class="fa fa-thumbs-up" aria-hidden="true"></i>Like</button>
                                                <input  type="text" name="comment" id="comment" placeholder="Type a comment..." required>

                                                <button class="btn btn-square btn-post" type="submit" title='Post comment'><i class="fa fa-chevron-right" aria-hidden="true"></i></button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="feed">
                        <div class="row1">
                            <div class="col">
                                <div class="item">
                                    <div class="item-info">
                                        <img class="item-profile-pic" src="images/profiles/default.png" alt="Profile Pic">
                                        <div class="item-user">Farwa Javed</div>
                                        <div class="item-time">Posted on 2017-10-17 11.13am</div>
                                        <div class="likes2"><i class="fa fa-thumbs-up" aria-hidden="true"></i>55</div>
                                    </div>
                                    <div class="item-content">
                                        <p>Started learning fingerstyle today!</p>
                                    </div>
                                    <div class="item-options">
                                        <form class='form-horizontal item-comment' action='comment-add-p.php' method='post'>
                                            <div>
                                                <p class='item-category'>Guitar</p>
                                                <button class="btn btn-square btn-like"><i class="fa fa-thumbs-up" aria-hidden="true"></i>Like</button>
                                                <input  type="text" name="comment" id="comment" placeholder="Type a comment..." required>

                                                <button class="btn btn-square btn-post" type="submit" title='Post comment'><i class="fa fa-chevron-right" aria-hidden="true"></i></button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="feed1">
                        <div class="row">
                            <div class="col">
                                <div class="item">
                                    <div class="item-info">
                                        <img class="item-profile-pic" src="images/profiles/default.png" alt="Profile Pic">
                                        <div class="item-user">Farwa Javed</div>
                                        <div class="item-time">Posted on 2017-10-17 7.04am</div>
                                        <div class="likes1"><i class="fa fa-thumbs-up" aria-hidden="true"></i>92</div>
                                    </div>
                                    <div class="item-content">
                                        <img src="images/explore/4.png" style="width: 100%">
                                    </div>
                                    <div class="item-options">
                                        <form class='form-horizontal item-comment' action='comment-add-p.php' method='post'>
                                            <div>
                                                <p class='item-category'>Traveling</p>
                                                <button class="btn btn-square btn-like"><i class="fa fa-thumbs-up" aria-hidden="true"></i>Like</button>
                                                <input  type="text" name="comment" id="comment" placeholder="Type a comment..." required>

                                                <button class="btn btn-square btn-post" type="submit" title='Post comment'><i class="fa fa-chevron-right" aria-hidden="true"></i></button>

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
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(2)').addClass("nav-active");
                $('.nav-mobile a:nth-child(2)').addClass("nav-active");
            });
        </script>
    </body>
</html>