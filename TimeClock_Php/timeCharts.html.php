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
