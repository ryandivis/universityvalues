<?

if($page == "update")
{
	foreach($_POST[thetext] as $k=>$v)
	{
		$update = "UPDATE prices SET price='$v' WHERE id='$k'";
		$result = mysql_query($update);
	}

}
	else if($page == "add")
	{

		$query = "INSERT INTO youtube (youtubeCode,youtubeThumb,orderNumb) values ('$_POST[code]','$_POST[thumb]', '$_POST[order]')";
		$result = mysql_query($query) or die(mysql_error());	
	}

 





if(!$_GET[pid] && $page != 'new')

{

	$select = "SELECT * FROM prices";

	$result = mysql_query($select) or die(mysql_error());

	echo "<table align=left border=1>

	<tr><th>ID</th><th>Title</th><th>Price</th></tr>

	";

?>

<form method=post action="admin.php?action=prices&page=update">
<?
	while($row = mysql_fetch_row($result))
		echo "<tr><td>$row[0]</td><td>$row[1]</td><td><b>$</b><input type=text name='thetext[".$row[0]."]' value=\"$row[2]\" size=10></td></tr>";
	echo "<tr><td><input type=submit value='Update'></td></tr>";
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

	



