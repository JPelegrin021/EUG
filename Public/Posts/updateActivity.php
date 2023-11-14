<?php
session_start();
include("../DB/dbconnect.php");
include("updateLastActivity.php");

if (isset($_SESSION['usuario_id'])) {
    updateLastActivity($mysqli, $_SESSION['usuario_id']);
}
?>
