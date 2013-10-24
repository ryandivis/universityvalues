<?
/*
if($page == "update")
{
	foreach($_POST[thetext] as $k=>$v)
	{
		$update = "UPDATE images SET url='$v' WHERE id='$k'";
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

	$select = "SELECT * FROM imageTypes ORDER BY id";

	$result = mysql_query($select) or die(mysql_error());
	echo "<b>Upload VIA WordPress then copy and paste URL</b><br/>";
	echo "<table align=center border=1>

	<tr><th>ID</th><th>Title</th><th>URL</th></tr>

	";

?>

<form method=post action="admin.php?action=images&page=update">
	<?
while($row = mysql_fetch_row($result))
echo "<tr><td>$row[0]</td><td>$row[1]</td><td><input type=text name='thetext[".$row[0]."]' value=\"$row[2]\" size=75></td></tr>";
echo "<tr><td><input type=submit value='Update'></td></tr>";
echo "</table></form>";
} else if($pid && $page == 'edit') {

$select = "SELECT * FROM businesses WHERE pid='$pid'";

$result = mysql_query($select) or die(mysql_error());

$biz = mysql_fetch_array($result);

	?>

	<a href="admin.php?action=businesses&page=delete&pid=<?=$pid?>">Delete This Business</a>
	<br/>
	<br/>
	<form method=post action="admin.php?action=businesses&page=save&pid=<?=$pid?>">
		<table>
			<?

foreach($biz as $k=>$v)

{

if(!is_numeric($k) && $k!='pid' && $k!='secret' && $k!='uid' && $k!='logo')

echo "<tr><td>".ucfirst($k)."</td><td><input type=text name=$k value='$v'/></td></tr>";

}

			?>

			<tr>
				<td></td><td>
				<input type=submit value="Save">
				</td>
			</tr>
		</table>
	</form>
 <img src="https://www.universityvalues.com/new/images/freeTemplate2.png">
 <img src="https://www.universityvalues.com/new/images/uvDesign2.png">
 <img src="https://www.universityvalues.com/new/images/uploadYourOwn2.png">
	<? } */
if($page == "update")
{
foreach($_POST[thetext] as $k=>$v)
{
if($_FILES['image'.$k]['error']<= 0 )
{
 $filename=$_FILES['image'.$k]['name'];
move_uploaded_file($_FILES['image'.$k]['tmp_name'],'newsimage/cartimage/'.$filename);
$filename=SITEURL.'/newsimage/cartimage/'.$filename;
$update = "UPDATE imageTypes SET url='$filename' WHERE id='$k'";
$result = mysql_query($update) or die(mysql_error());
}
}
}

if(!$_GET[pid] && $page != 'new')
{
$select = "SELECT * FROM imageTypes ORDER BY id";
$result = mysql_query($select) or die(mysql_error());
echo "<table align=center border=1>
<tr><th>IMAGE</th>
<th>TITLE</th>
<th>URL</th></tr>
";
	?>
	<form method=post action="admin.php?action=images&page=update" enctype="multipart/form-data">
		<?
		while ($row = mysql_fetch_row($result))
			echo "<tr><td><img src='$row[2]' width='216' height='142' ></td>
			<td>$row[1]</td>
			<td><input type='file' name='image$row[0]' >
			<input type=hidden name='thetext[" . $row[0] . "]' value=\"$row[2]\" size=75></td></tr>";
		echo "<tr><td><input type=submit value='Update'></td></tr>";
		echo "</table></form>";
		}
		?>
	</form>

