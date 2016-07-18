<?php
function riylSong($songname) {
	$con = mysqli_connect('localhost', 'root', '10826294', 'projecttest');
	if (!$con) {
		die("Could not connect: " . mysqli_error($con) . "\n");
	}
	$sql = "SELECT echonest_id
		FROM Song
		WHERE title = '{$songname}'";
	$result = mysqli_query($con, $sql);
	if(!$result) {
		die("There is no song with that title\n");
	}
	$song_id = mysqli_fetch_array($result, MYSQLI_ASSOC)["echonest_id"];
	echo $song_id . "\n";
	$sql = "SELECT s.title AS Song, SUM(l.playcount) AS Weight
		FROM Song AS s, Listens_To_Song AS l
		WHERE s.echonest_id = l.song AND l.listener IN (
			SELECT DISTINCT listener
			FROM Listens_To_Song
			WHERE song IN (
					SELECT echonest_id
					FROM Song
					WHERE title = '{$songname}')
		GROUP BY Song
		ORDER BY Weight";
	$result = mysqli_query($con, $sql);
	return $result;
}

var_dump(riylSong("A Dustland Fairytale"));
?>
