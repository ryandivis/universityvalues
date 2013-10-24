<?php
$ack="";
if (isset($_REQUEST['step'])==2) {
	$admin=($_SESSION['adminuser']);
	$pwd=md5($_POST['old_pwd']);
	$npwd=md5($_POST['new_pwd']);
	$cpwd=md5($_POST['cnfrm_pwd']);
	$result = mysql_query("SELECT pwd FROM admin WHERE admin_name='$admin'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($pwd!=$row['pwd']){
		$ack="Old Password not match";
	}
	else if($npwd!=$cpwd){
		$ack="New Password or Confirm password not match";
	}
	else if(mysql_query("UPDATE admin SET pwd='$npwd' WHERE admin_name='$admin'")) {
		$ack="Password Sucessful Change";
	}
	else{
		$ack="Some Problem Occure Try Again";
	}
}
?>
<form name="frm" action="#" method="post">
<table align=center border=1>
	<tr><th colspan="2" align="center">Change Admin Password</th></tr>
	<tr><td colspan="2" align="center"><h2><?php echo $ack; ?></h2> </td></tr>
	<tr><td>Old Password</td><td><input type="password" name="old_pwd" placeholder="OldPassword"></td></tr>
	<tr><td>New Password</td><td><input type="password" name="new_pwd" placeholder="New Password"></td></tr>
	<tr><td>Confirm Password</td><td><input type="password" name="cnfrm_pwd" placeholder="Confirm New Password"></td></tr>
	<input type="hidden" name="step" value="2">
	<tr><td> </td><td><input type="submit" value="Change Password" name="chngpwd"></td></tr>
</table>
</form>