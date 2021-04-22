<?php

include 'connect.php';
include 'filecleanup.php';
$m_email = $_POST['email'];
$m_password = $_POST['password'];


//search user database for email and password, check if it matches admin
$getUser = mysqli_query($myconnection, "SELECT * FROM users WHERE email = '$m_email' AND password = '$m_password' AND id IN (SELECT admin_id FROM admins);") or die ('Query failed: ' . msql_error());

echo "<h2>Admin Info</h2><br>";
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
	echo "<br>Meetings: " . "<form action='add_study_material.php' method='post'>
								<input type='hidden' name='email' value=$m_email >
								<input type='hidden' name='password' value=$m_password >
								<input type=submit class=button value='Add Study Material'></form>
								<form action='addmeeting.php' method='post'>
								<input type='hidden' name='email' value=$m_email >
								<input type='hidden' name='password' value=$m_password >
								<input type=submit class=button value='Add Meeting'></form>";
	echo "<br>Add students to meetings" . "<form action='add_mentee_entry.php' method='post'>
								<input type='hidden' name='email' value=$m_email >
								<input type='hidden' name='password' value=$m_password >
								<input type=submit class=button value='Add Students'></form>";
}
echo "<a href='databaseII.html'><button>Log out</button></a>";
?>