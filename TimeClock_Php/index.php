
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <LINK href="Style/page.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id='wrap'>
    
<h1>Time Sheet Manager</h1>

<ul id='nav'>
<li><a href="?page=2">Time Sheets</a></li>
<li><a href="?page=1">Manage Users</a></li>
<li><a href="setup.exe" onClick="return confirm('Download Client')" >Download Client</a></li>
</ul>

<div id="content">

<?php
    if (isset($_GET['page'])){
	if ($_GET['page']==1){
		include 'manageUsers.html.php';
	}
	if ($_GET['page']==2){
		include 'timeCharts.html.php';
	}
    }
    if (isset($_POST['getChart'])){
	include 'timechart.php';
    }
?>
</div>
</div>
</body>
</html>
