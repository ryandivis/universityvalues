<?php
$newslettermsg='';
 if (isset($_POST['schoolaction']) && $_POST['schoolaction'] == 'Update') {
    //action for update here
    foreach($_POST['schoolname'] as $k=>$v)
	{
		$lat = $_POST['lat'][$k];
		$long = $_POST['long'][$k];
		$name = "file_$k";
		if($_POST[schoollogodel][$k]){
			$filedeletion=unlink('images/schools/'.$k);
			$hasLogo=0;
		}
		else {
			$hasLogo = $_POST[hasLogo][$k];
		}
		if($_FILES[$name]['error'] <= 0)
		{
			list($txt, $ext) = explode(".", $_FILES[$name][name]);
			$newName = "$k";
			$uploadfile =  "images/schools/$newName";
			move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile);
			$hasLogo = 1;
		}

		$updqry = mysql_query("UPDATE schools SET name='$v', hasLogo='$hasLogo', lat='$lat' , lon='$long' WHERE sid=$k");		
		$newslettermsg='Schools Updated Successfuilly';
	}
} else if (isset($_POST['schoolaction']) && $_POST['schoolaction'] == 'Delete') {
    //action for delete
    $values='';	
	foreach($_POST['schooldel'] as $value)
		$values.=$value.',';
	$values=rtrim($values,',');
	$delqry=mysql_query("delete from schools where sid in ($values)");
	if($delqry && mysql_affected_rows()>0)
	$newslettermsg='Schools Deleted Successfuilly';
	else $newslettermsg='Sorry, an error occured in deletion';
} elseif($_POST['AddSchool'])
{
	$name=$_POST['schoolname'];
	$state=$_POST['addstate'];
	$hasLogo=0;
	$lat=$_POST['addlat'];
	$long=$_POST['addlong'];
	$insdate = mysql_query("INSERT INTO schools(name,state,hasLogo,lat,lon) values('$name','$state','$hasLogo','$lat','$long')");
	if($delqry && mysql_affected_rows()>0)
	$newslettermsg='New School Added Successfuilly';
	else $newslettermsg='Sorry, an error occured in addition';
}
 ?>
<center>
	<table width="95%">
		<tr>
			<td align="center"><b>Select State to get the school list : &nbsp;&nbsp;</b>
				<form method=get action="admin.php">
					<input type=hidden name="action" value="schools">
					<select name="state"><?=$stateOptions?></select>
					<input type=submit value="Go">
				</form>
			</td>
		</tr>
		<?php if(isset($_GET['state'])){ 
			$state=mysql_real_escape_string($_GET['state']); ?>
			<tr>
				<td align="center">					
					Listing Details For State <?php echo $state ?>
					<table>
						<tr>
							<td valign="center">
								<form name="addnewschool" method="post" action="admin.php?action=schools&state=<?php echo $state ?>">
									<input type="hidden" name="addstate" value="<?php echo $state ?>"/>
									Name : <input type="text" name="schoolname" />
									Lat : <input type="text" name="addlat" />
									Long : <input type="text" name="addlong" />
									<input type="submit" name="AddSchool" value="Add New School" />
								</form>
							</td>
						</tr>
					</table>
					<form method="post" enctype="multipart/form-data" action="admin.php?action=schools&state=<?php echo $state ?>">
					<table width="100%">						
						<tr>
							<th>Sr.No.</th>
							<th>School Name</th>							
							<th>Latitude</th>
							<th>Longitude</th>
							<th>Logo</th>
						</tr>	
							<?php $allschool = mysql_query("SELECT * FROM schools WHERE state='$state' ORDER BY name");
							if(mysql_num_rows($allschool))
							{while($allschoolarr=mysql_fetch_object($allschool)){ ?>
							<tr>
								<td><input type="checkbox" name="schooldel[]" value="<?php echo $allschoolarr->sid; ?>" /></td>
								<td><input type="text" name="schoolname[<?php echo $allschoolarr->sid; ?>]" value="<?php echo $allschoolarr->name; ?>" /></td>								
								<td><input type="text" name="lat[<?php echo $allschoolarr->sid; ?>]" value="<?php echo $allschoolarr->lat; ?>" /></td>
								<td><input type="text" name="long[<?php echo $allschoolarr->sid; ?>]" value="<?php echo $allschoolarr->lon; ?>" /></td>
								<td align="center"><input type="hidden" value="<?php echo $allschoolarr->hasLogo; ?>" name='hasLogo[<?php echo $allschoolarr->sid; ?>]'>
									<?php if($allschoolarr->hasLogo == 1){
										echo "<img src='images/schools/$allschoolarr->sid' height=75 width=75 border=1 />";
										echo "<input type='checkbox' name='schoollogodel[$allschoolarr->sid]' />Remove<br/>";
										echo "<input type='file' name='file_$allschoolarr->sid' /></center>";
										}
									else{
										echo "<input type='file' name='file_$allschoolarr->sid' />";} ?>
								</td>
							</tr>
							<?php } 
							echo '<tr><td colspan="2"> <input type="submit" name="schoolaction" value="Update"></td><td colspan="2"><input type="submit" name="schoolaction" value="Delete"></td></tr>';
							} else echo '<tr><td colspan="5" align="center">Sorry, No Schools exist in selected state. </td></tr>';?>						
					</table>
					</form>
				</td>
			</tr>
		<?php } ?>
	</table>
</center>