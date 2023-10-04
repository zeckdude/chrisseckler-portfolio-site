<?php
session_start();
session_destroy();
include('connection.php');
header('Location: ' . $site_basedir . 'login.php');
?>