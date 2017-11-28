<?php

require_once('connection.php');
require_once('functions.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$category_id = filter_input(INPUT_POST, 'filterselect', FILTER_SANITIZE_STRING);

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {

    if ($category_id == 1) {
        $query = "SELECT * FROM posts ORDER BY post_id DESC";
        $statement = $db->prepare($query);
        $statement->execute();
        $result_filter = $statement->fetchAll();
        $statement->closeCursor();
    } else {
        $query = "SELECT * FROM posts WHERE category_id = :category_id ORDER BY post_id DESC";
        $statement = $db->prepare($query);
        $statement->bindValue(":category_id", $category_id);
        $statement->execute();
        $result_filter = $statement->fetchAll();
        $statement->closeCursor();
    }
    $_SESSION['postAdded'] = 1;

    echo '<div class="feed">';
    echo '<div class="row">';
    if (!empty($result_filter)) {
        foreach ($result_filter as $result):

            $post_user_info = get_post_user_info($db, $result["user_id"]);
            $post_first_name = $post_user_info["first_name"];
            $post_last_name = $post_user_info["last_name"];
            $post_profile_pic = $post_user_info["profile_pic"];

            $post_category = get_post_category($db, $result["category_id"]);
            $post_likes_count = get_post_likes_count($db, $result["post_id"]);
            $post_like_status = get_post_like_status($db, $result["post_id"], $_SESSION["user_id"]);

            echo '<div class="col">';
            echo '<div class="item">';
            echo '<div class="item-info">';
            echo '<img class="item-profile-pic" src="images/profiles/' . $post_profile_pic . '" alt="Profile Pic">';
            echo '<div class="item-user">' . $post_first_name . " " . $post_last_name . '</div>';
            echo '<div class="item-time">Posted on ' . $result["time"] . '</div>';
            echo '<div class="item-likes"><i class="fa fa-thumbs-up" aria-hidden="true"></i>' . $post_likes_count . '</div>';
            echo '</div>';
            echo '<div class = "item-content">';
            if ($result["content"] != "") {

                echo '<p>' . $result["content"] . '</p>';
            }
            if ($result["images"] != "") {
                echo '<img src="images/posts/' . $result["images"] . '">';
            }
            echo '</div>';
            echo '<div class="item-options">';
            echo "<form class='form-horizontal item-comment' action='includes/comment-add-p.php' method='post'>";
            echo '<input class="form-control form-input" type="text" name="comment" id="comment" placeholder="Type a comment..." required>';
            echo '<div>';
            echo '<p class="item-category" title="' . $post_category . '">' . $post_category . '</p>';
            if ($post_like_status == 0) {
                echo '<button class="btn btn-square btn-like"><i class="fa fa-thumbs-up" aria-hidden="true"></i><span>Like</span></button>';
            } else {
                echo '<button class="btn btn-square btn-like btn-liked"><i class="fa fa-thumbs-up" aria-hidden="true"></i><span>Liked</span></button>';
            }
            echo '<input type="hidden" name="user_id" value="'. htmlspecialchars($_SESSION["user_id"]).'">';
            echo '<input type="hidden" name = "post_id" value="' . $result["post_id"] . '">';
            echo '<button class="btn btn-square btn-post" type="submit" title="Post comment">Comment<i class="fa fa-chevron-right" aria-hidden="true"></i></button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        endforeach;
    } else {
        echo "<div id='message'><i class='fa fa-info-circle' aria-hidden='true'></i>No posts just yet, get started by <a href='friends.php'>adding friends</a> and also by adding your own post!</div>";
    }
    echo '</div>';
    echo '</div>';
} else {
    $query = "SELECT * FROM posts ORDER BY post_id DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $result_filter = $statement->fetchAll();
    $statement->closeCursor();

    echo '<div class="feed">';
    echo '<div class="row">';
    if (!empty($result_filter)) {
        foreach ($result_filter as $result):

            $post_user_info = get_post_user_info($db, $result["user_id"]);
            $post_first_name = $post_user_info["first_name"];
            $post_last_name = $post_user_info["last_name"];
            $post_profile_pic = $post_user_info["profile_pic"];

            $post_category = get_post_category($db, $result["category_id"]);
            $post_likes_count = get_post_likes_count($db, $result["post_id"]);
            $post_like_status = get_post_like_status($db, $result["post_id"], $_SESSION["user_id"]);

            echo '<div class="col">';
            echo '<div class="item">';
            echo '<div class="item-info">';
            echo '<img class="item-profile-pic" src="images/profiles/' . $post_profile_pic . '" alt="Profile Pic">';
            echo '<div class="item-user">' . $post_first_name . " " . $post_last_name . '</div>';
            echo '<div class="item-time">Posted on ' . $result["time"] . '</div>';
            echo '<div class="item-likes"><i class="fa fa-thumbs-up" aria-hidden="true"></i>' . $post_likes_count . '</div>';
            echo '</div>';
            echo '<div class = "item-content">';
            if ($result["content"] != "") {

                echo '<p>' . $result["content"] . '</p>';
            }
            if ($result["images"] != "") {
                echo '<img src="images/posts/' . $result["images"] . '">';
            }
            echo '</div>';
            echo '<div class="item-options">';
            echo "<form class='form-horizontal item-comment' action='includes/comment-add-p.php' method='post'>";
            echo '<input class="form-control form-input" type="text" name="comment" id="comment" placeholder="Type a comment..." required>';
            echo '<div>';
            echo '<p class="item-category" title="' . $post_category . '">' . $post_category . '</p>';
            if ($post_like_status == 0) {
                echo '<button class="btn btn-square btn-like"><i class="fa fa-thumbs-up" aria-hidden="true"></i><span>Like</span></button>';
            } else {
                echo '<button class="btn btn-square btn-like btn-liked"><i class="fa fa-thumbs-up" aria-hidden="true"></i><span>Liked</span></button>';
            }
            echo '<input type="hidden" name="user_id" value="'. htmlspecialchars($_SESSION["user_id"]).'">';
            echo '<input type="hidden" name = "post_id" value="' . $result["post_id"] . '">';
            echo '<button class="btn btn-square btn-post" type="submit" title="Post comment">Comment<i class="fa fa-chevron-right" aria-hidden="true"></i></button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        endforeach;
    } else {
        echo "<div id='message'><i class='fa fa-info-circle' aria-hidden='true'></i>No posts just yet, get started by <a href='friends.php'>adding friends</a> and also by adding your own post!</div>";
    }
    echo '</div>';
    echo '</div>';
}
