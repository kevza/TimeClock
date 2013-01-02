<?php

	//Returns all the current users in a machine readable way
	include 'DB/connect.php';
	$conn_db = new DBConnect();
	$conn = $conn_db->getConn();
	$query = "select Name from TC_Users";
	$res = mysql_query($query,$conn);
	while($row = mysql_fetch_array($res)){

		echo "<user>".$row['Name']."</user>";
	}
?>
