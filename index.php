<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/essentials.php');

    $interests_array = get_interests($db);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Home | Friendalize</title>
        <link href="scripts/dead-simple-grid-gh-pages/css/grid.css" rel="stylesheet">
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
                    <form class="form-horizontal form-post" action='includes/post-add-p.php' method='post'>
                        <div><input class="form-control form-input" type="text" name="post" id="post" placeholder="Share a post..." required></div>
                        <div class="form-post-options">
                            <select class="form-control form-select" id="post_category" name="post_category" required>
                                <option value="" selected="selected">Choose Category</option>
                                <?php foreach ($interests_array as $interests) : ?>
                                    <option value="<?php echo $interests['interest_id']; ?>"><?php echo htmlspecialchars($interests['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-square btn-images">Upload Images</button>
                            <button class="btn btn-square btn-post" type="submit">Post<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                        </div>
                    </form>
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
                                        <div class="item-user">Lucas Tan</div>
                                        <div class="item-time">Posted on 2017-10-17 12.50pm</div>
                                        <div class="item-likes"><i class="fa fa-thumbs-up" aria-hidden="true"></i>26</div>
                                    </div>
                                    <div class="item-content">
                                        <p>Table tennis on Friday anyone?</p>
                                    </div>
                                    <div class="item-options">
                                        <form class='form-horizontal item-comment' action='includes/comment-add-p.php' method='post'>
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
                            <div class="col">
                                <div class="item">
                                    <div class="item-info">
                                        <img class="item-profile-pic" src="images/profiles/default.png" alt="Profile Pic">
                                        <div class="item-user">Lucas Tan</div>
                                        <div class="item-time">Posted on 2017-10-17 12.50pm</div>
                                        <div class="item-likes"><i class="fa fa-thumbs-up" aria-hidden="true"></i>26</div>
                                    </div>
                                    <div class="item-content">
                                        <img src="images/signin/signin_4.png">
                                    </div>
                                    <div class="item-options">
                                        <form class='form-horizontal item-comment' action='includes/comment-add-p.php' method='post'>
                                            <input class="form-control form-input" type="text" name="comment" id="comment" placeholder="Type a comment..." required>
                                            <div>
                                                <p class='item-category'>Travel</p>
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
        <script src="scripts/viewport-resize.js"></script>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(1)').addClass("nav-active");
                $('.nav-mobile a:nth-child(1)').addClass("nav-active");
            });
        </script>
    </body>
</html>