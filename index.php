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
    //$result_filter = get_post_filter($db, $_SESSION['filter-select']);

    $query = "SELECT * FROM posts ORDER BY post_id DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $result_filter = $statement->fetchAll();
    $statement->closeCursor();
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
                    <form class="form-horizontal form-post" action='includes/post-add-p.php' enctype="multipart/form-data" method='post'>
                        <div><input class="form-control form-input" type="text" name="post" id="post" placeholder="Share a post..."></div>
                        <div class="form-post-options">
                            <select class="form-control form-select" id="post_category" name="post_category">
                                <option value="1" selected="selected">Category (Optional)</option>
                                <?php foreach ($interests_array as $interests) : ?>
                                    <option value="<?php echo $interests['interest_id']; ?>"><?php echo htmlspecialchars($interests['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION["user_id"]); ?>">
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
                            <select class="form-control form-select" id="filter-select" name="filter-select" dir="rtl" required>
                                <option value="1" selected="selected">Filter</option>
                                <?php foreach ($interests_array as $interests) : ?>
                                    <option value="<?php echo $interests['interest_id']; ?>"><?php echo htmlspecialchars($interests['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                    <div class="feed">
                        <div class="row">
                            <?php if (!empty($result_filter)) { ?>
                                <?php foreach ($result_filter as $result): ?>
                                    <?php
                                    $post_user_info = get_post_user_info($db, $result["user_id"]);
                                    $post_first_name = $post_user_info["first_name"];
                                    $post_last_name = $post_user_info["last_name"];
                                    $post_profile_pic = $post_user_info["profile_pic"];
                                    ?>
                                    <div class="col">
                                        <div class="item">
                                            <div class="item-info">
                                                <img class="item-profile-pic" src="images/profiles/<?php echo $post_profile_pic; ?>" alt="Profile Pic">
                                                <div class="item-user"><?php echo $post_first_name . " " . $post_last_name; ?></div>
                                                <div class="item-time">Posted on <?php echo $result["time"]; ?></div>
                                                <div class="item-likes"><i class="fa fa-thumbs-up" aria-hidden="true"></i>26</div>
                                            </div>
                                            <div class="item-content">
                                                <?php if ($result["content"] != "") { ?>
                                                    <p><?php echo $result["content"]; ?></p>
                                                <?php } ?>
                                                <?php if ($result["images"] != "") { ?>
                                                    <img src="images/posts/<?php echo $result["images"]; ?>">
                                                <?php } ?>  
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
                                <?php endforeach; ?>
                            <?php } else { ?>
                                <?php
                                echo "<div id='message'><i class='fa fa-info-circle' aria-hidden='true'></i>No posts just yet, get started by <a href='friends.php'>adding friends</a> and also by adding your own post!</div>";
                                ?>
                            <?php } ?>
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