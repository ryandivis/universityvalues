</div>
<!-- Lower Area and Footers -->
<? if($turnOff != 1) { ?>
	
<script src="js/slides.min.jquery.js"></script>
	<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
				play: 5000,
				pause: 2500,
				effect: 'fade',
				crossfade: true
			});
		});
	</script>
	<style type="text/css" media="screen">
.slides_container {
    height: 176px;
    left: 18px;
    top: 21px;
    width: 287px;
    display:none;
}
		.slides_container div {
			width:240px;
			display:block;
		}
		
		.pagination {
			list-style:none;
			bottom: -24px;
			 position: relative;
    		z-index: 99;
    		padding-left: 237px;
		}

		.pagination .current a {
			color:red;
		}
		.pagination li a {
			display: block;
			width: 12px;
			height: 0;
			padding-top: 12px;
			background-image: url(pagination.png);
			background-position: 0 0;
			float: left;
			overflow: hidden;
			}
			.pagination li.current a {
	background-position:0 -12px;
}
#slides1{
	width:328px;
	background-image: url(new_images/news1.png);
	background-repeat:no-repeat;
	
}

.fearured_image {
    background-image: url("new_images/featuredcoupons1.png");
    background-repeat: no-repeat;
    height: 193px;
    position: relative;
    width: 320px;
}


	
</style>
	
<div style="position:relative;" id="lower-third-wrapper" <? if($code == 4) { echo "style=\"margin-top:-45px;\""; } ?>>
<div style="padding: 40px; clear: both;"></div>
<div style="position: absolute; bottom: 58px; left:66px;">
<img src="new_images/uvsnewsarrow.png" />
</div>
<center>
<table width="770" style="margin-left:88px;">
	<tr>
		<td width="">
			<div id="slides1">
				<div id="slides" style="height: 233px;">
					<div class="slides_container">
				<?php $query=mysql_query("SELECT * FROM managnews");
				while($row=mysql_fetch_array($query)){ ?>
				<div>
				<table>
					<tr>
						<td valign="bottom" style="padding-right:10px;" height="100">
						<a target="_blank" href="https://<?php echo $row['mylink']; ?>"><img width="283" height="171" alt="<?php echo $row['new_dsc']; ?>" src="newsimage/<?php echo $row['news_image']; ?>" /></a>	
						</td>
						
					</tr>
				</table>
				</div> <?php  } ?>
				</div>
			</div>
		</div>
		</td>
		<td align="left" width="">
			    <?php
			    if(is_array($featured))
			    {
					
			    }
			    else 
			    {
				$select = "SELECT * FROM featured";
				$result = mysql_query($select) or die(mysql_error());
			
			
				$i = 0;
				while($row = mysql_fetch_row($result))
				{
					$featured[$i][1] = $row[3];
					$i++;
				}
			
			    }
				shuffle($featured);
			    ?>
	<div class="fearured_image">
	<div style=" position: absolute; top: -35px; left: 61px; width:280px; height: 60px; background-image: url('new_images/featured-coupouns1.png'); background-repeat: no-repeat;"><div class="your" style="padding-top: 5px;">Featured Coupons</div></div>
	
    <center>
    <table style="position: absolute; top:26px;" cellspacing=0 cellpadding=0>
    <tr>
    <td width="320">
    <div id="bottom-feat-wrapper"> <!---- begin feat wrapper ------>
    	<table width="100%">
    		<tr>
    			<td align="center"><? if($featured[0][1]) { ?><? if($pullAds == 1) { ?><a href="coupon-details.php?state=<?=$_GET[state]?>&coupon=<?=$featured[0][0]?>&school=<?=$_GET[school]?>"><? } ?><img src="<?=$featured[0][1]?>" border="0" width="36" height="36"/><? if($pullAds == 1) echo '</a>'; ?><? } ?></td>
    			<td align="center"><? if($featured[1][1]) { ?><? if($pullAds == 1) { ?><a href="coupon-details.php?state=<?=$_GET[state]?>&coupon=<?=$featured[1][0]?>&school=<?=$_GET[school]?>"><? } ?><img src="<?=$featured[1][1]?>" border="0" width="36" height="36"/><? if($pullAds == 1) echo '</a>'; ?><? } ?></td>
    			<td align="center"><? if($featured[2][1]) { ?><? if($pullAds == 1) { ?><a href="coupon-details.php?state=<?=$_GET[state]?>&coupon=<?=$featured[2][0]?>&school=<?=$_GET[school]?>"><? } ?><img src="<?=$featured[2][1]?>" border="0" width="36" height="36"/><? if($pullAds == 1) echo '</a>'; ?><? } ?></td>
    		</tr>
    		<tr>
    			<td align="center" colspan="3">
    				<table>
    					<tr>
    						<td align="right" style="padding-right: 28px;"><? if($featured[3][1]) { ?><? if($pullAds == 1) { ?><a href="coupon-details.php?state=<?=$_GET[state]?>&coupon=<?=$featured[3][0]?>&school=<?=$_GET[school]?>"><? } ?><img src="<?=$featured[3][1]?>" border="0" width="36" height="36"/><? if($pullAds == 1) echo '</a>'; ?><? } ?></td>
    						<td align="left" style="padding-left: 28px;"><? if($featured[4][1]) { ?><? if($pullAds == 1) { ?><a href="coupon-details.php?state=<?=$_GET[state]?>&coupon=<?=$featured[4][0]?>&school=<?=$_GET[school]?>"><? } ?><img src="<?=$featured[4][1]?>" border="0" width="36" height="36"/><? if($pullAds == 1) echo '</a>'; ?><? } ?></td>
    					</tr>
    				</table>    				
    			</td>
    		</tr>
    		<tr>
    			<td align="center"><? if($featured[5][1]) { ?><? if($pullAds == 1) { ?><a href="coupon-details.php?state=<?=$_GET[state]?>&coupon=<?=$featured[5][0]?>&school=<?=$_GET[school]?>"><? } ?><img src="<?=$featured[5][1]?>" border="0" width="36" height="36"/><? if($pullAds == 1) echo '</a>'; ?><? } ?></td>
    			<td align="center"><? if($featured[6][1]) { ?><? if($pullAds == 1) { ?><a href="coupon-details.php?state=<?=$_GET[state]?>&coupon=<?=$featured[6][0]?>&school=<?=$_GET[school]?>"><? } ?><img src="<?=$featured[6][1]?>" border="0" width="36" height="36"/><? if($pullAds == 1) echo '</a>'; ?><? } ?></td>
    			<td align="center"><? if($featured[7][1]) { ?><? if($pullAds == 1) { ?><a href="coupon-details.php?state=<?=$_GET[state]?>&coupon=<?=$featured[7][0]?>&school=<?=$_GET[school]?>"><? } ?><img src="<?=$featured[7][1]?>" border="0" width="36" height="36"/><? if($pullAds == 1) echo '</a>'; ?><? } ?></td>
    		</tr>
    	</table>
   
    </div> 
    </td>
 </tr>
</table>    	
</div>
</td>
</tr>
</table>
</center>
</div>
</div>
 
 <table width="879" align="center" style="position: relative; top: 18px;">
 	<tr valign="top">
 		<td width="50%" align="right">
 			<div style=" font-family:'daniel_blackregular',Sans-Serif; font-size: 0.8em; text-align:center; padding:10px 0 0 0px; background-image: url(new_images/be-the-first1.png); background-repeat:no-repeat; width: 557px; height: 28px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Be the first to know about special deals, promotions and updates !</div>
 			</td>
 		<td width="50%" valign="top" align="">
 			<table> 				
 				<tr>
 					<td>
 			<input style="border-radius: 5px 5px 5px 5px; width: 211px !important; border: 2px solid rgb(0, 0, 0); padding-left: 5px;" type="email" class="defaultText" name="signupEmail" id="signup_Email" title="Your Email" value="Your Email">
 			</td><td>
 			<a href="javascript:void(0)" id="goButton" style=""><img src="new_images/subscribe.png" border=0></a>
 			</td>
 			</tr>
 			<tr ><td colspan="2" align="center"><div id="invalidEmail"></div></td></tr>
 			</table>
		</td>
 	</tr>
 </table>

<? } ?>

</div>
</div>
</center>
<!---- End Center area and main container ------>
<!-- Close Second CENTER TAG -->
</div>
</div>
<!-- Close FIRST CENTER TAG -->

</div>
</div>
<div id="Underwear" style="margin-top:0px;">
<?php /* if($front!=1 && $state!="") { ?>
 <div style="width:100%; background-color:#808080; height:2px;"></div>
 <div style="width:100%; background-color:#92d050; height:3px;"></div>
 <div style="width:100%; background-color:#808080; height:3px;"></div>
 <?php } echo $state;*/ ?>
 <?php  if($front==1 || $_GET['state']!="") {  } else { ?><div id="body-background_footer"><?php } ?>
<div id="<?php if($front==1 || $_GET['state']!=""){ echo'lower-bg-footer'; } else { echo 'lower-bg-footer'; } ?>">

<table width="1000" align="center" <?php if($front==1 || $_GET['state']!="") { echo 'style="padding-top: 69px;"';} else { echo'style="padding-top: 69px;"';} ?> >
	<tr>
		<td>
			<div style="width:1000px;">
				<div style="width: 180px; float: left; padding-left: 61px;">
					<div class="wlith_text">HELP</div>
					<div class="green_text"><a href="javascript: void(0);" class="appTutorial">Using The App</a></div>
					<!--<div class="green_text"><a href="#" class="appTutorial">Using The Website</a></div>
					<div class="green_text"><a href="index.php" >Find Your School</a></div>-->
					<div class="green_text"><a href="javascript: void(0);" class="openAdvert dropPage"">Advertiser Help</a></div>
					<div class="green_text"><a href="javascript: void(0);" class="openContact dropPage">Contact Us</a></div>
				</div>
				<div style="width: 205px; float: left; padding-left: 45px;">
					<div class="wlith_text">ABOUT US</div>
					<div class="green_text"><a href="javascript: void(0);" class="openAbout dropPage" >Bio</a></div>
					<div class="green_text"><a href="javascript: void(0);" class="openAbout dropPage" >Money in Your Pocket &reg;</a></div>
					<div class="green_text"><a href="javascript: void(0);" class="openAbout dropPage" >Students Win Prizes</a></div>
					<div class="green_text"><a  href="blog"  target="_blank" >Blog</a></div>
				</div>
				<div style="width: 205px; float: left; padding-left: 45px;">
					<div class="wlith_text">CONTACT US</div>
					<div class="green_text"><a href="javascript: void(0);" class="openContact dropPage" >Student Support</a></div>
					<div class="green_text"><a href="javascript: void(0);" class="openContact dropPage">Employment</a></div>
					<div class="green_text"><a href="javascript: void(0);" class="openContact dropPage">Refer a Merchant</a></div>
					<div class="green_text"><a href="javascript: void(0);" class="openContact dropPage">Feedback</a></div>
				</div>
					<div style="width: 205px; float: left; padding-left: 45px;">
					<div class="wlith_text">ADVERTISING</div>
					<div class="green_text"><a href="javascript: void(0);" class="openAdvert dropPage">Request Information</a></div>
					<div class="green_text"><a href="javascript: void(0);" class="openAdvert dropPage">Advertiser Coupon Lounge&trade;</a></div>
					<div class="green_text"><a href="javascript: void(0);" class="openAdvert dropPage">New Advertisers</a></div>
					<div class="green_text"><a href="javascript: void(0);" id="clientsSaying" class="clientsSaying">Testimonials</a></div>
				</div>
			</div>
		</td>
	</tr>
</table>
<center>
<table width="879">
	<tr>
	   	<td colspan="" height="10"> <div style="width:100%; background-color:#808080; height:1px;"></div></td>
	   </tr>
</table>
</center>
<table width="879" align="center">
	<tr>
		<td width="414">
			<div>
		<!--<script language="JavaScript" type="text/javascript">
		TrustLogo("https://universityvalues.com/new/images/comodoBadge.png", "SC5", "none");
		</script>
		<script language="JavaScript" type="text/javascript">

      TrustLogo("/images/comodoBadge.png", "CL1", "none");

</script>-->
 <script language="JavaScript" src="https://secure.comodo.net/trustlogo/javascript/trustlogo.js" type="text/javascript"></script>
<!--<a href="http://www.instantssl.com" id="comodoTL">SSL</a>-->
<!--<script type="text/javascript">TrustLogo("https://universityvalues.com/images/comodosecurepadlock.png", "SC", "none");</script>-->
<img style="float:left;margin-right:20px;" src="https://universityvalues.com/images/comodosecurepadlock.png" />
<img style="float:left;margin-right:20px;" src="https://universityvalues.com/images/sucuriverifiedbagemedium.png" />
<a id="bbblink" class="rbvtbus" href="http://www.bbb.org/utah/business-reviews/advertising-mobile/university-values-in-west-jordan-ut-22302904#bbbseal" title="University Values Inc., Advertising  Mobile, West Jordan, UT" style="float:left;display: block;position: relative;overflow: hidden; width: 40px; height: 65px; margin: 0px; padding: 0px;margin-left:10px;"><img style="padding: 0px; border: none;" id="bbblinkimg" src="http://seal-utah.bbb.org/logo/rbvtbus/university-values-22302904.png" width="80" height="65" alt="University Values Inc., Advertising  Mobile, West Jordan, UT" /></a><script type="text/javascript">var bbbprotocol = ( ("https:" == document.location.protocol) ? "https://" : "http://" ); document.write(unescape("%3Cscript src='" + bbbprotocol + 'seal-utah.bbb.org' + unescape('%2Flogo%2Funiversity-values-22302904.js') + "' type='text/javascript'%3E%3C/script%3E"));</script>
<div style="clear:left;"></div>
<style type="text/css">
		.follow-count{
		background: none repeat scroll 0 0 #FFFFFF!important;
		border: 1px solid #CCCCCC!important;
		border-radius: 3px 3px 3px 3px!important;
		color: #333333!important;
		display: block!important;
		font-family: "lucida grande", tahoma, verdana, arial, sans-serif;
		line-height: 1!important;
		margin-bottom: 9px!important;
		padding: 8px 2px!important;
		position: relative!important;
		text-align: center!important;
	}
	.follow-count {
		width: 54px;
	}
	.follow-count:after {
		-moz-border-bottom-colors: none!important;
		-moz-border-left-colors: none!important;
		-moz-border-right-colors: none!important;
		-moz-border-top-colors: none!important;
		border-color: #FFFFFF transparent transparent!important;
		border-image: none!important;
		border-style: solid!important;
		border-width: 5px!important;
		bottom: -9px!important;
		content: "";
		left: 50%!important;
		margin-left: -5px!important;
		position: absolute!important;
	}	.Bh.gw{		background-color:#000!important;	}
		.socialnetwork{
			float:left;
		}
		.gapINsocial{
			padding-right:52px;
		}
		.topto{
			padding-top:10px;
		}
		.twitter-follow-button{
			width:63px!important;
		}
	</style>

		</div>
			<div style="padding-top: 10px;" class="foote1">&copy; 2009-2013 University Values, Inc. All Rights Reserved. &nbsp;| &nbsp;<span><a class="openTOS" href="#">Terms of Service</a></span> &nbsp;| &nbsp; <span><a class="openPrivacy" href="#">Privacy Policy</a></span></div>
			<div class="foote1" >University Values and the University Values logos are registered trademarks of University Values, Inc.</div><br>&nbsp;
		</td>
		<td width="10" align="center"><div style="width:1px; background-color:#808080; height:100px;"></div></td>
		<td width="419" valign="top">
			<div style="clear: both; padding: 6px;"></div>
			<div style="float: left; padding-left: 6px;">&nbsp;</div>
			<div style="float: left;">
<!-- 				<div class="socialnetwork gapINsocial"> -->
<!-- 					<span class='st_pinterest_vcount' displayText='Pinterest' st_url="https://www.universityvalues.com/index.php" st_title="university"></span> -->
<!-- 				</div> -->
<!-- 				<div class="socialnetwork gapINsocial"> -->
<!-- 					<span class='st_googleplus_vcount' displayText='Google +' st_url="https://www.universityvalues.com/index.php" st_title="university" ></span> -->
<!-- 				</div> -->
				<div class="socialnetwork gapINsocial topto">
					<div class="fb-like" data-href="http://facebook.com/universityvalues" data-send="false" data-layout="box_count" data-width="450" data-show-faces="true" data-font="verdana"></div>
				</div>
				<div class="socialnetwork topto">
					<?
					echo "<pre style='border-radius:3px; background:#fff; width:55px; font-family:Arial; padding:8px 5px; text-align:center; font-size:15px; margin:0px; border:1px solid #d3d3d3'>";
					//echo ($testCount[0]['user']['followers_count'])?$testCount[0]['user']['followers_count']:"31K+";
					echo getTwitterFollowers('Univ_Values');
					echo "</pre>";
					?>
					<div class="pluginCountBoxNub" style="position:relative;z-index:2;bottom:1px;height:7px;left:7px;width:0"><s style="border-color:#D3D3D3 transparent transparent;border-right:5px solid transparent;border-style:solid;border-width:5px;display:block;position:relative"></s><i style="border-color:#D3D3D3 transparent transparent;border-right:5px solid transparent;border-style:solid;border-width:5px;display:block;position:relative"></i></div>
					<div><a href="https://twitter.com/univ_values" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @univ_values</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div>
				</div>	
			</div>
		</td>
	</tr>
</table>
</div>
</div>
 <?php  if($front==1 || $_GET['state']!="") { } else { ?></div><?php } ?>

<? include_once('includes/boxes.php'); ?>
<div id="lightboxB"> </div>
<div id="lightbox"> </div>
<div id="clearbox"> </div>
</body>
</html>