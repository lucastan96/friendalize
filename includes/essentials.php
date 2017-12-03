<?php

require_once('includes/connection.php');
require_once('includes/functions.php');

$institution_id = get_institution_id($db, $_SESSION['user_id']);

if ($institution_id == NULL) {
    header("Location: setup-institution.php");
    exit();
}

//$confirm_clicked = filter_input(INPUT_GET, 'clicked', FILTER_SANITIZE_STRING);
//
//if (isset($confirm_clicked)) {
//  
//    $update_comment_status = update_comment_status($db);
//    header("Location: ?");
//    exit();
//}

$profile_pic = get_profile_pic($db, $_SESSION['user_id']);
$first_name = get_first_name($db, $_SESSION['user_id']);
$notifications_count = get_notifications_count($db, $_SESSION['user_id']);
$result2 = get_notification_comments($db, $_SESSION['user_id']);
