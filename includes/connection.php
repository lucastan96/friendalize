<?php
require_once 'constant.php';

$dsn = 'mysql:host=' . HOST . ';dbname=' . DBNAME;

try {
    $db = new PDO($dsn, USERNAME, PASSWORD);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_reporting(E_ALL);
} catch (Exception $e) {
    $error_message = 'Connection Failed';
    $error_message .= $e->getMessage();

    include('db_error.php');
    exit();
}