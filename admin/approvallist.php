<?php

function getNumCouponLocationsForCouponWithId($couponId){
    echo "<script>console.log(\"BEGIN: getNumCouponLocationsForCouponWithId, couponId: $couponId\");</script>";
    $sql = "SELECT COUNT(*) as count FROM location_tie WHERE cid='$couponId'";
    echo "<script>console.log(\"QUERY: $sql\");</script>";
    $result = mysql_query($sql);
    $resultArray = mysql_fetch_array($result);
    return $resultArray['count'];
}

function getCouponIdCommaListForAllAwaitingApprovalCoupons() {
    $couponIdCommaList = "";
    $couponIdArray = array();
    $couponsPendingApprovalResult = mysql_query("SELECT cid FROM coupons WHERE issendforapprovel=1 ORDER BY updatetime DESC") or die(mysql_error());
    while ($row = mysql_fetch_assoc($couponsPendingApprovalResult))
        $couponIdArray[] = $row['cid'];

    $couponIdCommaList = implode("','", $couponIdArray);
    return $couponIdCommaList;
}

function getCouponListResultForPendingCouponsWithTypeId($typeId) {
    $couponIdCommaList = getCouponIdCommaListForAllAwaitingApprovalCoupons();
    echo "<script>console.log(\"COUPON ID COMMA LIST: $couponIdCommaList\");</script>";
    $query = "SELECT * FROM pending_coupon_edits WHERE cid IN ('$couponIdCommaList') AND type='$typeId' ORDER BY updatetime DESC";
    echo "<script>console.log(\"QUERY: $query\");</script>";
    return mysql_query($query);
}

function approveCouponWithId($couponId) {
    // copy data from pending_coupon_edits table to coupons table
    copyCouponDataFromPendingCouponEditsToCouponsTableWithCouponId($couponId);
    // set issendforapprovel = 0 and active = 1
    $updateValues = getUnsetAwaitingApprovalQueryClause() . ", active='1'";
    updateCouponTableWithValuesAndId($updateValues, $couponId);
    // delete row from pending_coupon_edits
    deleteCouponFromPendingTableWithId($couponId);
}

function dontApproveCouponWithId($couponId) {
    $select_files = "SELECT
                            coupons.built_into_your_coupon AS current_zip_file,
                            coupons.custom_image AS current_img,
                            coupons.template_image AS current_template_img,
                            pending_coupon_edits.built_into_your_coupon AS update_zip_file,
                            pending_coupon_edits.custom_image AS update_img,
                            pending_coupon_edits.template_image AS update_template_img
                        FROM coupons, pending_coupon_edits WHERE coupons.cid = '$couponId' AND pending_coupon_edits.cid = '$couponId'";
    $result = mysql_query($select_files) or die("Select coupon files: " . mysql_error());
    $file_set = mysql_fetch_assoc($result);
    if ($file_set['current_zip_file'] != $file_set['update_zip_file'])
        unlink($file_set['update_zip_file']);
    else if ($file_set['current_img'] != $file_set['update_img'])
        unlink($file_set['update_img']);
    else if ($file_set['current_template_img'] != $file_set['update_template_img'])
        unlink($file_set['update_template_img']);
    // delete row from pending_coupon_edits
    deleteCouponFromPendingTableWithId($couponId);
    // set issendforapprovel = 0 and lastMonthlyEdit = 1 month ago
    $updateValues = getUnsetAwaitingApprovalQueryClause() . ", " . getGiveBackEditQueryClause();
    updateCouponTableWithValuesAndId($updateValues, $couponId);
}

function sendApprovalEmail($couponId) {
    $query = "SELECT businesses.email, businesses.name FROM coupons JOIN businesses ON coupons.pid = businesses.pid WHERE coupons.cid='$couponId'";
    $result = mysql_query($query);
    $email_info = mysql_fetch_object($result);
    $headers = "From: University Values <support@universityvalues.com>\r\n";
    $head1 = "Congratulations, Your Coupon Is Live!";
    $approvesub = "Congratulations, Your Coupon Is Live!";
    $approvemsg =
            "Hi $email_info->name,<br><br>
            We are pleased to announce that your coupon has been approved and is live on the <a href='http://universityvalues.com'>University Values Apple and Android App and Website!</a><br><br>
            If you have any questions please don't hesitate to give us a call.<br><br>
            Thank you for helping to make University Values the most successful way to reach the students near you!<br><br>
            <i>-Your University Values Team</i>";
    sendmail($email_info->email, $approvesub, $approvemsg, $headers, $head1);
}

function copyCouponDataFromPendingCouponEditsToCouponsTableWithCouponId($couponId) {
    $pendingCouponEditResult = mysql_query("SELECT * FROM pending_coupon_edits WHERE cid='$couponId'") or die(mysql_error());
    $pendingCouponEditCoupon = mysql_fetch_assoc($pendingCouponEditResult);
    $valuesArray = array();
    foreach ($pendingCouponEditCoupon as $key => $value) {
        // don't set cid on coupons table
        if (strcasecmp($key, "cid") == 0)
            continue;
        $valuesArray[] = "$key='$value'";
    }
    $valuesString = implode(",", $valuesArray);
    updateCouponTableWithValuesAndId($valuesString, $couponId);
}

function deleteCouponFromPendingTableWithId($couponId) {
    $query = "DELETE FROM pending_coupon_edits WHERE cid='$couponId'";
    $result = mysql_query($query) or die(mysql_error());
}

function getGiveBackEditQueryClause() {
    $oneMonthAgo = date("Y-m-d H:i:s", strtotime("last month"));
    return "lastMonthlyEdit='$oneMonthAgo'";
}

function getUnsetAwaitingApprovalQueryClause() {
    return "issendforapprovel='0'";
}

function updateCouponTableWithValuesAndId($values, $couponId) {
    $query = "UPDATE coupons SET $values WHERE cid='$couponId'";
    $result = mysql_query($query) or die(mysql_error());
}

function getNumPendingCouponsWithType($type){
    // type = type code (1, 2, or 3)
    $sql = "SELECT COUNT(*) as count FROM coupons INNER JOIN pending_coupon_edits ON coupons.cid = pending_coupon_edits.cid WHERE coupons.issendforapprovel = 1 AND pending_coupon_edits.type = '$type'";
    $result = mysql_query($sql);
    $resultArray = mysql_fetch_assoc($result);
    $count = $resultArray['count'];
    return $count;
}

$create_ur_couponResult = getNumPendingCouponsWithType(1);
if ($create_ur_couponResult > 0) {
    $coountcreatecoupons = "<span style='color:green;'>(" . $create_ur_couponResult . ") Coupons Awaiting in this category</span>";
} else {
    $coountcreatecoupons = "<span style='color:red;'>Sorry..! there are no coupons in this category</span>";
}


$UV_coupon_couponResult = getNumPendingCouponsWithType(2);
if ($UV_coupon_couponResult > 0) {
    $UV_coupon_couponResult1 = "<span style='color:green;'>(" . $UV_coupon_couponResult . ") Coupons Awaiting in this category</span>";
} else {
    $UV_coupon_couponResult1 = "<span style='color:red;'>Sorry..! there are no coupons in this category</span>";
}


$uploadur_couponResult = getNumPendingCouponsWithType(3);
if ($uploadur_couponResult > 0) {
    $coountcreauploadur_couponResult = "<span style='color:green;'>(" . $uploadur_couponResult . ") Coupons Awaiting in this category</span>";
} else {
    $coountcreauploadur_couponResult = "<span style='color:red;'>Sorry..! there are no coupons in this category</span>";
}
?>
<div id="appTutorial-panel" style="left:100px; margin-left:0px; top:10px; margin-top:0px;">
    <div class="closeIt">
        <a id="close-appTutorial"><img src="<?= $url ?>/images/closeIt.png" border=0 alt="Close"></a>
    </div>
    <div class="appTutorialContent">
        <img id="appTutorialImg" src="<?php /* echo $getalllistarr['custom_image'] */ ?>" style="max-width:960px; max-height:800px;"  />
    </div>
</div>
<center>
    <table width="70%">
        <tr>
            <td><h2>Awaiting Approvals list</h2></td>
        </tr>
        <tr>
            <td><a href="admin.php?action=approvallist&page=create_ur_coupon&cat_id=1">Create Your Coupon Awaiting Approvals</a> &nbsp;&nbsp;<?php echo $coountcreatecoupons; ?></td>
        </tr>
        <tr>
            <td><a href="admin.php?action=approvallist&page=uvdesign_coupon">UV Coupon Design Awaiting Approvals</a> &nbsp;&nbsp;<?php echo $UV_coupon_couponResult1; ?></td>
        </tr>
        <tr>
            <td><a href="admin.php?action=approvallist&page=upload_coupon&cat_id=1">Upload Your Coupon Awaiting Approvals</a> &nbsp;&nbsp;<?php echo $coountcreauploadur_couponResult; ?></td>
        </tr>
    </table>
</center>
<?php
$cat_id = $_REQUEST['cat_id'];
$page = $_GET['page'];
if ($page == "create_ur_coupon") {
    $appmsg = '';
    if (isset($_GET['approveid'])) {
        // get coupon category that was set in the approval table
        $categoryid = $_REQUEST['category'];
        // get coupon id from $_GET['approveid']
        $approveid = mysql_real_escape_string($_GET['approveid']);
        // approve the coupon (see function at top of document)
        approveCouponWithId($approveid);
// 		$stdate = time();
        $getcoupondetail = mysql_query("select * from coupons where cid='$approveid'");
        if (mysql_num_rows($getcoupondetail)) {
            $getcoupondetailarr = mysql_fetch_array($getcoupondetail);
            // get new custom_image (path) value
            $newimgpath = str_replace('temp', 'livecoupons', $getcoupondetailarr['custom_image']);
            // move image to new path
            if (copy($getcoupondetailarr['custom_image'], $newimgpath))
                unlink($getcoupondetailarr['custom_image']);
            else
                $newimgpath = $getcoupondetailarr['custom_image'];

// 			$updqry = mysql_query("update coupons set active=1,startdate='$stdate',custom_image='$newimgpath',category='$categoryid' where cid='$approveid'");
            updateCouponTableWithValuesAndId("custom_image='$newimgpath', category='$categoryid'", $approveid);
// 			if ($updqry && mysql_affected_rows() > 0)
            echo '<script>window.location.href="admin.php?action=approvallist";</script>';
// 			else
// 				$appmsg = 'Sorry, an error occured and your coupon was not approved. Please try again.';
        }
        sendApprovalEmail($approveid);
    }

    else if (isset($_GET['denyid'])) {
        $categoryid = $_REQUEST['category'];
        // get coupon id from $_GET['approveid']
        $denyid = mysql_real_escape_string($_GET['denyid']);
        // deny the coupon (see function at top of document)
        dontApproveCouponWithId($denyid);
    }
    ?>
    <title> UV Coupon Design Awaiting Approvals - Admin Panel University Values</title>
    <script type="text/javascript">
        function validateit(validid)
        {
            var fup = document.getElementById(validid);
            var fileName = fup.value;
            var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
            ext.toLowerCase();
            //alert(fup.value+' '+ext);
            if (fup.value == '')
            {
                alert('Please Select an image file then approve it.');
                return false;
            }
            else {
                if (ext == "gif" || ext == "jpeg" || ext == "jpg" || ext == "png")
                    return true;
                else
                {
                    alert('Please Select an image file then approve it.');
                    return false;
                }

            }
        }
    </script>
    <center>
        <h2>Create Your Coupon Awaiting Approvals</h2>
        <table width="95%">
    <?php if ($appmsg != '') echo "<tr><td colspan='6'>$appmsg</td></tr>"; ?>
            <tr><th>Coupon Id</th>
                <th>Date</th>
                <th>Advertiser Name</th>
                <th>PID - Business Name</th>
                <th>Next Bill Date</th>
                <th>coupon Image</th>
                <th># Locations</th>

                <th>Approve</th>
            </tr>	
            <?php
            $getalllist = getCouponListResultForPendingCouponsWithTypeId(1);
            if (mysql_num_rows($getalllist))
                while ($getalllistarr = mysql_fetch_array($getalllist)) {
                    $result = mysql_query("SELECT name FROM  businesses WHERE pid='$getalllistarr[pid]'") or die(mysql_error());
                    $row = mysql_fetch_array($result);
                    $numCouponLocations = getNumCouponLocationsForCouponWithId($getalllistarr['cid']);
                    ?>
                    <tr>
                        <td align="center"><?php echo $getalllistarr['cid'] ?></td>
                        <td align="center"><?php echo date('m/d/Y', $getalllistarr['updatetime']) ?></td>
                        <td align="center"><?php echo $row['name'] ?></td>
                        <td align="center"><?php echo $getalllistarr['pid'] . ' - ' . $getalllistarr['business'] ?></td>
                        <td align="center"><?php echo date('m/d/Y', $getalllistarr[endDate]) ?></td>
                        <td align="center">
            <?php if ($getalllistarr['type'] == 2) { ?>
                                <a href="<?php echo $getalllistarr['custom_image'] ?>">Download ZIP File</a>
                            <?php } else { ?>
                                <img class="show_popup" src="<?php echo $getalllistarr['custom_image'] ?>" width="100" />

            <?php } ?>
                            
                        </td>
                        <td align="center"><?=$numCouponLocations?></td>
                        <td align="center">
                            <select name="category" id="category" onchange="fun_redirect(this.value)">
                                <option <?php if ($cat_id == 1) echo 'selected="selected"'; ?>value="1">Live</option>
                                <option <?php if ($cat_id == 2) echo 'selected="selected"'; ?> value="2">Eat</option>
                                <option <?php if ($cat_id == 3) echo 'selected="selected"'; ?> value="3">Play</option>
                            </select><br />
                            <a href="admin.php?action=approvallist&category=<?php echo $cat_id; ?>&page=create_ur_coupon&approveid=<?php echo $getalllistarr['cid']; ?>">Approve coupon</a><br />
                            <a href="admin.php?action=approvallist&category=<?php echo $cat_id; ?>&page=create_ur_coupon&denyid=<?php echo $getalllistarr['cid']; ?>">Dont Approve coupon</a>
                        </td>
                    </tr>
        <?php }
    else echo "<tr><td colspan='5' align='center'>Sorry, No data for approval</td></tr>"; ?>	
        </table>
    </center>
<?php
} elseif ($page == "uvdesign_coupon") {
    $appmsg = '';
    if (isset($_POST['approveid']) && isset($_POST['approveCoupon'])) {
        // get coupon id from $_POST['approveid']
        $approveid = mysql_real_escape_string($_POST['approveid']);
        // get coupon category id that was set in the approval table
        $categoryid = $_REQUEST['category'];
// 		$stdate = time();
        approveCouponWithId($approveid);
        $getcoupondetail = mysql_query("select * from coupons where cid='$approveid'");
        if (mysql_num_rows($getcoupondetail)) {
            $getcoupondetailarr = mysql_fetch_array($getcoupondetail);
            $zipfilepath = $getcoupondetailarr['custom_image'];
            // if UV custom coupon image was uploaded successfully in the form...
            if ($_FILES['newcoupon']['error'] <= 0) {
                // set custom_image value
                $newimgpath = 'images/livecoupans/' . $_FILES['newcoupon']['name'];
                if (move_uploaded_file($_FILES["newcoupon"]["tmp_name"], $newimgpath)) {
// 					$updqry = mysql_query("update coupons set active=1,startdate='$stdate',custom_image='$newimgpath',template_image='$zipfilepath',category='$categoryid' where cid='$approveid'");
                    updateCouponTableWithValuesAndId("custom_image='$newimgpath', template_image='$zipfilepath', category='$categoryid'", $approveid);
                    if (mysql_affected_rows() > 0)// 					if ($updqry && mysql_affected_rows() > 0)
                        $appmsg = 'Coupon Approved Successfully';
                    else
                        $appmsg = 'Sorry, an error occured and your coupon was not approved. Please try again.';
                } else {
                    $appmsg = 'Sorry, an error occured and your coupon was not approved. Please try again.';
                }
            } else {
                $appmsg = 'Sorry, an error occured while attempting to upload the coupon image.';
            }
        }
        sendApprovalEmail($approveid);
    } else if (isset($_GET['approveid']) && isset($_GET['approveCoupon'])) {
        // get coupon id from $_GET['approveid']
        $approveid = mysql_real_escape_string($_GET['approveid']);
// 		$stdate = time();
        approveCouponWithId($approveid);
        $getcoupondetail = mysql_query("select * from coupons where cid='$approveid'");
        if (mysql_num_rows($getcoupondetail)) {
            $getcoupondetailarr = mysql_fetch_array($getcoupondetail);
            $newimgpath = str_replace('temp', 'livecoupons', $getcoupondetailarr['custom_image']);
            if (copy($getcoupondetailarr['custom_image'], $newimgpath))
                unlink($getcoupondetailarr['custom_image']);
            else
                $newimgpath = $getcoupondetailarr['custom_image'];

// 			$updqry = mysql_query("update coupons set active=1,startdate='$stdate',custom_image='$newimgpath' where cid='$approveid'");
            updateCouponTableWithValuesAndId("custom_image='$newimgpath'", $approveid);
            if (mysql_affected_rows() > 0)// 			if ($updqry && mysql_affected_rows() > 0)
                $appmsg = 'Coupon Approved Successfully';
            else
                $appmsg = 'Sorry, an error occured coupon not approved, please try again.';
        }
        sendApprovalEmail($approveid);
    }

    else if (isset($_POST['denyid']) && isset($_POST['denyCoupon'])) {
        $categoryid = $_REQUEST['category'];
        // get coupon id from $_GET['approveid']
        $denyid = mysql_real_escape_string($_POST['denyid']);
        // deny the coupon (see function at top of document)
        dontApproveCouponWithId($denyid);
        echo "<script>console.log('Hit Deny: $denyid');</script>";
    } else if (isset($_GET['denyid']) && isset($_GET['denyCoupon'])) {
        $categoryid = $_REQUEST['category'];
        // get coupon id from $_GET['approveid']
        $denyid = mysql_real_escape_string($_GET['denyid']);
        // deny the coupon (see function at top of document)
        dontApproveCouponWithId($denyid);
        echo "<script>console.log('Hit Deny: $denyid');</script>";
    }
    ?>
    <title> Create Your Coupon Awaiting Approvals - Admin Panel University Values</title>
    <script type="text/javascript">
        function validateit(validid)
        {
            var fup = document.getElementById(validid);
            var fileName = fup.value;
            var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
            ext.toLowerCase();
            //alert(fup.value+' '+ext);
            if (fup.value == '')
            {
                alert('Please Select an image file then approve it.');
                return false;
            }
            else {
                if (ext == "gif" || ext == "jpeg" || ext == "jpg" || ext == "png")
                    return true;
                else
                {
                    alert('Please Select an image file then approve it.');
                    return false;
                }

            }
        }
    </script>
    <center>
        <h2>UV Coupon Design Awaiting Approvals</h2>
        <table width="95%">
    <?php if ($appmsg != '') echo "<tr><td colspan='5'>$appmsg</td></tr>"; ?>
            <tr><th>Coupon Id</th>
                <th>Advertiser Name</th>
                <th>Date</th>
                <th>PID - Business Name</th>
                <th>Next Bill Date</th>
                <th>Offer For Coupon</th>
                <th>Add about Offer</th>
                <th>Included Coupon Design</th>
                <th>Built into Coupon</th>
                <th>coupon Image</th>
                <th># Locations</th>
                <th>Approve</th>

            </tr>	
    <?php
    $getalllist = getCouponListResultForPendingCouponsWithTypeId(2);
    if (mysql_num_rows($getalllist))
        while ($getalllistarr = mysql_fetch_array($getalllist)) {
            $result = mysql_query("SELECT name FROM  businesses WHERE pid='$getalllistarr[pid]'") or die(mysql_error());
            $row = mysql_fetch_array($result);
            $numCouponLocations = getNumCouponLocationsForCouponWithId($getalllistarr['cid']);
            ?>
                    <tr>
                        <td align="center"><?php echo $getalllistarr['cid'] ?></td>
                        <td align="center"><?php echo date('m/d/Y', $getalllistarr['updatetime']) ?></td>
                        <td align="center"><?php echo $row['name'] ?></td>
                        <td align="center"><?php echo $getalllistarr['pid'] . ' - ' . $getalllistarr['business'] ?></td>
                        <td align="center"><?php echo date('m/d/Y', $getalllistarr[endDate]) ?></td>
                        <td align="center"><?php echo $getalllistarr['offers_for_your_coupon'] ?></td>
                        <td align="center"><?php echo $getalllistarr['add_about_your_offer'] ?></td>
                        <td align="center"><?php echo $getalllistarr['included_coupon_design'] ?></td>
                        <td align="center"><a href="<?php echo $getalllistarr['built_into_your_coupon'] ?>">Download Zip file</a></td>
                        <td align="center">
                            <img class="show_popup" src="<?php echo $getalllistarr['custom_image'] ?>" width="100" />
                        </td>
                        <td align="center"><?=$numCouponLocations?></td>
                        <td align="center">
            <?php if ($getalllistarr['type'] == 2) { ?>
                                <form enctype="multipart/form-data" action="admin.php?action=approvallist&page=uvdesign_coupon" method="post">
                                    <input name="approveid" type="hidden" value="<?php echo $getalllistarr['cid']; ?>" />
                                    <input name="denyid" type="hidden" value="<?php echo $getalllistarr['cid']; ?>" />
                                    <input type="file" name="newcoupon" id="newcoupon<?php echo $getalllistarr['cid']; ?>"/><br />
                                    <input type="submit" name="approveCoupon" value="Approve coupon" onclick="return validateit('newcoupon<?php echo $getalllistarr['cid']; ?>');" />
                                    <input type="submit" name="denyCoupon"value="Deny coupon" /><br />


                                    <select name="category">
                                        <option value="1">Live</option>
                                        <option value="2">Eat</option>
                                        <option value="3">Play</option>
                                    </select><br />
                                </form>
            <?php } ?>
                        </td>
                    </tr>
        <?php }
        
    else echo "<tr><td colspan='5' align='center'>Sorry, No data for approval</td></tr>"; ?>	
        </table>
    </center>

<?php
} elseif ($page == "upload_coupon") {

    $appmsg = '';
    if (isset($_GET['approveid'])) {
        // get coupon id from $_GET['approveid']
        $approveid = mysql_real_escape_string($_GET['approveid']);
        // get coupon category id that was set in approval table
        $categoryid = $_REQUEST['category'];
        approveCouponWithId($approveid);
// 		$stdate = time();
        $getcoupondetail = mysql_query("select * from coupons where cid='$approveid'");
        if (mysql_num_rows($getcoupondetail)) {
            $getcoupondetailarr = mysql_fetch_array($getcoupondetail);
            $newimgpath = str_replace('temp', 'livecoupons', $getcoupondetailarr['custom_image']);
            if (copy($getcoupondetailarr['custom_image'], $newimgpath))
                unlink($getcoupondetailarr['custom_image']);
            else
                $newimgpath = $getcoupondetailarr['custom_image'];

// 			$updqry = mysql_query("update coupons set active=1,startdate='$stdate',custom_image='$newimgpath',category='$categoryid' where cid='$approveid'");
            updateCouponTableWithValuesAndId("custom_image='$newimgpath',category='$categoryid'", $approveid);
            if (mysql_affected_rows() > 0) // 			if ($updqry && mysql_affected_rows() > 0)
                $appmsg = 'Coupon Approved Successfully';
            else
                $appmsg = 'Sorry, an error occured coupon not approved, please try again.';
        }
        sendApprovalEmail($approveid);
    }

    else if (isset($_GET['denyid'])) {
        $categoryid = $_REQUEST['category'];
        // get coupon id from $_GET['approveid']
        $denyid = mysql_real_escape_string($_GET['denyid']);
        // deny the coupon (see function at top of document)
        dontApproveCouponWithId($denyid);
    }
    ?>
    <title> Create Your Coupon Awaiting Approvals - Admin Panel University Values</title>
    <script type="text/javascript">
        function validateit(validid)
        {
            var fup = document.getElementById(validid);
            var fileName = fup.value;
            var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
            ext.toLowerCase();
            //alert(fup.value+' '+ext);
            if (fup.value == '')
            {
                alert('Please Select an image file then approve it.');
                return false;
            }
            else {
                if (ext == "gif" || ext == "jpeg" || ext == "jpg" || ext == "png")
                    return true;
                else
                {
                    alert('Please Select an image file then approve it.');
                    return false;
                }

            }
        }
    </script>
    <center>
        <h2>Upload Your Coupon Awaiting Approvals</h2>
        <table width="95%">
    <?php if ($appmsg != '') echo "<tr><td colspan='5'>$appmsg</td></tr>"; ?>
            <tr><th>Coupon Id</th>
                <th>Date</th>
                <th>Advertiser Name</th>
                <th>PID - Business Name</th>
                <th>Next Bill Date</th>
                <th>coupon Image</th>
                <th># Locations</th>
                <th>Approve</th>
            </tr>	
                    <?php
                    $getalllist = getCouponListResultForPendingCouponsWithTypeId(3);
                    if (mysql_num_rows($getalllist))
                        while ($getalllistarr = mysql_fetch_array($getalllist)) {
                            $result = mysql_query("SELECT name FROM  businesses WHERE pid='$getalllistarr[pid]'") or die(mysql_error());
                            $row = mysql_fetch_array($result);
                            $numCouponLocations = getNumCouponLocationsForCouponWithId($getalllistarr['cid']);
                            ?>
                    <tr>
                        <td align="center"><?php echo $getalllistarr['cid'] ?></td>
                        <td align="center"><?php echo date('m/d/Y', $getalllistarr['updatetime']) ?></td>
                        <td align="center"><?php echo $row['name'] ?></td>
                        <td align="center"><?php echo $getalllistarr['pid'] . ' - ' . $getalllistarr['business'] ?></td>
                        <td align="center"><?php echo date('m/d/Y', $getalllistarr[endDate]) ?></td>
                        <td align="center">
            <?php if ($getalllistarr['type'] == 2) { ?>
                                <a href="<?php echo $getalllistarr['custom_image'] ?>">Download ZIP File</a>
            <?php } else { ?>
                                <img class="show_popup" src="<?php echo $getalllistarr['custom_image'] ?>" width="100" />
                                
            <?php } ?>
                        </td>
                        <td align="center"><?=$numCouponLocations?></td>
                        <td align="center">
                            <select name="category" id="category" onchange="fun_redirect1(this.value)">
                                <option <?php if ($cat_id == 1) echo 'selected="selected"'; ?> value="1">Live</option>
                                <option <?php if ($cat_id == 2) echo 'selected="selected"'; ?> value="2">Eat</option>
                                <option <?php if ($cat_id == 3) echo 'selected="selected"'; ?> value="3">Play</option>
                            </select><br />
                            <a href="admin.php?action=approvallist&category=<?php echo $cat_id; ?>&page=upload_coupon&approveid=<?php echo $getalllistarr['cid']; ?>">Approve coupon</a><br />
                            <a href="admin.php?action=approvallist&category=<?php echo $cat_id; ?>&page=upload_coupon&denyid=<?php echo $getalllistarr['cid']; ?>">Deny Approval of coupon</a>

                        </td>
                    </tr>
        <?php }
    else echo "<tr><td colspan='5' align='center'>Sorry, No data for approval</td></tr>"; ?>	
        </table>
    </center>
<?php } ?>
<script type="text/javascript">
    function fun_redirect(str) {
        window.location = 'https://www.universityvalues.com/admin.php?action=approvallist&page=create_ur_coupon&cat_id=' + str;
    }
    function fun_redirect1(str) {
        window.location = 'https://www.universityvalues.com/admin.php?action=approvallist&page=upload_coupon&cat_id=' + str;
    }
</script>