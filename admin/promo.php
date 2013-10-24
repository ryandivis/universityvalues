<?

if($page == "delete")

{
	foreach($_POST[delete] as $k=>$v)
	{
		$select = "DELETE FROM promos WHERE prid='$k'";
		$result = mysql_query($select) or die(mysql_error());



		$pid = "";
	}

}
	else if($page == "add")
	{


		$secret = md5($_POST[password]);

		$query = "INSERT INTO promos (code, amountOff, promoType) values ('$_POST[code]','$_POST[amountOff]', '$_POST[promoType]')";
		echo $query;
		$result = mysql_query($query) or die(mysql_error());	
	}

 





if(!$_GET[pid] && $page != 'new')

{


	echo "<table align=center border=1>

	<tr><th>Delete</th><th>ID</th><th>Code</th><th>Amount</th></tr>

	";
	$select = "SELECT * FROM promos ";

	$result = mysql_query($select) or die(mysql_error());


?>
<form method=post action="admin.php?action=promo&page=add">
<tr><td/><td align=right><b>New:</b></td><td><input type=text name=code></td><td>
<input type=text name=amountOff size=5>
<select name=promoType>
<option value=1>$ Off</option>
<option value=2>% Off</option>
</select>
</td><td><input type=submit value="Add"/></td></tr>
</form>
<form method=post action="admin.php?action=promo&page=delete">
<?
	while($row = mysql_fetch_row($result))
	{

		$u = $row[1];
		$u = $users[$u];
		echo "<tr><td><input type=checkbox name='delete[$row[0]]'></td><td>$row[0]</td><td>$row[1]</td><td>";
		if($row[3] == 1)
			echo "\$$row[2] Off";
		else
			echo "$row[2]% Off";
		echo "</td></tr>";

	}
	echo "<tr><td><input type=submit value='DELETE'></td></tr>";
	echo "</table></form>";
} else if($pid && $page == 'edit') {

	$select = "SELECT * FROM users WHERE pid='$pid'";

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

	



