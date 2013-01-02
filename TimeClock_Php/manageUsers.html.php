<?php
    include 'DB/connect.php';
    $dbObj = new DBConnect();
    $conn = $dbObj->getConn();
    $query = "SELECT * FROM TC_Users";
    //Get all current users for the data base
    $res = mysql_query($query,$conn);
?>


<table>
<tr><td>User:</td><td>Password:</td></tr>    
    
<?php while($row =mysql_fetch_array($res)):?>
<tr>
<form name="updateUsers" action="manageUsers.php" method="post" > 
    <td><?php echo $row['Name'];?></td>
    <input type="hidden" name="name" value="<?php echo $row['Name'];?>"/>
    <td><input type="text" name="password" value="<?php echo $row['Password'];?>"/></td>
    <input type="hidden" name="id" value="<?php echo $row['Id'];?>"/>
    <td><input type="submit" name="update" value="Update" onClick="return confirm('Update Password?')"/></td>
    <td><input type="submit" name="delete" value="Delete" onClick="return confirm('Delete Record?')"/></td>
</form>
</tr>
<?php endwhile;?>
<form name="updateUsers" action="manageUsers.php" method="post" > 
    <td><input type="text" name="name" value="New User"/></td>
    <td><input type="text" name="password" value="New Password"/></td>
    <td><input type="submit" name="adduser" value="Add User" onClick="return confirm('Add User?')"/></td>

</form>
</table>
