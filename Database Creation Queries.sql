--Creates the initial database
CREATE DATABASE MusicAnalysis
GO
USE MusicAnalysis
GO
--Creates rules for types
CREATE RULE valid_index AS
	@index > 0 AND @index < 1;
GO
--Creates types for the database
CREATE TYPE enID FROM char(18);
CREATE TYPE mbID FROM uniqueidentifier;
CREATE TYPE [7dID] FROM int;
CREATE TYPE [index] FROM decimal;
EXEC sp_bindrule valid_index, 'index';

GO
--Creates the Song table
CREATE TABLE Song
	(echonest_id enID PRIMARY KEY, musicbrainz_id mbID UNIQUE, sevendigital_id [7dID] UNIQUE, 
	title varchar(100), [year] int,  release varchar(200), loudness decimal, hotttnesss [index],
	tempo float, [key] int, mode int, start decimal,
	CONSTRAINT valid_year CHECK([year] < YEAR(GETDATE()) AND [year] > 1800));

GO
--Creates the Artist table
CREATE TABLE Artist
	(echonest_id enID PRIMARY KEY, musicbrainz_id mbID UNIQUE, 
	name varchar(200), hotttnesss [index], familiarity [index]);

GO
--Creates the Performance table
CREATE TABLE Performance
	(artist enID REFERENCES Artist(echonest_id), song enID REFERENCES Song(echonest_id),
	genre varchar(200))
