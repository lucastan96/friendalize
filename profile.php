<?php
$friend_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_URL);

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/friendalize/signin");
    exit();
} else {
    require_once('includes/essentials.php');

    if ($friend_id == "") {
        $user_details_array = get_user_details($db, $_SESSION['user_id']);
        $institution = get_user_institution($db, $_SESSION['user_id']);
        $interests = get_user_interests($db, $_SESSION['user_id']);
        $friend_count = get_friend_count($db, $_SESSION['user_id']);
    } else {
        $user_details_array = get_user_details($db, $friend_id);
        $institution = get_user_institution($db, $friend_id);
        $interests = get_user_interests($db, $friend_id);
        $friend_status = get_friend_status($db, $_SESSION['user_id'], $friend_id);
        $friend_count = get_friend_count($db, $friend_id);
    }

    foreach ($user_details_array as $user_details):
        $id = $user_details["user_id"];
        $email = $user_details["email"];
        $friend_first_name = $user_details["first_name"];
        $last_name = $user_details["last_name"];
        $gender = $user_details["gender"];
        $age = $user_details["age"];
        $country_id = $user_details["country_id"];
        $join_date = $user_details["DATE(join_date)"];
        $friend_profile_pic = $user_details["profile_pic"];
    endforeach;

    $country = get_user_country($db, $country_id);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Profile - <?php
            if ($friend_id == "") {
                echo $first_name;
            } else {
                echo $friend_first_name;
            }
            ?><?php echo " " . $last_name; ?> | Friendalize</title>
        <link href="styles/profile.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <div class='col-sm-3 profile-info'>
                        <img class='profile-pic' src='images/profiles/<?php
                        if ($friend_id == "") {
                            echo $profile_pic;
                        } else {
                            echo $friend_profile_pic;
                        }
                        ?>' alt='Profile Picture'>
                        <h1><?php
                            if ($friend_id == "") {
                                echo $first_name;
                            } else {
                                echo $friend_first_name;
                            }
                            ?><?php echo " " . $last_name; ?></h1>
                        <?php if ($friend_id == "") { ?>
                            <a class='btn btn-default btn-profile' href='settings.php' role='button'>Edit Profile<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        <?php } else { ?>
                            <?php if ($friend_status == true) { ?>
                                <form action="includes/friend-delete-p.php" method="post">
                                    <input type="hidden" name="friend_id" value="<?php echo $friend_id; ?>">
                                    <button class="btn btn-default btn-profile" type="submit" onclick="return confirm('Are you sure you want to unfriend <?php echo $friend_first_name; ?>? This action cannot be undone!')">Unfriend</button>
                                </form>
                            <?php } else { ?>
                                <?php
                                $user_request_status = get_user_request_status($db, $_SESSION['user_id'], $friend_id);
                                $friend_request_status = get_friend_request_status($db, $_SESSION['user_id'], $friend_id);

                                if ($user_request_status == true) {
                                    ?>
                                    <button class="btn btn-default btn-profile disabled" title="Please wait for <?php echo $friend_first_name; ?> to accept your friend request">Requested</button>
                                <?php } else { ?>
                                    <?php if ($friend_request_status == true) { ?>
                                        <form action="includes/friend-add-p.php" method="post">
                                            <input type="hidden" name="friend_id" value="<?php echo $friend_id; ?>">
                                            <button class="btn btn-default btn-profile" type="submit">Accept Request</button>
                                        </form>
                                    <?php } else { ?>
                                        <form action="includes/friend-request-p.php" method="post">
                                            <input type="hidden" name="friend_id" value="<?php echo $friend_id; ?>">
                                            <button class="btn btn-default btn-profile" type="submit">Add Friend</button>
                                        </form>
                                    <?php } ?>
                                <?php } ?>
                                <?php
                            }
                        }
                        ?>
                        <div class='profile-about'>
                            <h5>Email</h5>
                            <p><?php echo $email; ?></p>
                            <h5>Institute</h5>
                            <p><?php echo $institution; ?></p>
                            <h5>Friends</h5>
                            <p><?php echo $friend_count; ?></p>
                            <h5>Age</h5>
                            <p><?php echo $age; ?></p>
                            <h5>Country</h5>
                            <p><?php echo $country; ?></p>
                            <h5>Interests</h5>
                            <?php if ($interests == "") { ?>
                                <p>Not Specified</p>
                            <?php } else { ?>
                                <p><?php echo $interests; ?></p>
                            <?php } ?>
                        </div>
                        <h5>Member since <?php echo $join_date; ?></h5>
                    </div>
                    <div class='col-sm-9 profile-posts'>
                        <h2>Posts</h2>
                        <?php
                        $query = "SELECT * FROM posts WHERE user_id = :user_id ORDER BY post_id DESC";
                        $statement = $db->prepare($query);
                        $statement->bindValue(":user_id", $id);
                        $statement->execute();
                        $result_filter = $statement->fetchAll();
                        $statement->closeCursor();
                        ?>
                        <div class="feed">
                            <div class="row">
                                <?php
                                if (!empty($result_filter)) {
                                    foreach ($result_filter as $result):
                                        $post_user_info = get_post_user_info($db, $result["user_id"]);
                                        $post_first_name = $post_user_info["first_name"];
                                        $post_last_name = $post_user_info["last_name"];
                                        $post_profile_pic = $post_user_info["profile_pic"];

                                        $post_category = get_post_category($db, $result["category_id"]);
                                        $post_likes_count = get_post_likes_count($db, $result["post_id"]);
                                        $post_like_status = get_post_like_status($db, $result["post_id"], $_SESSION["user_id"]);
                                        ?>
                                        <div class="col">
                                            <div class="item">
                                                <div class="item-info">
                                                    <img class="item-profile-pic" src="images/profiles/<?php echo $post_profile_pic; ?>" alt="Profile Pic">
                                                    <div class="item-user"><?php echo $post_first_name . " " . $post_last_name; ?></div>
                                                    <div class="item-time">Posted on <?php echo $result["time"]; ?></div>
                                                    <div class="item-likes" title="<?php echo $post_likes_count; ?> Likes"><i class="fa fa-thumbs-up" aria-hidden="true"></i><span><?php echo $post_likes_count; ?></span></div>
                                                </div>
                                                <div class = "item-content">
                                                    <?php
                                                    if ($result["content"] != "") {
                                                        ?>
                                                        <p><?php echo $result["content"]; ?></p>
                                                        <?php
                                                    }
                                                    if ($result["images"] != "") {
                                                        ?>
                                                        <img src="images/posts/<?php echo $result["images"]; ?>">
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="item-options">
                                                    <form class='form-horizontal item-comment' action='includes/comment-add-p.php' method='post'>
                                                        <input class="form-control form-input" type="text" name="comment" id="comment" placeholder="Type a comment..." required>
                                                        <div>
                                                            <p class="item-category" title="Category: <?php echo $post_category; ?>"><?php echo $post_category; ?></p>
                                                            <?php if ($post_like_status == 0) { ?>
                                                            <button class="btn btn-square btn-like" type="button"><i class="fa fa-thumbs-up" aria-hidden="true"></i><span>Like</span></button>
                                                            <?php } else { ?>
                                                            <button class="btn btn-square btn-like btn-liked" type="button"><i class="fa fa-thumbs-up" aria-hidden="true"></i><span>Liked</span></button>
                                                            <?php } ?>
                                                            <input type="hidden" name="post_id" value="<?php echo $result["post_id"]; ?>">
                                                            <input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"]; ?>">
                                                            <button class="btn btn-square btn-post" type="submit" title="Post comment">Comment<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    endforeach;
                                } else {
                                    ?>
                                    <div id='message'><i class='fa fa-info-circle' aria-hidden='true'></i>No posts just yet, get started by adding your own post!</div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script>
            var friend_id = "<?php echo $friend_id; ?>";

            $(document).ready(function () {
                if (friend_id == "") {
                    $('.navbar-right li:nth-child(1)').addClass("navbar-active");
                } else {
                    $('.nav-desktop li:nth-child(3)').addClass("nav-active");
                    $('.nav-mobile a:nth-child(3)').addClass("nav-active");
                }
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
                } else {
                    $(this).addClass("btn-liked");
                    $(this).find("span").text("Liked");
                    var post_likes_count = parseInt($(this).closest(".item").find(".item-info").find(".item-likes").find("span").text());
                    post_likes_count++;
                }

                $(this).closest(".item").find(".item-info").find(".item-likes").find("span").text(post_likes_count);
                $(this).closest(".item").find(".item-info").find(".item-likes").prop('title', post_likes_count += " Likes");

                $.ajax({
                    url: "includes/post-like-p.php",
                    type: "POST",
                    data: {
                        post_id: post_id,
                        action: action
                    }
                });
            });

            if (friend_id != "") {
                var width = $('.nav-mobile a:nth-child(1)').width() + $('.nav-mobile a:nth-child(2)').width();
                $('.nav-mobile').scrollLeft(width);
            }

            if (jQuery(".nav-mobile").css('display') == 'none') {
                jQuery.event.add(window, "load", resizeFrame);
                jQuery.event.add(window, "resize", resizeFrame);

                function resizeFrame() {
                    var h = $(window).height();

                    $(".nav-desktop").css('height', h);
                    $(".content").css('height', h);
                    $(".profile-info").css('height', h);
                    $(".profile-posts").css('height', h);
                }
            }
        </script>
    </body>
</html>