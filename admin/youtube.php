<?php 
$newslettermsg='';
function getid($url)
{
	$result = preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);	
    if (false !== $result) {
        return $matches[0];
    }
    return '';
}
if(isset($_POST['addvideo']) && $_POST['addvideo']=='Add New Video'){
	$youtubeurl=getid($_POST['videourl']);
	$youtubeorder=$_POST['videoorder'];
	if($_FILES['youimage']['error']<= 0){
		echo $youtubethumb='images/'.$_FILES['youimage']['name'];
		move_uploaded_file($_FILES['youimage']['tmp_name'], "images/".$_FILES['youimage']['name']);
		
	}
	else{
		$youtubethumb="http://img.youtube.com/vi/$youtubeurl/mqdefault.jpg";
	}
	
	
	
	$insqry=mysql_query("INSERT INTO youtube (youtubeCode,youtubeThumb,orderNum) values ('$youtubeurl','$youtubethumb', '$youtubeorder')") or die(mysql_error());
	if($insqry && mysql_affected_rows()>0)
	$newslettermsg='New Video Added Successfully';
	else $newslettermsg='Sorry, an error occured in addition';
	
}elseif(isset($_POST['youtubedel']) && $_POST['youtubedel']=='Delete'){
	$values='';	
	foreach($_POST['youtubeids'] as $value)
		$values.=$value.',';
	$values=rtrim($values,',');
	$delqry=mysql_query("delete from youtube where id in ($values)");
	if($delqry && mysql_affected_rows()>0)
	$newslettermsg='Video Deleted Successfuilly';
	else $newslettermsg='Sorry, an error occured in deletion';
} ?>
<center>
	<h2>You Tube Videos (sign up page)</h2>
	<form enctype="multipart/form-data" name="youtubeadd" method="post" action="admin.php?action=youtube">
	<table>
		<tr>Add New Video</tr>
		<tr><td>You Tube URL</td><td><input type="text" name="videourl" /></td></tr>
		<tr><td>Upload Image</td><td><input type="file" name="youimage" /></td></tr>
		<tr><td>Video Order</td><td><input type="text" name="videoorder" maxlength="2"  /></td></tr>
		<tr><td colspan="2"><input type="submit" name="addvideo" value="Add New Video"/></td></tr>
	</table>
	</form>
	<form name="youtube" method="post" action="admin.php?action=youtube">
		<input type="hidden" name="deletenewsletter" value="DM" />
		<table>
			<?php if($newslettermsg!='') echo "<tr><td colspan='2' align='center'>$newslettermsg</td></tr>"; ?>
			<tr>
				<th width="100">Sr No.</th>
				<th width="300">You Tube Code</th>
				<th>Thumbnail</th>
				<th>Order</th>
			</tr>
			<?php
			$allnews = mysql_query("SELECT * FROM youtube ORDER BY orderNum");
			if(mysql_num_rows($allnews))
			{while($allnewsarr=mysql_fetch_object($allnews))
			{ ?>
				<tr>
					<td align="center"><input type="checkbox" name="youtubeids[]" value="<?php echo $allnewsarr->id;  ?>" /></td>
					<td align="center"><?php echo $allnewsarr->youtubeCode ?></td>
					<td align="center"><img src="<?php echo $allnewsarr->youtubeThumb ?>" width="100" height=""></td>
					<td align="center"><?php echo $allnewsarr->orderNum ?></td>
				</tr>
			<?php }
			echo '<tr><td colspan="2"><input type="submit" value="Delete" name="youtubedel"></td></tr>';
			}
			else echo '<tr><td colspan="2" align="center">Sorry No you tube video posted yet</td></tr> ';
			?>
		</table>
	</form>
</center>