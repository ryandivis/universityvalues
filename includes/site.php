<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">


<head>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<title><?=$title?></title>


<link rel="stylesheet" type="text/css" href="css/style.css" />


<link rel="stylesheet" type="text/css" href="css/tablet.css" />


<link rel="stylesheet" type="text/css" href="css/ad-box.css" />


<?if($print == 1) { ?><link media="print" type="text/css" href="css/print.css" rel="stylesheet"><? } ?>


<link href='http://fonts.googleapis.com/css?family=Waiting+for+the+Sunrise' rel='stylesheet' type='text/css'>


<link href='http://fonts.googleapis.com/css?family=Rammetto+One' rel='stylesheet' type='text/css'>


<script src="../js/jquery-1.6.2.js"></script>	


<script type="text/javascript">


$(document).ready(function() {


 $("a#openAbout").click(function(){


    $("#lightbox, #aboutUs").animate({top:'0'},300);


    $("#lightbox").fadeIn(0);


 })


 $("a#openAdvert").click(function(){


    $("#lightbox, #advertising").animate({top:'0'},300);


    $("#lightbox").fadeIn(0);


 })


 $("a#closeAbout").click(function(){


         $("#lightbox,").fadeOut(300);


         $("#aboutUs").animate({top:'-800px'},300);


 })


 $("a#closeAdvert").click(function(){


         $("#lightbox,").fadeOut(300);


         $("#advertising").animate({top:'-800px'},300);


 })


 $("div#lightbox").click(function(){


         $("#lightbox,").fadeOut(300);


         $("#advertising, #aboutUs").animate({top:'-800px'},300);


 })


});


</script>


<?php


if($code == 1)


{


?>	


	<script src="lib/raphael.js"></script>


	<!-- <script src="scale.raphael.js"></script> -->


	<script src="js/color.jquery.js"></script>


	<script src="js/jquery.usmap.js"></script>


	<script>


	$(document).ready(function() {


	  $('#map').usmap({


	    	stateHoverStyles: {fill: '#8fc741'},    


	    'click' : function(event, data) {
		//alert('state clicked: ' + data.name);

		window.location = 'school.php?state='+data.name;


	    }


	  });


 	});


	</script>


<?php } else if($code == 2) { ?>


<script type="text/javascript">


$(document).ready(function(){


 $("a#show-print").click(function(){


    $("#lightbox, #print-panel").fadeIn(300);


 })


 $("a#close-print").click(function(){


     $("#lightbox, #print-panel").fadeOut(300);


 })


 $("a#show-social").click(function(){


    $("#lightbox, #socialMediaShare").fadeIn(300);


 })


 $("a#close-print").click(function(){


     $("#lightbox, #socialMediaShare").fadeOut(300);


 })


 $("div#lightbox").click(function(){


     $("#lightbox, #print-panel, #socialMediaShare").fadeOut(300);


 })


})


</script>


<? } ?>


</head>


<body>


<div id="main-wrapper">


 <div id="top-nav-wrapper">


    <div id="logo"><a href="index.php"><img src="http://www.warnerdata.com/uv/images/uv-logo-2.png" alt="University Values" border=0 /></a></div>


    <div id="slogan"><img src="images/slogan.png" /></div>


    <div id="top-buttons">


    <a href="#" id="openAbout"><img src="images/about-button.png" border=0 alt="About Us" /></a>


    <a href="#" id="openAdvert"><img src="images/advertise-button.png" border=0 alt="Advertising" /></a>


    </div>


    <div id="social-widget">


    <div>


	<div style="float:left; padding:3px;"><a href="###"><img src="images/SocialBox/blog.png" border=0 alt="Blog" /></a></div>


	<div style="float:left; padding:3px;"><a href="###"><img src="images/SocialBox/fb.png" border=0 alt="Facebook" /></a></div>


	<div style="float:left; padding:3px;"><a href="###"><img src="images/SocialBox/tw.png" border=0 alt="Twitter" /></a></div>


	<div style="float:left; padding:3px;"><a href="###"><img src="images/SocialBox/gg.png" border=0 alt="Google Plus" /></a></div>


	<div style="float:left; padding:3px;"><a href="###"><img src="images/SocialBox/yt.png" border=0 alt="YouTube" /></a></div>


    </div>


    </div>


 </div><!-- end top nav wrapper-->


</div><!-- end main wrapper-->


<div id="body-background">


 <div id="inner-body-control">








<?





include_once('includes/main.php');








if(!is_numeric($_GET[coupon]))


	header('Location: index.php');





$select = "SELECT * FROM coupons WHERE cid='$_GET[coupon]' LIMIT 1";


$result = mysql_query($select) or die(mysql_error());


$coupon = mysql_fetch_array($result);





$select = "SELECT * FROM location_tie WHERE cid='$_GET[coupon]'";


$result = mysql_query($select) or die(mysql_error());








while($location = mysql_fetch_array($result))


{


	$select = "SELECT * FROM locations WHERE lid='$location[lid]'";


	$resultb = mysql_query($select) or die(mysql_error());


	$locations[] = mysql_fetch_array($resultb);


}





$select = "SELECT * FROM businesses WHERE pid='$coupon[pid]' LIMIT 1";


$result = mysql_query($select) or die(mysql_error());


$business = mysql_fetch_array($result);








$selectb = "SELECT * FROM schools WHERE sid='$_GET[school]' LIMIT 1";


$resultb = mysql_query($selectb) or die(mysql_error());


$theschool = mysql_fetch_array($resultb);





$title = "$business[business] coupon's for $theschool[1] students";


$print = 1;


$code = 2;


include_once('includes/top.php');


?>





<table>


<tr><td>


	<?=$leftCol?>		


</td><td>	


	<?=$mainCol?>


</td><td>


	<?=$rightCol?>


</td></tr>


</table>





 </div> <!-- end inner body control-->


 <div id="lower-third-wrapper">


 <table>


 <tr><td width=150></td><td>


 <table style="margin-top:-50px;" cellspacing=0 cellpadding=0>


 <tr><td colspan=3><img src="images/ad-box/frame/top-blnk.png" style="margin-left:-9px;" /></td></tr>


 <tr>


 <td><img src="images/ad-box/frame/left.png" /></td>


 <td width=320>       				<div id="widgetHolder" style="position:relative; top:-10px; left:30px;">			<!---- Begin Widget Holder For Money Details ------->


       				<div id="money-widget"><div style="width:120px; height:40px; float:left; "><p class="cursive" style="font-size:18px;">Money Saved: </p></div>


                    <div style="float:left; height:20px; margin-top:20px;"><p class="cursive" style="float:left;">


                    <div class="cursive" style="float:left; font-size:20px;">$ </div> 


                    <div style="float:left; padding:3px;"><img src="images/SocialBox/MoneyCounter/zero.png" /></div>


                    <div style="float:left; padding:3px;"><img src="images/SocialBox/MoneyCounter/zero.png" /></div>


                    <div style="float:left; padding:3px;"><img src="images/SocialBox/MoneyCounter/zero.png" /></div>


                    <div  class="cursive" style="float:left;  font-size:20px;"> ,</div> 


                    <div style="float:left; padding:3px;"><img src="images/SocialBox/MoneyCounter/zero.png" /></div>


                    <div style="float:left; padding:3px;"><img src="images/SocialBox/MoneyCounter/zero.png" /></div>


                    <div style="float:left; padding:3px;"><img src="images/SocialBox/MoneyCounter/zero.png" /></div></div></div>


       				<div id="money-widget"><div class="cursive" style="font-size:20px; float:left; margin-top:10px; margin-left:10px;">Over 100,000 Values Redeemed</div></div>


					</div> 


 </td>


 <td>


 <img src="images/ad-box/frame/right-blnk.png" style="margin-left:1px;" />


 </td></tr>


 <tr><td colspan=3><img src="images/ad-box/frame/bot.png" /></td></tr>


 </table>


 </td>


 <td width=50></td>


 <td>


 <table style="margin-top:-50px;" cellspacing=0 cellpadding=0>


 <tr><td colspan=3><img src="images/ad-box/frame/top-blnk.png" style="margin-left:-9px;" /></td></tr>


 <tr>


 <td><img src="images/ad-box/frame/left.png" /></td>


 <td width=320>


 <div id="feat-wrapper" > <!---- begin feat wrapper ------>


 <div id="ad-box1"><img src="images/ad-box/ad1.png" /></div>


 <div id="ad-box2"><img src="images/ad-box/ad2.png" /></div>


 <div id="ad-box3"><img src="images/ad-box/ad3.png" /></div>


 <div id="ad-box4"><img src="images/ad-box/ad4.png" /></div>


 <br style="clear:left;" />


 <div id="ad-box1"><img src="images/ad-box/ad5.png" /></div>


 <div id="ad-box2"><img src="images/ad-box/ad6.png" /></div>


 <div id="ad-box3"><img src="images/ad-box/ad7.png" /></div>


 <div id="ad-box4"><img src="images/ad-box/ad8.png" /></div>


 </div> 


 </td>


 <td>


 <img src="images/ad-box/frame/right-blnk.png" style="margin-left:1px;" />


 </td></tr>


 <tr><td colspan=3><img src="images/ad-box/frame/bot.png" /></td></tr>


 </table>


 </td>


 </tr>


 </table>


 </div> <!-- end lower-third-wrapper -- >


</div> <!-- end body-background -->


<div id="Underwear">


 <div id="lower-bg-footer">


 <center>


  <div id="footer-fixed-bg">


   <div id="left-footer-content"><p class="footer"> &copy; 2012 University Values. All Rights Reserved.</p></div>


   <div id="right-footer-content">


    <div id="right-footer-widget">


     <!----   Lower Footer Containers For Counters -------->


     <div id="comodo" style="float:left; padding:3px; padding-right:9px;"><img src="images/comodoBadge.png" /></div>


     <div id="fbcounter" style="float:left; padding:3px; margin-top:10px;"><img src="images/googleCounter.png" /></div>


     <div id="googleCounter" style="float:left; padding:3px; margin-top:10px;"><img src="images/fbCounter.png" /></div>


     <div id="twitterCount" style="float:left; padding:3px; margin-top:10px;"><img src="images/twitterCounter.png" /></div> 


     <!----   Lower Footer Containers For Counters -------->


    </div><!-- end right widget -->


   </div> <!-- end right footer content -->


  </div> <!--end footer fixed bg -->


 </center>


 </div> <!--end lower-bg-footer-->


</div> <!--end Underwear-->





<div id="aboutUs">


  <div class="popContent">


  <a href="index.php"><img src="images/uv-logo-2.png" border=0 alt="Home" style="float:left;"/></a><h3 class="funky uppercase">About Us</h3>


  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et urna erat, sed ullamcorper enim. Maecenas eu venenatis metus. Mauris tortor eros, condimentum vel faucibus ac, commodo fermentum magna. Fusce posuere interdum arcu, eget ornare eros tempus et. Maecenas convallis faucibus sem sed commodo. Donec leo nisi, consequat sed luctus eu, pellentesque eu nibh. Vivamus sed quam a tortor lobortis iaculis. Phasellus et odio sed tortor interdum accumsan. Duis tempor condimentum rhoncus. Maecenas lacinia, nulla ac adipiscing mollis, augue felis luctus lectus, quis ultrices nisl odio a diam. Nam massa sapien, consequat nec mollis eget, sodales ac velit. Maecenas vehicula, ante eu rutrum elementum, lorem urna luctus libero, at pulvinar leo turpis et quam. Maecenas tristique pharetra placerat. Nam a justo risus. Nam felis nibh, adipiscing id ornare ac, malesuada sed mauris. Suspendisse potenti.


  <p>Quisque ullamcorper tortor eget quam fermentum nec laoreet est pharetra. Nullam vel massa id magna imperdiet faucibus in eleifend leo. Etiam tincidunt tellus neque, sit amet sodales lacus. Nullam venenatis rutrum blandit. Etiam id lorem id nisi elementum lobortis. Curabitur ac condimentum erat. Nam fermentum dictum pretium. Fusce feugiat, purus nec pellentesque porttitor, nisl diam pharetra enim, et lobortis nibh orci venenatis orci. Sed nibh odio, facilisis a cursus nec, tristique in orci. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris massa neque, tincidunt a sollicitudin eu, tincidunt et arcu. Duis mauris felis, feugiat pretium sodales sagittis, facilisis aliquam diam. Quisque tristique, turpis vitae tincidunt venenatis, nibh diam ornare tellus, sed egestas mauris velit quis magna. Aenean convallis molestie neque, eu dictum neque pretium eget. Phasellus ut orci vel ligula mollis mollis vitae eget augue. Maecenas vitae risus purus. Quisque justo tortor, congue eu tincidunt ut, ultricies a mauris. Aliquam vel eleifend turpis. Nulla facilisi.


  </div>


 <div class="popFooter">


 <div class="popContent">


  <a href="#" id="closeAbout"><img src="images/close-about.png" border=0 alt="Close About Us"/></a>


 </div>


 </div>


</div>


<div id="advertising">


	<div class="popContent">


	 <a href="index.php"><img src="images/uv-logo-2.png" border=0 alt="Home" style="float:left;"/></a><h3 class="funky uppercase">Advertising</h3>


 		<div class="request leftside">


		 <form method=post action="requestInfo.php">


		 <input type=text name="name" value="Name">


		 <input type=text name="business" value="Business">


		 <input type=text name="email" value="Email">


		 <input type=text name="phone" value="Phone">


		 <textarea name="message">Message</textarea>


		 <input type="submit" value="Submit">


		 </form>


		</div>


		<div class="login rightside">


		 <form method=post action="login.php">


		 <input type=text name="email" value="Email">


		 <input type=password name="password" value="Password">


		 <div class="leftside">


		  <a href="forgotpassword.php">Forgot your password?</a>


		 </div>


		 <div class="rightside"><input type="submit" value="Login"></div>


		 </form>


		 <form method=post action="signup.php">


		 <input type=text name="code" value="Invitation Code"><input type="submit" value="Enter">


		 </form>


		</div>


	</div>


	<div class="popFooter">


	 <div class="popContent">


	  <a href="#" id="closeAdvert"><img src="images/close-advert.png" border=0 alt="Close Advertising"/></a>


	 </div>


	</div>


</div>


<div id="lightbox"> </div>


</body>


</html>