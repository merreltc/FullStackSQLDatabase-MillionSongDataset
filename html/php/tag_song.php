<?php
	$song = $_GET['song_val'];
	$artist = $_GET['artist_val'];
	$tag = $_GET['tag_val'];

	$con = mysqli_connect('localhost','superuser','superP@$$123','testdb');
	if (!$con) {
		die('Could not connect: ' . mysqli_error($con));
	}

	mysqli_select_db($con,'projecttest');

	// Check for song in database first
	$sql="INSERT INTO `Pending-Tag`(song, artist, tag) VALUES('".$song."' , '".$artist."' , '".$tag."')";
	if (mysqli_query($con,$sql)) {
		echo "<p>Song tag pending, please wait approx. 72 hours for tag to appear on the site.</p>";
	} else {
		echo "<p>Error tagging song. Please try again or <a href='#'>contact us.</a></p>";
	}

	mysqli_close($con);
?>