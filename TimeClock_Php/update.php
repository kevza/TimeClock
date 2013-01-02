<?php

	$user = $_POST['User'];
	$pw = $_POST['Password'];
	$date = $_POST['Date'];
	$time = $_POST['Time'];
	$inout = $_POST['InOut'];
	//Get database connection
	include 'DB/connect.php';
	$dbConn = new DBConnect();
	$conn = $dbConn->getConn();
	//Check if the user is valid
	$query = "SELECT  * FROM TC_Users WHERE Name='".$user."'";
	$res = mysql_query($query,$conn);
	if (!$res){
		die("Query Failed");
	}
	//Check the password
	$row = mysql_fetch_array($res);
	if (!$row){
		echo 'ErrorUser';
		exit();
	}
	if ($row['Password']!==$pw){
		echo 'ErrorUser';
		exit();
	}
	$UserId = $row['Id'];
	//If we got through all of that we can now start to work on an update
	if ($inout==="In"){
		//Log me in
		//Check if a current login exits (login today with no logout)
		$query = "SELECT * FROM TC_Logins WHERE TC_UserId='".mysql_real_escape_string($UserId)."' 
			AND TC_Date='".mysql_real_escape_string($date)."'
			AND TC_OutTime IS NULL";
		$res = mysql_query($query,$conn);
		if (!$res){
			echo mysql_error();
			exit();
		}
		while ($row=mysql_fetch_array($res)){
			echo "ErrorLoggedIn";
			exit();
		}
		//Else Add an Entry
		$query = "INSERT INTO TC_Logins (TC_UserId,TC_Date,TC_InTime) VALUES ('".mysql_real_escape_string($UserId)."',
			'".mysql_real_escape_string($date)."',
			'".mysql_real_escape_string($time)."')";
		$res = mysql_query($query,$conn);
		if (!$res){
			die("Query Failed".mysql_error());
		}
		echo 'LoggedIn';
		exit();
	}
	if ($inout==="Out"){
		//Log me out
				//Check if a current login exits (login today with no logout)
		$query = "SELECT * FROM TC_Logins WHERE TC_UserId='".mysql_real_escape_string($UserId)."' 
			AND TC_OutTime IS NULL";
		$res = mysql_query($query,$conn);
		if (!$res){
			echo mysql_error();
			exit();
		}
		while ($row=mysql_fetch_array($res)){
			$query = "UPDATE TC_Logins SET TC_OutTime='".mysql_real_escape_string($time)."'
				WHERE Id='".mysql_real_escape_string($row['Id'])."'";
			$res = mysql_query($query,$conn);
			if (!$res){
				echo mysql_error();
				exit();
			}
			echo "LoggedOut";
			exit();
		}
		echo 'ErrorLoggedOut';
		exit();
		
	}
?>
