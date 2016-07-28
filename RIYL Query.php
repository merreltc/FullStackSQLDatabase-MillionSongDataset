<?php
function riylSong($songname) {
	$con = mysqli_connect('localhost', 'superuser', 'superP@$$123', 'projecttest');
	if (!$con) {
		die("Could not connect: " . mysqli_error($con) . "\n");
	}
	$sql = "SELECT count(*)
		FROM Song
		WHERE title LIKE '%{$songname}%'";
	$result = mysqli_query($con, $sql);
	if (mysqli_fetch_array($result, MYSQLI_NUM)[0] > 1) {
		//I dunno yet
	}

	$sql = "SELECT s.title AS Song, SUM(l.playcount) AS Weight
		FROM Song AS s, Listens_To_Song AS l
		WHERE s.echonest_id = l.song AND l.listener IN (
			SELECT DISTINCT listener
			FROM Listens_To_Song
			WHERE song IN (	SELECT echonest_id
					FROM Song
					WHERE title LIKE '%{$songname}%'))
		GROUP BY Song
		ORDER BY Weight";
	$result = mysqli_query($con, $sql);
	return $result;
}

function riylArtist($artistname) {
	$con = mysqli_connect('localhost', 'superuser', 'superP@$$123', 'projecttest');
	if (!$con) {
		die("Could not connect: " . mysqli_error($con) . "\n");
	}
	$sql = "SELECT count(*)
		FROM Artist
		WHERE name LIKE '%{$artistname}%'";
	$result = mysqli_query($con, $sql);
	if (mysqli_fetch_array($result, MYSQLI_NUM)[0] > 1) {
		//I dunno yet
	}
	$sql = "SELECT a.name AS Artist, SUM(l.playcount) AS Weight
		FROM Artist AS a, Listens_To_Artist AS l
		WHERE a.echonest_id = l.artist AND l.listener IN (
			SELECT DISTINCT listener
			FROM Listens_To_Artist
			WHERE artist IN (SELECT echonest_id
					FROM Artist
					WHERE name LIKE '%{$artistname}%'))
		GROUP BY Artist
		ORDER BY Weight";
	$result = mysqli_query($con, $sql);
	return $result;
}

var_dump(riylArtist("Killers"));
?>
