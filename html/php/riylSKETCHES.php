<?php
function riylSong($songname) {
	$con = mysqli_connect('localhost', 'superuser', 'superP@$$123', 'projecttest');
	if (!$con) {
		die("Could not connect: " . mysqli_error($con) . "\n");
	}
	$sql = "IF EXISTS (SELECT count(*)
		FROM Song
		WHERE title LIKE '%{$songname}%'
		HAVING count(*) > 1)";
	$result = mysqli_query($con, $sql);
	if (mysqli_fetch_array($result, MYSQLI_NUM)[0] > 1) {
		//I dunno yet
	}

	$sql = "SELECT s.title AS Song, SUM(l.playcount) AS Weight
		FROM Song AS s, Listens_To_Song AS l
		WHERE s.echonest_id = l.song AND l.listener IN (
			SELECT DISTINCT listener
			FROM Listens_To_Song
			WHERE song IN (	SELECT s.echonest_id
					FROM Song AS s, Artist AS a
					WHERE s.artist = a.echonest_id AND s.title LIKE '%{$songname}%'))
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

$sql = "CREATE PROCEDURE recommend_song()
	BEGIN
	IF EXISTS (SELECT count(*)
		FROM Song
		WHERE title LIKE '%{$songname}%'
		HAVING count(*) > 1) 
	THEN
	SELECT s.title, a.name, s.genre, s.album, s.release_year, SUM(l.playcount) AS Weight
	FROM Song AS s, Listens_To_Song AS l, Artist AS a
	WHERE s.echonest_id = l.song AND s.artist = a.echonest_id AND l.listener IN (
		SELECT DISTINCT listener
		FROM Listens_To_Song
		WHERE song IN (	SELECT echonest_id
				FROM Song
				WHERE title LIKE '%{$songname}%'))
	GROUP BY s.title, a.name, s.genre, s.album, s.release_year
	ORDER BY Weight
	ELSE THEN
	SELECT s.title AS Song, SUM(l.playcount) AS Weight
		FROM Song AS s, Listens_To_Song AS l
		WHERE s.echonest_id = l.song AND l.listener IN (
			SELECT DISTINCT listener
			FROM Listens_To_Song
			WHERE song IN (	SELECT s.echonest_id
					FROM Song AS s, Artist AS a
					WHERE s.artist = a.echonest_id AND s.title LIKE '%{$songname}%'))
		GROUP BY Song
		ORDER BY Weight
	END IF
	END";
?>
