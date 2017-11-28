<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    session_start();

    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
    $user_id = $_SESSION["user_id"];
    $action = filter_input(INPUT_POST, 'action', FILTER_VALIDATE_INT);

    $query1 = "SELECT likes FROM posts WHERE post_id = :post_id";
    $statement1 = $db->prepare($query1);
    $statement1->execute(array(":post_id" => $post_id));
    $results1 = $statement1->fetch();
    $statement1->closeCursor();

    $likes = $results1["likes"];

    if ($likes != NULL) {
        $likes_array = explode(",", $likes);
    }

    if ($action == 1) {
        if ($likes != NULL) {
            array_diff($likes_array, [$user_id]);
            $likes_new = implode(",", $likes_array);
        } else {
            $likes_new = $user_id;
        }

        $query2 = "UPDATE posts SET likes = :likes WHERE post_id = :post_id";
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(":post_id", $post_id);
        $statement2->execute();
        $statement2->closeCursor();
    } else if ($action == 2) {
        
    }
} else {
    header("Location: ../index.php");
    exit();
}