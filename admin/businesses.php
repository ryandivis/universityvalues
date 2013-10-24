<script type="text/javascript">
	function Unsubscribe2(email)
	{
		var confirmdel = confirm("Are You Sure Want to subscribe Selected Type?");
		if(confirmdel)
		window.location.href = "admin.php?action=businesses&page=sbscribe&delemail="+email;
	}
	function Unsubscribe1(email)
	{
		var confirmdel = confirm("Are You Sure Want to Unsubscribe Selected Type?");
		if(confirmdel)
		window.location.href = "admin.php?action=businesses&page=deletesubcribe&delemail="+email;
	}
</script>
<?


if($page == "delete")

{
	foreach($_POST[delete] as $k=>$v)
	{
		$select = "DELETE FROM businesses WHERE pid='$k'";
		$result = mysql_query($select) or die(mysql_error());

		$select = "DELETE FROM coupons WHERE pid='$k'";
		$result = mysql_query($select) or die(mysql_error());

		$select = "DELETE FROM locations WHERE pid='$k'";
		$result = mysql_query($select) or die(mysql_error());

		$select = "DELETE FROM featured WHERE pid='$k'";
		$result = mysql_query($select) or die(mysql_error());

		$pid = "";
	}

}
else if($page == "deletesubcribe"){
	
	$del="delete from newsLetter where email='$_GET[delemail]' ";
	$deletresult=mysql_query($del);
	
	echo "<script type='text/javascript'> window.location.href = 'admin.php?action=businesses'</script>";
}
else if($page == "sbscribe"){
	$emailinsert=$_GET[delemail];
	$date=time();
	$inertemail="insert into newsLetter (email,datemade) values('$emailinsert','$date') ";
	$inserresult=mysql_query($inertemail);
	
	echo "<script type='text/javascript'> window.location.href = 'admin.php?action=businesses'</script>";
}
	else if($page == "add")
	{
		$logo = "";
		if($_FILES[file][error] == 0)
		{
			list($txt, $ext) = explode(".", $_FILES[$name][name]);
			$newName = time()."$ext";
			$uploadfile =  $_SERVER['DOCUMENT_ROOT']."/new/images/business/logo/$newName"; // /home4/onlinea6/public_html... before (but doesn't work after server migration)

			if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			    echo "File is valid, and was successfully uploaded.\n";
			} else {
			    echo "Possible file upload attack!\n"; // "uploadfile = " . $uploadfile;
			}

			$logo = "images/business/logo/$newName";
		}

		$secret = md5($email);

                
		$query = "INSERT INTO businesses (  name, 
                                                    business, 
                                                    email, 
                                                    phone, 
                                                    address, 
                                                    addressMore, 
                                                    state, 
                                                    city, 
                                                    zip, 
                                                    website, 
                                                    facebook, 
                                                    twitter, 
                                                    logo, 
                                                    secret,
                                                    skiped) values 
                                                 (  '".mysql_real_escape_string($_POST[firstName] . " " . $_POST[lastName]) . "',
                                                    '".mysql_real_escape_string($_POST[business])."', 
                                                    '".mysql_real_escape_string($_POST[email])."',
                                                    '".mysql_real_escape_string($_POST[phone])."',
                                                    '".mysql_real_escape_string($_POST[address])."',
                                                    '".mysql_real_escape_string($_POST[addressMore])."',
                                                    '".mysql_real_escape_string($_POST[state]) . "',
                                                    '".mysql_real_escape_string($_POST[city]) . "',
                                                    '".mysql_real_escape_string($_POST[zip]) . "',
                                                    '".mysql_real_escape_string($_POST[website]) . "',
                                                    '".mysql_real_escape_string($_POST[facebook]) . "',
                                                    '".mysql_real_escape_string($_POST[twitter]) . "',
                                                    '".mysql_real_escape_string($logo) . "',
                                                    '".mysql_real_escape_string($secret) . "',
                                                    '".mysql_real_escape_string(1) . "'
                                                )";
		$result = mysql_query($query) or die(mysql_error());	
	}

 else if($page == "save") {

		$query = "UPDATE businesses SET name='$name',business='$business',email='$email',phone='$phone',address='$address',addressMore='$addressMore',state='$state',city='$city',zip='$zip',website='$website',facebook='$facebook',twitter='$twitter',cardName='$cardName',lastFour='$lastFour',expM='$expM',expY='$expY' WHERE pid='$pid'";

		$result = mysql_query($query) or die(mysql_error());		

		$pid = "";

} else if($page == "new") {
?>
<form method=post action="admin.php?action=businesses&page=add"  enctype="multipart/form-data">
<table align=center>
<tr>
<td>First Name:</td>
<td><input type="text" name="firstName" title="First Name" class="defaultText"></td></tr>
<tr>
<td>Last Name:</td>
<td><input type="text" name="lastName" title="Last Name" class="defaultText"> </td></tr>
<tr>
<td>Email:</td>
<td><input type="text" name="email" title="Email" class="defaultText"> </td></tr>

<tr>
<td>Business Name:</td>
<td><input type="text" name="business" title="Business Name" class="defaultText">  </td></tr>

<tr>
<td>Phone:</td>
<td><input type="text" name="phone" title="Phone" class="defaultText">  </td></tr>

<tr>
<td>Address 1:</td>
<td><input type="text" name="address" title="Address 1" class="defaultText">  </td></tr>

<tr>
<td>Address 2:</td>
<td><input type="text" name="addressMore" title="Address 2" class="defaultText">  </td></tr>

<tr>
<td>City:</td>
<td><input type="text" name="city" title="City" class="medium defaultText"></td></tr>

<tr>
<td>State:</td>
<td><select name="state" size="1">

            <option value="AK">AK</option>

            <option value="AL">AL</option>

            <option value="AR">AR</option>

            <option value="AZ">AZ</option>

            <option value="CA">CA</option>

            <option value="CO">CO</option>

            <option value="CT">CT</option>

            <option value="DC">DC</option>

            <option value="DE">DE</option>

            <option value="FL">FL</option>

            <option value="GA">GA</option>

            <option value="HI">HI</option>

            <option value="IA">IA</option>

            <option value="ID">ID</option>

            <option value="IL">IL</option>

            <option value="IN">IN</option>

            <option value="KS">KS</option>

            <option value="KY">KY</option>

            <option value="LA">LA</option>

            <option value="MA">MA</option>

            <option value="MD">MD</option>

            <option value="ME">ME</option>

            <option value="MI">MI</option>

            <option value="MN">MN</option>

            <option value="MO">MO</option>

            <option value="MS">MS</option>

            <option value="MT">MT</option>

            <option value="NC">NC</option>

            <option value="ND">ND</option>

            <option value="NE">NE</option>

            <option value="NH">NH</option>

            <option value="NJ">NJ</option>

            <option value="NM">NM</option>

            <option value="NV">NV</option>

            <option value="NY">NY</option>

            <option value="OH">OH</option>

            <option value="OK">OK</option>

            <option value="OR">OR</option>

            <option value="PA">PA</option>

            <option value="RI">RI</option>

            <option value="SC">SC</option>

            <option value="SD">SD</option>

            <option value="TN">TN</option>

            <option value="TX">TX</option>

            <option value="UT">UT</option>

            <option value="VA">VA</option>

            <option value="VT">VT</option>

            <option value="WA">WA</option>

            <option value="WI">WI</option>

            <option value="WV">WV</option>

            <option value="WY">WY</option>

        </select></td></tr>

<tr>
<td>Zip:</td>
<td><input type="text" name="zip" title="Zip" class="small defaultText"> </td></tr>

<tr>
<td>Website URL:</td>
<td><input type="text" name="website" title="Website URL" class="defaultText"> </td></tr>

<tr>
<td>Facebook URL:</td>
<td><input type="text" name="facebook" title="Facebook URL" class="defaultText"> </td></tr>

<tr>
<td>Twitter URL:</td>
<td><input type="text" name="twitter" title="Twitter URL" class="defaultText"> </td></tr>

<tr>
<td>Logo:</td>
<td><input type="file" name="file"> </td></tr>
<tr><td></td><td><br/><input type=submit value="Add Business"></td></tr>
</table>
</form>


<?
}





if(!$_GET[pid] && $page != 'new')

{
	if(!$filter)
		$filter = 'business';

	$select = "SELECT * FROM businesses where skiped!=0 ORDER BY $filter $dir";

	if($dir == 'DESC')
		$dir = '';
	else
	   $dir = 'DESC';



	$result = mysql_query($select) or die(mysql_error());

	echo "<table align=center border=1>

	<tr><th>Delete</th>
	<th><a href='admin.php?action=businesses&filter=pid&dir=$dir'>ID</a></th>
	<th><a href='admin.php?action=businesses&filter=business&dir=$dir'>Business</a></th>
	<th><a href='admin.php?action=businesses&filter=name&dir=$dir'>Name</a></th>
	<th><a href='admin.php?action=businesses&filter=email&dir=$dir'>Emails</a></th>
	<th><a href='admin.php?action=businesses&filter=phone&dir=$dir'>Phone</a></th>
	<th><a href='admin.php?action=businesses&filter=city&dir=$dir'>City</a></th>
	<th><a href='admin.php?action=businesses&filter=state&dir=$dir'>State</a></th><th></th></tr>

	";

?>
<center><A href="admin.php?action=businesses&page=new">Add New</a></center><br/>
<form method=post action="admin.php?action=businesses&state=<?=$state?>&page=delete">
<?
	while($row = mysql_fetch_array($result))
	{
		echo "<tr><td><input type=checkbox name='delete[$row[0]]'></td><td>$row[0]</td><td>$row[2]</td><td>$row[1]</td><td>$row[3]</td><td>$row[4]</td><td>$row[8]</td><td>$row[7]</td><td><a href=\"account.php?a=1&pid=$row[0]\" target=new>Login</a></td>";
		 $chechkmail="SELECT * FROM newsLetter where email='$row[3]'";
			$checkresult=mysql_query($chechkmail);
			if(mysql_fetch_array($checkresult)>0) { $sss="Unsubscribe"; $clic="1"; } else{ $sss="subscribe"; $clic="2"; } ?>
			
			<td><div onclick="Unsubscribe<?php echo $clic; ?>('<?php echo $row[3]; ?>');"><?php echo $sss; ?></div> </td></tr>
			<?php
	}
	echo "<tr><td><input type=submit value='DELETE'></td></tr>";
	echo "</table></form>";
} else if($pid && $page == 'edit') {

	$select = "SELECT * FROM businesses WHERE pid='$pid'";

	$result = mysql_query($select) or die(mysql_error());

	$biz = mysql_fetch_array($result);

?>

<a href="admin.php?action=businesses&page=delete&pid=<?=$pid?>">Delete This Business</a>

<br/><br/>
<form method=post action="admin.php?action=businesses&page=save&pid=<?=$pid?>">
<table>



<?

	foreach($biz as $k=>$v)

	{

		if(!is_numeric($k) && $k!='pid' && $k!='secret' && $k!='uid' && $k!='logo')

			echo "<tr><td>".ucfirst($k)."</td><td><input type=text name=$k value='$v'/></td></tr>";



	}

?>

<tr><td></td><td><input type=submit value="Save"></td></tr>

</table>

</form>



<? } ?>

	



