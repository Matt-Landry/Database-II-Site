<?php
	//PARENTS
	include 'connect.php';
	$m_email = $_POST['studentEmail'];
	$m_name = $_POST['name'];
	$m_phone = $_POST['phone'];
	$m_password = $_POST['password'];
	$m_grade = $_POST['grade'];
	$m_parentEmail = $_POST['parentEmail'];
	
	
	
	if((mysqli_query($myconnection, "SELECT * FROM users WHERE email = '$m_parentEmail';"))->num_rows != 0){		/*checking if parent email exists*/
		$query = "INSERT INTO users (email, password, name, phone) VALUES ('$m_email', '$m_password', '$m_name', '$m_phone');";
		if(mysqli_query($myconnection, $query)){
			echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'> Successfully inserted";
			echo "<br>";
		}else{
			echo $query;
			echo "<br>";
			echo "Error: could not insert. <br>" . mysqli_error($myconnection);
		};
		$studentID = $myconnection->query("SELECT MAX(id) FROM users;");
		$m_studentID = ($studentID->fetch_array(MYSQLI_NUM))[0]; /*this is the only way i can find to easily convert a mysqli object to a string! */
		
		$parentID = $myconnection->query("SELECT parent_id FROM parents WHERE parent_id = (SELECT id FROM users WHERE email = '$m_parentEmail');");
		$m_parentID = ($parentID->fetch_array(MYSQLI_NUM))[0];	

		$query2 = "INSERT INTO students (student_id, grade, parent_id) 
					VALUES ('$m_studentID', '$m_grade', '$m_parentID')";
					
					
		$query3 = "INSERT INTO mentees VALUES ('$m_studentID')";
		$query4	= "INSERT INTO mentors VALUES ('$m_studentID')";
		if(mysqli_query($myconnection, $query2)){
			echo "Updated students table</div>";
			mysqli_query($myconnection, $query3);
			mysqli_query($myconnection, $query4);
			readfile("databaseII.html");
		}else{
			echo $query2;
			echo "Error: could not update parents table. Reason: " . mysqli_error($myconnection);
		}
	}else{
		echo "<div style='width:200px; background-color:grey; color:red; border: 1px solid black'>Parent email does not exist in database<h3></div>";
		echo mysqli_error($myconnection);
		readfile("studentSignUp.html");
	}
	mysqli_close($myconnection);
?>