<?php
	include 'connect.php';
	$m_email = $_POST['email'];
	$m_password = $_POST['password'];
	if(!empty($_POST['parent_email'])){
		$parent_email = $_POST['parent_email'];
		$parent_password = $_POST['parent_password'];
	}
	
	if(!empty($_POST['phone'])){
		$new_phone = $_POST['phone'];
		$update = "UPDATE users SET phone = '$new_phone' WHERE email = '$m_email' AND password = '$m_password'";
		if(mysqli_query($myconnection, $update))
			echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'>Phone number successfully changed.";
		else
			echo "Error: " . mysqli_error($myconnection);
		echo "</div>";
	}
?>

<html>
	<form action="editPhone.php" method="post">
		<h2>Change Phone Number</h2>
			<table>
				<tr>
					<td>New Phone<input type="text" name="phone"></td>
				</tr>
				<tr>
					<input type='hidden' name='email' value= <?php echo $m_email?> >
					<input type='hidden' name='password' value= <?php echo $m_password?> >
					<input type='hidden' name='parent_email' value = <?php if(!empty($_POST['parent_email'])){echo $parent_email;} else {echo NULL;}?> >
					<input type='hidden' name='parent_password' value = <?php if(!empty($_POST['parent_password'])){echo $parent_password;} else {echo NULL;}?> >
					<td><input type="submit" value="Change"></td>
				</tr>
			</table>
	</form>
</html>


<?php
	if(mysqli_query($myconnection, "SELECT * FROM admins WHERE admin_id = (SELECT id FROM users WHERE email = '$m_email')")->num_rows != 0){
		$whichLogin = "adminLogin";
	}else if(mysqli_query($myconnection, "SELECT * FROM parents WHERE parent_id = (SELECT id FROM users WHERE email = '$m_email')")->num_rows != 0){
		$whichLogin = "parentLogin";
	}else{
		$whichLogin = "studentLogIn";
	}
	if(!empty($parent_email)){
		echo "<form action='parentLogin.php' method='post'>
			<input type='hidden' name='email' value= $parent_email>
			<input type='hidden' name='password' value= $parent_password>
			<input type=submit class=button value='return' />";
	}else{
		echo "<form action='" . $whichLogin . ".php' method='post'>
			<input type='hidden' name='email' value= $m_email>
			<input type='hidden' name='password' value= $m_password>
			<input type=submit class=button value='return' />";
	}
?>