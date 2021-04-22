<html>
<title>Loop Meetings</title>
<body>

<h1>Student's Meetings</h1>

<?php
	include 'connect.php';
	
	$m_email = $_POST['email'];
	$m_password = $_POST['password'];
	
	if(!empty($_POST['parent_email'])){
		$parent_email = $_POST['parent_email'];
		$parent_password = $_POST['parent_password'];
	}
	
	$curuserid = mysqli_query($myconnection, "SELECT id FROM users WHERE email = '$m_email'")->fetch_array(MYSQLI_NUM)[0];
	
	$meetid='';
	$menteequery = "SELECT meetings.meet_name, meetings.meet_id, meetings.date, time_slot.start_time, time_slot.end_time, meetings.group_id
					FROM meetings
          INNER JOIN time_slot ON meetings.time_slot_id = time_slot.time_slot_id
          inner join groups g on g.group_id=meetings.group_id
          where (select students.grade from students where student_id='$curuserid')=g.mentee_grade_req";
	$mentorquery = "SELECT meetings.meet_name, meetings.meet_id, meetings.date, time_slot.start_time, time_slot.end_time, meetings.group_id
					FROM meetings
          INNER JOIN time_slot ON meetings.time_slot_id = time_slot.time_slot_id
          inner join groups g on g.group_id=meetings.group_id
          where (select students.grade from students where student_id='$curuserid')>=g.mentor_grade_req";
					$buttonnum=0;
					$menteeresult = mysqli_query($myconnection, $menteequery);
					$mentorresult = mysqli_query($myconnection, $mentorquery);
	if
	(!empty($menteeresult) && $menteeresult->num_rows > 0)
	{

		echo "The following meetings you can be a MENTEE of<br><br><br>";
		// output data of each row
			while($row = $menteeresult->fetch_assoc()) {
				$meetid=$row["meet_id"];
				echo "<br> Meeting Name:	". $row["meet_name"]. "<br>Date:	". $row["date"]. "<br>Start Time:	" . $row["start_time"]. "<br>End Time:		" . $row["end_time"] . "<br>Group:		". $row["group_id"]. "<br>";
				echo "<form method='post'> <input type='hidden' name='email' value=$m_email>
								<input type='hidden' name='password' value=$m_password>";
				if(!empty($parent_email)){				
					echo "<input type='hidden' name='parent_email' value = $parent_email >
					<input type='hidden' name='parent_password' value = $parent_password >";
				}
				echo "<input type='submit' name='join".$buttonnum ."' value='Join'>";
				echo "<input type='submit' name='leave".$buttonnum ."' value='Leave' method='post'><br> </form>";
				$joinbut='join'.$buttonnum;
				$leavebut='leave'.$buttonnum;
				$buttonnum++;
				if(isset($_POST[$joinbut])) {
					$now = time();
					$meetdate = strtotime($row["date"]);

					// Get the difference of the two dates and convert it to days
					$diff = $meetdate - $now;
					$diff = round($diff / 86400);
					if($diff < 3) {
						echo "Cannot join meeting";
					}
					else {
						$menteeenrollq= "INSERT INTO enroll (meet_id, mentee_id) VALUES ('$meetid', '$curuserid')";
						if(mysqli_query($myconnection, $menteeenrollq)){
							echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'> Successfully Joined</div>";
							echo "<br>";
						}else{
							// echo $menteeenrollq;
							echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'>Error! see error below";
							echo "<br><br>";
							echo "Error" . mysqli_error($myconnection);
							echo "</div><br>";

					}

					}
				}

				if(isset($_POST[$leavebut])) {
					$menteedel= "DELETE from enroll WHERE meet_id='$meetid' and mentee_id='$curuserid'";
					if(mysqli_query($myconnection, $menteedel)){
						echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'>You have left the meeting</div>";
						echo "<br>";
					}else{
						echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'>Error! see error below";
						echo "<br><br>";
						echo "Error" . mysqli_error($myconnection);
						echo "</div><br>";
				}

		}
	}}else {
		echo "0 results <br>";
	}

	// check if the the query returned any rows
	if (!empty($mentorresult) && $mentorresult->num_rows > 0) {
		echo "The following meetings you can be a MENTOR of<br><br><br>";
		// output data of each row
		$meetmentorid='';
			while($row = $mentorresult->fetch_assoc()) {
				$meetmentorid=$row["meet_id"];
				echo '<br> Meeting Name:	'. $row["meet_name"]. "<br>Date:	". $row["date"]. "<br>Start Time:	" . $row["start_time"]. "<br>End Time:		" . $row["end_time"] . "<br>Group:		". $row["group_id"]. "<br>";
				echo "<form method='post'> <input type='hidden' name='email' value=$m_email>
								<input type='hidden' name='password' value=$m_password>";
				if(!empty($parent_email)){				
				echo "<input type='hidden' name='parent_email' value = $parent_email >
					<input type='hidden' name='parent_password' value = $parent_password >";
				}				
				echo "<input type='submit' name='join".$buttonnum ."' value='Join'>";
				echo "<input type='submit' name='leave".$buttonnum ."' value='Leave' method='post'><br> </form>";
				$joinbut='join'.$buttonnum;
				$leavebut='leave'.$buttonnum;
				$buttonnum++;

				if(isset($_POST[$joinbut])) {
					$now = time();
					$meetdate = strtotime($row["date"]);

					// Get the difference of the two dates and convert it to days
					$diff = $meetdate - $now;
					$diff = round($diff / 86400);
					if($diff < 3) {
						echo "Cannot join meeting";
					}
					else {
						$mentorenrollq= "INSERT INTO enroll2 (meet_id, mentor_id) VALUES ('$meetmentorid', '$curuserid')";
						if(mysqli_query($myconnection, $mentorenrollq)){
							echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'> Successfully Joined</div>";
							echo "<br>";
						}else{
							echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'>Error! see error below";
							echo "<br><br>";
							echo "Error" . mysqli_error($myconnection);
							echo "</div><br>";

					}
				}
			}

				if(isset($_POST[$leavebut])) {
					$now = time();
					$meetdate = strtotime($row["date"]);

					// Get the difference of the two dates and convert it to days
					$diff = $meetdate - $now;
					$diff = round($diff / 86400);
					if($diff < 3) {
						echo "Cannot leave meeting; past leave meeting deadline";
					}
					else {
						$mentoredel= "DELETE from enroll2 WHERE meet_id='$meetmentorid' and mentor_id='$curuserid'";
						if(	mysqli_query($myconnection, $mentoredel)){
							echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'>You have left this meeting</div>";
							echo "<br>";
						}else{
							echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'>Error! see error below";
							echo "<br><br>";
							echo "Error" . mysqli_error($myconnection);
							echo "</div><br>";
						};

					}
				}
		}
    }else {
		echo "0 results <br>";
	}
	if(!empty($parent_email)){
		echo "<form action='parentLogin.php' method='post'>
			<input type='hidden' name='email' value= $parent_email>
			<input type='hidden' name='password' value= $parent_password>
			<input type=submit class=button value='return' />";
	}else{
	echo "<form action='studentLogin.php' method='post'>
		<input type='hidden' name='email' value= $m_email>
		<input type='hidden' name='password' value= $m_password>
		<input type=submit class=button value='return' />";
	}
	mysqli_close($myconnection);
?>
</body>
</html>