<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
 	$con = mysqli_connect('localhost','root','strawberry','test');
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
		sevendigital_id int NULL UNIQUE, 
		title varchar(100) NOT NULL,
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

		// sql to create Performance table
		$sql = "CREATE TABLE IF NOT EXISTS Performance (
		song char(18),
		artist char(18), 
		genre varchar(200) NULL,
		FOREIGN KEY (song) REFERENCES Song(echonest_id),
		FOREIGN KEY (artist) REFERENCES Artist(echonest_id),
		PRIMARY KEY(artist, song));";

		if (mysqli_query($con, $sql)) {
		    echo "Table Performance created successfully\n";
		} else {
		    echo "Error creating Performance table: " . mysqli_error($con);
		}
		
			// sql to create Listener table
		$sql = "CREATE TABLE IF NOT EXISTS Listener (
			master_id int AUTO_INCREMENT PRIMARY KEY,
			echonest_id char(18) NULL UNIQUE,
			musicbrainz_id char(38) NULL UNIQUE,
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
		type ENUM('echonest','musicbrainz') NOT NULL,
		listener int,
		FOREIGN KEY (song) REFERENCES Song(echonest_id),
		FOREIGN KEY (listener) REFERENCES Listener(master_id),
		PRIMARY KEY(song, listener)
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

	$sql = "INSERT INTO Song (echonest_id, sevendigital_id, title, release_year, album, loudness, hotttnesss, tempo, song_key, mode, start)
	 VALUES ('abcdefghijklmnopqr', 187, 'Live Your Life', 1987, 'Alligators will cry', 20.2, 0.98, 20.2, 10, 10, 0.00)";

	if (mysqli_query($con, $sql)) {
	    echo "New record in Song created successfully\n";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
	}

	$sql = "INSERT INTO Artist (echonest_id, musicbrainz_id, name, hotttnesss, familiarity)
	 VALUES ('1q2w3e4r5t6y7u8i9o', '456e4567-e89b-12d3-a456-426655440000', 'J-Swizza', 0.73, 0.99)";

	if (mysqli_query($con, $sql)) {
	    echo "New record in Artist created successfully\n";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
	}

	$sql = "INSERT INTO Listener (echonest_id, musicbrainz_id, username)
	 VALUES ('asdfghjklqwertyuio', '123e4567-e89b-12d3-a456-426655440000', 'caligirl46')";

	if (mysqli_query($con, $sql)) {
	    echo "New record in Listener created successfully\n";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
	}

	$sql = "INSERT INTO Performance (song, artist, genre)
	 VALUES ('abcdefghijklmnopqr', '1q2w3e4r5t6y7u8i9o', 'rock')";

	if (mysqli_query($con, $sql)) {
	    echo "New record in Performance created successfully\n";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
	}

	$sql = "INSERT INTO Listens_To_Song (listener, song)
	 VALUES (1, 'abcdefghijklmnopqr')";

	if (mysqli_query($con, $sql)) {
	    echo "New record in Listens_To_Song created successfully\n";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
	}

	$sql = "INSERT INTO Listens_To_Artist (listener, artist)
	 VALUES (1, '1q2w3e4r5t6y7u8i9o')";

	if (mysqli_query($con, $sql)) {
	    echo "New record  in Listens_To_Artist created successfully\n";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($con) . "\n";
	}

	$sql = "INSERT INTO Tag (song, tag, type, listener)
	 VALUES ('abcdefghijklmnopqr', 'swedish_death_metal', 'echonest', 1)";

	if (mysqli_query($con, $sql)) {
	    echo "New recordin Tag created successfully\n";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($con);
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
