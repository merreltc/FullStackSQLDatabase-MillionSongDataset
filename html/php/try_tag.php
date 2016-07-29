<?php
$type = $_GET['type'];
$song = $_GET['songval'];
$artist = $_GET['artistval'];
$tag = $_GET['tagval'];

$con = mysqli_connect('localhost','superuser','superP@$$123','testdb');
if (!$con) {
	die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,'projecttest');

switch($type) {
	case "song":

	$sql="DECLARE @song_title char(18);";
	mysqli_query($con,$sql);

	$sql="START TRANSACTION;";
	mysqli_query($con,$sql);

	$sql="SELECT s.echonest_id INTO @song_title
		FROM Song s, Artist a WHERE s.artist = a.echonest_id AND s.title = '".$song."' AND a.name = '".$artist."';";
	mysqli_query($con,$sql);

	$sql="INSERT INTO Tag(song, tag)
		VALUES(song_title, '".$tag."');";
	mysqli_query($con,$sql);

	$sql="COMMIT;";

	if (mysqli_query($con,$sql)) {
		echo "<p>Song tag pending, please wait approx. 72 hours for tag to appear on the site.</p>";
	} else {
		echo "<p>Error tagging song: ".mysqli_error($con)." Please try again or contact us.</p>";
	}
	break;

	case "artist":
		$sql="DECLARE @song_title char(18);";
	mysqli_query($con,$sql);

	$sql="START TRANSACTION;";
	mysqli_query($con,$sql);

	$sql="SELECT echonest_id INTO @artist_id
		FROM Artist WHERE name = '".$artist."';";
	mysqli_query($con,$sql);

	$sql="INSERT INTO Artist_Tag(artist, tag)
		VALUES(artist_id, '".$tag."');";
	mysqli_query($con,$sql);

	$sql="COMMIT;";

	if (mysqli_query($con,$sql)) {
		echo "<p>Artist tag pending, please wait approx. 72 hours for tag to appear on the site.</p>";
	} else {
		echo "<p>Error tagging artist: ".mysqli_error($con)." Please try again or contact us.</p>";
	}
	break;
}

mysqli_close($con);
?>