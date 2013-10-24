<?
if($page == "update")
{
	foreach($_POST[thetext] as $k=>$v)
	{
		if($_FILES['image'.$k]['error']<= 0 )
		{
			$filename=$_FILES['image'.$k]['name'];
			move_uploaded_file($_FILES['image'.$k]['tmp_name'],'newsimage/featuredimage/'.$filename);
			$filename=SITEURL.'/newsimage/featuredimage/'.$filename;
			$update = "UPDATE featured SET imgUrl='$filename' WHERE fid='$k'";
			$result = mysql_query($update) or die(mysql_error());
		}
	}
}

if(!$_GET[pid] && $page != 'new')
{
	$select = "SELECT * FROM featured ORDER BY fid";
	$result = mysql_query($select) or die(mysql_error());
	echo "<table align=center border=1>
	<tr><th>Image</th><th>URL</th></tr>
	";
?>
<form method=post action="admin.php?action=featured&page=update" enctype="multipart/form-data">
<?
	while($row = mysql_fetch_row($result))
		echo "<tr>
		<td><img src='$row[3]'></td>
		<td><input type='file' name='image$row[0]' ><input type=hidden name='thetext[".$row[0]."]' value=\"$row[3]\" size=75></td>
		</tr>";
	echo "<tr><td><input type=submit value='Update'></td></tr>";
	echo "</table></form>";
} ?>
</form>