<?php 
$newslettermsg='';
if(isset($_POST['deletenewsletter']) && $_POST['deletenewsletter']=='DM'){
	$values='';	
	foreach($_POST['emailids'] as $value)
		$values.=$value.',';
	$values=rtrim($values,',');
	$delqry=mysql_query("delete from newsLetter where id in ($values)");
	if($delqry && mysql_affected_rows()>0)
	$newslettermsg='E-Mail IDs Deleted Successfuilly';
	else $newslettermsg='Sorry, an error occured in deletion';
} ?>
<center>
	<h2>NewsLetter Subscription E-Mail IDs</h2>
	<form name="newsletter" method="post" action="admin.php?action=newsletter">
		<input type="hidden" name="deletenewsletter" value="DM" />
		<table>
			<?php if($newslettermsg!='') echo "<tr><td colspan='2' align='center'>$newslettermsg</td></tr>"; ?>
			<tr>
				<th width="100">&nbsp;</th>
				<th width="300">E-Mail ID</th>
			</tr>
			<?php
			$allnews = mysql_query("SELECT * FROM newsLetter order by datemade desc ");
			if(mysql_num_rows($allnews))
			{while($allnewsarr=mysql_fetch_object($allnews))
			{ ?>
				<tr>
					<td align="center"><input type="checkbox" name="emailids[]" value="<?php echo $allnewsarr->id;  ?>" /></td>
					<td align="left"><?php echo $allnewsarr->email ?></td>
				</tr>
			<?php }
			echo '<tr><td colspan="2"><input type="submit" value="Delete" name="newsletterdel"></td></tr>';
			}
			else echo '<tr><td colspan="2" align="center">Sorry No E-mail Id in your newsletter</td></tr> ';
			?>
		</table>
	</form>
</center>