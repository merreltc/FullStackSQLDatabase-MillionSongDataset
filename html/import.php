<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
$con = mysqli_connect('localhost','root','10826294');
 	if (!$con) {
  	   die('Could not connect: ' . mysqli_error($con));
 	}

 	// Make MillionSongs the current database		
	$db_selected = mysqli_select_db($con, 'projecttest');
	if (!$db_selected) {
		// Create database and tables
		 $sql = "CREATE DATABASE projecttest";
		if (mysqli_query($con, $sql)) {
		    echo "Database created successfully\n";
		} else {
		    echo "Error creating database: " . mysqli_error($con);
		}

		mysqli_select_db($con, 'projecttest');

		// sql to create Song table
		$sql = "CREATE TABLE IF NOT EXISTS Song (
		echonest_id char(18) PRIMARY KEY,
		track_id char(18),
		sevendigital_id int NULL UNIQUE, 
		title varchar(100) NOT NULL,
		artist char(18) NOT NULL,
		genre varchar(100) NULL,
		release_year YEAR NOT NULL, 
		album varchar(200) NOT NULL,
		loudness decimal(5,2) NOT NULL,
		hotttnesss decimal(4,3) NOT NULL,
		tempo float NOT NULL,
		song_key int NOT NULL,
		mode int NOT NULL,
		start decimal(6,3) NOT NULL,
		CONSTRAINT ck_hotttnesss CHECK (hotttnesss > 0 AND hotttnesss < 1),
		CONSTRAINT valid_year CHECK(release_year < YEAR(GETDATE())
			AND release_year > 1800));";

		if (mysqli_query($con, $sql)) {
		    echo "Table Song created successfully\n";
		} else {
		    echo "Error creating Song table: " . mysqli_error($con);
		}

		// sql to create Artist table
		$sql = "CREATE TABLE IF NOT EXISTS Artist (
		echonest_id char(18) PRIMARY KEY,
		musicbrainz_id char(38) NOT NULL UNIQUE, 
		name varchar(200) NOT NULL,
		hotttnesss decimal(4,3) NOT NULL,
		familiarity decimal(4,3) NOT NULL,
		CONSTRAINT ck_hotttnesss CHECK (hotttnesss > 0 AND hotttnesss < 1),
		CONSTRAINT ck_familiarity CHECK (familiarity > 0 AND familiarity < 1));";

		if (mysqli_query($con, $sql)) {
		    echo "Table Artist created successfully\n";
		} else {
		    echo "Error creating Artist table: " . mysqli_error($con);
		}

		// sql to create Listener table
		$sql = "CREATE TABLE IF NOT EXISTS Listener (
			master_id int AUTO_INCREMENT PRIMARY KEY,
			echonest_id char(18) NULL UNIQUE,
			lastfm_sha char(40) NULL UNIQUE,
			username varchar(60) NULL,
			CONSTRAINT ck_ids CHECK(username IS NOT NULL OR musicbrainz_id IS NOT NULL OR echonest_id IS NOT NULL)
		)";

		if (mysqli_query($con, $sql)) {
		    echo "Table Listener created successfully\n";
		} else {
		    echo "Error creating Listener table: " . mysqli_error($con);
		}

		// sql to set Listener table's auto-increment intial value to 1
		$sql = "ALTER TABLE Listener AUTO_INCREMENT=1";

		if (mysqli_query($con, $sql)) {
		    echo "Table Listener increment initial value set successfully\n";
		} else {
		    echo "Error setting initial increment value: " . mysqli_error($con);
		}

		// sql to create Tag table
		$sql = "CREATE TABLE IF NOT EXISTS Tag (
		song char(18),
		tag VARCHAR(200) NOT NULL,
		listener int NULL,
		FOREIGN KEY (song) REFERENCES Song(echonest_id),
		FOREIGN KEY (listener) REFERENCES Listener(master_id),
		)";

		if (mysqli_query($con, $sql)) {
		    echo "Table Tag created successfully\n";
		} else {
		    echo "Error creating Tag table: " . mysqli_error($con);
		}

		// sql to create Favorite_Songs table
		$sql = "CREATE TABLE IF NOT EXISTS Favorite_Songs (
		listener int,
		song char(18),
		FOREIGN KEY (song) REFERENCES Song(echonest_id),
		FOREIGN KEY (listener) REFERENCES Listener(master_id),
		PRIMARY KEY(song, listener)
		)";

		if (mysqli_query($con, $sql)) {
		    echo "Table Favorite_Songs created successfully\n";
		} else {
		    echo "Error creating Favorite_Songs table: " . mysqli_error($con);
		}

		// sql to create Listens_To_Artist table
		$sql = "CREATE TABLE IF NOT EXISTS Listens_To_Artist (
		listener int,
		artist char(18),
		playcount int DEFAULT 1,
		FOREIGN KEY (artist) REFERENCES Artist(echonest_id),
		FOREIGN KEY (listener) REFERENCES Listener(master_id),
		PRIMARY KEY(artist, listener)
		)";

		if (mysqli_query($con, $sql)) {
		    echo "Table Listens_To_Artist created successfully\n";
		} else {
		    echo "Error creating Listens_To_Artist table: " . mysqli_error($con);
		}

		// sql to create Listens_To_Song table
		$sql = "CREATE TABLE IF NOT EXISTS Listens_To_Song (
		listener int,
		song char(18),
		playcount int DEFAULT 1,
		FOREIGN KEY (song) REFERENCES Song(echonest_id),
		FOREIGN KEY (listener) REFERENCES Listener(master_id),
		PRIMARY KEY(song, listener),
		CONSTRAINT ck_playcount CHECK (playcount >= 1)
		)";

		if (mysqli_query($con, $sql)) {
		    echo "Table Listens_To_Song created successfully\n";
		} else {
		    echo "Error creating Listens_To_Song table: " . mysqli_error($con);
		}
	}

	$songsartistsfile = fopen("SongsArtists.tsv", "r") or die("Unable to open file! :(");
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

	/*To DROP Database
		$sql = "DROP DATABASE projecttest";
	
		if (mysqli_query($con, $sql)) {
		    echo "Database deleted successfully\n";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($con);
		}*/

 	mysqli_close($con);
 ?>
</body>
</html>
