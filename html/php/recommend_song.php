<?php
$song = $_GET['song']; // Get input text   

$con = mysqli_connect('localhost','superuser','superP@$$123','testdb');
if (!$con) {
	die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,'projecttest');
$sql="SELECT s.title, a.name, s.genre,s.album, s.release_year FROM Song s, Artist a WHERE s.artist = a.echonest_id AND title = '".$song."'";
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
		echo "<td>" . $row['name'] . "</td>";
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
?>