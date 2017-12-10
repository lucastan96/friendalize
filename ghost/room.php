<?php
$room_id = filter_input(INPUT_GET, 'room_id', FILTER_SANITIZE_URL);

if ($room_id == "") {
    header("Location: ../challenges.php");
    exit();
}

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

    $query2 = 'SELECT * FROM ghost_room r, ghost_room_players rp, users p WHERE p.user_id = rp.user_id AND r.room_id = rp.room_id AND r.room_id = :room_id AND p.user_id = :user_id';
    $statement2 = $db->prepare($query2);
    $statement2->execute(array(":room_id" => $room_id, ":user_id" => $_SESSION['user_id']));
    $player = $statement2->fetch();
    $statement2->closeCursor();

    $_SESSION['room_id'] = $room_id;

    $query3 = "SELECT name FROM interests WHERE interest_id = :interest_id";
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(":interest_id", $player["interest_id"]);
    $statement3->execute();
    $interest_result = $statement3->fetch();
    $statement3->closeCursor();

    $interest = $interest_result["name"];

    if ($player["difficulty_id"] == 1) {
        $difficulty = "Easy";
    } else if ($player["difficulty_id"] == 2) {
        $difficulty = "Medium";
    } else {
        $difficulty = "Hard";
    }
}
?>
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="57x57" href="../images/favicons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="../images/favicons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="../images/favicons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="../images/favicons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="../images/favicons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="../images/favicons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="../images/favicons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="../images/favicons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="../images/favicons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="../images/favicons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../images/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="../images/favicons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../images/favicons/favicon-16x16.png">
        <link rel="manifest" href="../images/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#454545">
        <meta name="msapplication-TileImage" content="../images/favicons/ms-icon-144x144.png">
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
        <!--<script src="t_function.js" type="text/javascript"></script>-->
        <!--<script src="ready.js" type="text/javascript"></script>-->
    </head>
    <body>
        <div class="container-fluid">
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="../index.php"><div class="navbar-brand-logo"><img src="../images/logos/white_transparent.png" alt="Friendalize Logo"><span>friendalize</span></div></a>
                        <a href="../signout.php" class="navbar-toggle navbar-mobile" title="Sign Out"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i></a>
                        <a href="../notifications.php" class="navbar-toggle navbar-mobile" title="Notifications"><i class="fa fa-bell fa-fw" aria-hidden="true"></i></a>
                        <a href="../profile.php" class="navbar-toggle navbar-mobile" title="Profile"><img src="../images/profiles/<?php echo $profile_pic; ?>" alt="Profile Pic"></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="../profile.php" title="Profile"><div class="navbar-profile"><img src="../images/profiles/<?php echo $profile_pic; ?>" alt="Profile Pic"><?php echo $first_name; ?></div></a></li>
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
                        <li><a href="../discover.php">Discover</a></li>
                        <li><a href="../friends.php">Friends</a></li>
                        <li><a href="../challenges.php">Challenges</a></li>
                        <li><a href="../settings.php">Settings</a></li>
                    </ul>
                </div>
                <div class="nav-mobile navbar-fixed-top">
                    <a href="../index.php">Home</a>
                    <a href="../discover.php">Discover</a>
                    <a href="../friends.php">Friends</a>
                    <a href="../challenges.php">Challenges</a>
                    <a href="../settings.php">Settings</a>
                </div>
                <div class="col-sm-10 content">
                    <div class='room-info'>
                        <h1>Who's the Ghost?<?php if ($player["room_name"] != "") {
    echo " - <span id='room_name'>" . $player["room_name"] . "</span>";
} ?><span id="interest_difficulty"><?php echo $interest; ?> | Difficulty: <?php echo $difficulty; ?></span></h1>
                        <div class="room-info-right">
                            <div class='ready'></div>
                            <div class="player-info"></div>
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
                                <button class="btn btn-square">Send<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-4 room-game">
                        <div id="countdown-container">
                            <span id="countdown" class="timer"></span>
                        </div>
                        <div class='timer timer-container'>

                        </div>
                        <p id="btn-tips-desc"><i class='fa fa-lightbulb-o' aria-hidden='true'></i>Game help is turned <strong><span>ON</span></strong>.</p>
                        <button class="btn btn-square btn-tips tips-on" type="button">Disable</button>
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

            $(".btn-tips").click(function (e) {
                e.preventDefault();

                if ($(this).hasClass("tips-on")) {
                    $(this).removeClass("tips-on");
                    $(this).prev().find("span").text("OFF");
                    $(this).text("Enable");
                    $(".tip").hide();
                } else {
                    $(this).addClass("tips-on");
                    $(this).prev().find("span").text("ON");
                    $(this).text("Disable");
                    $(".tip").show();
                }
            });
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