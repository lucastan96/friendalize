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
        <title>Explore | Friendalize</title>
        <link href="scripts/dead-simple-grid-gh-pages/css/grid.css" rel="stylesheet">
        <link href="styles/explore.css" rel="stylesheet">

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
                    <h1>Explore</h1>
                    <h2 class="description">Find people in your institution or others that share same interests as you.</h2>

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
        <script>
                                $(document).ready(function () {
                                    $('.nav-desktop li:nth-child(2)').addClass("nav-active");
                                    $('.nav-mobile a:nth-child(2)').addClass("nav-active");
                                });
        </script>
    </body>
</html>