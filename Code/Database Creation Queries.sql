--Creates the initial database
CREATE DATABASE MusicAnalysis

--Initializes using the correct database
USE MusicAnalysis
GO

--Creates useful types for the database
CREATE TYPE enID FROM char(18);
CREATE TYPE mbID FROM uniqueidentifier;
CREATE TYPE [7dID] FROM int;

--Creates all the tables in the database
CREATE TABLE Song
	(echoNestId enID PRIMARY KEY, musicBrainzID mbID UNIQUE, sevenDigitalID [7dID] UNIQUE, 
	title varchar(100), [year] int,  release varchar(200,
	CONSTRAINT valid_year CHECK([year] < YEAR(GETDATE()) && [year] > 1800));
