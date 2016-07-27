<?php
	require 'createdb.php';

function sanitizeField($field) {
	$san = str_replace("'", "''", $field);
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

	$songsartistsfile = fopen("/var/www/html/imports/SongsArtists.tsv", "r") or die("Unable to open file! :(");

	while(!feof($songsartistsfile)) {
		$fields = sanitizeArray(explode("\t", fgets($songsartistsfile)));
		$sql = "INSERT INTO Artist (echonest_id, musicbrainz_id, name, hotttnesss, familiarity)
			 VALUES ('{$fields[12]}', '{$fields[13]}', '{$fields[14]}', {$fields[15]}, {$fields[16]})";

		if (mysqli_query($con, $sql)) {
			echo "New record in Artist created successfully\n";
			$tags = sanitizeArray(array_merge(explode(",", substr($fields[17], 1, -1)), explode(",", substr($fields[18], 1, -1))));
			foreach($tags as $value) {
				$sql = "INSERT INTO Artist_Tag (artist, tag)
					VALUES ('{$fields[12]}', '{$tag}');";
				if(mysqli_query($con, $sql)) {
					echo "New record in Artist_Tag created succesfully\n";
				} else {
					echo "Error: " . $sql . "<br>" . $mysqli_error($con) . "\n";
				}
			}
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
		}
		$sql = "INSERT INTO Song (echonest_id, track_id, sevendigital_id, title, artist, release_year, album, loudness, hotttnesss, tempo, song_key, mode, start)
			VALUES ('{$fields[0]}', '{$fields[1]}', '{$fields[2]}', '{$fields[3]}', '{$fields[12]}', {$fields[4]}, '{$fields[5]}', {$fields[6]}, {$fields[7]}, {$fields[8]}, {$fields[9]}, {$fields[10]}, {$fields[11]})";
	
		if (mysqli_query($con, $sql)) {
		    echo "New record in Song created successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
		}
	}
	fclose($songsartistsfile);

	$genresfile = fopen("/var/www/html/imports/Genres.tsv", "r") or die("Unable to open file! :(");

	while(!feof($genresfile)) {
		$fields = sanitizeArray(explode("\t", fgets($genresfile)));
		$sql = "UPDATE Song 
			SET genre = '{$fields[1]}'
			WHERE track_id = '{$fields[0]}';";

		if(mysqli_query($con, $sql)) {
			echo "Genre added to Song tuple successfuly\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";	
		}
	}
	fclose($genresfile);

	$songsfile = fopen("/var/www/html/imports/SongListens.tsv", "r") or die("Unable to open file! :(");

	while(!feof($songsfile)) {
		$fields = explode("\t", fgets($songsfile));
		$sql = "INSERT INTO Listener (echonest_id, lastfm_sha, username)
		 	VALUES ('{$fields[0]}', null, null)";

		if (mysqli_query($con, $sql)) {
		    echo "New record in Listener created successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
		}

		$sql = "SELECT master_id
			FROM Listener
			WHERE echonest_id = '{$fields[0]}'";
		$result = mysqli_query($con, $sql);
		$id = mysqli_fetch_array($result, MYSQLI_ASSOC)["master_id"];

		$sql = "INSERT INTO Listens_To_Song (listener, song, playcount)
			VALUES ({$id}, '{$fields[1]}', {$fields[2]})";
	
		if (mysqli_query($con, $sql)) {
		    echo "New record in Listens_To_Song created successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
		}
	}
	fclose($songsfile);
	
	$artistsfile = fopen("/var/www/html/imports/ArtistListens.tsv", "r") or die("Unable to open file! :(");

	while(!feof($artistsfile)) {
		$fields = explode("\t", fgets($artistsfile));
		$fields[1] = str_replace("-", "", $fields[1]);
		$sql = "INSERT INTO Listener (echonest_id, lastfm_sha, username)
			VALUES (null, '{$fields[0]}', null)";

		if (mysqli_query($con, $sql)) {
		    echo "New record in Listener created successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
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
	
		if (mysqli_query($con, $sql)) {
		    echo "New record  in Listens_To_Artist created successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
		}
	}
	fclose($artistsfile);

	$songtagfile = fopen("/var/www/html/imports/SongTags.tsv", "r") or die("Unable to open file! :(");

	while(!feof($songtagfile)) {
		$fields = sanitizeArray(explode("\t", fgets($songtagfile)));

		$sql = "SELECT echonest_id
			FROM Song
			WHERE track_id = '{$fields[1]}'";
		echo $sql . "\n";

		$result = mysqli_query($con, $sql);
		$song_id = mysqli_fetch_array($result, MYSQLI_ASSOC)["echonest_id"];

		echo $song_id . "\n";

		$sql = "INSERT INTO Tag (song, tag)
			VALUES ('{$song_id}', '{$fields[0]}')";
	
		if (mysqli_query($con, $sql)) {
		    echo "New recordin Tag created successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con);
		}
	}

 	mysqli_close($con);
?>
