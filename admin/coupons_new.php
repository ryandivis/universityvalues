<?php 

ini_set("auto_detect_line_endings", true);	// this is for the CSV locations file parsing - allows for reading files created on a mac (that use \r instead of \n for line returns)
// ini_set("post_max_size", '70M');


if(empty($_SERVER['CONTENT_TYPE']))	// TODO not sure if this is where to put this line - it's for the form processing
{
	$_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded";
}


include_once('php_helpers/google_maps/geocoding_helper.php');
// $haveShownBreakpoint = false;
function updateOrInsertCouponTie($cid, $sid, $fid){
// 	if (!$haveShownBreakpoint)
// 		echo "BEGIN: updateOrInsertCouponTie, cid=$cid, sid=$sid, fid=$fid";
	$haveShownBreakpoint = true;
	$updateAttempt = "UPDATE coupons_tie SET fid='$fid' WHERE cid='$cid' AND sid='$sid'";
	$updateResult = mysql_query($updateAttempt);
	$numRowsQuery = "SELECT COUNT(*) as count from coupons_tie WHERE cid='$cid' AND sid='$sid'";
	$numRowsResult = mysql_query($numRowsQuery);
	$numRowsRow = mysql_fetch_array($numRowsResult);
	$numRows = $numRowsRow['count'];
	if ($numRows == 0){
		$insert = "INSERT INTO coupons_tie (cid, sid, fid) values ('$cid', '$sid', '$fid')";
		$result = mysql_query($insert) or die(mysql_error());
	}
}

function deleteCouponTie($cid, $sid){
	$sql = "DELETE FROM coupons_tie WHERE cid=$cid AND sid=$sid";
	$result = mysql_query($sql) or die(mysql_error());
}

function getAllSchoolIdsFromDatabase(){
	// get all school id's from the database
// 	echo "BEGIN: getAllSchoolIdsFromDatabase()";
	$schoolIds = array();
	$selectAllSchoolIdsQuery = "SELECT sid FROM schools";
	$schoolIdsResult = mysql_query($selectAllSchoolIdsQuery);
	while ($row = mysql_fetch_array($schoolIdsResult)){
// 		echo "row 'sid' = " . $row['sid'];
		$schoolIds[] = $row['sid'];
	}
// 	echo "END: getAllSchoolIdsFromDatabase(), schoolIds count = " . count($schoolIds);
	return $schoolIds;
}

function getSchoolIdsFromPost(){
	$schoolIds = array();
	foreach ($_POST['schools'] as $k => $v)	// used to be $_POST['realSelected']
		$schoolIds[] = $v;
// 	echo "schoolIds From Post count = " . count($schoolIds);
	return $schoolIds;
}

function whatCouponProgramNameIsThis($couponPlanID){
	if ($couponPlanID == "1"){
		return "Associates";
	} else if ($couponPlanID == "2"){
		return "Bachelors";
	} else if ($couponPlanID == "3"){
		return "Masters";
	} else {
		return "";
	}
}

function getLocationsFromLocationsFile($locationsFilePath){
// 	echo "locationsFilePath = " . $locationsFilePath . "<br />";
// 	echo "filesize = " . filesize($locationsFilePath) . "<br />";
	// read locations file; parse and save each line/location
	$locations = array();
	$handle = @fopen($locationsFilePath, "r");	// "r" means for read-only
	if ($handle) {
// 		echo "got handle" . "<br />";
		$line = fgets($handle);	// first line is set of field titles, do not parse
// 		echo "first line = " . $line . "<br />";
		while (($line = fgets($handle)) !== false) {
// 			echo "read line"  . "<br />";
			$location = parseLocationFromLocationFileLine($line);
			$locations[] = $location;
		}
		//if (!feof($handle)) {	// <-- to handle some kind of file read error
		//    echo "Error: unexpected fgets() fail\n";
		//}
		fclose($handle);
	}
	unlink($locationsFilePath);
// 	echo "locations (from file) count = " . count($locations) . "<br />";
	return $locations;
}

function stringContainsBeginningQuote($s){
	return stringContainsQuoteAtIndex($s, 0);
}

function stringContainsEndingQuote($s){
	return stringContainsQuoteAtIndex($s, -1);
}

function stringContainsQuoteAtIndex($s, $i){
	return strcasecmp(substr($s, $i, 1), '"') == 0;
}

function parseLocationFromLocationFileLine($line){
	// split up line into location fields, in this order -> [street, city, state, zip, phone]; insert into database
	// -this array orders the names of the fields in the same order as the file has them - for conversion from field number to field name in the upcoming for loop
	$locationFieldNames = array(
			'street',
			'city',
			'state',
			'zip',
			'phone'
	);
	$locationAssocArray = array();
	$fields = explode(",", $line);
	$keyIndex = 0;
	for ($i = 0; $i < count($fields); $i++) {
// 		echo "outer i = " . $i . "<br />";
		$field = $fields[$i];
		// if the actual field contains a starting and ending quotation mark, that means there is a comma inside it (and therefore the field was split with the explode function earlier)
		if (stringContainsBeginningQuote($field)){
			// merge this field with the next field until the next field ends with a quotation mark
			$fieldPrefix = $field;
// 			$numberMergedFields = 1;
			for ($j = $i+1; $j < count($fields); $j++){
				$i = $j;
// 				echo "inner i = " . $i . "<br />";
				$fieldSuffix = $fields[$j];
				if (stringContainsEndingQuote($fieldSuffix)){
					$field = $fieldPrefix . ", " . $fieldSuffix;
					break;
				} else {
					$fieldPrefix .= ", " . $fieldSuffix;
				}
			}
		}
// 		echo "field = " . $field . "<br />";
		// cleans field of unwanted characters and whitespace, as the variable name implies
		$cleanedField = trim(preg_replace("/[^a-zA-Z\d\-\.,\s\(\)\#]/", "", $field));
// 		echo "cleanedField = " . $cleanedField . "<br />";
		$key = $locationFieldNames[$keyIndex++];
// 		echo "key = " . $key . "<br />";
		$locationAssocArray[$key] = $cleanedField;
	}
	return $locationAssocArray;
}

function getSchoolIdsOutsideThisList($schools){
// 	echo "BEGIN OUTSIDE: schools count = " . count($schools);
	$otherSchoolIds = array();
	
	$schoolIdsToExcludeString = implode("','",$schools);
	$sql = "SELECT sid FROM schools WHERE sid NOT IN ('$schoolIdsToExcludeString')";
// 	for ($i = 0; $i < count($schools); $i++){
// 		echo "<br />Going Once<br />";
// 		$school = $schools[$i];
// 		$schoolID = $school['sid'];
// 		if ($i == 0)
// 			$sql .= "WHERE sid!=$schoolID";
// 		else
// 			$sql .= " AND sid!=$schoolID";
// 	}
	// got sql
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result))
		$otherSchoolIds[] = $row['sid'];
	
	return $otherSchoolIds;
}

// function insertLocationIntoDb($location, $cid){
// 	// insert this location into locations and location_tie database tables
// 	// get lat & lng to save to locations table
// 	$address = getAddressStringFromLocationAssocArray($location);
// 	$position = useGoogleGeocodeToGetCoordinates($address);
// 	// insert into locations
// 	// insert into location_tie
// }

// function getAddressStringFromLocationAssocArray($location){
// 	$address = "USA, " . returnValueOrEmptyStringForKey($location, "street");
// 	$address .= ", " . returnValueOrEmptyStringForKey($location, "city");
// 	$address .= ", " . returnValueOrEmptyStringForKey($location, "state");
// 	$address .= ", " . returnValueOrEmptyStringForKey($location, "zip");
// 	return $address;
// }

// function returnValueOrEmptyStringForKey($array, $key){
// 	$value = $array[$key];
// 	// empty() can also be true for null values, which is the main reason for using it
// 	return (!empty($value)) ? $value : "";
// }

?>

<script type="text/javascript">

	var schoolListTypes = {
		"listedSchools":0,
		"allButListedSchools":1
	};
	
	var currentSchoolListType = schoolListTypes["listedSchools"];
	
	//function toggleApplyToAllSchools() {
	//	$('#stateAndSchoolsContainer').toggle();
	//}

	function switchSchoolListDivToAllSchoolsInTheNation(){
		$('#stateAndSchoolsContainer').hide();
	}

	function switchSchoolListDivToAllListedSchools(){
		toggleSchoolCheckboxesToSelectedSchools();
		$('#stateAndSchoolsContainer').show();
	}

	function switchSchoolListDivToAllButListedSchools(){
		toggleSchoolCheckboxesToUnselectedSchools();
		$('#stateAndSchoolsContainer').show();
	}

	function toggleSchoolCheckboxesToSelectedSchools(){
		if (currentSchoolListType != schoolListTypes['listedSchools'])
			toggleSchoolCheckboxes();
		currentSchoolListType = schoolListTypes['listedSchools'];
	}

	function toggleSchoolCheckboxesToUnselectedSchools(){
		if (currentSchoolListType != schoolListTypes['allButListedSchools'])
			toggleSchoolCheckboxes();
		currentSchoolListType = schoolListTypes['allButListedSchools'];
	}

	function toggleSchoolCheckboxes(){
		$('.schoolCheckbox').each(function(){
			console.log('BEGIN: each() for toggleSchoolCheckboxes -> ' + ($(this).is(':checked') ? '-' : '[OFF]'));
			if ($(this).is(':checked'))
				$(this).removeAttr('checked');
			else
				$(this).prop('checked', 'checked');
			console.log('END: each() for toggleSchoolCheckboxes');
		});
	}

	function removeAllUncheckedSchoolCheckboxes(){
		$('.schoolCheckboxSpan').each(function(){
			if (! $(this).children('input').is(':checked'))
				$(this).remove();
		});
	}

	function couponLocationsManualEntrySelected(){
		// hide from file div, show manual entry div
		$('#couponLocationsFromFile').hide();
		$('#couponLocationsManualEntry').show();
	}

	function couponLocationsFromFileSelected(){
		// hide manual entry div, show from file div
		$('#couponLocationsManualEntry').hide();
		$('#couponLocationsFromFile').show();
	}

	function couponEditFormShouldSubmit(){
		console.log('BEGIN: should submit');
		var locationsInputMethodChosen = $('input[name="locationsInputMethod"]:checked', '#editCouponForm').val();
		var fileName = $('#locationsFile').val();
		if (locationsInputMethodChosen == "file"){
			if (fileName != ""){
				var fileExt = fileName.slice(-3);
				//alert(fileExt);
				if (fileExt == "csv"){
					if (removeSchoolsIfOverLimit())
						return true;
				} else {
					alert("You can only upload .csv files");
					return false;
				}
			} else {
				alert("You must choose a locations file (.csv format) \nor select \"Manual Entry\" instead"); 
				return false;
			}
		}else{
			if (removeSchoolsIfOverLimit())
				return true;
		}
		console.log('END: should submit');
	}
	<?php // TODO CHECK BACK ON THIS FUNCTION TOMORROW ?>
	function removeSchoolsIfOverLimit(haveTriedOnce){
		console.log('BEGIN: removeSchoolsIfOverLimit(), haveTriedOnce = ' + (haveTriedOnce ? 'true' : 'false'));
		// this is to prevent the $_POST from the form cutting off if "All Schools in the Nation" is selected or nearly all schools are selected
		var threshold = 700;	// this is atm considered the "max" # of checked schools to process on this form
		var numSchoolCheckboxesChecked = $('.schoolCheckbox[checked="checked"]').size();
		//var numSchoolCheckboxes = parseFloat($("#numSchoolCheckboxes").val());
		if ($('#applyToAllSchools').is(':checked')){
			removeAllSchoolCheckboxes();
			return true;
		} else if ($('#applyToAllListedSchools').is(':checked')){
			if (numSchoolCheckboxesChecked > threshold) {
				if (!haveTriedOnce) {
					$('#applyToAllButListedSchools').attr('checked','checked'); 
					switchSchoolListDivToAllButListedSchools();
					return removeSchoolsIfOverLimit(true);
				} else {
					showTooManySchoolCheckboxesAlert();
					return false;
				}
			} else {
				return true;
			}
		} else if ($('#applyToAllButListedSchools').is(':checked')){
			if (numSchoolCheckboxesChecked > threshold) {
				if (!haveTriedOnce){
					$('#applyToAllListedSchools').attr('checked','checked'); 
					switchSchoolListDivToAllListedSchools();
					return removeSchoolsIfOverLimit(true);
				} else {
					showTooManySchoolCheckboxesAlert();
					return false;
				}
			} else {
				return true;
			}
		} else {
			// showTooManySchoolCheckboxesAlert();
			alert('An unknown error occurred relating to the schools to which you applied your coupon.');
			return false;
		}
	}

	function removeAllSchoolCheckboxes(){
		$('.schoolCheckboxSpan').remove();
	}

	function showTooManySchoolCheckboxesAlert(){
		alert('You are trying to connect this coupon to too many schools!\n(whether "Apply to All Listed" or "Apply to All But Listed" is selected)\nPlease select fewer than 700 schools in order to save properly)');
	}

	function showAllSchoolsInTheNation(){
		<?php // TODO THIS DOESN'T WORK YET?>
		$('#theState option').each(function(){
			var stateAbbrev = $(this).val();
			getSchools(stateAbbrev);
		});
	}

	

	var existingSchoolIds = [];
	
	function getSchools(a) {
		var stateSchoolCheckboxClassName = a + 'SchoolCheckbox';
		existingSchoolIds = [];
		$('.'+stateSchoolCheckboxClassName).each(function(){
			existingSchoolIds.push($(this).data('sid'));
		});
		existingSchoolIdsJsonString = JSON.stringify(existingSchoolIds);

		if(window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				$("#couponBuy").append(xmlhttp.responseText); // used to be changing #listTheSchools instead
			}
		};
		xmlhttp.open("GET", "getschools.php?q=" + a + "&t=2&existingsids=" + existingSchoolIdsJsonString, true);
		xmlhttp.send();

	}

	function changeTheSchoolb(name) {
		var school = name.split("~");
		$("#theschool" + school[0]).fadeOut(500);
		var newDiv = "<div id='#newSchool" + school[0] + "' style=''><input style='width:20px;' type=checkbox value=" + school[0] + " name='realSelected[]' CHECKED> " + school[1] + "<br/></div>";
		var currentHTML = $('#couponBuy').html();
		$('#couponBuy').append(newDiv);
		$("#newSchool" + school[0]).fadeIn(500);
	}
	
	
function remove(id,cid)
{
var veh_makehttp;
if(window.XMLHttpRequest)
veh_makehttp = new XMLHttpRequest();
else
veh_makehttp = new ActiveXObject("Microsoft.XMLHTTP");
veh_makehttp.onreadystatechange = function() {
document.getElementById("livemessage").innerHTML = '<img src="images/loader.gif" alt="Requesting...."/>';
if(veh_makehttp.readyState == 4 && veh_makehttp.status == 200) {
document.getElementById("livemessage").innerHTML = veh_makehttp.responseText;
}
};
veh_makehttp.open("GET", "removeschool.php?sid="+id+"&cid="+cid, true);
veh_makehttp.send();

}

function bus_name(businessid){
var veh_makehttp;
if(window.XMLHttpRequest)
veh_makehttp = new XMLHttpRequest();
else
veh_makehttp = new ActiveXObject("Microsoft.XMLHTTP");
veh_makehttp.onreadystatechange = function() {
document.getElementById("getbusinnesname").innerHTML = '<img src="images/loader.gif" alt="Requesting...."/>';
if(veh_makehttp.readyState == 4 && veh_makehttp.status == 200) {
document.getElementById("getbusinnesname").innerHTML = veh_makehttp.responseText;
}
};
veh_makehttp.open("GET", "getbusinnesname.php?businessid="+businessid, true);
veh_makehttp.send();

}

</script>
<center>
	<?php /*if($page!='edit' && $page!='locations'){ ?>
		  <select id="school" name="school" onchange="fun_school(this.value)" >
		  <option>Select School--</option>
		  <?php
		  
		  $query_school=mysql_query("select * from schools where name !='' order by name asc"); 
		  while($row=mysql_fetch_array($query_school)){
		  extract($row);
		  ?>
		  <option value="<?= $sid ?>"><?=$name ?></option>
		  <?php } ?>	
		  </select>
		  <?php } */ 
	?>
</center>
<?php

if (isset($schoolid) && $schoolid > 0) {
?>
	
	<form method=post action="admin.php?action=coupons&page=delete&schoolid=<?php echo $schoolid ?>" enctype="multipart/form-data">
	<center>
		<a href="admin.php?action=coupons&page=new">Add New</a> | 
		<a href="admin.php?action=coupons&sort=active&schoolid=<?php echo $schoolid ?>">View Live Coupons</a> | 
		<a href="admin.php?action=coupons&sort=pending&schoolid=<?php echo $schoolid ?>">View client Update Pending coupons</a> | 
		<a href="admin.php?action=coupons&sort=inactive&schoolid=<?php echo $schoolid ?>">Admin Approval Awaiting Coupons</a> | 
		<a href="admin.php?action=coupons&sort=expired&schoolid=<?php echo $schoolid ?>">Past-Due/Expired Coupons</a>
	</center>
	<?
	?><table width=100% border=1 >
	<tr ><td colspan="10" align="center">Sorted order<select name="asc_desc" id="asc_desc" onchange="fun_order2(this.value)">
		<option value="cid asc" <?php if ($sorted == 'cid asc')
		echo 'selected=selected'; ?> >Id ASC</option>
		<option value="cid desc" <?php if ($sorted == 'cid desc')
		echo 'selected=selected'; ?> >Id DESC</option>
		<option value="business asc" <?php if ($sorted == 'business asc')
		echo 'selected=selected'; ?>>Business ASC</option>
		<option value="business desc" <?php if ($sorted == 'business desc')
		echo 'selected=selected'; ?>>Business DESC</option>
		<option value="realOffer asc" <?php if ($sorted == 'realOffer asc')
		echo 'selected=selected'; ?>>Offer ASC</option>
		<option value="realOffer desc"<?php if ($sorted == 'realOffer desc')
		echo 'selected=selected'; ?> >Offer DESC</option>
		<option value="category asc" <?php if ($sorted == 'category asc')
		echo 'selected=selected'; ?>>Category ASC</option>
		<option value="category desc" <?php if ($sorted == 'category desc')
		echo 'selected=selected'; ?>>Category DESC</option>
		<option value="type asc" <?php if ($sorted == 'type asc')
		echo 'selected=selected'; ?> >Type ASC</option>
		<option value="type desc" <?php if ($sorted == 'type desc')
		echo 'selected=selected'; ?>>Type DESC</option>
		<option value="endDate asc"<?php if ($sorted == 'endDate asc')
		echo 'selected=selected'; ?> >Next Bill Date ASC</option>
		<option value="endDate desc"<?php if ($sorted == 'endDate desc')
		echo 'selected=selected'; ?> >Next Bill Date DESC</option>
		<option value="active asc" <?php if ($sorted == 'active asc')
		echo 'selected=selected'; ?>>Active ASC</option>
		<option value="active desc" <?php if ($sorted == 'active desc')
		echo 'selected=selected'; ?>>Active DESC</option>
		
	</select></td></td></tr>
	<tr>
		<td valign=top>Delete</td>
		<th>ID</th>
		<th>Business</th>
		<th>Offer</th>
		<th>Category</th>
		<th>Type</th>
		<th>Program</th>
		<th>Next Bill Date</th>
		<th>School</th>
		<th>Active</th>
	</tr>
<?php
	if ($_REQUEST['sorted'] != '')
		$sorted = $_REQUEST['sorted'];
	else
		$sorted = 'c.cid desc';
	if ($_REQUEST['sorted'] == 'cid asc')
		$sorted = 'c.cid desc';

	$curtime = time();
	$where = '';
	if (isset($_GET['sort'])) {
		switch ($_GET['sort']) {
		case 'active':
			$where = ' where active=1 and enddate>=$curtime ';
			break;
		case 'inactive':
			$where = ' where active=0 and enddate>=$curtime ';
			break;
		case 'expired':
			$where = " where enddate<=$curtime";
			break;
		case 'pending':
		default:
			$where = ' where issendforapprovel=1 and  enddate>=$curtime ';
		}
	}
	$query_sql = mysql_query("select * from coupons c, coupons_tie t,schools s where c.cid=t.cid and t.sid=s.sid and s.sid=$schoolid $where order by $sorted")
			or die(mysql_error());
	while ($row = mysql_fetch_array($query_sql)) {
		//$s="select name from users where  uid=$roe['salesRep']"
		$g = 1;
		$cat[1] = "Live";
		$cat[2] = "Eat";
		$cat[3] = "Play";
		$type1[1] = "Creator";
		$type1[2] = "Custom";
		$type1[3] = "Upload";
		$couponProgramName = whatCouponProgramNameIsThis($row['couponPlanID']);
		$str = '';
		extract($row);
		
		
		
		echo "<tr><td valign=top>
		<input type=checkbox value=$cid name=delete[]><br/>
		<a href=\"admin.php?action=coupons&page=edit&cid=$cid\">Edit</a></td>
		<td valign=top>$cid</td><td valign=top>$business ($pid)</td>
		<td valign=top>$realOffer</td><td valign=top>$cat[$category]</td>
		<td valign=top>$type1[$type]</td><td valign=top>$couponProgramName</td><td valign=top>"
				. date("m/d/y", $endDate)
				. "</td>
		<td valign=top>$name</td><td valign=top>";
		if ($row['active'] == 0 && $row['issendforapprovel'] == 0)
			echo 'pending client coupon update';
		else if ($row['active'] == 0 && $row['issendforapprovel'] == 1)
			echo 'Waiting for admin approval';
		else if ($row['endDate'] <= $curtime)
			echo 'Coupon Past-Due/Expired';
		else if ($row['active'] == 1 && $row['issendforapprovel'] == 1)
			echo 'Coupon Active & Awaiting Admin Approval for Update';
		else if ($row['active'] == 1 && $row['issendforapprovel'] == 0)
			echo 'Coupon Active';
		echo "</td></tr>";
	}
	echo "<tr><td valign=top><input type=submit value='Delete'></td></tr>

</table></form>";
}
else {

	if ($_REQUEST['sorted'] != '')
		$sorted = $_REQUEST['sorted'];
	else
		$sorted = 'cid desc';
	if ($page == '') {
?>
<form method=post action="admin.php?action=coupons&page=delete" enctype="multipart/form-data">
	<center>
		<a href="admin.php?action=coupons&page=new">Add New</a> | <a href="admin.php?action=coupons&sort=active">View Live Coupons</a>
		| <a href="admin.php?action=coupons&sort=pending">View client Update Pending coupons</a> | <a href="admin.php?action=coupons&sort=inactive">Admin Approval Awaiting Coupons</a> | <a href="admin.php?action=coupons&sort=expired">Past-Due/Expired Coupons</a>
	</center>
	<?
	?><table class='table table-hover table-bordered' align=center >
	<tr>
		<td valign=top>Delete</td>
		<th>ID</th>
		<th>Business</th>
		<th>Advertising Consultant</th>
		<th >Offer</th>
		<th>Category</th>
		<th>Type</th>
		<th>Program</th>
		<th>Next Bill Date</th>
		<th>School</th>
		<th>Coupon Status</th>
	</tr>
<?php
		$curtime = time();
		$where = '';
		if (isset($_GET['sort'])) {
			switch ($_GET['sort']) {
			case 'active':
				$where = ' where active=1 ';
				break;
			case 'inactive':
				$where = ' where active=0 ';
				break;
			case 'expired':
				$where = " where enddate<=$curtime";
				break;
			case 'pending':
			default:
				$where = ' where active=0 and issendforapprovel=0';
			}
		}
		$query_sql = mysql_query("select * from coupons $where order by $sorted");
// 				"select oid,type,cid,business,pid,category,realOffer,active,endDate,issendforapprovel from coupons $where order by $sorted");
		while ($row = mysql_fetch_array($query_sql)) {
			$g = 1;
			$cat[1] = "Live";
			$cat[2] = "Eat";
			$cat[3] = "Play";
			$type1[1] = "Creator";
			$type1[2] = "Custom";
			$type1[3] = "Upload";
			$abc = mysql_query(
					"select o.salesRep, c.oid from users u, orders o, coupons c   where  o.oid=$row[oid] and c.oid=o.oid");
			$fatchresult = mysql_fetch_array($abc);
			$s = "select name from users where  uid=$fatchresult[salesRep]";
			$conslt = mysql_query($s);
			$conrow = mysql_fetch_array($conslt);
			if ($conrow == "") {
				$consal = "<b>By Admin</b>";
			} else {
				$consal = $conrow[name];
			}

			$str = '';
			extract($row);
			$squery = mysql_query("select s.name from schools s, coupons_tie t where s.sid=t.sid and t.cid=$cid");
			$couponNumSchools = mysql_num_rows($squery);
			
			$totalNumSchoolsResult = mysql_query("select count(1) FROM schools");
			$totalNumSchoolsRow = mysql_fetch_array($totalNumSchoolsResult);
			$totalNumSchools = $totalNumSchoolsRow[0];
			
			$couponProgramName = whatCouponProgramNameIsThis($row['couponPlanID']);
			
			if ($couponNumSchools >= $totalNumSchools) {
				$str = "All Schools in the Nation";			
			} else if ($couponNumSchools > 100){
				$divSchoolListId = "lotsOfSchoolsFor$cid";
				$str = "<a href=\"javascript: $('#$divSchoolListId').toggle();\">$couponNumSchools Schools - Click to Show/Hide</a>";
				$str .= "<div id='$divSchoolListId' style='display:none;'>";
				while ($row1 = mysql_fetch_array($squery)) {
					extract($row1);
					$str .= "$g. $name <br/>";
					$g++;
				}
				$str .= "</div>";
			} else {
				$numSchoolsToShow = 10;
				$i = 0;
				while ($row1 = mysql_fetch_array($squery)) {
					extract($row1);
					if ($i++ != $numSchoolsToShow){
						$str .= "$g. $name <br/>";
					} else {
						$divSchoolListId = "lotsOfSchoolsFor$cid";
						$numSchoolsLeft = $couponNumSchools - $numSchoolsToShow;
						
						$str .= "<a href=\"javascript: $('#$divSchoolListId').toggle();\">$numSchoolsLeft More Schools - Click to Show/Hide</a>";
						$str .= "<div id='$divSchoolListId' style='display:none;'>";
						$str .= "$g. $name <br/>";
					}
					$g++;
				}
				$str .= "</div>";
			}
			echo "<tr><td valign=top>
		<input type=checkbox value=$cid name=delete[]><br/>
		<a href=\"admin.php?action=coupons&page=edit&cid=$cid\">Edit</a></td>
		<td valign=top>$cid</td><td valign=top>$business ($pid)</td>
		<td valign=top>$consal</td>
		<td valign=top>$realOffer</td><td valign=top>$cat[$category]</td>
		<td valign=top>$type1[$type]</td><td valign=top>$couponProgramName</td><td valign=top>"
					. date("m/d/y", $endDate) . "</td>
		<td valign=top>" . trim($str) . "</td><td valign=top>";
			if ($row['active'] == 0 && $row['issendforapprovel'] == 0)
				echo 'pending client coupon update';
			else if ($row['active'] == 0 && $row['issendforapprovel'] == 1)
				echo 'Waiting for admin approval';
			else if ($row['endDate'] <= $curtime)
				echo 'Coupon Past-Due/Expired';
			else if ($row['active'] == 1 && $row['issendforapprovel'] == 1)
				echo 'Coupon Active & Awaiting Admin Approval for Update';
			else if ($row['active'] == 1 && $row['issendforapprovel'] == 0)
				echo 'Coupon Active';
			echo "</td></tr>";
		}
		echo "<tr><td valign=top><input type=submit value='Delete'></td></tr>

</table></form>";
	} else if ($page == 'new' || $page == 'edit') {

		if ($page == 'edit') {
			$edit = 1;
			$select = "SELECT * FROM coupons WHERE cid='$_GET[cid]'";
			$result = mysql_query($select);
			$coupon = mysql_fetch_array($result);

			$select = "SELECT * from coupons_tie,schools WHERE coupons_tie.cid = $_GET[cid] AND coupons_tie.sid = schools.sid";
			$resultsch = mysql_query($select) or die(mysql_error());

			$select1 = "SELECT * from coupons_tie,schools WHERE coupons_tie.cid = $_GET[cid] AND coupons_tie.sid = schools.sid";
			$resultsch1 = mysql_query($select1) or die(mysql_error());
			$schools = mysql_fetch_array($resultsch1);
			$select = "SELECT * from location_tie WHERE cid='$_GET[cid]'";
			$result = mysql_query($select) or die(mysql_error());
			$lCount = 0;
			while ($locations = mysql_fetch_array($result))
				$lCount++;
		}
?>
	<form id="editCouponForm" method="post" action="admin.php?action=coupons&page=locations"  enctype="multipart/form-data"  onsubmit="return couponEditFormShouldSubmit();"	>
		<input type=hidden name=type value='<?=$_GET[page] ?>'>
		<input type=hidden name=cid value='<?=$_GET[cid] ?>'>
		<table width="100%" style="font-family:'Calibri',serif;">
			<tr>
				<td valign="top"><b>Business ID</b>
				<br/>
				<?php if ($page != 'edit') { ?>
				<select name="bussin_id" onchange="bus_name(this.value);">
				<?php
			$bussuniess11 = mysql_query(
					"SELECT * FROM businesses ORDER BY businesses.pid ASC LIMIT 1")
					or die(mysql_error());
			$businessid12 = mysql_fetch_array($bussuniess11);
			$bussuniess = mysql_query(
					"SELECT * FROM businesses ORDER BY businesses.pid ASC")
					or die(mysql_error());
			while ($businessid = mysql_fetch_array($bussuniess)) {
				?>
					<option value="<?php echo $businessid['pid'] ?>"><?php echo $businessid['pid'] ?></option>
				<?php } ?>
				</select>
				<div id="getbusinnesname">
					<input type=hidden name='bussin_name' value='<?=$businessid12['business'] ?>' />
				</div>
				<?php }
		if ($page == 'edit') { ?> <input type=text name="pid" value="<?=$coupon[pid] ?>" /> <?php } ?>
				<Br/>
				<?php
		//print_r($coupon);
		if ($page == 'edit') {
			echo "<br/><b>$coupon[business]</b><br/>";
				?>
					<input type=hidden name='bussin_name' value='<?=$coupon[business] ?>' />
				<?php } ?>
				<br/>
				<b>Coupon Image</b>
				<br/>
				<?
		if ($page == 'edit')
			echo "<img src='$coupon[custom_image]' width=300/><br/>";
				?>
				<input type="file" name="file">
                                <input type="hidden" name="custom_image" value="<?=$coupon[custom_image]?>">
				<br/>
				<br/>
				select coupon type 
				<br/>
				<select name="selectcoupontyp" id="">
					<option value="1" <?php if ($coupon['type'] == '1')
			echo "selected='SELECTED'"; ?>>Create Your Coupon</option>
					<option value="2" <?php if ($coupon['type'] == '2')
			echo "selected='SELECTED'"; ?>>UV Coupon Design</option>
					<option value="3" <?php if ($coupon['type'] == '3')
			echo "selected='SELECTED'"; ?>>Upload Own Coupon</option>
				</select>
				<br/>
				<br/>
				<b>Advertising Market(s)</b>
				<br/>
				<? if ($paid != 1) { // INSERT APPLY TO ALL SCHOOLS CHECKBOX HERE
				
				$squery = mysql_query("select s.name from schools s, coupons_tie t where s.sid=t.sid and t.cid=$cid");
				$couponNumSchools = mysql_num_rows($squery);
				
				$totalNumSchoolsResult = mysql_query("select count(1) FROM schools");
				$totalNumSchoolsRow = mysql_fetch_array($totalNumSchoolsResult);
				$totalNumSchools = $totalNumSchoolsRow[0];
				
				if ($couponNumSchools >= $totalNumSchools) {
					echo "<script> $(document).ready(function(){\$('#applyToAllSchools').attr('checked','checked'); switchSchoolListDivToAllSchoolsInTheNation();});</script>";	
				} else if($couponNumSchools < ($totalNumSchools / 2)){
					echo "<script> $(document).ready(function(){\$('#applyToAllListedSchools').attr('checked','checked'); switchSchoolListDivToAllListedSchools();});</script>";
				} else{
					echo "<script> $(document).ready(function(){\$('#applyToAllButListedSchools').attr('checked','checked'); switchSchoolListDivToAllButListedSchools();});</script>";
				}
				?>
				<input type="radio" name="applyToAllSchools" id="applyToAllSchools" onchange="if ($(this).is(':checked')) switchSchoolListDivToAllSchoolsInTheNation();" value="allSchoolsInTheNation" /> All Schools in the Nation<br />
				<input type="radio" name="applyToAllSchools" id="applyToAllListedSchools" onchange="if ($(this).is(':checked')) switchSchoolListDivToAllListedSchools();" value="allListedSchools" /> All Listed Schools<br />
				<input type="radio" name="applyToAllSchools" id="applyToAllButListedSchools" onchange="if ($(this).is(':checked')) switchSchoolListDivToAllButListedSchools();" value="allButListedSchools" /> All EXCEPT FOR Listed Schools<br />
				
				<div id="stateAndSchoolsContainer" style="margin-top:20px;">
				<span style='font-size:.8em;'>State:</span>
				<select name="state1" size="1" id="theState" onChange="getSchools(this.value,'2')">
					<option></option>
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
				</select>
				<script type="text/javascript">
					//$("#theState").val('<?php // echo $schools['state']; ?>'); // <-- this can be misleading when >1 state is selected AND prevents the initial state click / change event to occur for the user (bad)
				</script>
				<br/>
				<!-- <div id="listTheSchools" style="width:100%; clear:both; font-size:.8em;"></div>-->
				<div id="couponBuy" style="width:100%; clear:both; font-size:.8em;">
					<br/>
					
					
					<b>Selected Markets:</b><br />
					<a href="javascript: $('.schoolCheckbox').prop('checked', 'checked');">Check All</a> | 
					<a href="javascript: $('.schoolCheckbox').removeAttr('checked');">Uncheck All</a> | 
					<a href="javascript: toggleSchoolCheckboxes();">Invert All</a> | 
					<!-- <a href="javascript: showAllSchoolsInTheNation();">Show All</a> |--> 
					<a href="javascript: removeAllUncheckedSchoolCheckboxes();">Remove All Unchecked</a> | 
					<a href="javascript: $('.schoolCheckboxSpan').remove();">Remove All</a>
					<br/>
					<?
			if ($page == 'edit') {
				$ctr = 0;
				while ($schools = mysql_fetch_array($resultsch)) {
					$ctr++;
// 					echo "<input class='schoolCheckbox' onclick='remove($schools[sid],$_GET[cid]);' type='checkbox' value='$schools[sid]' name='schools[]' checked='checked' />$schools[name]<br/>";
					echo "<span class='schoolCheckboxSpan'><input class='schoolCheckbox $schools[state]SchoolCheckbox' onclick='' type='checkbox' value='$schools[sid]' data-sid='$schools[sid]' name='schools[]' checked='checked' />$schools[name]<br/></span>";
				}
// 				echo "<input type='hidden' id='numSchoolCheckboxes' name='numSchoolCheckboxes' value='$ctr' />";
// 				$thelength = ($coupon[endDate] - $coupon[startDate]) / 86400;

				//echo "123: $thelength";
			}
					?>
				</div>
				</div>
				<? }
		//if (!$_GET[cid]) { ?>
				<br/>
				<b>Coupon Program</b>
				<br/>
				<select name="active">
					<option value="1" <? if ($page == 'edit'
					&& $coupon[couponPlanID] == 1)
				echo "SELECTED" ?>
>Associates</option>
					<option value="2" <? if ($page == 'edit'
					&& $coupon[couponPlanID] == 2)
				echo "SELECTED" ?>
>Bachelors</option>
					<option value="3" <? if ($page == 'edit'
					&& $coupon[couponPlanID] == 3)
				echo "SELECTED" ?>
>Masters</option>
				</select><? //} else { ?>
				<br/>
				<b>Next Bill Date</b>
				<br/>
				<input type=text name=expires value="<? 
					$couponEndDate = "";
					if ($page == 'edit'){
						$couponEndDate = date('m/d/y', $coupon[endDate]);
					} else {
						$couponEndDate = date('m/d/y', strtotime("+3 months"));
					}
					echo $couponEndDate; ?>"/>
				<? //} ?>
				<br/>
				
				<p>
					<b>Offer</b>
					<Br/>
					<textarea class="defaultText" name="offerText" style="width:300px; height:80px;"><?=$coupon['realOffer'] ?></textarea>
				</p>
				<!--<p>
					<b>Category</b>
					<br/>
					<select name="cat">
						<option value="1" <? //if ($page == 'edit'
				//&& $coupon['category'] == 1)
			//echo "SELECTED" ?>
>Live</option>
						<option value="2" <? //if ($page == 'edit'
				//&& $coupon['category'] == 2)
			//echo "SELECTED" ?>
>Eat</option>
						<option value="3" <? //if ($page == 'edit'
				//&& $coupon['category'] == 3)
			//echo "SELECTED" ?>
>Play</option>
					</select>
				</p>-->
				<p>
					<b>Redemptions Allowed Per Mobile Device</b>
					<br/>
					<select name="redemptions">
						<option value="0" <? if ($page == 'edit'
				&& $coupon['mobileRedeem'] == 0)
			echo "SELECTED" ?>
>Unlimited</option>
						<option value="1" <? if ($page == 'edit'
				&& $coupon['mobileRedeem'] == 1)
			echo "SELECTED" ?>
>1</option>
						<option value="2" <? if ($page == 'edit'
				&& $coupon['mobileRedeem'] == 2)
			echo "SELECTED" ?>
>2</option>
						<option value="3" <? if ($page == 'edit'
				&& $coupon['mobileRedeem'] == 3)
			echo "SELECTED" ?>
>3</option>
					</select>
					<br/>
					
					<b>Select Location Input Method:</b>
					<br/>
					<input type="radio" name="locationsInputMethod" value="manual" checked="checked" onclick="javascript:couponLocationsManualEntrySelected();">Manual Entry<br />
					<input type="radio" name="locationsInputMethod" value="file" onclick="javascript:couponLocationsFromFileSelected();">From File
					<br/>
					
					<div id="couponLocationsManualEntry">
					<span style="font-size:.8em;"><b>Number of Locations</b> - 0 for online only</span>
					<br/>
					<input type=text name="locations" value='<?=$lCount ?>'>
					<br/>
					</div>
					
					<div id="couponLocationsFromFile" style="display:none;font-size:.8em;">
					<label for="locationsFile" style="font-weight: bold;">Choose CSV ("Comma-Separated") Locations File:</label><br />
					<input type="file" name="locationsFile" id="locationsFile"><br />
					<input type="radio" name="appendOrReplaceLocations" value="replace" checked="checked"><b>Replace</b> Existing Locations with Contents of CSV File
					<input type="radio" name="appendOrReplaceLocations" value="append" ><b>Append</b> Existing Locations with Contents of CSV File
					</div>
					
					<br/>
					<input type=submit value="Next">
				</td>
			</tr>
		</table>
	</form>
	<? } else if ($page == 'locations') {	// TODO Page = Locations
// 	error_reporting(E_ALL);
// 	ini_set('display_errors', True);
		if ($_FILES['file']['error'] == 0) {
			list($txt, $ext) = explode(".", $_FILES['file']['name']);
			$newName = time() . ".$ext";
			$uploadfile = "images/coupon/$newName";
			if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
				echo "";
			} else {
				echo "";
			}
			$logo = "images/coupon/$newName";
		}
		$select = "SELECT * FROM businesses WHERE pid='{$_POST['pid']}'";
		$result = mysql_query($select);
		$business = mysql_fetch_array($result);
// 		$expire = strtotime("+" . $_POST['active'] . " months");
		$expire = strtotime("+3 months");		//  make sure this date (3 mo from start date) saves in the db correctly
		$local = 0;
		$active = 0;
		if ($_POST['locations'] != 0)
			$local = 1;
		
		// Coupon Plan ID tells what number coupons and coupon updates the business gets - as well as whether the coupon(s) are featured
		$couponPlanID = $_POST['active'];
		$couponPlanIDConstants = array(
				"ASSOCIATES" => "1",
				"BACHELORS" => "2",
				"MASTERS" => "3"
		);
		$editsLeft = "0";
		$f = "0"; // stands for "featured" - 0 or 1 <-- actually, don't use this - just use fid on coupon_ties table
		$numCouponsLeftToCreate = "0"; // for businesses table, for now only 0 for assoc/bach or 1 for masters
		
		if ($couponPlanID == $couponPlanIDConstants["ASSOCIATES"]){
			$editsLeft = "3";
			$f = "0";
			$numCouponsLeftToCreate = "0";
		} else if ($couponPlanID == $couponPlanIDConstants["BACHELORS"]){
			$editsLeft = "6";
			$f = "0";
			$numCouponsLeftToCreate = "1";
		} else if ($couponPlanID == $couponPlanIDConstants["MASTERS"]){
			$editsLeft = "6";
			$f = "1";
			$numCouponsLeftToCreate = "1";
		}
		
		$businessUpdateQuery = "UPDATE businesses SET numCouponsLeftToCreate='$numCouponsLeftToCreate' WHERE pid='{$business['pid']}'";
		$businessUpdateResult = mysql_query($businessUpdateQuery);
		
		$business['business'] = str_replace("'", "\'", $business['business']);

		$shouldApplyToAllSchools = false;
		$shouldApplyToUncheckedSchoolsOnly = false;

		if (isset($_POST['applyToAllSchools']) && $_POST['applyToAllSchools'] == 'allSchoolsInTheNation')
			$shouldApplyToAllSchools = true;
		else if (isset($_POST['applyToAllSchools']) && $_POST['applyToAllSchools'] == 'allButListedSchools')
			$shouldApplyToUncheckedSchoolsOnly = true;
		
		$couponId = "";
		
		// TODO Adding Coupon in DB
		if ($_POST['type'] != 'edit') {
			$updatetime = time();
			$pid = $_POST['bussin_id'];
			$bussinname = $_POST['bussin_name'];
			$query = "INSERT INTO coupons (sid, pid, type, business, startDate, endDate, custom_image, active, local, realOffer, edit, editsLeft, mobileRedeem,issendforapprovel,updatetime,couponPlanID) values ('-1','$pid','{$_POST['selectcoupontyp']}','$bussinname','"
					. time()
					. "','$expire','$logo','$active','$local','{$_POST['offerText']}','0','$editsLeft','{$_POST['redemptions']}','1','$updatetime', '$couponPlanID')";
			$result = mysql_query($query) or die(mysql_error());
			$cid1 = mysql_insert_id();
			$query = "DELETE FROM pending_coupon_edits WHERE cid='$cid1'";
			$result = mysql_query($query);
			$query = "INSERT INTO pending_coupon_edits (cid, sid, pid, type, business, startDate, endDate, custom_image, active, local, realOffer, edit, editsLeft, mobileRedeem,issendforapprovel,updatetime,couponPlanID) values ('$cid1', '-1','$pid','{$_POST['selectcoupontyp']}','$bussinname','"
			. time()
			. "','$expire','$logo','$active','$local','{$_POST['offerText']}','0','$editsLeft','{$_POST['redemptions']}','1','$updatetime', '$couponPlanID')";
			$result = mysql_query($query) or die(mysql_error());
			$couponId = $cid1;
			
		// TODO Editing Coupon in DB
		} else {
			$updatetime = time();
			$timestamp = strtotime("{$_POST['expires']}");
			if ($logo)
				$image = $logo; //	$image = "custom_image='$logo',";
                        else
                            $image = $_POST['custom_image'];
// 			$query = "UPDATE coupons SET pid='{$_POST['pid']}', active=0, endDate='$timestamp', $image  issendforapprovel=1, local='$local', realOffer='{$_POST['offerText']}', edit='{$_POST['monthlyEdit']}', mobileRedeem='{$_POST['redemptions']}',updatetime='$updatetime',type='{$_POST['selectcoupontyp']}',couponPlanID='$couponPlanID' WHERE cid='{$_POST['cid']}'";
// 			$result = mysql_query($query) or die(mysql_error());
			$query = "UPDATE coupons SET issendforapprovel=1 WHERE cid='{$_POST['cid']}'";
			$result = mysql_query($query) or die(mysql_error());
			$query = "DELETE FROM pending_coupon_edits WHERE cid='{$_POST['cid']}'";
			$result = mysql_query($query);
			$query = "INSERT INTO pending_coupon_edits (pid, endDate, custom_image, issendforapprovel, local, realOffer, edit, mobileRedeem, updatetime, type, couponPlanID, cid, business) VALUES ('{$_POST['pid']}', '$timestamp', '$image',  '1', '$local', '{$_POST['offerText']}', '{$_POST['monthlyEdit']}', '{$_POST['redemptions']}', '$updatetime', '{$_POST['selectcoupontyp']}', '$couponPlanID', '{$_POST['cid']}', '{$_POST['bussin_name']}')";
			$result = mysql_query($query) or die(mysql_error());
			// now only featured if couponPlanID == 3 (Masters Program)
			$upgdatefeatur = "UPDATE coupons_tie set fid='$f' where cid='{$_POST['cid']}'";
			$updateresult = mysql_query($upgdatefeatur) or die(mysql_error());
			$couponId = $_POST['cid'];
		}
		
		// ADDING / EDITING COUPON TIES IN DB
		$schoolIdsChecked = getSchoolIdsFromPost();
		$schoolIdsNotChecked = getSchoolIdsOutsideThisList($schoolIdsChecked);
		
		// Apply to All Schools
		if ($shouldApplyToAllSchools) {
			$schoolIds = getAllSchoolIdsFromDatabase();
			foreach ($schoolIds as $schoolId)
				updateOrInsertCouponTie($couponId, $schoolId, $f);
		// Apply to Checked Schools
		} else if ($shouldApplyToUncheckedSchoolsOnly){
			foreach ($schoolIdsNotChecked as $schoolId)
				updateOrInsertCouponTie($couponId, $schoolId, $f);
			foreach ($schoolIdsChecked as $schoolId)
				deleteCouponTie($couponId, $schoolId);
		// Apply to Unchecked Schools
		} else {
			foreach ($schoolIdsChecked as $schoolId)
				updateOrInsertCouponTie($couponId, $schoolId, $f);
			foreach ($schoolIdsNotChecked as $schoolId)
				deleteCouponTie($couponId, $schoolId);
		}

		if ($_POST['type'] != 'edit')
			$cid = $cid1;
		else
			$cid = $_POST['cid'];
		//$busnaqme1=$business['business'];
	?>
	
	<form method=post action="admin.php?action=coupons&page=done">
		<input type=hidden name='cid' value='<?=$cid ?>' />
		<input type=hidden name='edit' value='<?=$_POST['type'] ?>' />
		<input type=hidden name='pid' value='<?=$_POST['bussin_id'] ?>' />
		<input type=hidden name='pid1' value='<?=$cid1 ?>' />
		<input type=hidden name='business' value='<?=$_POST['bussin_name'] ?>' />
		<?
		$busnaqme = $_POST['bussin_name'];
		//$busnaqme=$busnaqme1;
		if ($_POST['locations'] > 0) {
			// determine whether to include existing locations from the database in the displayed forms here
			$locationsFileWasUploaded = $_POST['locationsInputMethod'] == 'file' ? true : false;	
			$appendChecked = $_POST['appendOrReplaceLocations'] == 'append' ? true : false; 				
			$shouldPullExistingLocations = false;
			if ($_POST['type'] == 'edit'){
				if ($locationsFileWasUploaded){
					if ($appendChecked){
						$shouldPullExistingLocations = true;
					} else {
						$shouldPullExistingLocations = false;
					}
				} else {
					$shouldPullExistingLocations = true;
				}
			} else {
				$shouldPullExistingLocations = false;
			}
			$cur = array();
			if ($shouldPullExistingLocations) {
				$query = "SELECT * FROM location_tie, locations WHERE location_tie.cid='$cid' AND locations.lid=location_tie.lid";
				$result = mysql_query($query) or die(mysql_error());
				$j = 1;
				while ($row = mysql_fetch_array($result)) {
					$cur["$j"] = $row;
					$j++;
				}
			}
			$numLocationFormsToDisplay = 0;
			if ($locationsFileWasUploaded){
				// get locations from the locations file and append them to the locations we may have gotten from the database (called $cur - but $cur is an associative array for some reason, using numbers in strings)
				$locationsFilePath = $_FILES['locationsFile']['tmp_name'];
				$locationsFromFile = getLocationsFromLocationsFile($locationsFilePath);	
				$curCount = count($cur) + 1;
				for ($i = 0; $i < count($locationsFromFile); $i++){
					$cur["$curCount"] = $locationsFromFile[$i];
					$curCount++;
				}
				$numLocationFormsToDisplay = count($cur);
			} else {
				$numLocationFormsToDisplay = $_POST['locations'];
				if ($_POST['locations'] < count($cur)) {
					// don't show existing locations if the new number of locations is smaller than the number that was previously in the database
					// -- so clear cur's values to empty strings
					for ($i = 1; $i <= count($cur); $i++){
						foreach ($cur[$i] as $k=>$v){
							$cur[$i][$k] = "";
						}
					}
				}
			}
			for ($i = 1; $i <= $numLocationFormsToDisplay; $i++) {	// check used to be $i <= $_POST['locations']
				if ($i == 1)
					echo "<b>Primary</b> ";
		?>
		<b>Location <?=$i
					?></b>
		<br/>
		<table>
			<tr>
				<td></td><td>
				<input type=hidden name=locationName[<?=$i ?>] value="<?php echo $busnaqme; ?>">
				</td>
			</tr>
			<tr>
				<td>Street</td><td>
				<input type=text name=street[<?=$i ?>] value="<?=$cur[$i][street] ?>">
				</td>
			</tr>
			<tr>
				<td>City</td><td>
				<input type=text name=city[<?=$i ?>] value="<?=$cur[$i][city] ?>">
				</td>
			</tr>
			<tr>
				<td>State</td><td>
				<input type=text name=state[<?=$i ?>] length=2 size=2 maxlength=2 value="<?=$cur[$i][state] ?>">
				</td>
			</tr>
			<tr>
				<td>Zip</td><td>
				<input type=text name=zip[<?=$i ?>] value="<?=$cur[$i][zip] ?>">
				</td>
			</tr>
			<tr>
				<td>Phone</td><td>
				<input type=text name=phone[<?=$i ?>] value="<?=$cur[$i][phone] ?>">
				</td>
			</tr>
		</table>
		<br/>
		<?
			}
		?>
		<input type=submit value='Add Locations' />
	</form>
	<? } else { ?>
	<b>Online Only URL:</b>
	<br/>
	<input type=text name='onlineURL' />
	<input type=submit value='Add URL' />
</form>
<? }
	} else if ($page == 'done') {

		if (!$_POST['onlineURL']) {
			
			if ($_POST['edit'] == 'edit') {
				$select = "SELECT * FROM location_tie WHERE cid='$_POST[cid]'";
				$result = mysql_query($select);

				while ($row = mysql_fetch_row($result)) {
					$query = "DELETE from locations WHERE lid='$row[1]'";
					$resultb = mysql_query($query) or die(mysql_error());
				}

				$query = "DELETE from location_tie WHERE cid='$_POST[cid]'";
				$result = mysql_query($query) or die(mysql_error());
			}
			
			foreach ($_POST['locationName'] as $k => $v) {
				$locationFieldsMergedForCheck = trim($_POST['state'][$k]) . trim($_POST['city'][$k]) . trim($_POST['street'][$k]) . trim($_POST['zip'][$k]);
				if (empty($locationFieldsMergedForCheck))
					continue;
					
				$address = 'USA, ' . $_POST['state'][$k] . ', ' . $_POST['city'][$k] . ', ' . $_POST['street'][$k] . ', ' . $_POST['zip'][$k];
// 				echo "address: " . $address . "<br />";
				$position = useGoogleGeocodeToGetCoordinates($address);
// 				var_dump($position);
// 				echo "<br />";
				$p = 0;
				if ($k == 1)
					$p = 1;
				$insert = "INSERT INTO locations (pid, lat, lng, name,street, state,city,zip,phone, locationName, primaryLoco) values ('$_POST[pid]','" . $position['lat'] . "','" . $position['lng'] . "','" . $_POST[business] . "','"
						. $_POST[street][$k] . "','" . $_POST[state][$k]
						. "','" . $_POST[city][$k] . "','" . $_POST[zip][$k]
						. "','" . $_POST[phone][$k] . "','$v','$p')";
				$result = mysql_query($insert) or die(mysql_error());
				$lid = mysql_insert_id();
// 				echo "lid from insert: " . $lid . "<br />";
				$insert = "INSERT INTO location_tie (lid, cid) values ($lid,'$_POST[cid]')";
				$result = mysql_query($insert) or die(mysql_error());

			}
		} else {
			$update = "UPDATE coupons SET onlineURL='$_POST[onlineURL]' WHERE cid='$_POST[cid]'";
			$result = mysql_query($update) or die(mysql_error());
		}

		echo "<b>Coupon Added</b>";
?>

<? } else if ($page == 'delete') {
		foreach ($_POST[delete] as $k => $v) {
			echo "$v ";

			if ($v > 0) {
				$delete = "DELETE FROM coupons WHERE cid='$v'";
				$result = mysql_query($delete);

				$delete = "DELETE FROM coupons_tie WHERE cid='$v'";
				$result = mysql_query($delete);

				$select = "SELECT * FROM location_tie WHERE cid='$v'";
				$result = mysql_query($select);
				while ($row = mysql_fetch_row($result)) {
					$delete = "DELETE FROM locations WHERE lid='$row[1]'";
					$result = mysql_query($delete);
				}

				$delete = "DELETE FROM location_tie WHERE cid='$v'";
				$result = mysql_query($delete);
				$delete = "DELETE FROM location_tie WHERE cid='$v'";
				$result = mysql_query($delete);

				echo " deleted.<br/>";

			}
		}
	}
}
?>
<script type="text/javascript">
	function fun_consultant_sort(fieldname, setorder) {
		var neworder = "";
		var set_new_order = document.getElementById(setorder).value;
		if(set_new_order == "desc") {
			neworder = "asc";
		} else if(set_new_order == "asc") {
			neworder = "desc";
		} else {
		}
		window.location = "https://www.universityvalues.com/admin.php?action=coupons&sort_fname=" + fieldname + "&sort_order=" + neworder;
	}
</script>
<script type="text/javascript">
function fun_order(order){
	window.location="admin.php?action=coupons<?php echo isset($_GET['sort']) ? '&sort='
				. $_GET['sort'] : ''; ?>&sorted="+order;
}
function fun_order2(order){
	window.location="admin.php?action=coupons<?php echo isset($_GET['sort']) ? '&sort='
				. $_GET['sort'] : ''; ?>&schoolid=<?php echo $schoolid ?>&sorted="+order;
}
function fun_school(school){
	window.location="admin.php?action=coupons&schoolid="+school;
}

</script>
