
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
$startDate = $_POST['startDate'];
$endDate = date("Y-m-d",strtotime(date("Y-m-d", strtotime($startDate)) . "+".$_POST['daysCount']." days"));
include_once 'DB/connect.php';
$connDb = new DBConnect();
$conn = $connDb->getConn();
function secondsToTime($seconds)
{
    // extract hours
    $hours = floor($seconds / (60 * 60));
 
    // extract minutes
    $divisor_for_minutes = $seconds % (60 * 60);
    $minutes = floor($divisor_for_minutes / 60);
 
    // extract the remaining seconds
    $divisor_for_seconds = $divisor_for_minutes % 60;
    $seconds = ceil($divisor_for_seconds);
 
    // return the final array
    $obj = array(
        "h" => (int) $hours,
        "m" => (int) $minutes,
        "s" => (int) $seconds,
    );
    return $obj;
}

?>
<p>Time Sheets from <?php echo $startDate;?> to <?php echo $endDate;?> </p>

<?php
//Check Users contains data return if it doesnt
if (!isset($_POST['Users'])){
    ob_end_clean();
    header("Location:index.php?page=2");
}
?>

<?php foreach($_POST['Users'] as $user):?>
<?php
    //Find the Correct User for Disply
    $query = "SELECT Name FROM  TC_Users WHERE Id=$user";
    $res = mysql_query($query,$conn);
    if (!$res){
	die("Query error".mysql_error());
    }
    $row = mysql_fetch_array($res);
    $userName = $row['Name'];
?>


<p>Time Sheet for <?php echo $userName;?></p>
<?php
    //Get all time data within a range
    $query = "SELECT * FROM TC_Logins WHERE TC_UserId='$user' and  TC_Date >= '$startDate' AND TC_Date < '$endDate' ";
    $res = mysql_query($query,$conn);
    if (!$res){
	die("Query error".mysql_error());
    }
?>
<table>
    <tr>
    <td>Person</td><td>Date</td><td>Start Time</td><td>Finish Time</td><td>Total Time</td>
    </tr>
<?php $totalTime = 0;?>
<? while($row = mysql_fetch_array($res)):?>
<?php
    $strI = strtotime($row['TC_InTime']);
    $strO = strtotime($row['TC_OutTime']);
    $t = $strO - $strI;
    if ($t > 0){
	$totalTime += $t;
    }else if(!empty($row['TC_OutTime'])) {
	$t = 86400 - $strI + $strO;
	$totalTime += $t;
    }else{
	$t = 0;
	}
    $rT = secondsToTime($t);
?>


<tr>
<td><?php echo $userName;?></td>
<td><?php echo $row['TC_Date'];?></td>
<td><?php echo $row['TC_InTime'];?></td>
<td><?php echo $row['TC_OutTime'];?></td>
<td><?php echo $rT['h'].":".$rT['m'].":".$rT['s']; ?></td>
</tr>
<?php endwhile;?>
<?php $tT = secondsToTime($totalTime);?>
<td></td><td></td><td></td><td>Total Time :</td><td> <?php echo $tT['h'].":".$tT['m'].":".$tT['s']; ?></td>
</table>

<?php endforeach;?>
