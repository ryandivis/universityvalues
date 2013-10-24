<script type="text/javascript">
	function Unsubscribe2(email)
	{
		var confirmdel = confirm("Are You Sure Want to subscribe Selected Type?");
		if(confirmdel)
		window.location.href = "admin_new.php?action=businesses&page=sbscribe&delemail="+email;
	}
	function Unsubscribe1(email)
	{
		var confirmdel = confirm("Are You Sure Want to Unsubscribe Selected Type?");
		if(confirmdel)
		window.location.href = "admin_new.php?action=businesses&page=deletesubcribe&delemail="+email;
	}
	$(function(){

		$('tr.business').click(function(){

			window.location = 'admin_new.php?action=business&id='+$(this).attr('rel');
			
		});

		$('form.form-search').submit(function(event){
			event.preventDefault();

			var query = $(this).find('input[name="search"]').val();

			$.ajax({
				url : 'admin/search.php',
				data: {
					'type': 'business',
					'query': query
				},
				method: 'POST'
			}).done(function(data){
				$('#table_area').empty().append(data);
			})
		})
	
	})
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
	
	echo "<script type='text/javascript'> window.location.href = 'admin_new.php?action=businesses'</script>";
}
else if($page == "sbscribe"){
	$emailinsert=$_GET[delemail];
	$date=time();
	$inertemail="insert into newsLetter (email,datemade) values('$emailinsert','$date') ";
	$inserresult=mysql_query($inertemail);
	
	echo "<script type='text/javascript'> window.location.href = 'admin_new.php?action=businesses'</script>";
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
<form method=post action="admin_new.php?action=businesses&page=add"  enctype="multipart/form-data">
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

	// get the count of the total businesses
	$res = mysql_query("SELECT COUNT(*) as cnt FROM businesses WHERE skiped!=0") or die(mysql_error());
	$res = mysql_fetch_assoc($res);
	$total = $res['cnt'];

	$x = isset($_GET['x'])? $_GET['x'] : 0;

	$select = "SELECT b.pid,b.business, b.name, b.email, b.phone, b.city,b.state,COUNT(c.cid) as cnt FROM businesses b LEFT JOIN coupons c ON b.pid = c.pid where b.skiped!=0 GROUP BY b.pid ORDER BY $filter $dir LIMIT 10 OFFSET $x";

	if($dir == 'DESC')
		$dir = '';
	else
	   $dir = 'DESC';

	$result = mysql_query($select) or die(mysql_error());
	
	$href = $_SERVER['REQUEST_URI']; //for pagination
	$href = preg_replace('/&x=\d+/', '', $href);
?>
<form class="form-search">
  <div class="input-append">
    <input name="search" type="text" class="input-large search-query">
    <button type="submit" class="btn">Search</button>
  </div>
</form>
<a class="btn btn-primary" href="admin_new.php?action=businesses&page=new">Add New</a>
<div id="table_area">
	<form method=post action="admin_new.php?action=businesses&state=<?=$state?>&page=delete">
	<div class="pagination pagination-centered">
		<ul>
			<li <?php if($x < 1) echo "class='disabled'"; ?>><a href="<?php echo $href."&x=".$i-1?>"><<</a></li>
			<?php for($i=0; ($i * 10) < $total; $i++): ?>
			<li <?php if($x == $i) echo "class='active'";?>><a href="<?php echo $href."&x=".$i?>"><?php echo $i+1; ?></a></li>
			<?php endfor;?>
			<li <?php if($x == $i) echo "class='active'";?>><a href="<?php echo $href."&x=".$i?>"><?php echo $i+1;?></a></li>
			<li><a href="<?php echo $href."&x=".$i; ?>">>></a></li>
		</ul>
	</div>
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
	<div class="pagination pagination-centered">
		<ul>
			<li <?php if($x < 1) echo "class='disabled'"; ?>><a href="<?php echo $href."&x=".$i-1?>"><<</a></li>
			<?php for($i=0; ($i * 10) < $total; $i++): ?>
			<li <?php if($x == $i) echo "class='active'";?>><a href="<?php echo $href."&x=".$i?>"><?php echo $i+1; ?></a></li>
			<?php endfor;?>
			<li <?php if($x == $i) echo "class='active'";?>><a href="<?php echo $href."&x=".$i?>"><?php echo $i+1;?></a></li>
			<li><a href="<?php echo $href."&x=".$i; ?>">>></a></li>
		</ul>
	</div>
</div>
<?php
} else if($pid && $page == 'edit') {

	$select = "SELECT * FROM businesses WHERE pid='$pid'";

	$result = mysql_query($select) or die(mysql_error());

	$biz = mysql_fetch_array($result);

?>

<a href="admin_new.php?action=businesses&page=delete&pid=<?=$pid?>">Delete This Business</a>

<br/><br/>
<form method=post action="admin_new.php?action=businesses&page=save&pid=<?=$pid?>">
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

	



