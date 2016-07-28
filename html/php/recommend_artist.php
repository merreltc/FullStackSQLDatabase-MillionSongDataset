<?php
$artist = $_GET['artist']; //get input text

$con = mysqli_connect('localhost','superuser','superP@$$123','testdb');
if (!$con) {
	die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,'projecttest');
$sql = "SELECT a.*, SUM(l.playcount) AS Weight
	FROM Artist AS a, Listens_To_Artist AS l
	WHERE a.echonest_id = l.artist AND l.listener IN (
		SELECT DISTINCT listener
		FROM Listens_To_Artist
		WHERE artist IN (SELECT echonest_id
				FROM Artist
				WHERE name LIKE '%{$artistname}%'))
	GROUP BY a.*
	ORDER BY Weight";
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
?>
