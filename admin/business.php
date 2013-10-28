<script>
$(function(){
	$('#navTabs a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
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
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="contact">
			<h3>Contact Info</h3>
			<dl>
				<dt>Name</dt>
				<dd>
					<span class="static"><?php echo $business['name']; ?></span>
					<input name="name" type="text" />
				</dd>
				<dt>Email</dt>
				<dd>
					<span class="static"><?php echo $business['email']?></span>
					<input type="text" name="email" value="<?php echo $business["email"]; ?>" />
				</dd>
				<dt>Phone</dt>
				<dd>
					<span class="static"><?php echo $business['phone']?></span>
					<input type="text" name="phone" value="<?php echo $business["phone"]; ?>" />
				</dd>
				<dt>Address</dt>
				<dd>
					<address>
					<?php echo ucwords($business['address']); ?><br/>
					<?php echo ucwords($business['addressMore']); ?><br/>
					<?php echo ucwords($business['city']);?><br/>
					<?php echo $business['state'].", ".$business['zip'];?>
					</address>
				</dd>
				<dt>Website</dt>
				<dd><a href="<?php echo $business['website'];?>" target="_blank"><?php echo $business['website'];?></a></dd>
			</dl>
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
				<div class="span6">
					<dl>
						<dt>Offer</dt>
						<dd><?php echo $coupon["realOffer"];?></dd>
						<dt>Start Date</dt>
						<dd><?php echo date("m/d/Y",$coupon["startDate"]);?></dd>
						<dt>End Date</dt>
						<dd><?php echo date("m/d/Y",$coupon["endDate"]);?></dd>
					</dl>
				</div>
			</div>
			
			<?php endwhile;?>
		</div>
	</div>
	
	

</div>