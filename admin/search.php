<?php

session_start();

if (!isset($_SESSION['adminuser'])) die('not authorized');

if(!isset($_POST['type'])) die('no type sent');

if(!isset($_POST['query'])) die('no query sent');

include_once('../includes/main.php');

$query = $_POST['query'];

switch($_POST['type'])
{
	case 'business':
		$ids = array();
		// select from business table first
		$select = "SELECT pid from businesses where business LIKE '%$query%' or name like '%$query%' or state like '%$query%'";
		$res = mysql_query($select) or die(mysql_error());
		while($row = mysql_fetch_assoc($res))
		{
			$ids[] = $row['pid'];
		}
		$select = "SELECT c.pid from coupons c LEFT JOIN coupons_tie ct ON c.cid = ct.cid LEFT JOIN schools s ON ct.sid = s.sid WHERE s.name LIKE '%$query%'";
		$res = mysql_query($select) or die(mysql_error());
		while($row = mysql_fetch_assoc($res))
		{
			$ids[] = $row['pid'];
		}
		$ids = array_unique($ids);
		if(count($ids) > 0)
		{
			$ids = implode(",", $ids);
			$select = "SELECT b.pid,b.business, b.name, b.email, b.phone, b.city,b.state,COUNT(c.cid) as cnt FROM businesses b LEFT JOIN coupons c ON b.pid = c.pid where b.skiped!=0 AND b.pid IN ($ids) GROUP BY b.pid";
			$result = mysql_query($select) or die(mysql_error());
			include('../templates/business_table.php');
		}
		else
		{
			echo "<h4>No Results Found</h4>";
		}
		break;
}

?>