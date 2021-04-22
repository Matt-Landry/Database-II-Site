<?php
	include 'connect.php';
	
	$query = 'SELECT * FROM groups';
	
	$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . msql_error());
	
	echo '<h2>groups</h2><br><br>';
	
	while($row = mysqli_fetch_array ($result, MYSQLI_ASSOC)) {
		echo $row["name"];
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		echo $row["description"];
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		echo $row["mentor_grade_req"];
		echo "&nbsp;&nbsp;&nbsp;&nbsp;";
		echo $row["mentee_grade_req"];
		echo '<br>';
	}
	
	mysqli_free_result($result);
	mysqli_close($myconnection);
?>