<?

if($page == "delete")

{
	foreach($_POST[delete] as $k=>$v)
	{
		$select = "DELETE FROM users WHERE uid='$k'";
		$result = mysql_query($select) or die(mysql_error());



		$pid = "";
	}

}
	else if($page == "add")
	{


		$secret = md5($_POST[password]);

		$query = "INSERT INTO users (name, email, password) values ('$_POST[name]','$_POST[email]', '$secret')";
		$result = mysql_query($query) or die(mysql_error());	
	}

 





if(!$_GET[pid] && $page != 'new')

{

	$select = "SELECT * FROM users ORDER BY name";

	$result = mysql_query($select) or die(mysql_error());

	echo "<table align=center border=1>

	<tr><th>Delete</th><th>ID</th><th>Name</th><th>Email</th><th>Password</th></tr>

	";

?>
<form method=post action="admin.php?action=users&page=add">
<tr><td/><td align=right><b>New:</b></td><td><input type=text name=name></td><td><input type=email name=email></td><td><input type=password name=password><input type=submit value="Add"/></td></tr>
</form>
<form method=post action="admin.php?action=users&page=delete">
<?
	while($row = mysql_fetch_row($result))
		echo "<tr><td><input type=checkbox name='delete[$row[0]]'></td><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
	echo "<tr><td><input type=submit value='DELETE'></td></tr>";
	echo "</table></form>";
} else if($pid && $page == 'edit') {

	$select = "SELECT * FROM businesses WHERE pid='$pid'";

	$result = mysql_query($select) or die(mysql_error());

	$biz = mysql_fetch_array($result);

?>

<a href="admin.php?action=businesses&page=delete&pid=<?=$pid?>">Delete This Business</a>

<br/><br/>

<form method=post action="admin.php?action=businesses&page=save&pid=<?=$pid?>">

<table>



<?

	foreach($biz as $k=>$v)

	{

		if(!is_numeric($k) && $k!='pid' && $k!='secret' && $k!='uid' && $k!='logo')

			echo "<tr><td>".ucfirst($k)."</td><td><input type=text name=$k value='$v'/></td></tr>";



	}

?>

<tr><td></td><td><input type=submit value="Save"></td></tr>

</table>

</form>



<? } ?>

	



