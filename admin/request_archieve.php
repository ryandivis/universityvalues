<?
if ($_POST['subaction'] == "delete") {
	foreach ($_POST[delete] as $k => $v) {
		$select = "delete from request_info WHERE mid='$k'";
		$result = mysql_query($select) or die(mysql_error());

		$pid = "";
	}

}elseif($_POST['subaction'] == "active")
{
	foreach($_POST[delete] as $k=>$v)
	{
		$select = "update request_info set archieve=0 WHERE mid='$k'";
		$result = mysql_query($select) or die(mysql_error());
		$pid = "";
	}
}

echo '<form method=post id="frm1"><input type="hidden" name="subaction" id="action">';

echo "<table align=center border=1 width=800>
	<tr><td colspan='10'  align='right'  ><a href='admin.php?action=request_archieve'>Unarchive List</a></td></tr>
	<tr><th>Unarchive</th><th>Name</th><th>Business<th>Email</th><th>Phone</th><th>Date Created</th></tr>

	";
$select = "SELECT * FROM request_info where archieve='1' order by mid desc ";

$result = mysql_query($select) or die(mysql_error());

	while ($row = mysql_fetch_row($result)) {

		$u = $row[1];
		$u = $users[$u];
		echo "<tr><td align=center><input type=checkbox name='delete[$row[0]]'></td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>" . date('m/d/y', $row[6]) . "</td></tr>";
		echo "<tr><td/><th>Message:</th><td colspan=4>$row[5]</td></tr>";
		echo "<tr><td colspan=6><br/></td></tr>";
	}
	echo "<tr><td><input type=submit value='Unarchive' onclick=fun_redirect('1') ></td><td colspan=2><input type=submit value='Delete' onclick=fun_redirect('2') ></td><td><a href='admin.php?action=requests'><input type='button' value='BACK'></a></td></tr>";
	echo "</table></form>";
	?>
<script>
	function fun_redirect(str) {

		if(str == 1)
			{
				document.getElementById('action').value='active';
				document.getElementById('frm1').submit();
			}
		else
			{
				document.getElementById('action').value='delete';
				document.getElementById('frm1').submit();
			}

	}
</script>