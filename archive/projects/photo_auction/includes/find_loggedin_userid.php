<?php



$conn = dbConnect('admin');
$userid_sql = 'SELECT user_id, username
			   FROM users
			   WHERE username = "' . $_SESSION['authenticated_pa'] . '"';

$userid_result = $conn->query($userid_sql) or die(mysqli_error());
$userid_row = $userid_result->fetch_assoc();
$user_id = $userid_row['user_id'];







?>