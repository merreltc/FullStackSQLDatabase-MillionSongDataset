<?php
function riylSong($songname) {
	$con = mysqli_connect('localhost', 'superuser', 'superp@$$123', 'projecttest');
	if (!$con) {
		die("Could not connect: " . mysqli_error($con) . "\n");
	}
	$sql = "SELECT echonest_id
		FROM Song
		WHERE title = {$songname}"
	$result = mysqli_query($con, $sql);
	if(!$result) {
		die("There is no song with that title");
	}
	$song_id = mysqli_fetch_array($result, MYSQLI_ASSOC)["echonest_id"];
	$sql = "SELECT s.title AS Song, SUM(l.playcount) AS Weight
		FROM Song AS s, Listens_To_Song AS l
		WHERE s.echonest_id = l.song AND l.id IN (
			SELECT DISTINCT id
			FROM Listens_To_Song
			WHERE song = {$song_id})
		GROUP BY Song
		ORDER BY Weight"
	$result = mysqli_query($con, $sql);
	return $result;
}
?>
