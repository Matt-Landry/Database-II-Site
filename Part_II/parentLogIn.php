<?php

include 'connect.php';
$m_email = $_POST['email'];
$m_password = $_POST['password'];
//search user database for email and password, check if it matches admin
$getUser = mysqli_query($myconnection, "SELECT * FROM users WHERE email = '$m_email' AND password = '$m_password' AND id IN (SELECT parent_id FROM parents);") or die ('Query failed: ' . msql_error());

echo "<h2>Parent Info</h2><br>";
while($row = mysqli_fetch_array ($getUser, MYSQLI_ASSOC)) {
	echo "Name: " . $row["name"];
	echo "<br>Email: " . $row["email"] . " <form action='editEmail.php' method='post'>
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
}

echo "<h2>Children</h2>";
$parent_id_result = mysqli_query($myconnection, "SELECT id FROM users WHERE email = '$m_email'");
$m_parentid = ($parent_id_result->fetch_array(MYSQLI_NUM))[0];
$children_query = "SELECT * FROM users INNER JOIN students ON users.id = students.student_id INNER JOIN parents ON students.parent_id = parents.parent_id AND parents.parent_id = '$m_parentid'";
$children_result = mysqli_query($myconnection, $children_query);
echo "<table>";
while($row = $children_result->fetch_assoc()){
	
	$student_email = $row["email"];
	$student_password = $row["password"];
	echo "<td><table>";
	echo "<tr>Email: " . $row["email"] . "<form action='editEmail.php' method='post'>
								<input type='hidden' name='email' value=$student_email >
								<input type='hidden' name='password' value=$student_password >
								<input type='hidden' name='parent_email' value=$m_email>
								<input type='hidden' name='parent_password' value=$m_password>
								<input type=submit class=button value='Change Email' ></form><br></tr>";
	echo "<tr>Phone: " . $row["phone"] . "<form action='editPhone.php' method='post'>
								<input type='hidden' name='email' value=$student_email >
								<input type='hidden' name='password' value=$student_password >
								<input type='hidden' name='parent_email' value=$m_email>
								<input type='hidden' name='parent_password' value=$m_password>
								<input type=submit class=button value='Change Phone' ></form><br></tr>";
	echo "<tr>Password " . "<form action='editPassword.php' method='post'>
								<input type='hidden' name='email' value=$student_email >
								<input type='hidden' name='password' value=$student_password >
								<input type='hidden' name='parent_email' value=$m_email>
								<input type='hidden' name='parent_password' value=$m_password>
								<input type=submit class=button value='Change Password' ></form><br></tr>";
	echo "<tr>Meetings " . "<form action='studentmeetings.php' method='post'>
								<input type='hidden' name='email' value=$student_email >
								<input type='hidden' name='password' value=$student_password >
								<input type='hidden' name='parent_email' value=$m_email>
								<input type='hidden' name='parent_password' value=$m_password>
								<input type=submit class=button value='Join meetings' ></form><br></tr>";
	echo "</table></td>";
}
echo "</table>";
echo "<a href='databaseII.html'><button>Log out</button></a>";
?>