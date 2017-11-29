<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/essentials.php');
    require_once('includes/functions.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Notifications | Friendalize</title>

        <script type="text/javascript">

            function myFunction() {
                $.ajax({
                    url: "includes/notifications-p.php",
                    type: "POST",
                    processData: false,
                    success: function (data) {
                        $("#notification-count").remove();
                        $("#notification-latest").show();
                        $("#notification-latest").html(data);
                    },
                    error: function () {}
                });
            }

            $(document).ready(function () {
                $('body').click(function (e) {
                    if (e.target.id != 'notification-icon') {
                        $("#notification-latest").hide();
                    }
                });
            });

        </script>
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <h1>Notifications</h1>

                    <div id="notification-header">
                        <div style="position:relative">
                            <button id="notification-icon" name="button" class='btn btn-default' onclick="myFunction()"><span id="notification-count"><?php
                                    if ($notifications_count > 0) {
                                        echo $notifications_count;
                                    }
                                    ?><i class="fa fa-bell fa-fw" aria-hidden="true"></i>  Click to see All notifications!!</span></button>
                            <div id="notification-latest"></div>
                        </div>			

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="scripts/viewport-resize.js"></script>
    <script>
                                $(document).ready(function () {
                                    $('.navbar-right li:nth-child(2)').addClass("navbar-active");
                                });
    </script>
</body>
</html>


