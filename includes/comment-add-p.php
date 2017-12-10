<?php
session_start();

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    require_once('connection.php');

    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);

    $prohibited_words = array("fudge", "egg", "shirt");
    $pass = true;

    for ($i = 0; $i < sizeof($prohibited_words); $i++) {
	if (strpos($comment, $prohibited_words[$i]) !== false) {
	    $pass = false;
	}
    }

    if ($pass == false) {
	$message = "<i class='fa fa-info-circle' aria-hidden='true'></i>The comment contains prohibited words.<div><i class='fa fa-times' aria-hidden='true'></i></div>";

	header("Location: ../index.php");
	exit();
    } else {
	$query2 = "INSERT INTO post_comments (comment , user_id , post_id) VALUES (:comment , :id , :post_id);";
	$statement2 = $db->prepare($query2);
	$statement2->bindValue(":comment", $comment);
	$statement2->bindValue(":id", $user_id);
	$statement2->bindValue(":post_id", $post_id);
	$statement2->execute();
	$statement2->closeCursor();
	
	$_SESSION["commentAdded"] = 1;

	header('Location: ../index.php');
	exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
