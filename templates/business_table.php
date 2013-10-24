<form method=post action="admin_new.php?action=businesses&state=<?=$state?>&page=delete">
<table class='table table-hover table-bordered' align=center>
<tr>
<th>Delete</th>
<th><a href='admin_new.php?action=businesses&filter=business'>Business</a></th>
<th><a href='admin_new.php?action=businesses&filter=name'>Name</a></th>
<th><a href='admin_new.php?action=businesses&filter=coupons'>Coupons</a>
<th><a href='admin_new.php?action=businesses&filter=email'>Emails</a></th>
<th><a href='admin_new.php?action=businesses&filter=phone'>Phone</a></th>
<th><a href='admin_new.php?action=businesses&filter=city'>City</a></th>
<th><a href='admin_new.php?action=businesses&filter=state'>State</a></th>
<th></th>
</tr>
	
<?
while($row = mysql_fetch_assoc($result))
{
	echo "<tr class='business' rel='".$row['pid']."'>
	<td><input type=checkbox name='delete[".$row['pid']."]'></td>
	<td>".$row['business']."</td>
	<td>".$row['name']."</td>
	<td>".$row['cnt']."</td>
	<td>".$row['email']."</td>
	<td>".$row['phone']."</td>
	<td>".$row['city']."</td>
	<td>".$row['state']."</td>
	<td><a href=\"account.php?a=1&pid=".$row['pid']."\" target=new>Login</a></td>";
}
?>
	<tr>
		<td>
			<input type=submit value="DELETE">
		</td>
	</tr>
</table>
</form>