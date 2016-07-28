<?php
	require 'createdb.php';

function sanitizeField($field) {
	$san = str_replace("'", "''", $field);
	$san = str_replace("[", "", $san);
	$san = str_replace("]", "", $san);
	$san = str_replace("\\", "", $san);
	$san = rtrim($san);
	return $san;
}

function sanitizeArray($arr) {
	for($i=0; $i < count($arr); $i += 1) {
		$arr[$i] = sanitizeField($arr[$i]);
	}
	return $arr;
}

$con = mysqli_connect('localhost','superuser','superP@$$123');
 	if (!$con) {
 		die('Could not connect: ' . mysqli_error($con) . "\n");
 	}

 	// Make MillionSongs the current database		
	$db_selected = mysqli_select_db($con, 'projecttest');
	if (!$db_selected) {
		die('Database not connected');
	}

	echo "Import beginning...\n\n";

	$songsartistsfile = fopen("/var/www/html/imports/SongsArtists.csv", "r") or die("Unable to open file! :(");

	while(!feof($songsartistsfile)) {
		$fields = sanitizeArray(explode(",", fgets($songsartistsfile), 18));
		$sql = "INSERT INTO Artist (echonest_id, musicbrainz_id, name, hotttnesss, familiarity)
			 VALUES ('{$fields[12]}', '{$fields[13]}', '{$fields[14]}', {$fields[15]}, {$fields[16]})";

		if (mysqli_query($con, $sql)) {
			$tags = sanitizeArray(explode(",", $fields[17]));
			foreach($tags as $tag) {
				$sql = "INSERT INTO Artist_Tag (artist, tag)
					VALUES ('{$fields[12]}', '{$tag}');";
				if(!mysqli_query($con, $sql)) {
					echo "Error: " . $sql . "\n" . $mysqli_error($con) . "\n\n";
				}
			}
		} else {
		    if(!(strpos(mysqli_error($con), "key 'PRIMARY'") !== false)) {
			 echo "Error: " . $sql . "\n" . mysqli_error($con) . "\n\n";
		    }
		}
		$sql = "INSERT INTO Song (echonest_id, track_id, sevendigital_id, title, artist, release_year, album, loudness, hotttnesss, tempo, song_key, mode, start)
			VALUES ('{$fields[0]}', '{$fields[1]}', '{$fields[2]}', '{$fields[3]}', '{$fields[12]}', {$fields[4]}, '{$fields[5]}', {$fields[6]}, {$fields[7]}, {$fields[8]}, {$fields[9]}, {$fields[10]}, {$fields[11]})";
	
	$artistsfile = fopen("/var/www/html/imports/ArtistListens.tsv", "r") or die("Unable to open file! :(");

	while(!feof($artistsfile)) {
		$fields = explode("\t", fgets($artistsfile));
		$fields[1] = str_replace("-", "", $fields[1]);
		$sql = "INSERT INTO Listener (echonest_id, lastfm_sha, username)
			VALUES (null, '{$fields[0]}', null)";

		if (!mysqli_query($con, $sql) && !(strpos(mysqli_error($con), "Duplicate") !== false)) {
		    echo "Error: " . $sql . "\n" . mysqli_error($con) . "\n\n";
		}
	}
	fclose($songsartistsfile);

	echo "Songs, Artists, and ArtistTags imported\n\n";

	$genresfile = fopen("/var/www/html/imports/Genres.tsv", "r") or die("Unable to open file! :(");

	while(!feof($genresfile)) {
		$fields = sanitizeArray(explode("\t", fgets($genresfile)));
		$sql = "UPDATE Song 
			SET genre = '{$fields[1]}'
			WHERE track_id = '{$fields[0]}';";

		if(!mysqli_query($con, $sql)) {
		    echo "Error: " . $sql . "\n" . mysqli_error($con) . "\n\n";	
		}
	}
	fclose($genresfile);
	
	echo "Genres imported\n";

	$songsfile = fopen("/var/www/html/imports/SongListens.tsv", "r") or die("Unable to open file! :(");

	while(!feof($songsfile)) {
		$fields = explode("\t", fgets($songsfile));
		$sql = "INSERT INTO Listener (echonest_id, lastfm_sha, username)
		 	VALUES ('{$fields[0]}', null, null)";

		if (!mysqli_query($con, $sql) && !(strpos(mysqli_error($con), "Duplicate") !== false)) {
		    echo "Error: " . $sql . "\n" . mysqli_error($con) . "\n\n";
		}

		$sql = "SELECT master_id
			FROM Listener
			WHERE echonest_id = '{$fields[0]}'";
		$result = mysqli_query($con, $sql);
		$id = mysqli_fetch_array($result, MYSQLI_ASSOC)["master_id"];

		$sql = "INSERT INTO Listens_To_Song (listener, song, playcount)
			VALUES ({$id}, '{$fields[1]}', {$fields[2]})";
	
		if (!mysqli_query($con, $sql)) {
		    echo "Error: " . $sql . "\n" . mysqli_error($con) . "\n\n";
		}
	}
	fclose($songsfile);
	echo "Listeners and SongListens imported\n";
	
	$artistsfile = fopen("/var/www/html/imports/ArtistListens.tsv", "r") or die("Unable to open file! :(");

	while(!feof($artistsfile)) {
		$fields = explode("\t", fgets($artistsfile));
		$fields[1] = str_replace("-", "", $fields[1]);
		$sql = "INSERT INTO Listener (echonest_id, lastfm_sha, username)
			VALUES (null, '{$fields[0]}', null)";

		if (!mysqli_query($con, $sql) && !(strpos(mysqli_error($con), "Duplicate") !== false)) {
		    echo "Error: " . $sql . "\n" . mysqli_error($con) . "\n\n";
		}
	     
		$sql = "SELECT master_id
			FROM Listener
			WHERE lastfm_sha = '{$fields[0]}'";
		$result = mysqli_query($con, $sql);
		$id = mysqli_fetch_array($result, MYSQLI_ASSOC)["master_id"];

		$sql = "SELECT echonest_id
			FROM Artist
			WHERE musicbrainz_id = '{$fields[1]}'";
		$result = mysqli_query($con, $sql);
		$artist = mysqli_fetch_array($result, MYSQLI_ASSOC)["echonest_id"];
	     
		$sql = "INSERT INTO Listens_To_Artist (listener, artist, playcount)
		 VALUES ({$id}, '{$artist}', {$fields[3]})";
	
		if (!mysqli_query($con, $sql)) {
		    echo "Error: " . $sql . "\n" . mysqli_error($con) . "\n\n";
		}
	}
	fclose($artistsfile);
	echo "Listeners and ArtistListens imported\n\n";

	$songtagfile = fopen("/var/www/html/imports/SongTags.tsv", "r") or die("Unable to open file! :(");

	while(!feof($songtagfile)) {
		$fields = sanitizeArray(explode("\t", fgets($songtagfile)));
		$sql = "SELECT echonest_id
			FROM Song
			WHERE track_id = '{$fields[1]}'";
		echo $sql . "\n\n";

		$result = mysqli_query($con, $sql);
		$song_id = mysqli_fetch_array($result, MYSQLI_ASSOC)["echonest_id"];

		echo $song_id . "\n";

		$sql = "INSERT INTO Tag (song, tag)
			VALUES ('{$song_id}', '{$fields[0]}')";
		if (!mysqli_query($con, $sql)) {
		    echo "Error: " . $sql . "\n\n" . mysqli_error($con);
		}
	}
	fclose($songtagfile);
	echo "SongTags imported\n\n";

 	mysqli_close($con);
?>
