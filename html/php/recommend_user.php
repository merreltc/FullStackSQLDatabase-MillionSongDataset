<?php

$con = mysqli_connect('localhost','superuser','superP@$$123','testdb');
if (!$con) {
	die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,'projecttest');
$sql="SELECT s.title, a.name, s.genre,s.album, s.release_year FROM Song s, Artist a WHERE s.artist = a.echonest_id AND title = 'Smile' LIMIT 10";
$result = mysqli_query($con,$sql);

echo "<table style='width:100%'>";

while($row = mysqli_fetch_array($result)) {
	echo "<tr>";
	echo "<td><img class='thumbnail' src='http://placehold.it/50x50'></td>";
	echo "<td><a href='#'>" . $row['title'] . "<br>" . $row['name'] . "</a></td>";
	echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>