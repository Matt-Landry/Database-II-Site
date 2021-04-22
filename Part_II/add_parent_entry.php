<?php
	//PARENTS
	include 'connect.php';
	$m_email = $_POST['email'];
	$m_name = $_POST['name'];
	$m_phone = $_POST['phone'];
	$m_password = $_POST['password'];
	
	$query = "INSERT INTO users (email, password, name, phone) VALUES ('$m_email', '$m_password', '$m_name', '$m_phone');";
	if(mysqli_query($myconnection, $query)){
		echo "<div style='width:200px; background-color:grey; color:white; border: 1px solid black'> Successfully inserted";
		echo "<br>";
	}else{
		echo $query;
		echo "<br>";
		echo "Error: could not insert. <br>" . mysqli_error($myconnection);
	};  /*or die ('Query failed: ' . mysqli_error(TRUE))*/
	$query2 = "INSERT INTO parents SELECT MAX(id) FROM users;";
	if(mysqli_query($myconnection, $query2)){
		echo "Updated parents table</div>";
		readfile("databaseII.html");
	}else{
		echo $query2;
		echo "Error: could not update parents table. Reason: " . mysqli_error($myconnection);
	}
	mysqli_close($myconnection);
?>