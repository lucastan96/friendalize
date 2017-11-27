<?php
session_start();

require_once('connection.php');

$category_id = filter_input(INPUT_POST, 'filter-select', FILTER_SANITIZE_INT);

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {

    $_SESSION['filter-select'] = $category_id;
    $_SESSION['postAdded'] = 1;

    header("Location: ../index.php");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
