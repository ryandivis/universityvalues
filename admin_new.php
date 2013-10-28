<?php
if (isset($_GET['action']) && $_GET['action'] == 'logoff') {

	session_start();

	session_destroy();
	
}

include_once('includes/main.php');

if (!isset($_SESSION['adminuser']))

	$action = 'login';

extract($_GET);

if(!isset($action)) $action = '';

if (isset($_POST['userid'], $_POST['password'])) {

	$uname = md5($_POST['userid']);

	$pwd = md5($_POST['password']);

	$result = mysql_query("SELECT * FROM admin WHERE admin_name='$uname' and pwd='$pwd'");

	$count = mysql_num_rows($result);

	if ($count == 1) {

		$_SESSION['nicename'] = $_POST['userid'];

		$_SESSION['adminuser'] = $uname;

	}

}

if (!isset($_SESSION['adminuser']))

	$action = 'login';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>University Values Admin :: Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
      tr.business {
      	cursor: pointer;
      }
      #navTabs{
      	margin-bottom:0px;
      	padding-bottom:0px;
      }
      .tab-pane { 
      	padding:10px 50px;
      	border: 1px solid #ddd;
      	border-top: 0px;
      }
      .tab-pane.active{
      	background:#fff;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">University Values Admin</a>
          <div class="nav-collapse collapse">
          <?php if($_SESSION['adminuser']): ?>
            <p class="navbar-text pull-right">
              Logged in as <a href="#" class="navbar-link"><?php echo $_SESSION['nicename']; ?></a>
              &nbsp;&nbsp;<a href="admin_new.php?action=logoff">Logout</a>
            </p>
           <?php endif;?>
            <ul class="nav">
              <!-- <li class="active"><a href="#">Home</a></li> -->
             <!--  <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li> -->
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
      <?php if(isset($_SESSION['adminuser'])): ?>
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Menu</li>
              <li <?php if ($action == 'manageaboutus') echo 'class="active"'?>><a href="admin_new.php?action=manageaboutus">Manage About Us</a></li>
              <li <?php if ($action == 'managecontactus') echo 'class="active"'?>><a href="admin_new.php?action=managecontactus">Manage Contact Us</a>
              <li <?php if ($action == 'approvallist') echo 'class="active"'?>><a  href="admin_new.php?action=approvallist" id="color1" >Awaiting Approvals <?php //echo $coountcreauploadur_couponResult; ?> </a></li>
              <li <?php if ($action == 'managenews') echo 'class="active"'?>><a  href="admin_new.php?action=managenews" id="color2">Manage News</a></li>
              <li <?php if ($action == 'businesses') echo 'class="active"'?>><a  href="admin_new.php?action=businesses" id="color3" >Businesses</a></li>
              <li <?php if ($action == 'images') echo 'class="active"'?>><a href="admin_new.php?action=images">Cart Images</a></li>
              <li <?php if ($action == 'consultations') echo 'class="active"'?>><a href="admin_new.php?action=consultations">Consultations</a></li>
              <li <?php if ($action == 'coupons') echo 'class="active"'?>><a href="admin_new.php?action=coupons">Coupons</a></li>
              <li <?php if ($action == 'codes') echo 'class="active"'?>><a href="admin_new.php?action=codes">Invitation Codes</a></li>
              <li <?php if ($action == 'featured') echo 'class="active"'?>><a href="admin_new.php?action=featured">Featured Business</a></li>
              <li <?php if ($action == 'requests') echo 'class="active"'?>><a href="admin_new.php?action=requests">Info Requests</a></li>
              <li <?php if ($action == 'newsletter') echo 'class="active"'?>><a href="admin_new.php?action=newsletter">Newsletter</a></li>
              <li <?php if ($action == 'prices') echo 'class="active"'?>><a href="admin_new.php?action=prices">Prices</a></li>
              <li <?php if ($action == 'promo') echo 'class="active"'?>><a href="admin_new.php?action=promo">Promo Codes</a></li>
              <li <?php if ($action == 'questions') echo 'class="active"'?>><a href="admin_new.php?action=questions">Question Marks</a></li>
              <li <?php if ($action == 'referrals') echo 'class="active"'?>><a href="admin_new.php?action=referrals">Referrals</a></li>
              <li <?php if ($action == 'schools') echo 'class="active"'?>><a href="admin_new.php?action=schools">Schools</a></li>
              <li <?php if ($action == 'users') echo 'class="active"'?>><a href="admin_new.php?action=users">Advertising Consultants</a></li>
              <li <?php if ($action == 'youtube') echo 'class="active"'?>><a href="admin_new.php?action=youtube">YouTube</a></li>
              <li <?php if ($action == 'how_it_work') echo 'class="active"'?>><a href="admin_new.php?action=how_it_work">How It Works</a></li>
              <li <?php if ($action == 'skiped_coupon') echo 'class="active"'?>><a href="admin_new.php?action=skiped_coupon">Incomplete Businesses</a></li>
              <li <?php if ($action == 'guidelines_text') echo 'class="active"'?>><a href="admin_new.php?action=guidelines_text">Guidelines Text</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
      <?php endif;?>
        <div class="span9">
          <?php 
            if($action != '')
            {
              if(is_file("admin/".$action."_new.php"))
              {
                include("admin/".$action."_new.php");
              }
              else
              {
                include("admin/$action.php");
              }
            } 
          ?>  
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; University Values 2013</p>
      </footer>

    </div><!--/.fluid-container-->

  </body>
</html>
