<?php

require_once('connection.php');

$sql = "UPDATE post_comments SET status=1 WHERE status=0";
$statement1 = $db->prepare($sql);
$statement1->execute();
$result = $statement1->fetchAll();
$statement1->closeCursor();

$sql2 = "select * from post_comments ORDER BY post_id DESC limit 5";
$statement2 = $db->prepare($sql2);
$statement2->execute();
$result2 = $statement2->fetchAll();

foreach ($result2 as $row):
    echo $row["comment"] . "<br>";

endforeach;

?>
