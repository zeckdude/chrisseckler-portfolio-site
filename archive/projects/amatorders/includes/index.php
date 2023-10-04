<?php 
	ob_start();
	include("connection.php");
	header('Location: ' . $site_basedir . 'index.php');
?>
