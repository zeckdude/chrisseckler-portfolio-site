<?php 
	ob_start();
	include("../includes/connection.php");
	header('Location: ' . $site_basedir . 'index.php');
?>
