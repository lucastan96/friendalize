<?php

require_once('includes/connection.php');
require_once('includes/functions.php');

$institution_id = get_institution_id($db, $_SESSION['user_id']);

if ($institution_id == NULL) {
    header("Location: setup-institution.php");
    exit();
}

$profile_pic = get_profile_pic($db, $_SESSION['user_id']);
$first_name = get_first_name($db, $_SESSION['user_id']);