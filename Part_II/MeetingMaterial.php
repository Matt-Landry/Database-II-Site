<?php
include 'connect.php';
$m_email = $_POST['email'];
$m_password = $_POST['password'];
$met = $_POST['meeting_id'];

$getMaterial = "Select ma.title, ma.type, ma.notes, ma.url, me.date from material ma
inner join assign a on ma.material_id=a.material_id
inner join meetings me on me.meet_id=a.meet_id and me.meet_id=$met";
$result = mysqli_query($myconnection, $getMaterial);
echo "<h2>Meeting Info</h2>";
echo "<table>";
while($row = $result->fetch_assoc()){
	echo "<td>";
	echo "Title: " . $row['title'];
	echo "<br>Type: " . $row['type'];
	echo "<br>Notes: " . $row['notes'];
	echo "<br>Assigned date: " . $row['date'];
	echo "<br>URL: " . $row['url'];
	echo "</td>";
}
echo "</table>";
echo "<form action='studentLogIn.php' method='post'>
	<input type='hidden' name='email' value= $m_email>
	<input type='hidden' name='password' value= $m_password>
	<input type=submit class=button value='return' />";

?>