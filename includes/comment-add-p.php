<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    require_once('includes/connection.php');

    $comment_text = filter_input(INPUT_POST, 'comment_text', FILTER_SANITIZE_STRING);
    $member_id = filter_input(INPUT_POST, 'member_id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);

    $prohibited_words = array("fudge", "egg", "shirt");
    $pass = true;

    for ($i = 0; $i < sizeof($prohibited_words); $i++) {
	if (strpos($comment_text, $prohibited_words[$i]) !== false) {
	    $pass = false;
	}
    }

    if ($pass == false) {
	$message = "<i class='fa fa-info-circle' aria-hidden='true'></i>The comment contains prohibited words.<div><i class='fa fa-times' aria-hidden='true'></i></div>";

	header("Location: post.php?id=" . $post_id);
	exit();
    } else {
	$query2 = "INSERT INTO comment (comment_text , member_id , post_id) VALUES (:comment_text , :id , :post_id);";
	$statement2 = $db->prepare($query2);
	$statement2->bindValue(":comment_text", $comment_text);
	$statement2->bindValue(":id", $member_id);
	$statement2->bindValue(":post_id", $post_id);
	$statement2->execute();
	$statement2->closeCursor();
	
	$_SESSION["commentAdded"] = 1;

	header('Location: post?id=' . $post_id);
	exit();
    }
} else {
    header("Location: index");
    exit();
}
