<?php
include_once('connect.php');
if ($_POST) {
    $meeting_id = $_POST['meeting_id'];
//	echo $meeting_id;
    $m_email = $_POST['email'];
	$m_password = $_POST['password'];
    $sql = "Select * from meetings where meet_id='$meeting_id'";
    $stmt = $myconnection->prepare(
            "SELECT meet_id, meet_name, date, capacity, announcement, group_id, day_of_the_week, start_time, end_time FROM meetings INNER JOIN time_slot on time_slot.time_slot_id = meetings.time_slot_id WHERE meetings.meet_id = $meeting_id"); 
    $stmt->execute();
    $stmt->bind_result($meeting_id, $meeting_name, $meet_date, $capacity, $announcement, $group_id, $dow, $start_time, $end_time);
    $stmt->fetch();
    $stmt->close();
//	echo $meeting_id;
} else {
    $meeting_id = 0;
    $meeting_name = "error";
    $meet_date = "error";
    $dow = "error";
    $start_time = "Error";
    $end_time = "Error";
    $capacity = "error";
    $announcement = "error";
    $group_id = "error";
    $meet_time_slot_id = "error";
}

//echo $meeting_id;

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meeting Information</title>
</head>

<body>
<h1 style="text-align: center;">Meeting Information</h1>
<p>Meeting Name: <?php echo $meeting_name ?></p>
<p>Meeting Date: <?php echo $meet_date ?></p>
<p>Meeting Day Of The Week: <?php echo $dow ?></p>
<p>Meeting Start Time: <?php echo $start_time ?></p>
<p>Meeting End Time: <?php echo $end_time ?></p>
<p>Capacity: <?php echo $capacity ?></p>

<div style="display: flex; flex-direction: row; justify-content: space-evenly">
    <div>
        <h2>Mentees in meeting</h2>
        <?php
        $result = $myconnection->query("SELECT name, email FROM enroll INNER JOIN users ON enroll.mentee_id = users.id AND meet_id = '$meeting_id'");
        if ($result->num_rows >= 1) {
            while ($row = $result->fetch_row()) {
                echo "<p> Name: " . $row[0] . "</p><p>Email: " . $row[1] . "</p>";
            }
        } else {
            echo "<p>No Mentees</p>";
        }
        ?>
    </div>
    <div>
        <h2>Mentors in meeting</h2>
        <?php
        $result = $myconnection->query("SELECT name, email FROM enroll2 INNER JOIN users ON enroll2.mentor_id = users.id AND meet_id = '$meeting_id'");
        if ($result->num_rows >= 1) {
            while ($row = $result->fetch_row()) {
                echo "<p> Name: " . $row[0] . "</p><p>Email: " . $row[1] . "</p>";
            }
        } else {
            echo "<p>No Mentors</p>";
        }
        ?>
    </div>
</div>
<?php
    echo "<form action='studentLogIn.php' method='post'>
			<input type='hidden' name='email' value= $m_email>
			<input type='hidden' name='password' value= $m_password>
			<input type=submit class=button value='return' />";

?>
</body>
</html>