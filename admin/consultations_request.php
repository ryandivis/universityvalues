<?
if($_POST['subaction'] == "active")
{
	foreach($_POST[delete] as $k=>$v)
	{
		$select = "update consultations set status=0 WHERE id='$k'";
		$result = mysql_query($select) or die(mysql_error());
		$pid = "";
	}
}else if ($_POST['subaction'] == "delete") {
	foreach ($_POST[delete] as $k => $v) {
		$select = "delete from consultations WHERE id='$k'";
		$result = mysql_query($select) or die(mysql_error());

		$pid = "";
	}

}


	if(!$_GET[pid] && $page != 'new')
	{
		echo '<form method=post action="admin.php?action=consultations">';
	echo "<table align=center border=1 cellspacing=3 cellpadding=3>
	<tr><td align='right' colspan='14' ><a href='admin.php?action=consultations_request'>Unarchive List</a></td></tr>
	
	<tr><th>Archieve</th><th style='cursor:pointer;' title='sort by id' onclick=fun_consultant_sort('pid','new_hidden_pid')>ID</th><th style='cursor:pointer;' title='sort by name' onclick=fun_consultant_sort('name','new_hidden_name')>Name</th><th style='cursor:pointer;' title='sort by business' onclick=fun_consultant_sort('business','new_hidden_business')>Business<th style='cursor:pointer;' title='sort by email' onclick=fun_consultant_sort('email','new_hidden_email')>Email</th><th>Phone</th><th style='cursor:pointer;' title='sort by date' onclick=fun_consultant_sort('date','new_hidden_DateCreated')>Date Created</th><th style='cursor:pointer;' title='sort by Social Media' onclick=fun_consultant_sort('socialMedia','new_hidden_SocialMedia')>Social Media</th><th style='cursor:pointer;' title='sort by Mobile Apps'  onclick=fun_consultant_sort('mobileApp','new_hidden_MobileApps')>Mobile Apps</th><th style='cursor:pointer;' title='sort by Mobile Site' onclick=fun_consultant_sort('mobileOp','new_hidden_MobileSite')>Mobile Site</th><th style='cursor:pointer;' title='sort by Design/SEO' onclick=fun_consultant_sort('designSEO','new_hidden_DesignSEO')>Design/SEO</th></tr>
	";
	if( ($_REQUEST['sort_fname']!="") && ($_REQUEST['sort_order']!="") ){
		if($_REQUEST['sort_fname']=='pid') $_REQUEST['sort_fname']='consultations.id';
		$select = "SELECT * FROM consultations,businesses WHERE consultations.status=1 and consultations.pid = businesses.pid order by ".$_REQUEST['sort_fname']. "  " . $_REQUEST['sort_order'];
		if($_REQUEST['sort_fname']=='consultations.id') $_REQUEST['sort_fname']='pid';
	}else{
	   $select = "SELECT * FROM consultations,businesses WHERE consultations.status=1 and  consultations.pid = businesses.pid order by businesses.pid asc";
	}
	$result = mysql_query($select) or die(mysql_error());
	$sort_fname1=$_REQUEST['sort_fname'];
	$sort_order1=$_REQUEST['sort_order'];
	$pid1="";
	$name1="";
	$email1="";
	$business1="";
	if($sort_fname1=='pid'){
		if($sort_order1=="asc"){
			$pid1="asc";
		} else {
			$pid1="desc";
		}
	}
else if($sort_fname1=='name'){
		if($sort_order1=="asc"){
			$name1="asc";
		} else {
			$name1="desc";
		}
	}
else if($sort_fname1=='business'){
		if($sort_order1=="asc"){
			$business1="asc";
		} else {
			$business1="desc";
		}
	}
else if($sort_fname1=='email'){
		if($sort_order1=="asc"){
			$email1="asc";
		} else {
			$email1="desc";
		}
	}else if($sort_fname1=='date'){
		if($sort_order1=="asc"){
			$DateCreated="asc";
		} else {
			$DateCreated="desc";
		}
	}
else if($sort_fname1=='socialMedia'){
		if($sort_order1=="asc"){
			$SocialMedia="asc";
		} else {
			$SocialMedia="desc";
		}
	}
	else if($sort_fname1=='mobileApp'){
		if($sort_order1=="asc"){
			$MobileApps="asc";
		} else {
			$MobileApps="desc";
		}
	}
	else if($sort_fname1=='mobileOp'){
		if($sort_order1=="asc"){
			$MobileSite="asc";
		} else {
			$MobileSite="desc";
		}
	}
	else if($sort_fname1=='designSEO'){
		if($sort_order1=="asc"){
			$DesignSEO="asc";
		} else {
			$DesignSEO="desc";
		}
	} else{}
?>


	<input type="hidden" name="new_hidden_pid" id="new_hidden_pid" value="<?php if($pid1==""){echo 'desc';}else{echo $pid1;}?>">
	<input type="hidden" name="new_hidden_name" id="new_hidden_name" value="<?php if($name1==""){echo 'asc';}else{echo $name1;}?>">
	<input type="hidden" name="new_hidden_business" id="new_hidden_business" value="<?php if($business1==""){echo 'asc';}else{echo $business1;}?>">
	<input type="hidden" name="new_hidden_email" id="new_hidden_email" value="<?php if($email1==""){echo 'asc';}else{echo $email1;}?>">
	
	<input type="hidden" name="new_hidden_DateCreated" id="new_hidden_DateCreated" value="<?php if($DateCreated==""){echo 'asc';}else{echo $DateCreated;}?>">
	<input type="hidden" name="new_hidden_SocialMedia" id="new_hidden_SocialMedia" value="<?php if($SocialMedia==""){echo 'asc';}else{echo $SocialMedia;}?>">
	<input type="hidden" name="new_hidden_MobileApps" id="new_hidden_MobileApps" value="<?php if($MobileApps==""){echo 'asc';}else{echo $MobileApps;}?>">
	<input type="hidden" name="new_hidden_MobileSite" id="new_hidden_MobileSite" value="<?php if($MobileSite==""){echo 'asc';}else{echo $MobileSite;}?>">
	<input type="hidden" name="new_hidden_DesignSEO" id="new_hidden_DesignSEO" value="<?php if($DesignSEO==""){echo 'asc';}else{echo $DesignSEO;}?>">

<?
	while($row = mysql_fetch_array($result))
	{
	$u = $row[1];
	$u = $users[$u];
	echo "
	<tr>
		<td align=center>
		<input type=checkbox name='delete[$row[0]]'>
		</td><td>$row[pid]</td><td>$row[name]</td><td>$row[business]</td><td>$row[email]</td><td>$row[phone]</td><td>".date('m/d/y',$row[6])."</td>";
		echo "<td>";
		if($row[2])	echo "X"; else echo '-';
		echo "</td>";
		echo "<td>";
		if($row[3])	echo "X"; else echo '-';
		echo "</td>";
		echo "<td>";
		if($row[4])	echo "X"; else echo '-';
		echo "</td>";
		echo "<td>";
		if($row[5])	echo "X"; else echo '-';
		echo "</td>";

		echo "
	</tr>
	";

	}
	echo "
	<tr>
		<td><input type='hidden' name='subaction' id='action'>
		<input type=submit value='Unarchive' onclick=fun_redirect('1')>
		</td><td><input type=submit value='Delete' onclick=fun_redirect('2')><td><td colspan=4><a href='admin.php?action=consultations'><input type='button' value='BACK'</a></td>
	</tr>
	";
	echo "</table></form>";
	} else if($pid && $page == 'edit') {

	$select = "SELECT * FROM users WHERE pid='$pid'";
	$result = mysql_query($select) or die(mysql_error());
	$biz = mysql_fetch_array($result);
	?> <a href="admin.php?action=businesses&page=delete&pid=<?=$pid?>">Delete This Business</a>
	<br/>
	<br/>
	<form method=post action="admin.php?action=businesses&page=save&pid=<?=$pid?>">
		<table>
			<? foreach($biz as $k=>$v)
				{
				if(!is_numeric($k) && $k!='pid' && $k!='secret' && $k!='uid' && $k!='logo')
				echo "<tr><td>".ucfirst($k)."</td><td><input type=text name=$k value='$v'/></td></tr>";
				}
			?>
			<tr>
				<td></td><td>
				<input type=submit value="Save">
				</td>
			</tr>
		</table>
	</form>
<? }	?>
<script type="text/javascript">
 function fun_consultant_sort(fieldname,setorder){
 	var neworder="";
 	var set_new_order=document.getElementById(setorder).value;
 	if(set_new_order=="desc"){
 		neworder="asc";
 	}else if(set_new_order=="asc"){
 	  neworder="desc";	
 	}else{}
 	window.location="https://www.universityvalues.com/MW/admin.php?action=consultations_request&sort_fname="+fieldname+"&sort_order="+neworder;
 }	
	function fun_redirect(str) {

		if(str == 1)
			{
				document.getElementById('action').value='active';
				document.getElementById('frm1').submit();
			}
		else
			{
				document.getElementById('action').value='delete';
				document.getElementById('frm1').submit();
			}

	}
</script>