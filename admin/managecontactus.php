<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckeditor/_samples/sample.js"></script>
<?php
$select="select * from managepages where id=2";
$result=mysql_query($select);
$row=mysql_fetch_array($result);
if(isset($_REQUEST['submit']))
{
$descr = $_POST['page_dis'];
$update="update managepages set page_name='$descr.' where id='2' ";
$resultudate=mysql_query($update);
if($resultudate){  echo'<script>window.location="admin.php?action=managecontactus";</script>' ;} else { die('error' . mysql_error()); }
}
?>
<form method="post" enctype="multipart/form-data">
	<center>
	<table width="90%" height="100%">
		<tr>
			<td><h2>Contact US</h2</td>
		</tr>
		<tr>
			<td><?php
				include('ckeditor/ckeditor.php');
				$ckeditor = new CKEditor();
				$description=$row['page_name'];
				$ckeditor->editor('page_dis',$description);?></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Update" /></td>
		</tr>
	</table>
	</center>
</form>