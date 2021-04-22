<?php

include 'connect.php';
$m_email = $_POST['email'];
$m_password = $_POST['password'];

//search user database for email and password, check if it matches admin
$getUser = mysqli_query($myconnection, "SELECT * FROM users WHERE email = '$m_email' AND password = '$m_password' AND id IN (SELECT student_id FROM students);") or die ('Query failed: ' . msql_error());

echo "<h2>Student Info</h2><br>";
while($row = mysqli_fetch_array ($getUser, MYSQLI_ASSOC)) {
	echo "Name: " . $row["name"];
	echo "<br>Email: " . $row["email"] . "<form action='editEmail.php' method='post'>
								<input type='hidden' name='email' value=$m_email >
								<input type='hidden' name='password' value=$m_password >
								<input type=submit class=button value='Change Email' ></form>";		
	echo "<br>Phone: " . $row["phone"] . "<form action='editPhone.php' method='post'>
								<input type='hidden' name='email' value=$m_email >
								<input type='hidden' name='password' value=$m_password >
								<input type=submit class=button value='Change Phone' ></form>";
	echo "<br>Password: " . "<form action='editPassword.php' method='post'>
								<input type='hidden' name='email' value=$m_email >
								<input type='hidden' name='password' value=$m_password >
								<input type=submit class=button value='Change Password' ></form>";
	echo "<br>Meetings you can join: " . "<form action='studentmeetings.php' method='post'>
								<input type='hidden' name='email' value=$m_email >
								<input type='hidden' name='password' value=$m_password >
								<input type=submit class=button value='Meetings' ></form>";
}
$user_id_result = mysqli_query($myconnection, "SELECT id FROM users WHERE email = '$m_email'");
$user_id = ($user_id_result->fetch_array(MYSQLI_NUM))[0];
$queryByMattL = "SELECT meetings.meet_name, meetings.meet_id, meetings.date, time_slot.start_time, time_slot.end_time, meetings.group_id
        FROM meetings
        INNER JOIN time_slot ON meetings.time_slot_id = time_slot.time_slot_id
        inner join groups g on g.group_id=meetings.group_id
        where meetings.meet_id in ((select enroll.meet_id FROM enroll where enroll.mentee_id=$user_id)UNION(select enroll2.meet_id FROM enroll2 where enroll2.mentor_id=$user_id))";
$result = mysqli_query($myconnection, $queryByMattL);
echo "<h2>Your Meetings</h2><br><table>";
while($row = $result->fetch_assoc()) {
	echo "<td>";
	$meetid=$row["meet_id"];
	$meetDate=$row["date"];
	echo "Meeting Name: " . $row["meet_name"] . "<br>";
	echo "Meeting Date: " . $row["date"] . "<br>";
	echo "Meeting Time: " . $row["start_time"] . " to ". $row["end_time"] . "<br>";
	echo "<form action='MeetingInfo.php' method='post'>
			<input type='hidden' name='email' value=$m_email >
			<input type='hidden' name='password' value=$m_password >
			<input type='hidden' name='meeting_id' value=$meetid >
			<input type=submit class=button value='Meeting Information'></form>";
	$now = time();
					$meetdate = strtotime($row["date"]);
					$diff = $meetdate - $now;
					$diff = round($diff / 86400);
	if($diff <= 7){
		echo "<form action='MeetingMaterial.php' method='post'>
				<input type='hidden' name='email' value=$m_email >
				<input type='hidden' name='password' value=$m_password >
				<input type='hidden' name='meeting_id' value=$meetid >
				<input type=submit class=button value='Meeting Material'></form>";
	}
	echo "</td>";
}
echo "</table>";

echo "<a href='databaseII.html'><button>Log out</button></a>";
?>