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

        <script>
            function viewBy(filterselect) {
                $.ajax({
                    url: "includes/view-post-filter-p.php",
                    type: "post",
                    data: {'filterselect': filterselect},
                    success: function (data) {
                        $("#viewList").html(data);
                    },
                    error: function () {
                        $("#viewList").html("Error with AJAX.");
                    }
                });
            }
        </script>
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
                                <option value="1" selected="selected">Category</option>
                                <?php foreach ($interests_array as $interests) : ?>
                                    <option value="<?php echo $interests['interest_id']; ?>"><?php echo htmlspecialchars($interests['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION["user_id"]); ?>">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div>
                                    <span class="btn btn-default btn-file btn-images"><span class="fileinput-new">Upload Image</span><span class="fileinput-exists">Change</span><input type="file" name="picture"></span>
                                    <a href="#" class="btn btn-default fileinput-exists btn-images" data-dismiss="fileinput">Cancel</a>
                                </div>
                            </div>
                            <button class="btn btn-square btn-post" type="submit">Post<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                        </div>
                    </form>

                    <form class="form-horizontal form-post" action="" method='post'>
                        <div class="filter-box">
                            <p>Showing all categories</p>
                            <select class="form-control form-select" id="filter-select" name="filterselect" onchange="viewBy(this.value)" dir="rtl" required>
                                <option value="1" selected="selected">Filter</option>
                                <?php foreach ($interests_array as $interests) : ?>
                                    <option value="<?php echo $interests['interest_id']; ?>"><?php echo htmlspecialchars($interests['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                    <div id="viewList">
                        <?php include 'includes/view-post-filter-p.php'; ?>
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

                                $(".btn-like").click(function (e) {
                                    e.preventDefault();

                                    var post_id = $(this).next().val();
                                    var action = 1;

                                    if ($(this).hasClass("btn-liked")) {
                                        action = 2;
                                        $(this).removeClass("btn-liked");
                                        $(this).find("span").text("Like");
                                        var post_likes_count = parseInt($(this).closest(".item").find(".item-info").find(".item-likes").find("span").text());
                                        post_likes_count--;
                                        $(this).closest(".item").find(".item-info").find(".item-likes").find("span").text(post_likes_count);
                                    } else {
                                        $(this).addClass("btn-liked");
                                        $(this).find("span").text("Liked");
                                        var post_likes_count = parseInt($(this).closest(".item").find(".item-info").find(".item-likes").find("span").text());
                                        post_likes_count++;
                                        $(this).closest(".item").find(".item-info").find(".item-likes").find("span").text(post_likes_count);
                                    }

                                    $.ajax({
                                        url: "includes/post-like-p.php",
                                        type: "POST",
                                        data: {
                                            post_id: post_id,
                                            action: action
                                        }
                                    });
                                });
        </script>
    </body>
</html>
