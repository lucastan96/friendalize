<?php

session_start();

require_once('connection.php');

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING);
$content = filter_input(INPUT_POST, 'post', FILTER_SANITIZE_STRING);
$category_id = filter_input(INPUT_POST, 'post_category', FILTER_SANITIZE_STRING);

if (!empty($_FILES['picture']['name'])) {
    $target_dir = "../images/posts/";
    $target_name = basename($_FILES["picture"]["name"]);
    $target_file = $target_dir . $target_name;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    $request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

    if ($request_method == 'POST') {
        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if ($check == FALSE) {
            $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Uploaded file is not an image.<div><i class'fa fa-times' aria-hidden='true'></i></div>";
        }

        if (isset($message)) {
            include '../index.php';
            exit();
        }

        if ($_FILES["picture"]["size"] > 50000000) {
            $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Uploaded file is too large.<div><i class'fa fa-times' aria-hidden='true'></i></div>";
        }

        if (isset($message)) {
            include 'index.php';
            exit();
        }

        if ($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Only JPG, JPEG, PNG & GIF files allowed.<div><i class'fa fa-times' aria-hidden='true'></i></div>";
        }

        if (isset($message)) {
            include 'index.php';
            exit();
        } else {
            $query3 = "INSERT INTO posts (content, category_id, user_id) VALUES (:content, :category_id, :user_id )";
            $statement3 = $db->prepare($query3);
            $statement3->bindValue(":content", $content);
            $statement3->bindValue(":category_id", $category_id);
            $statement3->bindValue(":user_id", $user_id);
            $statement3->execute();
            $statement3->closeCursor();

            $query5 = "SELECT post_id FROM posts WHERE content = :content AND category_id = :category_id AND user_id = :user_id";
            $statement5 = $db->prepare($query5);
            $statement5->bindValue(":content", $content);
            $statement5->bindValue(":category_id", $category_id);
            $statement5->bindValue(":user_id", $user_id);
            $statement5->execute();
            $result_array5 = $statement5->fetch();
            $statement5->closeCursor();
            
            $post_id = $result_array5["post_id"];

            $pic_name = $target_dir . "post_" . $post_id . "." . $imageFileType;
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $pic_name)) {
                $fileName = "post_" . $post_id . "." . $imageFileType;
                $query4 = "UPDATE posts SET images = :images where post_id = :post_id";
                $statement4 = $db->prepare($query4);
                $statement4->bindValue(":images", $fileName);
                $statement4->bindValue(":post_id", $post_id);
                $statement4->execute();
                $statement4->closeCursor();

                $_SESSION['postAdded'] = 1;

                header("Location: http://localhost/friendalize/");
                exit();
            }
        }
    } else {
        header("Location: http://localhost/friendalize/");
        exit();
    }
} else {
    $query3 = "INSERT INTO posts (content, category_id, user_id) VALUES (:content, :category_id, :user_id )";
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(":content", $content);
    $statement3->bindValue(":category_id", $category_id);
    $statement3->bindValue(":user_id", $user_id);
    $statement3->execute();
    $statement3->closeCursor();

    $_SESSION['postAdded'] = 1;

    header("Location: http://localhost/friendalize/");
    exit();
}