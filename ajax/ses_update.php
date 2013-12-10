<?
session_start();


if($_POST['a']=="program"){
	foreach($_SESSION['coupons'] as $key=>$val){
		if($_POST['cid']==$key+1){
			$_SESSION['coupons'][$key]['couponProgram'] = $_POST['couponProgram'];
			$_SESSION['coupons'][$key]['campaignCost'] = $_POST['campaignCost'];
			$_SESSION['coupons'][$key]['total'] = $_POST['cost'];
		}
	}
}
if($_POST['a']=="type"){
	foreach($_SESSION['coupons'] as $key=>$val){
		if($_POST['cid']==$key+1){
			$_SESSION['coupons'][$key]['couponType'] = $_POST['couponType'];
			$_SESSION['coupons'][$key]['couponCost'] = $_POST['couponTypeCost'];
			$_SESSION['coupons'][$key]['total'] = $_POST['cost'];
		}
	}
}
print_r($_SESSION);