<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Million Songs SQL | Welcome</title>
	<link rel="stylesheet" type="text/css" href="millsongs.css">

</head>

<body>
	<div class="callout large">
		<div class="row column text-center">
			<h1>Million Songs SQL</h1>
			<p class="lead">Everything you never needed to know about contemporary music.</p>
		</div>
	</div>

	<div class="row">
		<center>
			<ul class="menu">
				<li><a href="index_mill.html">Home</a></li>
				<li><a href="tags.html">Tags</a></li>
				<li class="menu-text">Recommendation Engine</li>
				<li><a href="cacophony.html">Beautiful Cacophony</a></li>
				<li><a href="help_us.html">Help Us Out</a></li>
				<li><a href="#">My Account</a></li>
			</ul>
		</center>
	</div>

	<hr>

	<div class="row columns">
		<div class="medium-6 columns">
			<h5 style="text-align:center">Recommend Based on Song</h5>
			<hr>

			<form action="" method="post" id="song-rec">
				<input form="song-rec" type="text" name="song" maxlength="200" required>
				<input  form="song-rec" type="submit" name="submit_song" value="Recommend">
			</form>

			<hr>

			<center>
			<div id="recommend-song" class="row">
				<?php
			if(isset($_POST['submit_song'])){ // Check if form was submitted
			    $song = $_POST['song']; // Get input text   

			    $con = mysqli_connect('localhost','superuser','superP@$$123','testdb');
			    if (!$con) {
			    	die('Could not connect: ' . mysqli_error($con));
			    }

			    mysqli_select_db($con,'projecttest');
			    $sql="SELECT * FROM Song WHERE title = '".$song."'";
			    $result = mysqli_query($con,$sql);

			    if (mysqli_num_rows($result) > 0) {
			    	echo "<table>
			    	<tr>
			    		<th>Title</th>
			    		<th>Artist</th>
			    		<th>Genre</th>
			    		<th>Album</th>
			    		<th>Release Year</th>
			    	</tr>";

			    	while($row = mysqli_fetch_array($result)) {
			    		echo "<tr>";
			    		echo "<td>" . $row['title'] . "</td>";
			    		echo "<td>" . $row['artist'] . "</td>";
			    		echo "<td>" . $row['genre'] . "</td>";
			    		echo "<td>" . $row['album'] . "</td>";
			    		echo "<td>" . $row['release_year'] . "</td>";
			    		echo "</tr>";
			    	}
			    	echo "</table>";
			    } else {
			    	echo '<p>This song is not in our database.</p>';
			    }

			    mysqli_close($con);
			} else {
				echo '<p>Please input a song.</p>';
			}
			?>
		</div>
		</center>
	</div>

	<div class="medium-6 columns">

		<h5 style="text-align:center">Recommend Based on Artist</h5>
		<hr>

		<form action="" method="post" id="artist-rec">
			<input form="artist-rec" type="text" name="artist" maxlength="200" required>
			<input form="artist-rec" type="submit" name="submit_artist" value="Recommend">
		</form>
		<hr>
		<center>
		<div id="recommend-artist" class="row">
			<?php
		if(isset($_POST['submit_artist'])){ //check if form was submitted
		    $artist = $_POST['artist']; //get input text

		    $con = mysqli_connect('localhost','superuser','superP@$$123','testdb');
		    if (!$con) {
		    	die('Could not connect: ' . mysqli_error($con));
		    }

		    mysqli_select_db($con,'projecttest');
		    $sql="SELECT * FROM Artist WHERE name = '".$artist."'";
		    $result = mysqli_query($con,$sql);

		    if (mysqli_num_rows($result) > 0) {
		    	echo "<table>
		    	<tr>
		    		<th>Echonest ID</th>
		    		<th>MusicBrainz ID</th>
		    		<th>Name</th>
		    		<th>Hotttnesss</th>
		    		<th>Familiarity</th>
		    	</tr>";

		    	while($row = mysqli_fetch_array($result)) {
		    		echo "<tr>";
		    		echo "<td>" . $row['echonest_id'] . "</td>";
		    		echo "<td>" . $row['musicbrainz_id'] . "</td>";
		    		echo "<td>" . $row['name'] . "</td>";
		    		echo "<td>" . $row['hotttnesss'] . "</td>";
		    		echo "<td>" . $row['familiarity'] . "</td>";
		    		echo "</tr>";
		    	}
		    	echo "</table>";
		    } else {
		    	echo '<p>This artist is not in our database.</p>';
		    }

		    mysqli_close($con);
		} else {
			echo '<p>Please input an artist.</p>';
		}
		?>
	</div>
	</center>
</div>

<hr>

<div class="row column">
	<ul class="vertical medium-horizontal menu expanded text-center">
		<li><a href="#"><div class="stat">9,988</div><span>Songs</span></a></li>
		<li><a href="#"><div class="stat">3,489</div><span>Artists</span></a></li>
		<li><a href="#"><div class="stat">44,602</div><span>Listeners</span></a></li>
		<li><a href="#"><div class="stat">3 bil.</div><span>Tags</span></a></li>
		<li><a href="#"><div class="stat">18</div><span>Useless Facts</span></a></li>
	</ul>
</div>

<hr>

<center>
	<div class="row column">
		<ul class="menu">
			<li><a href="index_mill.html">Home</a></li>
			<li><a href="tags.html">Tags</a></li>
			<li><a href="recommend_eng.php">Recommendation Engine</a></li>
			<li><a href="cacophony.html">Beautiful Cacophony</a></li>
			<li><a href="help_us.html">Help Us Out</a></li>
			<li><a href="#">My Account</a></li>
		</ul>
	</div>
</center>

</body>
</html>
