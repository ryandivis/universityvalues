<?php
$ack="";
if(!isset($_REQUEST['upd_link'])){
$result = mysql_query("SELECT youtube_link FROM how_it_work WHERE id=1") or die(mysql_error());
$row = mysql_fetch_array($result);
$pre_val=$row['youtube_link'];
}
else {
	$y_link=$_POST['youtube_link'];
	if($y_link==""){
		$ack="Please Insert Link";
	}
	else if(mysql_query("UPDATE how_it_work SET youtube_link='$y_link' WHERE id=1")) {
		$ack="Link Update";
	}
	else{
		$ack="Unknown Error";
	}
}
?>
<form name="frm" action="#" method="post">
<table align=center border=1>
	<tr><th colspan="2" align="center">How It Works</th></tr>
	<tr><td colspan="2" align="center"><h2><?php echo $ack; ?></h2> </td></tr>
	<tr><td>You Tube Link</td><td><input type="text" name="youtube_link" value="<?php echo $pre_val; ?>"></td></tr>
	<input type="hidden" name="step" value="2">
	<tr><td> </td><td><input type="submit" value="Update Link" name="upd_link"></td></tr>
</table>
</form>