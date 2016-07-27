<?php

$con = mysqli_connect('localhost','superuser','superP@$$123');
if (!$con) {
	die('Could not connect: ' . mysqli_error($con) . "\n");
}

 	// Make MillionSongs the current database		
$db_selected = mysqli_select_db($con, 'projecttest');
if (!$db_selected) {
		// Create database and tables
	$sql = "CREATE DATABASE projecttest";
	if (mysqli_query($con, $sql)) {
		echo "Database created successfully\n";
	} else {
		echo "Error creating database: " . mysqli_error($con) . "\n";
	}
}

mysqli_select_db($con, 'projecttest');

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
	echo "Error creating Artist table: " . mysqli_error($con) . "\n";
}

// sql to create Song table
$sql = "CREATE TABLE IF NOT EXISTS Song (
echonest_id char(18) PRIMARY KEY,
track_id char(18) NOT NULL,
sevendigital_id int NULL UNIQUE, 
title varchar(200) NOT NULL,
artist char(18) NOT NULL,
genre varchar(100) NULL,
release_year YEAR NULL, 
album varchar(200) NOT NULL,
loudness decimal(5,2) NOT NULL,
hotttnesss decimal(4,3) NOT NULL,
tempo float NOT NULL,
song_key int NOT NULL,
mode int NOT NULL,
start decimal(6,3) NOT NULL,
FOREIGN KEY (artist) REFERENCES Artist(echonest_id),
CONSTRAINT ck_hotttnesss CHECK (hotttnesss > 0 AND hotttnesss < 1),
CONSTRAINT valid_year CHECK(release_year < YEAR(GETDATE())
AND release_year > 1800));";

if (mysqli_query($con, $sql)) {
	echo "Table Song created successfully\n";
} else {
	echo "Error creating Song table: " . mysqli_error($con) . "\n";
}

// sql to create Listener table
$sql = "CREATE TABLE IF NOT EXISTS Listener (
master_id int AUTO_INCREMENT PRIMARY KEY,
echonest_id char(40) NULL UNIQUE,
lastfm_sha char(40) NULL UNIQUE,
username varchar(60) NULL,
CONSTRAINT ck_ids CHECK(username IS NOT NULL OR musicbrainz_id IS NOT NULL OR echonest_id IS NOT NULL)
)";

if (mysqli_query($con, $sql)) {
	echo "Table Listener created successfully\n";
} else {
	echo "Error creating Listener table: " . mysqli_error($con) . "\n";
}

// sql to set Listener table's auto-increment intial value to 1
$sql = "ALTER TABLE Listener AUTO_INCREMENT=100";

if (mysqli_query($con, $sql)) {
	echo "Table Listener increment initial value set successfully\n";
} else {
	echo "Error setting initial increment value: " . mysqli_error($con) . "\n";
}

// sql to create Tag table
$sql = "CREATE TABLE IF NOT EXISTS Tag (
song char(18) NOT NULL,
tag VARCHAR(200) NOT NULL,
listener int NULL,
FOREIGN KEY (song) REFERENCES Song(echonest_id),
FOREIGN KEY (listener) REFERENCES Listener(master_id)
)";

if (mysqli_query($con, $sql)) {
	echo "Table Tag created successfully\n";
} else {
	echo "Error creating Tag table: " . mysqli_error($con) . "\n";
}

// sql to create Artist_Tag table
$sql = "CREATE TABLE IF NOT EXISTS Artist_Tag (
artist  char(18) NOT NULL,
tag VARCHAR(200) NOT NULL,
listener int NULL,
FOREIGN KEY (artist) REFERENCES Artist(echonest_id),
FOREIGN KEY (listener) REFERENCES Listener(master_id)
)";

if (mysqli_query($con, $sql)) {
	echo "Table Tag created successfully\n";
} else {
	echo "Error creating Tag table: " . mysqli_error($con) . "\n";
}

		// sql to create Favorite_Songs table
$sql = "CREATE TABLE IF NOT EXISTS Favorite_Songs (
listener int NOT NULL,
song char(18) NOT NULL,
FOREIGN KEY (song) REFERENCES Song(echonest_id),
FOREIGN KEY (listener) REFERENCES Listener(master_id),
PRIMARY KEY(song, listener)
)";

if (mysqli_query($con, $sql)) {
	echo "Table Favorite_Songs created successfully\n";
} else {
	echo "Error creating Favorite_Songs table: " . mysqli_error($con) . "\n";
}

// sql to create Listens_To_Artist table
$sql = "CREATE TABLE IF NOT EXISTS Listens_To_Artist (
listener int NOT NULL,
artist char(18) NOT NULL,
playcount int DEFAULT 1,
FOREIGN KEY (artist) REFERENCES Artist(echonest_id),
FOREIGN KEY (listener) REFERENCES Listener(master_id),
PRIMARY KEY(artist, listener)
)";

if (mysqli_query($con, $sql)) {
	echo "Table Listens_To_Artist created successfully\n";
} else {
	echo "Error creating Listens_To_Artist table: " . mysqli_error($con) . "\n";
}

// sql to create Listens_To_Song table
$sql = "CREATE TABLE IF NOT EXISTS Listens_To_Song (
listener int NOT NULL,
song char(18) NOT NULL,
playcount int DEFAULT 1,
FOREIGN KEY (song) REFERENCES Song(echonest_id),
FOREIGN KEY (listener) REFERENCES Listener(master_id),
PRIMARY KEY(song, listener),
CONSTRAINT ck_playcount CHECK (playcount >= 1)
)";

if (mysqli_query($con, $sql)) {
	echo "Table Listens_To_Song created successfully\n";
} else {
	echo "Error creating Listens_To_Song table: " . mysqli_error($con) . "\n";
}

// sql to create Song table
$sql = "CREATE TABLE IF NOT EXISTS `Update-Song` (
title varchar(200) NOT NULL,
artist varchar(200) NULL,
genre varchar(100) NULL,
release_year YEAR NULL, 
album varchar(200) NULL,
CONSTRAINT valid_year CHECK(release_year < YEAR(GETDATE())
AND release_year > 1800));";

if (mysqli_query($con, $sql)) {
	echo "Table Update-Song created successfully\n";
} else {
	echo "Error creating Update-Song table: " . mysqli_error($con) . "\n";
}

// sql to create Song table
$sql = "CREATE TABLE IF NOT EXISTS `Add-Song` (
title varchar(200) NOT NULL,
artist varchar(200) NOT NULL,
genre varchar(100) NULL,
release_year YEAR NULL, 
album varchar(200) NOT NULL,
CONSTRAINT valid_year CHECK(release_year < YEAR(GETDATE())
AND release_year > 1800));";

if (mysqli_query($con, $sql)) {
	echo "Table Add-Song created successfully\n";
} else {
	echo "Error creating Add-Song table: " . mysqli_error($con) . "\n";
}

// sql to create Tag table
$sql = "CREATE TABLE IF NOT EXISTS `Pending-Tag` (
song VARCHAR(200) NOT NULL,
artist VARCHAR(200) NOT NULL,
tag VARCHAR(200) NOT NULL,
listener VARCHAR(200) NULL
)";

if (mysqli_query($con, $sql)) {
	echo "Table Pending-Tag created successfully\n";
} else {
	echo "Error creating Pending-Tag table: " . mysqli_error($con) . "\n";
}

// various triggers that are needed
$sql = "CREATE TRIGGER songfix
	BEFORE INSERT
	ON Song FOR EACH ROW
	BEGIN
		IF NEW.release_year = 0 THEN
		SET NEW.release_year = NULL;
		END IF;

		IF NEW.hotttnesss = 0 THEN
		SET NEW.hotttnesss = NULL;
		END IF;
	END";

if (mysqli_query($con, $sql)) {
	echo "Trigger creation dope\n";
} else {
	echo "Error creating trigger: " . mysqli_error($con) . "\n";
}


mysqli_close($con);
?>
