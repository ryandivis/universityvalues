<?php

session_start();

if (!isset($_SESSION['adminuser'])) die('not authorized');

if(!isset($_POST['type'])) die('no type sent');

if(!isset($_POST['query'])) die('no query sent');

include_once('../includes/main.php');

switch($_POST['type'])
{
	case 'business':
		$select = "SELECT b.pid,b.business, b.name, b.email, b.phone, b.city,b.state,COUNT(c.cid) as cnt FROM businesses b LEFT JOIN coupons c ON b.pid = c.pid where b.skiped!=0 GROUP BY b.pid LIMIT 10";
		break;
}

?>