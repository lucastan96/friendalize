<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/essentials.php');

    if (isset($_SESSION['first_login'])) {
        $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Welcome, you are now offically a Friendalizer!";
        $_SESSION['first_login'] = null;
    }

    $interests_array = get_interests($db);
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
                    <h1>Home</h1>
                    <?php
                    if (isset($message)) {
                        echo "<div id='message'>" . $message . "</div>";
                    }
                    ?>
                    <form class="form-horizontal form-post" action='includes/post-add-p.php' method='post'>
                        <div><input class="form-control form-input" type="text" name="post" id="post" placeholder="Share a post..." required></div>
                        <div class="form-post-options">
                            <select class="form-control form-select" id="post_category" name="post_category">
                                <option value="" selected="selected">Category (Optional)</option>
                                <?php foreach ($interests_array as $interests) : ?>
                                    <option value="<?php echo $interests['interest_id']; ?>"><?php echo htmlspecialchars($interests['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($_SESSION["user_id"]); ?>">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div>
                                    <span class="btn btn-default btn-file btn-images"><span class="fileinput-new">Upload Image</span><span class="fileinput-exists">Change Image</span><input type="file" name="picture"></span>
                                    <a href="#" class="btn btn-default fileinput-exists btn-images" data-dismiss="fileinput">Cancel Image Upload</a>
                                </div>
                            </div>
                            <button class="btn btn-square btn-post" type="submit">Post<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                        </div>
                    </form>
                    <form class="form-horizontal form-post" action='includes/view-post-filter-p.php' method='post'>
                        <div class="filter-box">
                            <p>Showing all categories</p>
                            <select class="form-control form-select" id="filter-select" name="filter-select" required>
                                <option value="1" selected="selected">Filter</option>
                                <?php foreach ($interests_array as $interests) : ?>
                                    <option value="<?php echo $interests['interest_id']; ?>"><?php echo htmlspecialchars($interests['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
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
        <script src="scripts/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(1)').addClass("nav-active");
                $('.nav-mobile a:nth-child(1)').addClass("nav-active");
            });
        </script>
    </body>
</html>