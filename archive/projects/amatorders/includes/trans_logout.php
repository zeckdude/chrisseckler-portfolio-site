<?php
session_start();
unset($_SESSION['authenticated_translator']);
include('connection.php');
header('Location: ' . $site_basedir . 'admin/trans_login.php');
?>