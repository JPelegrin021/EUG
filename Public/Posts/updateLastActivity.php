<?php
include("../DB/dbconnect.php");

function updateLastActivity($mysqli, $userId) {
    $currentTime = date('Y-m-d H:i:s');
    $query = $mysqli->prepare("UPDATE Users SET last_activity = ? WHERE Code = ?");
    $query->bind_param("si", $currentTime, $userId);
    $query->execute();
}
?>
