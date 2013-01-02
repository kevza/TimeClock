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
<link rel="stylesheet" type="text/css" media="all" href="DatePicker/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="DatePicker/jsDatePick.min.1.3.js"></script>
<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"inputField",
			dateFormat:"%Y-%m-%d",

			limitToToday:false,
			cellColorScheme:"beige",
			
			weekStartDay:1
		});
	};
</script>
<p>Get Time Charts</p>
<?php
    include 'DB/connect.php';
    $dbObj = new DBConnect();
    $conn = $dbObj->getConn();
    $query = "SELECT * FROM TC_Users";
    //Get all current users for the data base
    $res = mysql_query($query,$conn);
?>
<form name="getTimeChart" action="index.php" method="post">
    
Start Date : <input type="text" name="startDate" id="inputField"/>
Days : <input type="text" name="daysCount" value="7"/>
<table>
<?php while($row =mysql_fetch_array($res)):?>
<tr>
<td><?php echo $row['Name'];?> <input type="checkbox" name="Users[]" value="<?php echo $row['Id'];?>"/></td>
</tr>
<?php endwhile;?>
</table>
<input type="submit" name="getChart" value="Get Time Charts"/>
</form>
