<?php
	//PARENTS
	include 'connect.php';
	$m_email = $_POST['email'];
	$m_password = $_POST['password'];
	// $m_name = $_POST['name'];
	// $curuser = 16;
	$meetid = '';
	$menteeid = '';
	if(!empty($_POST["enrollmentor"])) {
		$menteeid = $_POST['mentee_id'];
		$meetid = $_POST['meet_id'];
		$insertquery = "INSERT INTO enroll2 (meet_id, mentor_id) VALUES ('$meetid', '$menteeid')";

		if(mysqli_query($myconnection, $insertquery)) {
			echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'>Student added</div><br>";
		}
		else {
			echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'>Error! see below:<br>";
			echo "<br><br>";
			echo "Error" . mysqli_error($myconnection);
			echo "</div><br>";
		}

	if(isset($_POST["enrollmentee"])) {
			$menteeid = $_POST['mentee_id'];
			$meetid = $_POST['meet_id'];
			$insertquery = "INSERT INTO enroll (meet_id, mentee_id) VALUES ('$meetid', '$menteeid')";

			if(mysqli_query($myconnection, $insertquery)) {
				echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'>Student added</div><br>";
			}
			else {
				echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'>Error! see below:<br>";
				echo "<br><br>";
				echo "Error" . mysqli_error($myconnection);
				echo "</div><br>";
			}
		}

	mysqli_close($myconnection);
}
?>

<html>
	<title>Add Mentees</title>
	<h2>Add student</h2>
	<form action="add_mentee_entry.php" method="post">
		<table>
			<tr>
				<td>Student ID: <input type="text" name="mentee_id"></td>
			</tr>
			<tr>
				<td>Meeting ID: <input type="text" name="meet_id"></td>
			</tr>
			<tr>
				<input type='hidden' name='email' value= <?php echo $m_email?> >
				<input type='hidden' name='password' value= <?php echo $m_password?> >
				<td><input type="submit" name="enrollmentor" value="Enroll as mentor"></td>
				<td><input type="submit" name="enrollmentee" value="Enroll as mentee"></td>
				<td><input type="reset" name="reset" value="reset"></td>
			</tr>
		</table>
	</form>
</html>
<?php
	echo "<form action='adminLogin.php' method='post'>
		<input type='hidden' name='email' value= $m_email>
		<input type='hidden' name='password' value= $m_password>
		<input type=submit class=button value='return' />";
?>