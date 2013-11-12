<script>
$(function(){
	$('#navTabs a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	})
	$('.edit,.formCancel').click(function(evt){
		evt.preventDefault();
		var rel = $(this).attr('rel');
		$(rel).find('.static,.formField').toggle();
		if($('.edit[rel="'+rel+'"]') == 'Edit')
		{
			$('.edit[rel="'+rel+'"]').text("Cancel");
		}
		else
		{
			$('.edit[rel="'+rel+'"]').text('Edit');
		}
	})
})
</script>
<?php
	//retrieve the business information from the database
	$res = mysql_query("SELECT * FROM businesses b WHERE b.pid =".$_GET['id']) or die(mysql_error());
	$business = mysql_fetch_assoc($res);
?>
<div class="well">
	<img style="float:left;margin-right:20px" src="<?php echo $business['logo']; ?>?>" />
	<h2 style="float:left;"><?php echo $business['business']; ?></h2>
	<br style="clear:both;"/>
	
	
	<ul class="nav nav-tabs" id="navTabs">
	  <li class="active"><a href="#contact">Contact Info</a></li>
	  <li><a href="#coupons">Coupons</a></li>
	  <li><a href="#billing">Billing</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="contact">
			<h3>Contact Info <button type="button" class="btn btn-default active edit" rel="#info" >Edit</button></h3>
			<form id="info" action="">
			<dl>
				<dt>Name</dt>
				<dd>
					<span class="static"><?php echo $business['name']; ?></span>
					<input class="formField" name="name" type="text" value="<?php echo $business["name"]; ?>" />
				</dd>
				<dt>Email</dt>
				<dd>
					<span class="static"><?php echo $business['email']?></span>
					<input class="formField" type="text" name="email" value="<?php echo $business["email"]; ?>" />
				</dd>
				<dt>Phone</dt>
				<dd>
					<span class="static"><?php echo $business['phone']?></span>
					<input class="formField" type="text" name="phone" value="<?php echo $business["phone"]; ?>" />
				</dd>
				<dt>Address</dt>
				<dd>
					<address class="static">
					<?php echo ucwords($business['address']); ?><br/>
					<?php echo ucwords($business['addressMore']); ?><br/>
					<?php echo ucwords($business['city']);?><br/>
					<?php echo $business['state'].", ".$business['zip'];?>
					</address>
					<address class="formField">
					<input type="text" name="address" value="<?php echo ucwords($business['address']); ?>"/><br/>
					<input type="text" name="addressMore" value="<?php echo ucwords($business['addressMore']); ?>"/><br/>
					<input type="text" name="city" value="<?php echo ucwords($business['city']);?>"/><br/>
					<?php echo state_select('state',$business['state']); ?>, <input type="text" name="zip" value="<?php echo $business['zip'];?>"/>
					</address>
				</dd>
				<dt>Website</dt>
				<dd>
					<a class="static" href="<?php echo $business['website'];?>" target="_blank"><?php echo $business['website'];?></a>
					<input class="formField" type="text" name="phone" value="<?php echo $business["website"]; ?>" />
				</dd>
			</dl>
			<span class="formField">
				<button type="button" class="btn btn-default active formCancel" rel="#info" >Cancel</button></h3>
				<button type="button" class="btn btn-primary active formSave" rel="#info" >Save</button></h3>
			</span>
			</form>
		</div>
		<div class="tab-pane" id="coupons">
			<h3>Coupons</h3>
			<?php 
				$res = mysql_query("SELECT * FROM coupons c WHERE c.pid =".$_GET['id']) or die(mysql_error());
				while($coupon = mysql_fetch_assoc($res)):
			?>
			<div class="row">
				
				<div class="span3">
					<a href="admin_new.php?action=coupons&page=edit&cid=<?php echo $coupon['cid'];?>">Edit</a>
					<img src="<?php echo $coupon['custom_image']; ?>" width="300" />
				</div>
				<form id="coupon_<?php echo $coupon['cid']; ?>" action="">
				<div class="span6 static">
					<dl>
						<dt>Offer</dt>
						<dd><?php echo $coupon["realOffer"];?></dd>
						<dt>Start Date</dt>
						<dd><?php echo date("m/d/Y",$coupon["startDate"]);?></dd>
						<dt>End Date</dt>
						<dd><?php echo date("m/d/Y",$coupon["endDate"]);?></dd>
					</dl>
				</div>
				<div class="formField">

				</div>
				</form>
			</div>
			
			<?php endwhile;?>
		</div>
		<div class="tab-pane" id="billing">
			<h3>Billing Information</h3>
			<?php
				$res = mysql_query("SELECT * FROM orders WHERE pid = '".$business['pid']."' ORDER BY dateOrdered DESC") or die(mysql_error());
				$row = mysql_fetch_assoc($res);
				?>
				<dl>
					<dt>Credit Card Info</dt>
					<dd>
						<address>
							<u>Name on Card:</u> <?php echo $row['nameOnCard'] ;?><br />
							<u>Credit Card:</u> **** **** **** <?php echo $row['lastFour']; ?>
						</address>
					</dd>
					<dt>Billing Address</dt>
					<dd>
						<address>
							<?php echo $row['address']; ?></br>
							<?php echo $row['addressMore']; ?></br>
							<?php echo ucwords($row['city']);?><br/>
							<?php echo $row['state'].", ".$row['zip'];?>
						</address>
					</dd>
				</dl>

		</div>
	</div>
	
	

</div>