<!--
Time Clock 
A web based time clock for tracking employee hours.
    
Copyright (C) 2013  Kevin Luke kevzawinning@gmail.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->
<!--
Time Clock 
A web based time clock for tracking employee hours.
    
Copyright (C) 2013  Kevin Luke kevzawinning@gmail.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
-->
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
