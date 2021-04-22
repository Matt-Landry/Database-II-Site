<?php
	include 'connect.php';
	
	$m_email = $_POST['email'];
	$m_password = $_POST['password'];
	
	if(!empty($_POST['isanythingset'])){
		$m_title = $_POST['title'];
		$m_author = $_POST['author'];
		$m_url = $_POST['url'];
		$m_notes = $_POST['notes'];
		$m_subject = $_POST['subject'];
	}
	
?>
<html>
	<form action="add_study_material.php" method="post">
	<h2>Add Study Material</h2>
		<table>
			<tr>
				<td>Title:</td><td><input type="text" name="title"></td>
			</tr>
			<tr>
				<td>Author:</td><td><input type="text" name="author"></td>
			</tr>
			<tr>
				<td>URL:</td><td><input type="text" name="url"></td>
			</tr>
			<tr>
				<td>Notes:</td><td><input type="text" name="notes"></td>
			</tr>
			<tr>
				<td>Subject:</td><td><select name="subject">
				<option value="Math">Math</option>
				<option value="Science">Science</option>
				<option value="English">English</option>
				<option value="History">History</option>
				</select></td>
			</tr>
			<tr>
				<input type='hidden' name='email' value= <?php echo $m_email ?>>
				<input type='hidden' name='password' value= <?php echo $m_password ?>>
				<input type="hidden" name='isanythingset' value='nowitis'>
				<td><input type='submit' value='Create Material'></td>
			</tr>
		</table>
	</form>
</html>

<?php 
	if(isset($m_title)){
		if(idate('w') == 2){
			$mat_add = "INSERT INTO material (title, author, type, url, assigned_date, notes) 
							VALUES ('$m_title', '$m_author', '$m_subject', '$m_url', CURDATE(), '$m_notes')";
			mysqli_query($myconnection, $mat_add);
			$mat_id = mysqli_fetch_array(mysqli_query($myconnection, "SELECT MAX(material_id) FROM material"), MYSQLI_NUM);
			
			$meetings = mysqli_query($myconnection, "SELECT meet_id FROM meetings 
								WHERE meet_name='$m_subject' AND (date = (DATE_ADD(CURDATE(), INTERVAL 1 WEEK)) 
								OR date = (DATE_ADD(CURDATE(), INTERVAL 8 DAY)))");
			$arr_meetings =  array();
			while($row = mysqli_fetch_array($meetings, MYSQLI_NUM)) {
				$arr_meetings[] = $row;
			}
			foreach ($arr_meetings as &$cur_meeting){
				$value = $cur_meeting[0];
				mysqli_query($myconnection, "INSERT INTO assign VALUES ('$value', '$mat_id[0]')");
			}
		}
	}
	echo "<form action='adminLogin.php' method='post'>
		<input type='hidden' name='email' value= $m_email>
		<input type='hidden' name='password' value= $m_password>
		<input type=submit class=button value='return' />";
?>