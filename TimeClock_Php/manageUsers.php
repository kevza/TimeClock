<?php
    include 'DB/connect.php';
    $dbObj = new DBConnect();
    $conn = $dbObj->getConn();
    if (isset($_POST['update'])){
	//Update a user
	$query = "UPDATE TC_Users SET Password='".mysql_real_escape_string($_POST['password'])."' where
		    Name='".mysql_real_escape_string($_POST['name'])."'
		     and Id=".mysql_real_escape_string($_POST['id']);
	$res = mysql_query($query,$conn);
	if (!$res){
	    die("Query Failed");
	}
    }

    if (isset($_POST['delete'])){
	//Delete a user
	$query = "DELETE FROM TC_Users WHERE Id=".mysql_real_escape_string($_POST['id']);
	$res = mysql_query($query,$conn);
	if (!$res){
	    die("Query Failed");
	}
    }
    
    if (isset($_POST['adduser'])){
	//Add a User
	$query = "INSERT INTO TC_Users (Name,Password) VALUES ('".mysql_real_escape_string($_POST['name'])."',
					    '".mysql_real_escape_string($_POST['password'])."')";
	$res = mysql_query($query,$conn);
	if (!$res){
	    die("Query Failed");
	}
    }
    ob_end_clean();
    header("Location:index.php?page=1");
    
?>
