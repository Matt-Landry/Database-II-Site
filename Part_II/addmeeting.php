<?php
  include 'connect.php';
  	$m_email = $_POST['email'];
	$m_password = $_POST['password'];
?>

<html>
<head>
<title>Add a meeting</title>
</head>
<body>

<form method="post" action="addmeeting.php">
  Subject: <select id="Subject" name="Sub">
      <option value="Math">Math</option>
      <option value="Science">Science</option>
      <option value="English">English</option>
      <option value="History">History</option>
      <option value="Language">Language</option>
    </select>
<br>

Date:     type as YYYY-MM-DD (with dashes) <input type="text" name="Datet"> <br>
Announcement: <input type="text" name="Ann"> <br>
Capacity: <select id="Capacity" name="Cap">
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
  </select> <br>
Timeslot ID: <input type="text" name="Times"> <br>
Group ID: <input type="text" name="Group"> <br>
<br>

<input type='hidden' name='email' value= <?php echo $m_email?> >
<input type='hidden' name='password' value= <?php echo $m_password?> >
<input type="submit" value="Submit">
<input type="reset" value="Reset">
</form>
</body>
</html>

<?php
  if(isset($_POST["Sub"])){
	  $Sub = $_POST["Sub"];
	  $Datet = $_POST["Datet"];
	  $Ann = $_POST["Ann"];
	  $Cap = $_POST["Cap"];
	  $Times = $_POST["Times"];
	  $Group= $_POST["Group"];
  

	
	
  $query = "INSERT INTO meetings (announcement, capacity, date, group_id, meet_id, meet_name, time_slot_id)
  VALUES ('$Ann', '$Cap', '$Datet', '$Group', (select COALESCE(max(me.meet_id),0) + 1 from Meetings me), '$Sub', '$Times');";
	if(mysqli_query($myconnection, $query)){
		echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'> Successfully inserted";
		echo "<br>";
	}else{
		echo $query;
		echo "<br>";
		echo "Error: could not insert. <br>" . mysqli_error($myconnection);
	}  /*or die ('Query failed: ' . mysqli_error(TRUE))*/
  }
	echo "<form action='adminLogin.php' method='post'>
	<input type='hidden' name='email' value= $m_email>
	<input type='hidden' name='password' value= $m_password>
	<input type=submit class=button value='return' />";
	mysqli_close($myconnection);
	
	
?>