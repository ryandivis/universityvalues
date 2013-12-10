<?php 
if ($page == 'edit') 
{
	$edit = 1;
	$select = "SELECT * FROM coupons WHERE cid='$_GET[cid]'";
	$result = mysql_query($select);
	$coupon = mysql_fetch_array($result);

	$select = "SELECT * from coupons_tie,schools WHERE coupons_tie.cid = $_GET[cid] AND coupons_tie.sid = schools.sid";
	$resultsch = mysql_query($select) or die(mysql_error());

	$select1 = "SELECT * from coupons_tie,schools WHERE coupons_tie.cid = $_GET[cid] AND coupons_tie.sid = schools.sid";
	$resultsch1 = mysql_query($select1) or die(mysql_error());
	$schools = mysql_fetch_array($resultsch1);
	$sql = "SELECT * FROM locations l WHERE l.lid IN (SELECT lid FROM location_tie WHERE cid = '$_GET[cid]')";
	//$select = "SELECT * from location_tie LEFT JOIN locations on location_tie.lid = locations.lid WHERE cid='$_GET[cid]'";
	$result = mysql_query($sql) or die(mysql_error());
	$lCount = 0;
	$locationsArray = array();
	while ($location = mysql_fetch_array($result))
		$locationsArray[] = $location;
		$lCount++;
}
?>
<form id="editCouponForm" method="post" action="admin.php?action=coupons&page=locations"  enctype="multipart/form-data"	>
	<input type=hidden name=type value='<?=$_GET[page] ?>'>
	<input type=hidden name=cid value='<?=$_GET[cid] ?>'>
	<dl>
		
		<dt>Business</dt>
		<dd>
			<?php if($page != 'edit'): ?>
			<select name="bussin_id">
				<?php echo getBusinessList('html'); ?>
			</select>
			<?php else: ?>
				<?php echo $coupon['business']; ?>
				<input type="hidden" name="bussin_id" value="<?php echo $coupon['pid'];?>" />
				<input type="hidden" name="bussin_name" value="<?php echo $coupon['business'];?>" />
			<?php endif; ?>	
		</dd>
		<dt>Coupon Image</dt>
		<dd>
			<?php if($page == 'edit'): ?>
				<img src="<?php echo $coupon['custom_image']; ?>" width="300" />
			<?php endif; ?>
			<br/>
			<input id="couponFile" type="file" name="file" />
			<div id="previewImage" style="display:none;position:relative;">
				<img src="" width="300"/>
				<div class="glyphicon glyphicon-remove-sign"></div>
			</div>
			<input type="hidden" name="custom_image" value="<?php echo $coupon['custom_image']; ?>" />
		</dd>
		<dt>Coupon Type</dt>
		<dd>
			<select name="couponTypeId">
				<option value="1" <?php if ($coupon['type'] == '1') echo "selected='selected'"; ?>>Create Your Coupon</option>
				<option value="2" <?php if ($coupon['type'] == '2') echo "selected='selected'"; ?>>UV Coupon Design</option>
				<option value="3" <?php if ($coupon['type'] == '3') echo "selected='selected'"; ?>>Upload Own Coupon</option>
			</select>	
		</dd>
		<dt>Advertising Market(s)</dt>
		<dd>
			<dl>
				<dd>
					<input type="radio" onchange="toggleStateAndSchoolsContainer()" name="advertisingMarkets" value="allSchoolsInTheNation" />	All Schools in the Nation <br/>
					<input type="radio" checked="checked" onchange="toggleStateAndSchoolsContainer()" name="advertisingMarkets" value="applyToAllListedSchools" />	All Listed Schools <br/>
					<input type="radio" onchange="toggleStateAndSchoolsContainer()" name="advertisingMarkets" value="applyToAllButListedSchools" />	All EXCEPT Listed Schools <br/>
				</dd>
				<div id="stateAndSchoolsContainer">
					<dt>State</dt>
					<dd>
						<?php echo state_select("state",null,"stateSelector"); ?>
					</dd>
					<dt>Selected Markets</dt>
					<dd>
						<a href="javascript: $('.schoolCheckbox').prop('checked', 'checked');">Check All</a> | 
						<a href="javascript: $('.schoolCheckbox').removeAttr('checked');">Uncheck All</a> | 
						<a href="javascript: toggleSchoolCheckboxes();">Invert All</a> | 
						<!-- <a href="javascript: showAllSchoolsInTheNation();">Show All</a> |--> 
						<a href="javascript: removeAllUncheckedSchoolCheckboxes();">Remove All Unchecked</a> | 
						<a href="javascript: $('.schoolCheckboxSpan').remove();">Remove All</a>
						<dl id="couponBuy">
						<?php
							if ($page == 'edit') 
							{
								$ctr = 0;
								while ($schools = mysql_fetch_array($resultsch))
								{
									$ctr++;
									echo "<dd><input class='schoolCheckbox $schools[state]SchoolCheckbox' onclick='' type='checkbox' value='$schools[sid]' data-sid='$schools[sid]' name='schools[]' checked='checked' />$schools[name]<br/></dd>";
								}
							}
						?>
						</dl>
					</dd>
				</div>
			</dl>
		</dd>
		<dt>Next Bill Date</dt>
		<dd>
			<?php
				if($page != 'edit')
				{
					$couponEndDate = date('m/d/y', $coupon['endDate']);
				}
				else
				{
					$couponEndDate = date('m/d/y', strtotime("+3 months"));	
				}
			?>
			<input type=text name="expires" value="<?php echo $couponEndDate; ?>" />
		</dd>
		<dt>Offer</dt>
		<dd>
			<textarea name="offerText"><?php echo $coupon['realOffer'] ?></textarea>
		</dd>
		<dt>Redemptions Allowed Per Mobile Device</dt>
		<dd>
			<select name="redemptions">
				<option value="0" <? if ($page == 'edit' && $coupon['mobileRedeem'] == 0) echo "SELECTED" ?>>Unlimited</option>
				<option value="1" <? if ($page == 'edit' && $coupon['mobileRedeem'] == 1) echo "SELECTED" ?>>1</option>
				<option value="2" <? if ($page == 'edit' && $coupon['mobileRedeem'] == 2) echo "SELECTED" ?>>2</option>
				<option value="3" <? if ($page == 'edit' && $coupon['mobileRedeem'] == 3) echo "SELECTED" ?>>3</option>
			</select>	
		</dd>
		<dt>Locations</dt>
		<dd>
			<em>If there are no locations, the coupon is online only</em><br/>
			<a class="btn addLocation">Add Location</a>
			<a class="btn addLocationCSV" onclick="$('#csv').click();">Upload Location CSV</a>
			<input id="csv" type="file" name="csv" style="visibility:hidden;" />
			<table id="locations" class="table table-striped table-bordered">
				<tr>
					<th style="text-align:center;">#</th>
					<th>Primary</th>
					<th>Street</th>
					<th>City</th>
					<th>State</th>
					<th>Zip</th>
					<th>Phone</th>
					<th></th>
				</tr>
				<tr class="default" style="display:none">
					<td></td>
					<td style="text-align:center;">
						<input type="checkbox" value="1" disabled="disabled" name="primaryLoco" <?php echo ($location['primaryLoco'] == 1)? 'checked="checked"' : '';?> />
					</td>
					<td>
						<input name="street" disabled="disabled"/>
					</td>
					<td>
						<input name="city" disabled="disabled"/>
					</td>
					<td>
						<?php echo state_select('state'); ?>
					</td>
					<td>
						<input name="zip" disabled="disabled"/>
					</td>
					<td>
						<input name="phone" disabled="disabled"/>
					</td>
					<td>
						<a class="btn removeLocation" rel="">Remove</a>
					</td>
				</tr>
				<?php
					$i = 0; 
					foreach($locationsArray as $location): 
				?>
				<tr class="locationRow">
					<td>
						<?php echo $location['lid']; ?>
						<input type="hidden" name="locations[<?php echo $i; ?>][lid]" value="<?php echo $location['lid']; ?>" />
					</td>
					<td style="text-align:center;">
						<input type="checkbox" value="1" name="locations[<?php echo $i; ?>][primaryLoco]" <?php echo ($location['primaryLoco'] == 1)? 'checked="checked"' : '';?> />
					</td>
					<td>
						<span class="static"><?php echo $location['street']; ?></span>
						<input class="formField" name="locations[<?php echo $i; ?>][street]" value="<?php echo $location['street']; ?>" />
					</td>
					<td>
						<span class="static"><?php echo $location['city']; ?></span>
						<input class="formField" name="locations[<?php echo $i; ?>][city]" value="<?php echo $location['city']; ?>" />
					</td>
					<td>
						<span class="static"><?php echo $location['state']; ?></span>
						<?php echo state_select('locations['.$i.'][state]',$location['state'],null,'formField'); ?>
					</td>
					<td>
						<span class="static"><?php echo $location['zip']; ?></span>
						<input class="formField" name="locations[<?php echo $i; ?>][zip]" value="<?php echo $location['zip']; ?>" />
					</td>
					<td>
						<span class="static"><?php echo $location['phone']; ?></span>
						<input class="formField" name="locations[<?php echo $i; ?>][phone]" value="<?php echo $location['phone']; ?>" />
					</td>
					<td>
						<a class="btn editLocation" rel="<?php echo $location['lid']; ?>">Edit</a>
						<a class="btn removeLocation" rel="<?php echo $location['lid']; ?>">Remove</a>
					</td>
				</tr>
				<?php 
					$i++;
					endforeach;
				?>	
			</table>
			
		</dd>
		<dd>
			<button type="button" class="btn btn-default active formCancel" rel="#info" >Cancel</button>
			<input type="Submit" class="btn btn-primary active formSave" value="Save" /><span class="glyphicon glyphicon-refresh"></span>
		</dd>
	</dl>
</form>

<script>
$(function(){
	$('.removeLocation').on('click',function(evt){
		evt.preventDefault();
		$(this).parents('tr').remove();
	})
	$('.addLocation').click(function(evt){
		evt.preventDefault();
		addLocation();
	})
	$('.editLocation').on('click',function(evt){
		evt.preventDefault();
		$(this).parents('tr').find('.static,.formField').toggle();
	})
	$('#stateSelector').change(function(){
		getSchools($(this).val());
	})
	$('#editCouponForm').submit(function(evt){
		evt.preventDefault();
		//validate form data
		var formData = new FormData($(this)[0]);
		$.ajax({
			url : '/ajax/admin/coupon_edit.php',
			type: 'POST',
			data: formData,
			cache: false,
			contentType: false,
			processData: false
		}).done(function(data){
			console.log(data);
		})
		
	})
	$('#couponFile').change(function(evt){
		var file = this.files[0];
		var reader = new FileReader();
		reader.readAsDataURL(file);
		reader.onload = displayPreview;
	})
	$('#csv').change(function(evt){
		var file = this.files[0];
		var reader = new FileReader();
		reader.readAsText(file);
		reader.onload = loadCsv
	})
})

function addLocation()
{
	var tr = $('#locations').find('tr.default').clone();
	tr.addClass('locationRow').removeClass('default');
	tr.find('.removeLocation').click(function(){
		tr.remove();
	})
	tr.find('input,select').each(function(){
		$(this).removeAttr('disabled');
	})
	var rows = $('#locations').find('tr.locationRow').length;
	tr.find('input,select').each(function(){
		var name = $(this).attr('name');
		$(this).attr('name','locations[' + rows + '][' + name + ']');
		$(this).attr('id','locations.'+rows+'.'+name);
	})
	$('#locations').append(tr);
	tr.show();
	return rows;
}

function loadCsv(event)
{
	var fields = ['street','city','state','zip','phone'];
	var result = event.target.result;
	result = result.split(/\n/);
	for(var idx in result)
	{
		row = addLocation();
		input = result[idx].split(',');
		for(var i in input)
		{
			var el = $('#locations\\.'+row+'\\.'+fields[i]);
			console.log(el);
			el.val(input[i].trim());
		}
	}
	
}

function displayPreview(event){
	var result = event.target.result;
	$('#previewImage img').attr('src',result);
	$('#previewImage').show();
	$('#couponFile').hide();
}

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
				$('#couponBuy').find('span').each(function(){
					var inner = $(this).html();
					$(this).replaceWith('<dd>' + inner + '</dd>');
				})
			}
		};
		xmlhttp.open("GET", "getschools.php?q=" + a + "&t=2&existingsids=" + existingSchoolIdsJsonString, true);
		xmlhttp.send();

	}
function toggleStateAndSchoolsContainer()
{
	var value = $('input[name="advertisingMarkets"]:checked').val();
	if(value == 'allSchoolsInTheNation')
	{
		$('#stateAndSchoolsContainer').hide();
	}
	else
	{
		$('#stateAndSchoolsContainer').show();	
	}
}
</script>