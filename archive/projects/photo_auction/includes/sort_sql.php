<?php

if(!isset($_POST['sort'])){  //The way it appears when the page is first loaded 
		$sql = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photos.status, users.username, photographers.photographer_sitelink
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			LEFT JOIN users ON photos.highest_bidder = users.user_id
			WHERE photos.status != 'finished'
			ORDER BY photos.end_auction DESC";
			
	 $sql_finished = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photos.status, users.username, photographers.photographer_sitelink
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			LEFT JOIN users ON photos.highest_bidder = users.user_id
			WHERE photos.status = 'finished'
			ORDER BY photos.end_auction ASC";
			

	} else if(isset($_POST['sort']) && !isset($_POST['filterby'])) { //if its is being sorted but not filtered
		if($_POST['sortby'] == 'end_auction') {
		$sql = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photos.status, users.username, photographers.photographer_sitelink
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			LEFT JOIN users ON photos.highest_bidder = users.user_id
			WHERE photos.status != 'finished'
			ORDER BY " .$_POST['sortby'] . ' ' . $_POST['direction'];
			
		$sql_finished = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photos.status, users.username, photographers.photographer_sitelink
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			LEFT JOIN users ON photos.highest_bidder = users.user_id
			WHERE photos.status = 'finished'
			ORDER BY " .$_POST['sortby'] . ' ' . $_POST['direction'];
		} else {
			$sql = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photos.status, users.username, photographers.photographer_sitelink
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			LEFT JOIN users ON photos.highest_bidder = users.user_id
			ORDER BY " .$_POST['sortby'] . ' ' . $_POST['direction'];	
		} //end else
		
		
		
		
	} else if(isset($_POST['sort']) && isset($_POST['filterby'])) { //if it is being sorted AND filtered
		if($_POST['sortby'] == 'end_auction') { //the user picks the ending auction sort feature
		$sql = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photos.status, users.username, photographers.photographer_sitelink
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			LEFT JOIN users ON photos.highest_bidder = users.user_id
			WHERE " . $_POST['category'] . " = '" . $_POST['filterby'] . "'AND photos.status != 'finished'
			ORDER BY " .$_POST['sortby'] . ' ' . $_POST['direction'];
			
		$sql_finished = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photos.status, users.username, photographers.photographer_sitelink
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			LEFT JOIN users ON photos.highest_bidder = users.user_id
			WHERE " . $_POST['category'] . " = '" . $_POST['filterby'] . "'AND photos.status = 'finished'
			ORDER BY " .$_POST['sortby'] . ' ' . $_POST['direction'];
		} else {
			$sql = "SELECT photos.photo_id, photos.photo_title, photos.photo_price, photos.photographer_id, photographers.photographer_id, photographers.photographer_name, photographers.photographer_firstname, photographers.photographer_lastname, photos.style_id, styles.style_id, styles.style_name, types.type_id, types.type_name, photos.image_id, images.image_id, images.image_filename, photos.highest_bidder, users.user_id, photos.end_auction, photos.status, users.username, photographers.photographer_sitelink
			FROM photos 
			LEFT JOIN photographers ON photos.photographer_id = photographers.photographer_id
			LEFT JOIN styles ON photos.style_id = styles.style_id
			LEFT JOIN types ON photos.type_id = types.type_id
			LEFT JOIN images ON photos.image_id = images.image_id
			LEFT JOIN users ON photos.highest_bidder = users.user_id
			WHERE " . $_POST['category'] . " = '" . $_POST['filterby'] . "'
			ORDER BY " .$_POST['sortby'] . ' ' . $_POST['direction'];
		} //end else
	} //end elseif
	
	//This is sending the request to the database and saving the results in $result
	$result = $conn->query($sql) or die(mysqli_error());
	
	if( ($_POST['sortby'] == 'end_auction') || (!isset($_POST['sort'])) ) {
		$finished_result = $conn->query($sql_finished) or die(mysqli_error());
	}
	
?>