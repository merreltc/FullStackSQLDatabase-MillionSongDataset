<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php require 'createdb.php';?>

<?php

 	$con = mysqli_connect('localhost','superuser','superP@$$123','testdb');
 	if (!$con) {
  	   die('Could not connect: ' . mysqli_error($con) . "\n");
 	}

 	// Make MillionSongs the current database		
	$db_selected = mysqli_select_db($con, 'projecttest');
	if (!$db_selected) {
		die('Database not connected');
	}

	$songsartistsfile = fopen("SongsArtists.tsv", "r") or echo("Unable to open file! :(");
	while(!feof($songsartistsfile)) {
		$fields = explode("\t", fgets($songsartistsfile));
		$sql = "INSERT INTO Artist (echonest_id, musicbrainz_id, name, hotttnesss, familiarity)
			 VALUES ('{$fields[12]}', '{$fileds[13]}', '{$fields[14]}', {$fields[15]}, {$fields[16]})";

		if (mysqli_query($con, $sql)) {
		    echo "New record in Artist created successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
		}
		$sql = "INSERT INTO Song (echonest_id, track_id, sevendigital_id, title, artist, release_year, album, loudness, hotttnesss, tempo, song_key, mode, start)
			VALUES ('{$fields[0]}', '{$fields[1]}', '{$fields[2]}', '{$fields[3]}', {$fields[12]}, {$fields[4]}, '{$fields[5]}', {$fields[6]}, {$fields[7]}, {$fields[8]}, {$fields[9]}, {$fields[10]}, {$fields[11]})";
	
		if (mysqli_query($con, $sql)) {
		    echo "New record in Song created successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
		}
	}
	fclose($songsartistsfile);

	$genresfile = fopen("Genres.tsv", "r") or die("Unable to open file! :(");
	while(!feof($genresfile)) {
		$fields = explode("\t" fgets($genresfile));
		$sql = "INSERT INTO Song (genre)
			VALUES ('{$fields[1]}')
			WHERE track_id = {$fields[0]}";

		if(mysqli_query($con, $sql)) {
			echo "Genre added to Song tuple successfulyl";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";	
		}
	}
	fclose($genresfile);

	$songsfile = fopen("SongListens.tsv", "r") or die("Unable to open file! :(");
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
			WHERE echonest_id = {$fields[0]}";
		$result = mysqli_query($con, $sql))
		$id = mysqli_fetch_array($result, MYSQLI_ASSOC)["master_id"];

		$sql = "INSERT INTO Listens_To_Song (listener, song, playcount)
			VALUES ({$id}, {$fields[1]}, {$fields[2]})";
	
		if (mysqli_query($con, $sql)) {
		    echo "New record in Listens_To_Song created successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
		}
	}
	fclose($songsfile);
	
	$artistsfile = fopen("ArtistListens.tsv", "r") or die("Unable to open file! :(");
	while(!feof($artistsfile)) {
		$fields = explode("\t", fgets($artistsfile));
		$sql = "INSERT INTO Listener (echonest_id, lastfm_sha, username)
			VALUES (null, '{$fields[0]}', null)";

		if (mysqli_query($con, $sql)) {
		    echo "New record in Listener created successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
		}
		
		$sql = "SELECT master_id
			FROM Listener
			WHERE lastfm_sha = {$fields[0]}";
		$result = mysqli_query($con, $sql));
		$id = mysqli_fetch_array($result, MYSQLI_ASSOC)["master_id"];

		
		$sql = "INSERT INTO Listens_To_Artist (listener, artist, playcount)
		 VALUES ({$id}, {$fields[1]}, {$fields[2]})";
	
		if (mysqli_query($con, $sql)) {
		    echo "New record  in Listens_To_Artist created successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
		}
	}
	fclose($artistsfile);

	$songtagfile = fopen("SongTags.tsv", "r") or die("Unable to open file! :(");
	while(!feof($songtagfile)) {
		$fields = explode("\t", fgets($songtagfile));

		$sql = "SELECT song_id
			FROM Song
			WHERE track_id = {$fields[1]}"
		$result = mysqli_query($con, $sql);
		$song_id = mysqli_fetch_array($result, MYSQLI_ASSOC)["song_id"];

		$sql = "INSERT INTO Tag (song, tag)
			VALUES ('{$song_id}', '{$fields[0]}')";
	
		if (mysqli_query($con, $sql)) {
		    echo "New recordin Tag created successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con);
		}
	}

	// To DROP Database
		$sql = "DROP DATABASE projecttest";
	
		if (mysqli_query($con, $sql)) {
		    echo "Database deleted successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con);
		}

 	mysqli_close($con);
 ?>
</body>
</html>
