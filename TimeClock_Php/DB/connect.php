<?php
    include 'DB/db_inf.php';
    
    class DbConnect{
	var $conn = NULL;

	//Build the class and setup the database connections
	function DbConnect(){
	    $usr = new DbUser();
	    $this->conn = mysql_connect($usr->server,$usr->user,$usr->password);
	    //Check the connection
	    if (!$this->conn){
		die("Database connection failed to initialize".mysql_error());
	    }
	    //Select the database and create the database if the files dont exist
	    $res = mysql_select_db($usr->db_name,$this->conn);
	    if (!$res){
		//Database doesn't exist create it.
		$query = "create database ".$usr->db_name;
		$res = mysql_query($query,$this->conn);
		if (!$res){
		    die("Create database failed : ".mysql_error());
		}
		$res = mysql_select_db($usr->db_name,$this->conn);
		//Create Tables
		//User Table
		$queryT[0] = "CREATE TABLE TC_Users(Id int NOT NULL AUTO_INCREMENT,
			    Name varchar(20) UNIQUE,
			    Password varchar(20),PRIMARY KEY(Id))";
		//Create Time Clock Table
		$queryT[1] = "CREATE TABLE TC_Logins(Id int NOT NULL AUTO_INCREMENT,
			    TC_UserId int NOT NULL,
			    TC_Date DATE NOT NULL,
			    TC_InTime TIME NOT NULL,
			    TC_OutTime TIME,
			    PRIMARY KEY(Id))";
			    
		foreach($queryT as $q){
		    $res = mysql_query($q,$this->conn);
		    if (!$res){
			die("Create Table Query Failed :".mysql_error());
		    }
		}
	    }
	}
	
	//Return a connection object
	function getConn(){
	    return $this->conn;
	}
    }
?>
