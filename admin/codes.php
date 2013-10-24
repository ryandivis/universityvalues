<?
if(isset($_POST['delete']) && $page== "delete")
{ 
	foreach($_POST[delete] as $k=>$v)
	{
		$select = "DELETE FROM codes WHERE inid='$k'";
		$result = mysql_query($select) or die(mysql_error());		
		$pid = "";
	}
	if($result && mysql_affected_rows()>0) echo 'Code deleted Successfully'; else echo 'An error occured in deletion, try again';
}else if(isset($_POST['code']) && $page== "add")
	{
		$secret = md5($_POST[password]);
		$query = "INSERT INTO codes (uid, code) values ('$_POST[uid]','$_POST[code]')";
		$result = mysql_query($query) or die(mysql_error());	
	}
 
if(!$_GET[pid] && $page != 'new')
{
	$select = "SELECT * FROM users ORDER BY name";
	$result = mysql_query($select) or die(mysql_error());
	while($row = mysql_fetch_row($result))
		$users[$row[0]] = $row[1];
	echo "<table align=center border=1>
	<tr><th>Delete</th><th>ID</th><th>Code</th><th>User</th><th>Used</th></tr>
	";
	$select = "SELECT * FROM codes ";
	$result = mysql_query($select) or die(mysql_error());
?>
<form method=post action="admin.php?action=codes&page=add">
	<tr><td/><td align=right><b>New:</b></td><td>
		<input type=text name=code>
		</td><td>
		<select name=uid>
			<?
			foreach ($users as $k => $v)
				echo "<option value=$k>$v</option>";
			?>
		</select></td><td>
		<input type=submit value="Add"/>
		</td>
	</tr>
</form>
<form method=post action="admin.php?action=codes&page=delete">
	<?
	while ($row = mysql_fetch_row($result)) {

		$u = $row[1];
		$u = $users[$u];
		echo "<tr><td><input type=checkbox name='delete[$row[0]]'></td><td>$row[0]</td><td>$row[2]</td><td>$u</td><td>$row[3]</td></tr>";

	}
	echo "<tr><td><input type=submit value='DELETE'></td></tr>";
	echo "</table></form>";
	} ?>

	