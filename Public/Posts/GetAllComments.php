<?php
include '../DB/dbconnect.php';

$query = $mysqli->prepare("SELECT Comments.Code, Comments.Comment, Comments.Date, Users.UserName FROM Comments JOIN Users ON Comments.User = Users.Code ORDER BY Comments.Date DESC");
$query->execute();
$result = $query->get_result();

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}
?>
