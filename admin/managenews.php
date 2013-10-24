<script>
	function cancle()
	{
		window.location='admin.php?action=managenews&page=list';
	}
</script>
<?php
$page=$_GET['page'];	
if($page=='add')
{
if($_REQUEST['submit']==1)
{
	$time=time();
	$uploaddir = 'newsimage/';
	$fileimage = $uploaddir .$time.basename($_FILES['Filedata']['name']);
	$filename =$time.basename($_FILES['Filedata']['name']);
	if(@move_uploaded_file($_FILES['Filedata']['tmp_name'], $fileimage))
	{				$offerbgimg=$fileimage;					$image_info = getimagesize($offerbgimg);					$image_type = $image_info[2];					if( $image_type == IMAGETYPE_JPEG ) { 				        $finalimage = imagecreatefromjpeg($offerbgimg);				      } elseif( $image_type == IMAGETYPE_GIF ) { 				         $finalimage = imagecreatefromgif($offerbgimg);				      } elseif( $image_type == IMAGETYPE_PNG ) { 				         $finalimage = imagecreatefrompng($offerbgimg);				      }					  $bg_image = imagecreatetruecolor(283, 171);					  $imgwidth=@imagesx($finalimage);	 				  $imgheight=@imagesy($finalimage);					  					  imagealphablending($bg_image, false);					  imagesavealpha($bg_image,true);					  $transparent = imagecolorallocatealpha($bg_image, 255, 255, 255, 127);					  imagefilledrectangle($bg_image, 0, 0, $imgwidth, $imgheight, $transparent);					  					  @imagecopyresampled($bg_image, $finalimage, 0, 0, 0, 0, 283, 171, $imgwidth, $imgheight);					  if( $image_type == IMAGETYPE_JPEG ){					  							 	imagejpeg($bg_image,$offerbgimg,75);						 }elseif( $image_type == IMAGETYPE_GIF ) {					        imagegif($bg_image,$offerbgimg);					     } elseif( $image_type == IMAGETYPE_PNG ) {					      	imagepng($bg_image,$offerbgimg,0);					     }					   imagedestroy($finalimage);					   imagedestroy($bg_image);
	$insert="INSERT INTO managnews(news_image, 	new_dsc) values('".$filename."','".@mysql_real_escape_string($_POST['description'])."')";
	$query=mysql_query($insert);
	if($query)
	{
		echo'<script>window.location="admin.php?action=managenews&page=list&conf=1";</script>';
	}
	else { die('error' . mysql_error()); }
	}
}
?>
<form action="" method="post" enctype="multipart/form-data" >
	<center>
	<table border="1">
		<tr>
			<td align="center" colspan="2">Add News</td>
		</tr>
		<tr>
			<td>Image</td>
			<td><input type="file" name="Filedata" /></td>
		</tr>
		
		<tr>
			<td>Description</td>
			<td><textarea name="description" style="width: 224px; height: 84px;"></textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" value="submit" /> &nbsp;&nbsp;&nbsp;<input onclick="cancle();" type="button" name="" value="cancle" />
				<input type="hidden" value="1" name="submit" />
				
			</td>
		</tr>
	</table>
	</center>
</form>
<?php }
else if($page=='edit')
{
	
	$query="SELECT * FROM managnews WHERE news_id='".$_GET['nid']."'";
	$result=@mysql_query($query);
	$row= @mysql_fetch_array($result);
	if($_REQUEST['submit']==2)
	{
		$time=time();
		$uploaddir = 'newsimage/';
		$removeimage = "newsimage/".$row['news_image'];
		$fileimage = $uploaddir .$time.basename($_FILES['Filedata']['name']);
		$filename =$time.basename($_FILES['Filedata']['name']);
		if($_FILES['Filedata']['name']=="")
		{
			$filename=$row['news_image'];
		}
		else {
			$filename=$time.basename($_FILES['Filedata']['name']);
		}
		$update="UPDATE managnews SET news_image='".$filename."',mylink='".@mysql_real_escape_string($_POST['mylink'])."', new_dsc='".@mysql_real_escape_string($_POST['description'])."' WHERE news_id='".$_GET['nid']."'";
		$query=mysql_query($update);
		if($query)
		{
			$move=@move_uploaded_file($_FILES['Filedata']['tmp_name'], $fileimage);									$offerbgimg=$fileimage;					$image_info = getimagesize($offerbgimg);					$image_type = $image_info[2];					if( $image_type == IMAGETYPE_JPEG ) { 				        $finalimage = imagecreatefromjpeg($offerbgimg);				      } elseif( $image_type == IMAGETYPE_GIF ) { 				         $finalimage = imagecreatefromgif($offerbgimg);				      } elseif( $image_type == IMAGETYPE_PNG ) { 				         $finalimage = imagecreatefrompng($offerbgimg);				      }					  $bg_image = imagecreatetruecolor(283, 171);					  $imgwidth=@imagesx($finalimage);	 				  $imgheight=@imagesy($finalimage);					  					  imagealphablending($bg_image, false);					  imagesavealpha($bg_image,true);					  $transparent = imagecolorallocatealpha($bg_image, 255, 255, 255, 127);					  imagefilledrectangle($bg_image, 0, 0, $imgwidth, $imgheight, $transparent);					  					  @imagecopyresampled($bg_image, $finalimage, 0, 0, 0, 0, 283, 171, $imgwidth, $imgheight);					  if( $image_type == IMAGETYPE_JPEG ){					  							 	imagejpeg($bg_image,$offerbgimg,75);						 }elseif( $image_type == IMAGETYPE_GIF ) {					        imagegif($bg_image,$offerbgimg);					     } elseif( $image_type == IMAGETYPE_PNG ) {					      	imagepng($bg_image,$offerbgimg,0);					     }					   imagedestroy($finalimage);					   imagedestroy($bg_image);
			if($move){ unlink($removeimage); }
			echo'<script>window.location="admin.php?action=managenews&page=list&confup=1";</script>';
		}
		else { die('error' . mysql_error()); }
	}
?>
	<form action="" method="post" enctype="multipart/form-data" >
	<center>
	<table border="1">
		<tr>
			<th align="center"colspan="2">Update Info</td>
		</tr>
		<tr>
			<td>Image</td>
			<td><input type="file" name="Filedata"/></td>
		</tr>
		<tr>
			<td></td>
			<td> <img width="100" height="100" src="newsimage/<?php echo $row['news_image']; ?>" /> </td>
		</tr>
		<tr>
			<td>Link</td>
			<td><input type="text" name="mylink" value=<?php echo $row['mylink']; ?>></td>
		</tr>
		<tr>
			<td>Description</td>
			<td><textarea name="description" style="width: 224px; height: 84px;"><?php echo $row['new_dsc']; ?></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" value="submit" /> &nbsp;&nbsp;&nbsp;<input onclick="cancle();" type="button" name="" value="cancle" />
				<input type="hidden" value="2" name="submit" />
				
			</td>
		</tr>
	</table>
	</center>
</form>
	
<? } else if($page=='del') {
	
		 if (isset($_GET['nid'])) {
					$qry = mysql_query("delete from managnews where news_id='" . $_GET['nid'] . "'");
					if ($qry) {
						unlink('newsimage/'.$_GET['imagename']);
						echo'<script>window.location="admin.php?action=managenews&page=list&confdl=1";</script>';
					} else {
						die('error' . mysql_error());
					}
				}
	
}
 else { ?>
 	<center>
<table width="" border="1">
	<tr>
		<?php if($_GET[conf]==1) { echo "<td align='center' colspan='4'>Add Successfully....</td>"; }?>
		<?php if($_GET[confup]==1) { echo "<td align='center' colspan='4'>Update Successfully....</td>"; }?>
		<?php if($_GET[confdl]==1) { echo "<td align='center' colspan='4'>Delete Successfully....</td>"; }?>
		<td colspan='5' width="70" align="right"> <a href="admin.php?action=managenews&page=add">Add News</a> </td>
	</tr>
		<tr>
			<th>Id</th>
			<th>Image</th>
			<th>Descripation</th>
			<th>Link</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
		<?php 
		$query="SELECT * FROM managnews";
		$result=mysql_query($query);
		if(mysql_num_rows($result)!=0)
		{
			while($row=mysql_fetch_array($result))
			{
				echo '<tr>
				<td align="center" width="50">'.$row['news_id'].'</td>
				<td align="center" width="150"><img width="100" height="100" src="newsimage/'.$row['news_image'].'"</td>
				<td align="center" width="250">'.$row['new_dsc'].'</td>
				<td align="center"><a href='.$row['mylink'].'>'.$row['mylink'].'</a></td>
				<td align="center" width="50"><a href="admin.php?action=managenews&page=edit&nid='.$row['news_id'].'">Edit</a></td>
				<td align="center" width="50"><a href="admin.php?action=managenews&page=del&nid='.$row['news_id'].'&imagename='.$row['news_image'].'">Delete</a></td>
				</tr>';
			}
		} else { echo"<tr><td align='center' colspan='5'>No Data</td></tr>"; }
			
		?>
	</table>
	</center>
	
<?php } ?>