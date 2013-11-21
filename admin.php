<?php
if (isset($_GET['action']) && $_GET['action'] == 'logoff') {
    session_start();
    session_destroy();
}
include_once('includes/main.php');
if (isset($_POST['userid'], $_POST['password'])) {
    if(!login($_POST['userid'],$_POST['password'])) $action = 'login';
    $uname = md5($_POST['userid']);
    $pwd = md5($_POST['password']);
    $result = mysql_query("SELECT * FROM admin WHERE admin_name='$uname' and pwd='$pwd'");
    $count = mysql_num_rows($result);
    if ($count == 1) {
        $_SESSION['adminuser'] = $uname;
    }
}
else
{
    if (!login_check()) $action = 'login';   
}

$uploadur_coupon = mysql_query("select * from coupons where issendforapprovel=1") or die(mysql_error());
$uploadur_couponResult = mysql_num_rows($uploadur_coupon);
if ($uploadur_couponResult > 0) {
    $coountcreauploadur_couponResult = "<spam style='color:green;'>(" . $uploadur_couponResult . ")</spam>";
} else {
    $coountcreauploadur_couponResult = "<spam style='color:red;'>(0)</spam>";
}
?>
<script src="js/jquery-1.6.2.js"></script>
<img border="0" src="new_images/University-Values-logo.png" alt="University Values">
<style type="text/css">
    /* Table Design */
    body{margin:0px; font-family: calibri;}
    input[type=text]
    { border: 1px solid #999;
      border-radius: 5px 5px 5px 5px;
      color: black;
      height: 27px;
      padding-left: 5px;
      width: 200px;}
    #ab table {
        border-collapse:collapse;
        background:#EFF4FB url(teaser.gif) repeat-x;
        /*border-left:1px solid #686868;
        border-right:1px solid #686868;
        /*font:1.1em/145% 'Trebuchet MS',helvetica,arial,verdana;*/
        color: #333;
    }

    td, th {
        padding:5px;
    }

    caption {
        padding: 0 0 .5em 0;
        text-align: left;
        font-size: 1.4em;
        font-weight: bold;
        text-transform: uppercase;
        color: #333;
        background: transparent;
    }

    /* =links
    ----------------------------------------------- */

    table a {
        color:#950000;
        text-decoration:none;
    }

    table a:link {}

    table a:visited {
        font-weight:normal;
        color:#666;
        text-decoration: line-through;
    }

    table a:hover {
        border-bottom: 1px dashed #bbb;
    }

    /* =head =foot
    ----------------------------------------------- */

    thead th, tfoot th, tfoot td {
        background:#333 repeat-x;
        color:#fff
    }

    tfoot td {
        text-align:right
    }

    /* =body
    ----------------------------------------------- */

    tbody th, tbody td {
        border-bottom: dotted 1px #333;		
    }

    tbody th {
        white-space: nowrap;
    }

    tbody th a {
        color:#333;
    }

    .odd {}

    /*tbody tr:hover {
                    background:#fafafa
    }*/
    hr{margin:5px 0;}
    .closeIt {
        cursor: pointer;
        position: relative;
        text-align: right;
        top: 9px;
        width: 102%;
    }
    #appTutorial-panel{
        display: none;
        left: 63%;
        margin-left: -394.5px;
        margin-top: -186px;
        padding: 0;
        position: fixed;
        top: 50%;
        z-index: 1001;
    }
    a {
        color: #89CE52;
        font-family: 'Calibri',serif;
        font-weight: bold;
    }
    img {
        border: medium none;
    }
    .appTutorialContent {
        background-color: #FFFFFF;
        border: 3px solid #92D050;
        font-family: 'Arial';

    }
    #lightbox {
        background: none repeat scroll 0 0 #000000;
        display: none;
        left: 0;
        min-height: 100%;
        min-width: 100%;
        opacity: 0.9;
        position: absolute;
        top: 0;
        z-index: 1000;
    }
</style>
<div id="lightbox" style="height: 1284px; top: 0px; display: none;"> </div>
<table width="100%" class="table_height" >

    <tr><td valign=top width="130">
            <?php if (isset($_SESSION['adminuser'])) { ?>
                Hello Admin,<br>
                <a  href="admin.php?action=changepwd" <?php if ($action == 'changepwd') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Change Password</a>
                <a  href="admin.php?action=logoff" <?php if ($action == 'logoff') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Log Off</a><br/><br />

                <a href="admin.php?action=manageaboutus" <?php if ($action == 'manageaboutus') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Manage About Us</a><hr/>

                <a href="admin.php?action=managecontactus" <?php if ($action == 'managecontactus') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Manage Contact Us</a><hr/>
                <a  href="admin.php?action=approvallist" <?php if ($action == 'approvallist') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?> id="color1" >Awaiting Approvals <?php echo $coountcreauploadur_couponResult; ?> </a><hr/>
                <a  href="admin.php?action=managenews" <?php if ($action == 'managenews') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?> id="color2"  >Manage News</a><hr/>
                <a  href="admin.php?action=businesses" <?php if ($action == 'businesses') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?> id="color3" >Businesses</a><hr/>

                <a href="admin.php?action=images" <?php if ($action == 'images') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?> >Cart Images</a><hr/>

                <a href="admin.php?action=consultations" <?php if ($action == 'consultations') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Consultations</a><hr/>

                <a href="admin.php?action=coupons" <?php if ($action == 'coupons') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Coupons</a><hr/>

                <a href="admin.php?action=codes" <?php if ($action == 'codes') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Invitation Codes</a><hr/>

                <a href="admin.php?action=featured" <?php if ($action == 'featured') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Featured Business</a><hr/>

                <a href="admin.php?action=requests" <?php if ($action == 'requests') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Info Requests</a><hr/>

                <a href="admin.php?action=newsletter" <?php if ($action == 'newsletter') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Newsletter</a><hr/>

                <a href="admin.php?action=prices" <?php if ($action == 'prices') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Prices</a><hr/>

                <a href="admin.php?action=promo" <?php if ($action == 'promo') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Promo Codes</a><hr/>

                <a href="admin.php?action=questions" <?php if ($action == 'questions') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Question Marks</a><hr/>

                <a href="admin.php?action=referrals" <?php if ($action == 'referrals') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Referrals</a><hr/>

                <a href="admin.php?action=schools" <?php if ($action == 'schools') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Schools</a><hr/>

                <a href="admin.php?action=users" <?php if ($action == 'users') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Advertising Consultants</a><hr/>

                <a href="admin.php?action=youtube" <?php if ($action == 'youtube') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>YouTube</a><hr/>

                <a href="admin.php?action=how_it_work" <?php if ($action == 'how_it_work') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>How It Works</a><hr/>

                <a href="admin.php?action=skiped_coupon" <?php if ($action == 'skiped_coupon') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Incomplete Businesses</a><hr/>

                <a href="admin.php?action=guidelines _text" <?php if ($action == 'guidelines _text') echo 'class="select_color"';
                else echo'style="color:#000;"'; ?>>Guidelines Text</a><hr/>
<?php } ?>
        </td>
        <td valign=top >
            <div id="ab">
<?php
if ($action) {
// 	error_reporting(E_ALL);
// 	ini_set("display_errors", 1);
// 	echo "including ".$action;
    include("admin/$action.php");
}
?>
            </div>

        </td></tr>
</table>
<script>
    $(".show_popup").click(function(evt) {
        var thisImageTagObj = $(this);
        if (thisImageTagObj)
            console.log("it's an object");
        else
            console.log("it's nothing");
        var thisImgSrc = thisImageTagObj.attr("src");
        console.log("new img src = " + thisImgSrc);
        $("#appTutorialImg").attr("src", thisImgSrc);
        $("#appTutorial-panel").css("display", "block");
        $("#appTutorial-panel,#lightbox").fadeIn(0);

    });
    $("a#close-appTutorial,#lightbox").click(function() {
        $("#appTutorial-panel,#lightbox").fadeOut(0);
        $("#appTutorial-panel").css("display", "none");

    });

</script>
<style>
    .select_color{

        text-shadow: 1px 1px #CCCCCC;
        color:#89CE52 !important;	
    }
</style>