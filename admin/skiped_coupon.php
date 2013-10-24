<?php if($_POST['subaction'] == "Delete"){
	
	foreach($_POST[delete] as $k=>$v)
	{
	  $select = "delete from businesses WHERE skiped=0 and pid='$v'";
	  $delqry=mysql_query("delete from temp_coupons_tie where cid in (select cid from temp_coupons where pid=$v)");
		$delqry=mysql_query("delete from temp_coupons where pid=$v");	
	   	$result = mysql_query($select) or die(mysql_error());
		$pid = "";
	}
	if($result && mysql_affected_rows()>0) echo 'Business deleted Successfully'; else echo 'An error occured in deletion, try again';
	
} ?>
<form action="admin.php?action=skiped_coupon" method="post">
<table width="900">
	<tr><th colspan="5" align="center">Incomplete Businesses</th></tr>
	<tr>
		<th>Action</th>
		<th>Id</th>
		<th>Name</th>
		<th>Email Id</th>
		<th>Business Name</th>
		<th>Phone No</th>
	</tr>
<?php
$query=mysql_query('SELECT * FROM businesses where skiped=0');
while ($row=mysql_fetch_array($query)) { ?>
	<tr>
		<td><input type="checkbox" name="delete[]" value="<?php echo "$row[pid]"; ?>"/></td>
		<td><?php echo "$row[pid]"; ?></td>
		<td><?php echo "$row[name]"; ?></td>
		<td><?php echo "$row[email]"; ?></td>
		<td><?php echo "$row[business]"; ?></td>
		<td><?php echo "$row[phone]"; ?></td>
	</tr>
	<?php $qry=mysql_query("select type,totalmonths,name,state,featureLen,editsLeft from temp_coupons c, temp_coupons_tie t,schools s where c.cid=t.cid and t.sid=s.sid and c.pid=$row[pid]");
	if(mysql_num_rows($qry)){ ?>
	<tr>
		<td colspan="6" align="center"><b>Selected Coupons</b><br />
		<table width="100%" style="background: none;">
			<tr>
				<th>Coupon Type</th>				
				<th>School</th>
				<th>Duration</th>
				<th>Feature Length</th>
				<th>Updates Remain</th>
			</tr>			
		<?php 
		$type1[1] = "Creator";
		 $type1[2] = "Custom";
		 $type1[3] = "Upload";
		while($row2=mysql_fetch_array($qry)){ ?> 
				<tr>
					<td><?php echo $type1[$row2['type']] ?></td>
					<td><?php echo $row2['name'].', '.$row2['state']; ?></td>
					<td><?php echo $row2['totalmonths'] ?></td>
					<td><?php echo $row2['featureLen'] ?></td>
					<td><?php echo $row2['editsLeft'] ?></td>
				</tr>
			
			<?php } ?>
		</table>
		</td>
	</tr>
<?php } echo '<tr><td colspan="6" style="background-color:green;" height="3"></td></tr>'; } ?>
<tr><td><input type="submit" value="Delete" name="subaction" /></td></tr>
</table></form>