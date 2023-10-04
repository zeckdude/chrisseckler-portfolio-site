<?php

include("connection.php");
$conn = dbConnect('query');

$sql = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photos.winner_email_sent, photos.status
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			LEFT JOIN users ON photos.highest_bidder = users.user_id
			ORDER BY photos.photo_price DESC";

$result = $conn->query($sql) or die(mysqli_error());


$now = time();

while($row = $result->fetch_assoc()) {
	
	// 1. Check if the current entry auction end date is past
	if($now >= strtotime($row['end_auction'])) { //if the auction is finished
		
		// 2. Check if the current entry auction winner has already received a notification email
		if($row['winner_email_sent'] == 'not sent') { //if the winner has not received an notification email since the auction has finished
			$conn = dbConnect('query');
			
			// 3. If the current entry auction is past, then find out who the winner is
			$winner_sql = "SELECT users.user_id, users.user_email, users.user_firstname, users.user_lastname, photos.highest_bidder
							FROM users
							LEFT JOIN photos ON users.user_id = photos.highest_bidder
							WHERE users.user_id = '" . $row['highest_bidder'] . "'";
							
			$winner_result = $conn->query($winner_sql) or die(mysqli_error());
			$winner_row = $winner_result->fetch_assoc();
			
			
			$name = 'Silent Auction';
			$mailTo = $winner_row['user_email'];
			$mailFrom = 'silent@auction.com';
			$subject = 'You have won the auction for the photo ' . $row['photo_title'];
			$mainmessage = 'Congratulations ' . $winner_row['user_firstname'] . ' ' . $winner_row['user_lastname'] . ', you have the won the photo ' . $row['photo_title'] . '. Please follow these steps to process your order and claim your photo.';
			
			// 4. Send the auction winner an email			
			mail($mailTo, $subject, $mainmessage, "From: ".$mailFrom, $name);
			
			$conn = dbConnect('admin');
			// 5. Change the string in the winner_email_sent column to 'sent' so no duplicate emails are sent the next time it checks if an auction is finished
			$update_sql = "UPDATE photos 
					SET winner_email_sent = 'sent', status = 'finished'
					WHERE photo_id = " . $row['photo_id'];
							
			$update_result = $conn->query($update_sql) or die(mysqli_error());
		} //end if the winner_email_sent is 'not sent'
	} //end if auction is over
} // end while loop







/*$name = 'Silent Auction';
$mailTo = 'zeckdude@gmail.com';
$mailFrom = 'silent@auction.com';
$subject = 'This is an email to show that the script and Cron Job is working';
$mainmessage = 'Congratulations, you have the won the photo blablabla. Please follow these steps to process your order and claim your photo.';

			
mail($mailTo, $subject, $mainmessage, "From: ".$mailFrom, $name);*/
?>