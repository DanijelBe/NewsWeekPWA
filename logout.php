<?php
session_start();
if (isset($_POST['logout_button'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: administracija.php");
    exit;
}
?>