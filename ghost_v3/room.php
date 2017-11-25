<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('../includes/connection.php');
    require_once('../includes/functions.php');

    $institution_id = get_institution_id($db, $_SESSION['user_id']);

    if ($institution_id == NULL) {
        header("Location: ../setup-institution.php");
        exit();
    }

    $profile_pic = get_profile_pic($db, $_SESSION['user_id']);
    $first_name = get_first_name($db, $_SESSION['user_id']);

    $room_id = $_GET["room_id"];

    $query2 = 'SELECT * FROM ghost_room r, ghost_room_players rp, users p WHERE p.user_id = rp.user_id AND r.room_id = rp.room_id AND r.room_id = :room_id AND p.user_id = :user_id';
    $statement2 = $db->prepare($query2);
    $statement2->execute(array(":room_id" => $room_id, ":user_id" => $_SESSION['user_id']));
    $player = $statement2->fetch();
    $statement2->closeCursor();

    $_SESSION['room_id'] = $room_id;
}
?>
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="theme-color" content="#454545">
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../styles/common.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--[if lt IE 9]><script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script><script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
        <title>Challenge | Who's the Ghost? | Friendalize</title>
        <link href="../styles/room.css" rel="stylesheet">
        <script src="room.js" type="text/javascript"></script>
        <script src="ready.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="../index.php"><div class="navbar-brand-logo"><img src="../images/logos/white_transparent.png" alt="Friendalize Logo"><span>friendalize</span></div></a>
                        <a href="../signout.php" class="navbar-toggle navbar-mobile" title="Sign Out"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i></a>
                        <a href="../notifications.php" class="navbar-toggle navbar-mobile" title="Notifications"><i class="fa fa-bell fa-fw" aria-hidden="true"></i></a>
                        <a href="../profile.php" class="navbar-toggle navbar-mobile" title="Profile"><img src="../images/profiles/<?php echo $profile_pic; ?>.png" alt="Profile Pic"></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="../profile.php" title="Profile"><div class="navbar-profile"><img src="../images/profiles/<?php echo $profile_pic; ?>.png" alt="Profile Pic"><?php echo $first_name; ?></div></a></li>
                            <li><a href="../notifications.php" title="Notifications"><i class="fa fa-bell fa-fw" aria-hidden="true"></i></a></li>
                            <li><a href="../signout.php" title="Sign Out"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="row cols">
                <div class="col-sm-2 nav-desktop">
                    <ul>
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="../explore.php">Explore</a></li>
                        <li><a href="../friends.php">Friends</a></li>
                        <li><a href="../challenges.php">Challenges</a></li>
                        <li><a href="../messages.php">Messages</a></li>
                        <li><a href="../settings.php">Settings</a></li>
                    </ul>
                </div>
                <div class="nav-mobile navbar-fixed-top">
                    <a href="../index.php">Home</a>
                    <a href="../explore.php">Explore</a>
                    <a href="../friends.php">Friends</a>
                    <a href="../challenges.php">Challenges</a>
                    <a href="../messages.php">Messages</a>
                    <a href="../settings.php">Settings</a>
                </div>
                <div class="col-sm-10 content">
                    <div class='room-info'>
                        <h1>Who's the Ghost?</h1>
                        <div class='ready'>
                            <?php include_once 'ready.php'; ?>
                        </div>
                    </div>
                    <div class="col-sm-8 room-chat">
                        <div class="chat">
                            <div class='msgs'>
                                <?php include ("msgs.php"); ?>
                            </div>
                            <form id="msg_form">
                                <input name="msg" class="form-control form-input" size="30" type="text" placeholder="Type a message..."/>
                                <input type="hidden" name ="room_id" id="room_id" value="<?php echo $room_id ?>">
                                <button class="btn btn-square">Send</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-4 room-game">
                        <span id="countdown" class="timer"></span>
                        <div class='timer'>
                            <?php include_once 'timer.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(4)').addClass("nav-active");
                $('.nav-mobile a:nth-child(4)').addClass("nav-active");
            });

            var width = $('.nav-mobile a:nth-child(1)').width() + $('.nav-mobile a:nth-child(2)').width() + $('.nav-mobile a:nth-child(3)').width();
            $('.nav-mobile').scrollLeft(width);
        </script>
        <script>
            if (jQuery(".nav-mobile").css('display') == 'none') {
                jQuery.event.add(window, "load", resizeFrame);
                jQuery.event.add(window, "resize", resizeFrame);

                function resizeFrame() {
                    var h = $(window).height();

                    $(".room-chat").css('height', h - 138);
                    $(".room-game").css('height', h - 138);
                }
            }
        </script>
    </body>
</html>