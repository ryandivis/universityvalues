<? if($_POST['subaction'] == "delete"){
	
	foreach($_POST[delete] as $k=>$v)
	{
		 	$select = "delete from refferals WHERE rfid='$k'";
	    	$result = mysql_query($select) or die(mysql_error());
		$pid = "";
	}
	
}
if($_POST['subaction'] == "active")
{
	foreach($_POST[delete] as $k=>$v)
	{
		 	$select = "update refferals set status=1 WHERE rfid='$k'";
	        $result = mysql_query($select) or die(mysql_error());
		$pid = "";
	}

}
echo '<form method=post id="frm1"><input type="hidden" name="subaction" id="action">';
	echo "<table align=center border=1 cellpadding=3 cellspacing=3>
	<tr><td align='right' colspan='14'><a href='admin.php?action=referrals_archieve'>Archive List</a></td></tr>
	<tr><th>Action</th><th>Date</th><th>ID</th><th>Name</th><th>Business</th><th>Referral Name</th><th>Referral Email</th><th>Referral Phone</th></th><th>Referral message</th></tr>
	";
	$select = "SELECT * FROM refferals,businesses WHERE refferals.status=0 and  refferals.pid = businesses.pid";

	$result = mysql_query($select) or die(mysql_error());
	while ($row = mysql_fetch_array($result)) {

		$u = $row[1];
		$u = $users[$u];
		echo "<tr><td><input type=checkbox name='delete[$row[0]]'></td><td>" . date('m/d/y', $row[2]) . "</td><td>$row[pid]</td><td>$row[name]</td><td>$row[business]</td><td>$row[3]</td><td>$row[5]</td><td>$row[4]</td><td>$row[7]</td></tr>";

	}
	echo "<tr><td colspan='9'><input type=submit value='Archive' onclick=fun_redirect('1') ><input type=submit value='Delete' onclick=fun_redirect('2') ></td></tr>";
	echo "</table></form>";
	?>
	<script>
		function fun_redirect(str) {

			if(str == 1) {
				document.getElementById('action').value = 'active';
				document.getElementById('frm1').submit();
			} else {
				document.getElementById('action').value = 'delete';
				document.getElementById('frm1').submit();
			}

		}
	</script>
