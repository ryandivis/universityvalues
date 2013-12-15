<?
include_once('php_helpers/forms/states.php');
include_once('php_helpers/page_specific/boxes_helper.php');

if ($_SERVER['HTTP_HOST'] == 'universityvalues.com'
		|| $_SERVER['HTTP_HOST'] == 'www.universityvalues.com')
	$url = 'https://' . $_SERVER['HTTP_HOST'] . '/';
else
	$url = 'http://' . $_SERVER['HTTP_HOST'] . "/UniversityValues/old/";
if ($print == 1) {
?>

<div id="print-panel">
	<div class="closeIt">
		<a id="close-print" href="#"><img src="images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="printContent">
		<div class="printHeader"><img onclick="Print('custom_print_coupon')" src="images/click-print.png" alt="Click to Print" border=0 style="margin-left:41px; cursor: pointer;"/>
		</div>
		<div id="custom_print_coupon" style="margin:10px;width: 758px">
			<table class="uvBrand" cellpadding="0" cellspacing="0" border="0" align="center" style="width: 758px">
				<tr>
					<td colspan="4" valign="top" height="5"><img src="<?php echo $url; ?>images/dash_horz.jpg" border="0"></td>
				</tr>
				<tr>
					<td width="5" valign="top"><img src="<?php echo $url; ?>images/dash_ver.jpg" border="0" height="358"></td>
					<td style="width:260px;" align="left" valign="center">
					<div align="left" style="text-align: center;font-size: 28px;font-weight:bold;font-family: 'calibri','serif';text-transform: uppercase;">
						This Coupon Was
						<br/>
						Found On:
						<br/>
						<img src="<?php echo $url; ?>images/foundOn.jpg" />
					</div></td>
					<td valign="center" align="center" style="width: 488px;">
					<table align="center" border="0" cellpadding="0" cellspacing="0" style="width: 440px;">
						<tbody>
							<tr>
								<td valign="top"><img width="446" height="307" src="<?php if ($coupon['type']
			== 1) {
		echo $coupon[custom_image];
	} else
		echo $url . $coupon[custom_image];
																					?>" style="background-color: #92d050;border: 2px solid #000;"></td>
							</tr>
						</tbody>
					</table></td>
					<td valign="top" width="5"><img src="<?php echo $url; ?>images/dash_ver.jpg" border="0" height="358"></td>
				</tr>
				<tr>
					<td colspan="4" valign="top" height="5"><img src="<?php echo $url; ?>images/dash_horz.jpg" border="0"></td>
				</tr>
			</table>
		</div>
		</p>
	</div>
</div>
<script type ="text/javascript" language ="javascript">
	function Print(strid) {
		var values = document.getElementById(strid);
		var printing = window.open("width=800");
		printing.document.write(values.innerHTML);
		printing.document.close();
		printing.focus();
		printing.print();
		printing.close();
	}
</script>
<div id="email-panel">
	<script type="text/javascript">
		function validateemailshare()
		{
			if(document.getElementById('emailContentyourName').value=='' || document.getElementById('emailContentyourName').value=='Your Name')
			{alert('Please Enter your Name'); document.getElementById('emailContentyourName').focus; return false;}
			
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(document.getElementById('emailContentemail').value=='' || !re.test(document.getElementById('emailContentemail').value))
			{  alert ("Please enter a valid email"); document.getElementById('emailContentemail').focus; return false;}	
		}
	</script>
	<div class="closeIt">
		<a id="close-email" href="#"><img src="images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="emailContent">
		<img src="images/emailCoupon.jpg" />
		<table class="uvBrand" align=center style="margin-top:20px;" width=97% style="margin-left:auto; margin-right:auto; text-align:center;">
			<tr>
				<td valign=top align=center>
				<br/>
				<br/>
				<br/>
				<br/>
				<form  method="post" onsubmit="return validateemailshare();" action="<?=$url ?>coupon-details.php?state=<?=$_GET[state] ?>&coupon=<?=$_GET[coupon] ?>&school=<?=$_GET[school] ?>">
					<input type="hidden" name="sendEmail" value="1"/>
					<p>
						<input type="text" name="yourName" id="emailContentyourName" title="Your Name"  class="defaultText" style="margin-bottom:12px;" />
						<br/>
						<input type="text" name="email" id="emailContentemail" title="Email to send to"  class="defaultText" />
					</p>
					<p>
						<input type="image" src="images/clickToSend.jpg" style="margin-top:5px;" border="0" alt="SUBMIT">
					</p>
				</form></td><td align=center valign=top>
				<br/>
				<br/>
				<br/>
				<img src="<?=$coupon[custom_image] ?>" width="324" height="217" style=" margin-right:45px;" ></td>
			</tr>
			<tr></tr>
		</table>
	</div>
</div>
<div id="map-panel">
	<div class="closeIt">
		<a id="close-map" href="#"><img src="images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="map-content">
		<div id="map-locations">
			<?

	$count = 1;

	foreach ($locations as $location) {

			?>

			<span class="funky upper" style="color:#000;">Location <?=$count
																   ?></span>
			<div style="width:100%; height:1px; background-color:#000;"></div>
			<span style="display:block; margin-top:5px; margin-bottom:10px; font-family:'Arial'; font-size:12px; line-height:1.5em;"> <?
		if ($location[name])
																																	  ?>
<?
		if ($location[locationName])
?>
<?=$location[street]
?><br/> <?=$location[city]
		?>	<?=$location[state]
			  ?>, <?=$location[zip]
									?><br/> <?php echo format_phone(
				$location[phone]); // used to say $primary[phone] for some reason, rather than $location[phone]
										  ?><br/> <a href="#" class="show-mapit" title="<?=$location[street] ?>,<?=$location[city] ?> <?=$location[state] ?>, <?=$location[zip] ?>" ><img src="images/mapIt.png"></a> </span>
			<? $count++;

	}
			?>
		</div>
		<div id="GMap" style="width: 523px; height: 440px;"></div>
	</div>
</div>
<?php } else if ($code == 5) { ?>
<script type="text/javascript">

var selectlocation = document.getElementById('setlocation');
if (selectlocation != null)
	selectlocation = selectlocation.value;

var i;
var arr;

var entryNumber;

function setEntryNumber(num){
	entryNumber = num;
}

function appendEmptyLocationFormEntry(){
	entryNumber++; //incrementLocationFormEntries();
	var stateOptions=document.getElementById('new_cust_st').innerHTML;
	var emptyLocationFormEntryHTML ='<div id="email'+ entryNumber +'" style="float: left; width: 220px; padding-left: 30px; padding-bottom: 20px;"><div style="padding-bottom: 5px;"><span class="funky upper">SELECT LOCATION <input type="checkbox"  name="chk[]" onclick=apply() style="width:30px;"></span></div><div style="padding-bottom: 5px;" ><input value='+selectlocation+' type="hidden" name="locationName[]" id="location'+entryNumber+'" style="width:184px;"></div><div style="padding-bottom: 5px;"><input type="text" name="street[]" id="street'+entryNumber+'" placeholder="Street Address" style="width:184px;"></div><div style="padding-bottom: 5px;"><input type="text" name="city[]" id="city'+entryNumber+'" placeholder="City name" style="width:184px;"></div><div style="padding-bottom: 5px;"><select id="state'+entryNumber+'" name="state1[]" size="1">'+stateOptions+'</select><input type="text" name="zip[]" placeholder="Zip" style="width:84px;" id="zip'+entryNumber+'" /></div><div style="padding-bottom:5px;"><input type="text" name="phone[]" placeholder="Phone Number" id="phone'+entryNumber+'" style="width:184px;"></div><a href="#" name="sub[]" onclick=removediv(this) style="visibility :hidden;">Delete</a></div>';
	$('#emails').append(emptyLocationFormEntryHTML);
}

//function appendFilledLocationFormEntry(streetAddress, city, state, zip, phoneNumber){
//	var v = incrementLocationFormEntries();
//	var stateOptions=document.getElementById('new_cust_st').innerHTML;
//	var filledLocationFormEntryHTML ='<div id="email'+v+'" style="float: left; width: 220px; padding-left: 30px; padding-bottom: 20px;"><div style="padding-bottom: 5px;"><span class="funky upper">SELECT LOCATION <input type="checkbox"  name="chk[]" onclick=apply() style="width:30px;"></span></div><div style="padding-bottom: 5px;" ><input value='+selectlocation+' type="hidden" name="locationName[]" id="location'+v+'" style="width:184px;"></div><div style="padding-bottom: 5px;"><input type="text" name="street[]" id="street'+v+'" placeholder="Street Address" value="'+streetAddress+'" style="width:184px;"></div><div style="padding-bottom: 5px;"><input type="text" name="city[]" id="city'+v+'" placeholder="City name" value="'+city+'" style="width:184px;"></div><div style="padding-bottom: 5px;"><select id="state'+v+'" name="state1[]" size="1">'+stateOptions+'</select><input type="text" name="zip[]" placeholder="Zip" value="'+zip+'" style="width:84px;" id="zip'+v+'" /></div><div style="padding-bottom:5px;"><input type="text" name="phone[]" placeholder="Phone Number" value="'+phoneNumber+'" id="phone'+v+'" style="width:184px;"></div><a href="#" name="sub[]" onclick=removediv(this) style="visibility :hidden;">Delete</a></div>';
//	$('#emails').append(filledLocationFormEntryHTML);
//}
	
	function removediv(divid) {
//		var remove_cnt = document.getElementById('cnt').value;
		emailid=divid.parentNode.id;
		if(emailid!="email1"){
			var d=document.getElementById(emailid);
			d.parentNode.removeChild(d);
			entryNumber--;
			// document.getElementById('cnt').value=remove_cnt-1;
		}
	}

	function apply(){
		var objList = document.getElementsByName('chk[]');
		var o=document.getElementsByName('sub[]');
		if(objList[0].checked==true){
			objList[0].checked =false;
		}
		for(var i = 1; i < objList.length; i++) {
			if(objList[i].checked ==true){
				o[i].style.visibility = 'visible';
		}
		if(objList[i].checked ==false){
			o[i].style.visibility = 'hidden';
		}
	}
}
	
</script>

<div id="coupon-message-panel">
	<div class="closeIt" style="margin-bottom:5px;">
		<a id="close-coupon-message" href="#"><img src="images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div style="width: 792px; height: 35px; background: url('images/header-bak.png');"></div>
	<div id="innerhtml" class="couponMessageContent" style="overflow-x: hidden;">
		<p style="margin: 150px 40px;">Your monthly coupon update has already been used. Your next coupon update will be available on the first day of the following month. Please contact University Values if you need assistance.</p>
	</div>
</div>

<div id="cancel-subscription-msg">
	<div class="closeIt" style="margin-bottom:5px;">
		<a id="close-cancel-subscription" href="#"><img src="images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div style="width: 792px; height: 35px; background: url('images/header-bak.png');"></div>
	<div id="innerhtml" class="cancelSubscriptionContent" style="overflow-x: hidden;">
		<?/*<p style="margin: 150px 40px;">*/?><div style="margin-top:150px; font-size:large;"><center>To cancel any of your subscriptions, please contact a University Values represenative.</center></div><?/*</p>*/?>
	</div>
</div>

<div id="coupon-type-panel">
	<div class="closeIt" style="margin-bottom:5px;">
		<a id="close-type-panel" href="#"><img src="images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div style="width: 792px; height: 35px; background: url('images/header-bak.png');"></div>
	<div id="innerhtml" class="couponTypeContent" style="overflow-x: hidden;">
		<br />
		<center style="font-size:large;"><b>Please select a coupon type to continue.</b></center>
		<center><b><small>If you would like a UV Design coupon please contact a University Values representative for assistance.</small></b></center>
		<table style="font-family:'Arial';margin-top:13px; border-collapse: separate; border-spacing: 10px 5px; width:100%;">
			<tr>
				<td align="center"><input id="CT11651" type="radio" name="couponType[1165]" value="1" style="width:auto;" checked="yes"></td>
				<td align="center"><input id="CT11653" type="radio" name="couponType[1165]" value="3" style="width:auto;"></td>
			</tr>
			<tr>
				<td align="center"><label for="CT11651"><a style="cursor:pointer;"><img src="images/uv_coupon_creator_template.png" border="0"></a></label></td>
				<td align="center"><label for="CT11653"><a style="cursor:pointer;"><img src="images/uv_upload_your_own_coupon.png"></a></label></td>
			</tr>
		</table>
		<center><a id="continueToEditCoupon" href="#"><img src='images/continue.png' border=0 alt='Edit' style=''></a></center>
		<input type="hidden" id="cidForEdit"/>
	</div>
</div>

<div id="locations-panel">

<script>
$("#continueToEditCoupon").live("click", function(){
	$("#lightbox, #coupon-type-panel").fadeOut(300);
	var cid = $("#cidForEdit").val();
	document.location.href=$("#CT11651").attr("checked")?"account.php?page=new&action=template&edit=1&cid="+cid:"account.php?page=new&action=upload&edit=1&cid="+cid;
})
	
function close_locations_box()
{
	$("#lightbox, #locations-panel").fadeOut(300);
}

function close_coupon_type_box()
{
	$("#lightbox, #coupon-type-panel").fadeOut(300);
}

function submit_locations_form()
{
	$("#cnt").val(entryNumber);
	$("#save_locations_form").ajaxSubmit({url:'save-locations.php',type:'post'});
	close_locations_box();
}
</script>

<div class="closeIt" style="margin-bottom:5px;">
<a id="close-locations" href="#"><img src="images/closeIt.png" border=0 alt="Close"></a>
</div>
<div id="innerhtml" class="locationsContent" style="overflow-x: hidden;">
<img src="images/selectLocation.jpg" />
<div style="padding: 20px; clear: both;"></div>
<form name="save_locations_form" id="save_locations_form">
<div id="emails">
<?php 
	// get locations for this coupon 
// 	echo "cid = " . $cid . "<br />";
	$locations = getLocationsForCouponID($cid);
// 	echo "num existing locations = " . count($locations) . "<br />";
?>
<?php // getExistingLocationFormEntryHTML() and getEmptyLocationFormEntryHTML() are both defined in this page's helper php file included above
	$numEntries = 0;
	foreach($locations as $location){
		$numEntries++;
		$streetAddress = $location['street'];
		$city = $location['city'];
		$state = $location['state'];
		$zip = $location['zip'];
		$phoneNumber = $location['phone'];
		
		echo getExistingLocationFormEntryHTML($streetAddress, $city, $state, $zip, $phoneNumber, $numEntries);
		echo "\n";
	}
	
	// also display one empty location form entry
	$numEntries++;
	echo getEmptyLocationFormEntryHTML($numEntries);
	echo "\n";
	echo "<script type='text/javascript'>setEntryNumber(".$numEntries.");</script>";
?>

</div>
<div style="padding: 10px; clear: both;"></div>
<div style="float: left; width: 220px; padding-left: 30px;">
<a id="addemail" href="#" onclick="appendEmptyLocationFormEntry();">Add</a>
</div>
<div class="deepak111"><img src="images/saveButton.jpg" onclick="submit_locations_form();"/>
</div>
<div id="replacedeepak"></div>
<div id="new_cust_st" style="display: none"><?php echo getStateOptions(); ?></div>
<input type="hidden" name="cnt" id="cnt" />
<input type="hidden" value="<?=$cid?>" name="coupon_id" />
<input type="hidden" value="<?=$coupon[business]?>" name="business_name"/>
</form>

</div>
</div>
<div id="upload-panel">
	<div class="closeIt">
		<a id="close-upload" href="#"><img src="images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="emailContent">
		<table class="uvBrand" align=center style="margin-top:55px;" width=97% style="margin-left:auto; margin-right:auto; text-align:center;">
			<tr>
				<td valign=top>
				<div class="foundOn funky uppercase" style="font-size:1.2em;">
					<br/>
					<form id="imageform" method="post" enctype="multipart/form-data" action='ajaximage.php'>
						Upload image:
						<input type="file" name="photoimg" id="photoimg" />
						<div id="replaceImg"></div>
						<br/>
						<span class="thegray" style="font-size:.8em">Acceptable file types include: .png, .gif, .jpeg, or .bmp.</span>
					</form>
				</div></td>
			</tr>
			<tr></tr>
		</table>
	</div>
</div>
<div id="deepak" style="display: none; position: fixed; top: 110px; left: 50%; margin-left: -390px; width: 787px; height: 100px; padding: 0; z-index: 1001;">
	<div class="closeIt">
		<a id="close1" href="#"><img src="images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="emailContent">
		<table class="uvBrand" align=center style="margin-top:55px;" width=97% style="margin-left:auto; margin-right:auto; text-align:center;">
			<tr>
				<td valign=top>
				<div class="foundOn funky uppercase" style="font-size:1.2em;">
					<br/>
					<form id="imageform1" method="post" enctype="multipart/form-data" action='ajaximage1.php'>
						Upload image:
						<input type="file" name="photoimg1" id="photoimg1" />
						<div id="replaceImg1"></div>
						<br/>
						<span class="thegray" style="font-size:.8em">Acceptable file types include: .png, .gif, .jpeg, or .bmp.</span>
					</form>
				</div></td>
			</tr>
			<tr></tr>
		</table>
	</div>
</div>
<div id="deepak2" style="display: none; position: fixed; top: 110px; left: 50%; margin-left: -390px; width: 787px; height: 100px; padding: 0; z-index: 1001;">
	<div class="closeIt">
		<a id="close2" href="#"><img src="images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="emailContent">
		<table class="uvBrand" align=center style="margin-top:55px;" width=97% style="margin-left:auto; margin-right:auto; text-align:center;">
			<tr>
				<td valign=top>
				<div class="foundOn funky uppercase" style="font-size:1.2em;">
					<br/>
					<form id="imageform2" method="post" enctype="multipart/form-data" action='ajaximage2.php'>
						Upload image:
						<input type="file" name="photoimg2" id="photoimg2" />
						<div id="replaceImg2"></div>
						<br/>
						<span class="thegray" style="font-size:.8em">For best results, upload your logo with a square and transparent background. Acceptable file types include: .png, .gif, .jpeg, or .bmp.</span>
					</form>
				</div></td>
			</tr>
			<tr></tr>
		</table>
	</div>
</div>
<div id="deepak3" style="display: none; position: fixed; top: 110px; left: 50%; margin-left: -390px; width: 787px; height: 100px; padding: 0; z-index: 1001;">
	<div class="closeIt">
		<a id="close3" href="#"><img src="images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="emailContent">
		<table class="uvBrand" align=center style="margin-top:55px;" width=97% style="margin-left:auto; margin-right:auto; text-align:center;">
			<tr>
				<td valign=top>
				<div class="foundOn funky uppercase" style="font-size:1.2em;">
					<br/>
					<form id="imageform3" method="post" enctype="multipart/form-data" action='ajaximage3.php'>
						Upload image:
						<input type="file" name="photoimg3" id="photoimg3" />
						<div id="replaceImg3"></div>
						<br/>
						<span class="thegray" style="font-size:.8em">For best results, upload your logo with a square and transparent background. Acceptable file types include: .png, .gif, .jpeg, or .bmp.</span>
					</form>
				</div></td>
			</tr>
			<tr></tr>
		</table>
	</div>
</div>
<div id="deepak5" style="display: none; position: fixed; top: 110px; left: 50%; margin-left: -390px; width: 787px; height: 100px; padding: 0; z-index: 1001;">
	<div class="closeIt">
		<a id="close5" href="#"><img src="images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="emailContent">
		<table class="uvBrand" align=center style="margin-top:55px;" width=97% style="margin-left:auto; margin-right:auto; text-align:center;">
			<tr>
				<td valign=top>
				<div class="foundOn funky uppercase" style="font-size:1.2em;">
					<br/>
					<form id="imageform5" method="post" enctype="multipart/form-data" action='ajexzip.php'>
						Upload ZIP File:
						<input type="file" name="photoimg5" id="photoimg5" />
						<div id="replaceImg5"></div>
						<br/>
						<span class="thegray" style="font-size:.8em">For best results upload a ZIP file.ZIP type should be only .ZIP</span>
					</form>
				</div></td>
			</tr>
			<tr></tr>
		</table>
	</div>
</div>
<? } ?>

<div id="aboutUs">
	<div class="paperbackground">
		<div class="popContent" style="text-align:left;">
			<center>
				<div style="padding: 10px; clear: both;"></div>
				<table width=895 cellpadding=0 cellspacing=0>
					<tr>
						<td style="width: 344px;"><a href="javascript: void(0);" onclick="History.back();"><img src="https://www.universityvalues.com/new_images/University-Values-logo.png" border=0 alt="Home"/></a></td>
						<td valign="top"><div style="padding-left: 40px; padding-top: 23px; text-align:left;" class="top_heading">About Us</div></td>
					</tr>
				</table>
				<div style="height:5px;"></div>
				<div style="height:350px; overflow-y:auto;">
				<table style="margin-left: 47px;" width=870 cellpadding=0 cellspacing=0>
					<tr>
						<td colspan="2" style="text-align:left;">
						 <?php
$select = "select * from managepages where id=1";
$result = mysql_query($select);
$row = mysql_fetch_array($result);
echo $description = $row['page_name'];
						 ?>
					</td>
					
					</tr>
				</table>
				</div>
			</center>
		</div>
	</div>
	<div class="popFooter">
		<div style="margin-left: auto;margin-right: auto;width: 450px;">
			<a href="closeAbout.php" id="closeAbout"><img src="<?=$url ?>/new_images/aboutus-hover-button.png" border=0 alt="Close About Us"/></a>
		</div>
	</div>
</div>
<div id="contactus">
	<div class="paperbackground">
		<div class="popContent">
			<center>
				<div style="padding: 10px; clear: both;"></div>
				<table width=895 cellpadding=0 cellspacing=0>
					<tr>
						<td style="width: 344px;"><a href="javascript: void(0);" onclick="History.back();"><img src="https://www.universityvalues.com/new_images/University-Values-logo.png" border=0 alt="Home"/></a></td>
						<td valign="top"><div style="padding-left: 40px; padding-top: 23px; text-align:left; font-family: 'daniel_blackregular', Sans-Serif;" class="top_heading">Contact Us</div></td>
					</tr>
				</table>
				<div style="height:350px; overflow-y:auto; text-align:left;">
				<?php
$select = "select * from managepages where id=2";
$result = mysql_query($select);
$row = mysql_fetch_array($result);
echo $description = $row['page_name'];
				?>
				</div>
			</center>
		</div>
	</div>
	<div class="popFooter">
		<div style="margin-left: auto;margin-right: auto;width: 650px;">
			<a href="closeContact.php" id="closeContact"><img src="<?=$url ?>/new_images/contactus-hover-button.png" border=0 alt="Close Contact Us"/></a>
		</div>
	</div>
</div>
<script type="text/javascript">

	$(function(){

		$('#requestInformation').submit(function(evt){

			var $this = $(this);

			$this.find('#submitbutton').hide();

			evt.preventDefault();

			if(validateForm(this))
			{
				//submit the form via ajax
				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: $(this).serialize(),
					success: function(data)
					{
						if(data == 'success')
						{
							$this.parent().append('<b>Thank you for your request. One of our knowledgeable experts will be in touch with you shortly.</b>');
							$this.remove();
						}
						else if(data == 'captcha')
						{
							alert('The recaptcha you entered was incorrect. Please try again.');
							$this.find('#submitbutton').show();
						}
					}
				})
			}

			$this.find('#submitbutton').show();

		});

	});

	function validateForm(theform) {
		var why = "";
		var name1 = theform.name.value;
		if(name1 == null || name1 == "Name") {
			why += "-  Please enter your name.\n";
		}

		var business1 = theform.business.value;
		if(business1 == null || business1 == "Business") {
			why += "-  Please enter your business.\n";
		}

		var x = theform.email.value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");
		if(atpos < 1 || dotpos < (atpos + 2) || dotpos + 2 >= x.length) {
			why += "-  Please enter a valid email address.\n";
		}

		var phone1 = theform.phone.value;
		if(phone1 == null || phone1 == "Phone") {
			why += "-  Please enter your phone.\n";
		}

		var message1 = theform.message.value;
		if(message1 == null || message1 == "Message") {
			why += "-  Please enter your message.\n";
		}

		if(why != "") {
			alert(why);
			return false;
		}
		else
		{
			return true;
		}
	}

	function client_login(theform) {
		var why = "";

		var x = theform.email.value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");
		if(atpos < 1 || dotpos < (atpos + 2) || dotpos + 2 >= x.length) {
			why += "-  Please enter a valid email address.\n";
		}

		var password1 = theform.password.value;
		if(password1 == null || password1 == "Password") {
			why += "-  Please enter your password.\n";
		}

		if(why != "") {
			alert(why);
			return false;
		}
	}

	function new_advertisers(theform) {
		var why = "";
		var code1 = theform.code.value;
		if(code1 == null || code1 == "Invitation Code") {
			why += "-  Please enter your invitation code.\n";
		}

		if(why != "") {
			alert(why);
			return false;
		}
	}
</script>
<div id="advertising">
	<div class="paperbackground">
		<div class="popContent">
			<center>
			<div style="padding: 10px; clear: both;"></div>
			<table width=895 cellpadding=0 cellspacing=0>
				<tr>
					<td style="width:320px;"><a href="javascript: void(0);" onclick="History.back();"><img src="https://www.universityvalues.com/new_images/University-Values-logo.png" border=0 alt="Home"/></a></td>
					<td align="center" ><h3 class="top_heading">Advertising</h3></td>
					<td align="right" style="padding-right:37px;"> <!-- padding-bottom:19px; -->
					<a href="javascript:void(0);" class="clientsSaying contactus_text1"><img src="/images/whatAdvSaying.png" width="148px;" height="107" /></a>
					<!--<div style="padding-right: 20px;">
						<a href="#" class="clientsSaying contactus_text1">View Testimonials</a>
					</div>
					<div><img width="200" src="https://www.universityvalues.com/new_images/underline1.png" alt="What Our Clients Are Saying" border=0 />
					</div>-->
					</td>
				</tr>
			</table>
			
			<!-- <div style="padding:10px;"></div> -->
			<table width=895 cellpadding=0 cellspacing=0 style="text-align:left;">
				<tr>
					<td width=111></td>
					<td valign=top width=275>
						<div style="font-size: 16pt;font-weight: bold; font-family: 'danielbold',Sans-Serif;">Request Information</div>
						<form id="requestInformation" method=post action="/ajax/request_info.php">
							<input type=text name="name" title="Name" style="width:268px;" class="defaultText" />
							<input type=text name="business" title="Business" style="width:268px;" class="defaultText" />
							<input type=text name="email" title="Email" style="width:268px;" class="defaultText" />
							<input type=text name="phone" title="Phone" style="width:268px;" class="defaultText" />
							<input type="text" aria-required="true" size="30" value="" name="username" class="username" />
							<textarea style="height:40px !important; padding-top: 5px!important;margin-bottom:9px;" id="textareaa" title="Message"  class="defaultText" name="message">Message</textarea>
							<?php
							include_once('/includes/recaptchalib.php');
							$publickey = "6Le9uOsSAAAAANck66b4jUjpLLCTNc00n9c4f-iT"; // you got this from the signup page
							echo recaptcha_get_html($publickey);
							?>
							<INPUT TYPE="image" src="<?=$url ?>/images/submit.png" style="width:90px; hegiht:32px; float:right; margin-top:5px; margin-right: 10px;" BORDER="0" ALT="SUBMIT" id="submitbutton">
						</form>
					</td>
						<td width=111></td><td valign=top width=275><div style="font-size: 16pt;font-weight: bold; font-family: 'danielbold',Sans-Serif; padding-bottom:9px;">Advertiser Coupon Lounge&trade;</div>
					<form onSubmit="return client_login(this);"  method=post action="<?=$url ?>login.php">
						<input type="text" name="email" title="Email"  class="defaultText" style="width:268px;" />
						<div id="passwordSpan">
							<input type="text" name="passwordn" title="Password" style="width:268px;" class="defaultText" id="clear" />
							<input type="password" name="password" title="Password" style="width:268px; display:none" class="defaultText" id="password_input" />
						</div>
						<a href="<?=$url ?>/forgotpassword.php">Forgot your password?</a>
						<INPUT TYPE="image" src="<?=$url ?>/images/loginOff.png"	style="width:82px; height:32px; float:right; margin-top:5px; margin-right: 10px;" BORDER="0" ALT="LOGIN" id="loginbutton">
					</form>
					<div style="clear:both;"></div>
					<div style="font-size: 16pt;font-weight: bold; font-family: 'danielbold',Sans-Serif;">New Advertisers</div>
					<div style="clear:both; height:6px"></div>
					<form onSubmit="return new_advertisers(this);" method=post action="<?=$url ?>signup.php">
						<input type=text name="code" title="Invitation Code"   class="defaultText medium" />
						<INPUT TYPE="image" src="<?=$url ?>/images/enter.png"

						style="width:90px; hegiht:32px; float:right; margin-top:-3px; margin-right: 10px;"

						BORDER="0" ALT="ENTER" id="enterbutton">
					</form></td><td width=95></td>
				</tr>
			</table>
			</center>
		</div>
	</div>
	<div class="popFooterb">
		<div style="margin-left:auto; margin-right:auto; width:805px;">
			<a href="closeAdvert.php" id="closeAdvert"><img src="<?=$url ?>/new_images/advertiser-section-button-hover.png" border=0 alt="Close Advertising"/></a>
		</div>
	</div>
</div>
<div id="testimonials-panel">
	<div class="closeIt">
		<a id="close-testimonials"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="testimonialsContent">
		<div class="testimonialsHeader"></div>
		<div style="padding-left:30px; padding-right:30px; padding-top:30px;">
			<? getContent("testimonial"); ?>
		</div>
	</div>
</div>
<?php if ($front == 1 || $_GET['state'] != "") { ?>
<div id="appTutorial-panel">
	<div class="closeIt">
		<a id="close-appTutorial"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="appTutorialContent">
		<?php $query = "select * from how_it_work where id='1'";
	$sql = mysql_query($query);
	$row = mysql_fetch_array($sql);
		?>
		<!--<div class="testimonialsHeader"></div>-->
		<div id="changevideo">
			<iframe width="787" height="440" frameborder="0" allowfullscreen="" src="https://www.youtube.com/embed/<?php echo $row['youtube_link']; ?>?wmode=transparent&amp;rel=0" id="youtube"></iframe>
		</div>
		<div id="video_div" style="display: none;">
		<iframe width="787" height="440" frameborder="0" allowfullscreen="" src="https://www.youtube.com/embed/<?php echo $row['youtube_link']; ?>?wmode=transparent&amp;rel=0" id="youtube"></iframe>
		</div>
	</div>
</div>
<?php } ?>

<div id="freegallery-panel">
	<div class="closeIt">
		<a id="close-freegallery"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="freegalleryContent" style="overflow:hidden">
		<div class="freegalleryHeader"></div>
		
	</div>
</div>
<div id="customgallery-panel">
	<div class="closeIt">
		<a id="close-customgallery"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="customgalleryContent" style="overflow:hidden">
		<div class="customgalleryHeader"></div>
		
	</div>
</div>
</div>
<?php if ($action == 'template') { ?>
<div id="Example_create_coupon">
	<div class="closeIt_upload">
		<a id="close-example"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="couponcenterContent" style="overflow:hidden">
		<div class="couponcenterHeader"></div>
		<iframe name="cccImg" id="cccImg" width="787" height="465" src="https://www.universityvalues.com/blog/?page_id=414&signup=1" frameborder="0" scrolling="no"></iframe>
	</div>
</div>
<?php } else if ($action == 'upload') { ?>
<div id="Example">
	<div class="closeIt_upload">
		<a id="close-example"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="couponcenterContent" style="overflow:hidden">
		<div class="couponcenterHeader"></div>
		<iframe name="cccImg" id="cccImg" width="787" height="465" src="https://www.universityvalues.com/blog/?page_id=415&signup=1" frameborder="0" scrolling="no"></iframe>
	</div>
</div>
<?php } else if ($action == 'custom') { ?>
<div id="Example_uv_coupon">
	<div class="closeIt_upload">
		<a id="close-example"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="couponcenterContent" style="overflow:hidden">
		<div class="couponcenterHeader"></div>
		<iframe name="cccImg" id="cccImg" width="787" height="465" src="https://www.universityvalues.com/blog/?page_id=44&signup=1" frameborder="0" scrolling="no"></iframe>
	</div>
</div>
<?php } else if ($basename == "signup.php") { ?>

<div id="uvcouponsScreen-panel" style="display:none;">
	<div class="closeIt_upload">
		<a id="close-uvcouponsScreen" style="margin-right:-75px;"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="uvcouponsScreenContent" style="overflow:hidden">
		<div class="couponcenterHeader"></div>
		<iframe name="cccImg" id="cccImg" width="787" height="465" src="https://www.universityvalues.com/blog/?page_id=422" frameborder="0" scrolling="no"></iframe>
	</div>
</div>

<div id="couponcenter-panel">
	<div class="closeIt_upload">
		<a id="close-couponcenter"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="couponcenterContent" style="overflow:hidden">
		<div class="couponcenterHeader"></div>
		<iframe name="cccImg" id="cccImg" width="787" height="465" src="https://www.universityvalues.com/blog/?page_id=172&signup=1" frameborder="0" scrolling="no"></iframe>
	</div>
</div>

<div id="Example_uv_coupon">
	<div class="closeIt_upload">
		<a id="close-example"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="couponcenterContent" style="overflow:hidden">
		<div class="couponcenterHeader"></div>
		<iframe name="cccImg" id="cccImg" width="787" height="465" src="https://www.universityvalues.com/blog/?page_id=44&signup=1" frameborder="0" scrolling="no"></iframe>
	</div>
</div>

<div id="Example_create_coupon">
	<div class="closeIt_upload">
		<a id="close-example"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="couponcenterContent" style="overflow:hidden">
		<div class="couponcenterHeader"></div>
		<iframe name="cccImg" id="cccImg" width="787" height="465" src="https://www.universityvalues.com/blog/?page_id=414&signup=1" frameborder="0" scrolling="no"></iframe>
	</div>
</div>
<?php } else if ($basename == "account.php?page=new") { ?>
	<div id="Example_uv_coupon">
	<div class="closeIt_upload">
		<a id="close-example"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="couponcenterContent" style="overflow:hidden">
		<div class="couponcenterHeader"></div>
		<iframe name="cccImg" id="cccImg" width="787" height="465" src="https://www.universityvalues.com/blog/?page_id=44&signup=1" frameborder="0" scrolling="no"></iframe>
	</div>
</div>

<div id="Example_create_coupon">
	<div class="closeIt_upload">
		<a id="close-example"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="couponcenterContent" style="overflow:hidden">
		<div class="couponcenterHeader"></div>
		<iframe name="cccImg" id="cccImg" width="787" height="465" src="https://www.universityvalues.com/blog/?page_id=414&signup=1" frameborder="0" scrolling="no"></iframe>
	</div>
</div>
<?php } ?>
</div>
<div id="mapit-panel">
	<div class="closeIt">
		<a id="close-mapit" href="javascript: closeMapIt();"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="mapitContent">
		<div class="mapitHeader"></div>
		<style>
			#map_canvas {
				width: 523px;
				height: 440px;
			}
			#directionsPanel {
				width: 259px;
				height: 440px;
				overflow: auto;
				padding-left: 5px;
				background-color: #FFF;
			}

		</style>
		<input type="hidden" name="end" id="end" value="" style="width:200px; background-color:#CCC;" disabled>
		<table cellspacing=0 cellpadding=0>
			<tr>
				<td><div id="map_canvas"></div></td><td>
				<div id="directionsPanel">
					<center>
						<strong>Change Starting Location: </strong>
						<input type="text" name="start" id="start"  style="width:200px;" onKeyUp="showMap()">
					</center>
					<p>
						<span id="total"></span>
					</p>
				</div></td>
			</tr>
		</table>
	</div>
</div>
<div id="TOS-panel">
	<div class="closeIt1">
		<a id="close-TOS" href="#"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="TOS-content">
		<? getContent("terms-of-service"); ?>
	</div>
</div>
<div id="privacy-panel">
	<div class="closeIt1">
		<a id="close-privacy" href="#"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="privacy-content">
		<? getContent("privacy-policy"); ?>
	</div>
</div>
<div id="AATOS-panel">
	<div class="advertising-agreement">
		<a id="close-AATOS" href="#"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="AATOS-content">
		<? getContent("advertising-agreement"); ?>
	</div>
</div>
<script type ="text/javascript" language ="javascript">
	function Print1(stridprint) {
		var values = document.getElementById(stridprint);
		var printing = window.open("width=800");
		printing.document.write(values.innerHTML);
		printing.document.close();
		printing.focus();
		printing.print();
		printing.close();
	}
</script>
<div id="guidelines-panel">
	<div class="advertising-agreement">
		<a id="close-AATOS" href="#"><img src="<?=$url ?>/images/closeIt.png" border=0 alt="Close"></a>
	</div>
	<div class="AATOS-content">
		<?php
$select = "select * from managepages where id=3";
$result = mysql_query($select);
$row = mysql_fetch_array($result);
echo $description = $row['page_name'];
		?>
		
		<div style="text-align: center;"><a href="#" onclick="Print1('stridprint');">Print</a></div><br /><br />
	</div>
</div>

<div id="stridprint" style="display: none;">
		<div  style=" width: 500px; margin-left:400px;">
		<br>
	<?php
$select = "select * from managepages where id=3";
$result = mysql_query($select);
$row = mysql_fetch_array($result);
echo $description = $row['page_name'];
	?>
		<div><a href="#" onclick="Print1('stridprint');">Print</a></div></div>
	</div>