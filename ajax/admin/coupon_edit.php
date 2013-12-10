<?php

if($_POST)
{
	require('../../includes/main.php'); //include all of the db stuff and functions
	require_once('../../php_helpers/google_maps/geocoding_helper.php');

	$jr = new JsonResponse();

	//handle upload of new coupon
	if($_FILES['file']['error'] == 0)
	{
		list($txt,$ext) = explode(".", $_FILES['file']['name']);
		$newName = time() . ".$ext";
		$uploadFile = "images/coupon/" . $newName;
		if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile))
		{
			$logo = $uploadFile;
			$jr->addResponse('File successfully uploaded.');
		}	
		else
		{
			$jr->addResponse('There was an error uploading the file.',true);
		}
	}

	//update business for # of edits and # of coupons
	switch($_POST['couponTypeId'])
	{
		case '1': //associates
			$editsLeft = 3;
			$featured = 0;
			$couponsLeft = 0;
			break;
		case '2': //bachelors
			$editsLeft = 6;
			$featured = 0;
			$couponsLeft = 1;
			break;
		case '3': //masters
			$editsLeft = 6;
			$featured = 1;
			$couponsLeft = 1;
			break;
	}

	$stmt = $DB->prepare("UPDATE businesses SET numCouponsLeftToCreate=:couponsLeft WHERE pid=:pid");
	$stmt->execute(array(':couponsLeft' => $couponsLeft, ':pid' => $_POST['bussin_id']));

	//update coupon within the pending edits table
	$stmt = $DB->prepare("UPDATE coupons SET issendforapprovel = 1 WHERE cid=:cid");
	$stmt->bindValue(':cid', $_POST['cid'], PDO::PARAM_INT);
	$stmt->execute();

	$stmt = $DB->prepare("DELETE FROM pending_coupon_edits WHERE cid=:cid");
	$stmt->bindValue(':cid', $_POST['cid'], PDO::PARAM_INT);
	$stmt->execute();
	
	if(isset($logo))
	{
		$image = $logo;
	}
	else
	{
		$image = $_POST['custom_image'];
	}

	$stmt = $DB->prepare("INSERT INTO pending_coupon_edits (pid, endDate, custom_image, issendforapprovel, local, realOffer, mobileRedeem, updatetime, type, cid, business) VALUES(:pid, :endDate, :customImage, :issendforapprovel, :local, :realOffer, :mobileRedeem, :updateTime, :type, :cid, :business);");
	$stmt->bindValue(':pid',$_POST['bussin_id'],PDO::PARAM_INT);
	$stmt->bindValue(':endDate', strtotime($_POST['expires']));
	$stmt->bindValue(":customImage", $image,PDO::PARAM_STR);
	$stmt->bindValue(":issendforapprovel", 1);
	$stmt->bindValue(':local', 0);
	$stmt->bindValue(':realOffer',$_POST['offerText'],PDO::PARAM_STR);
	$stmt->bindValue(':mobileRedeem',$_POST['redemptions'],PDO::PARAM_INT);
	$stmt->bindValue(':updateTime',time());
	$stmt->bindValue(':type',$_POST['couponTypeId'],PDO::PARAM_INT);
	// $stmt->bindValue(':couponPlanID',$_POST['couponTypeId'],PDO::PARAM_INT);
	$stmt->bindValue(':cid',$_POST['cid'],PDO::PARAM_INT);
	$stmt->bindValue(':business',$_POST['bussin_name'],PDO::PARAM_STR);
	$stmt->execute();

	//set featured
	$stmt = $DB->prepare("UPDATE coupons_tie set fid=:featured where cid=:cid");
	$stmt->bindValue(':featured',$featured,PDO::PARAM_INT);
	$stmt->bindValue(':cid',$_POST['cid'],PDO::PARAM_INT);
	$stmt->execute();

	//update coupons tie to reflect coupons <==> schools
	$allSchools = false;
	$uncheckedSchools = false;

	if (isset($_POST['advertisingMarkets']) && $_POST['advertisingMarkets'] == 'allSchoolsInTheNation')
	{
		$allSchools = true;	
	}	
	else if (isset($_POST['advertisingMarkets']) && $_POST['advertisingMarkets'] == 'allButListedSchools')
	{
		$uncheckedSchools = true;	
	}

	
	//first remove all previous ties that exist
	$stmt = $DB->prepare("DELETE FROM coupons_tie WHERE cid=:cid");
	$stmt->bindValue(':cid',$_POST['cid'],PDO::PARAM_INT);
	$stmt->execute();


	$schools = implode(",", $_POST['schools']);

	if($allSchools)
	{
		//add ties for all schools to this coupon
		$stmt = $DB->PREPARE("INSERT INTO coupons_tie (cid,sid) SELECT :cid,sid FROM schools");
		$stmt->bindValue(':cid',$_POST['cid'],PDO::PARAM_INT);
	}
	else if($uncheckedSchools)
	{
		//add ties for all unchecked schools
		$stmt = $DB->PREPARE("INSERT INTO coupons_tie (cid,sid) SELECT :cid,sid FROM schools WHERE sid NOT IN (". $schools .")");
		$stmt->bindValue(':cid',$_POST['cid'],PDO::PARAM_INT);
	}
	else
	{
		//add ties for all checked schools
		$stmt = $DB->PREPARE("INSERT INTO coupons_tie (cid,sid) SELECT :cid,sid FROM schools WHERE sid IN (". $schools .")");
		$stmt->bindValue(':cid',$_POST['cid'],PDO::PARAM_INT);
	}
	$stmt->execute();

	//add locations
	try{
		$locationIds = array();
		foreach($_POST['locations'] as $location)
		{
			$address = 'USA, ' . $location['state'] . ', ' . $location['city'] . ', ' . $location['street'] . ', ' . $location['zip'];
			$position = useGoogleGeocodeToGetCoordinates($address);

			if($location['lid'])
			{
				//location exists, just update
				$stmt = $DB->prepare("UPDATE locations SET pid=:pid, lat=:lat, lng=:lng, name=:name, primaryLoco=:primaryLoco, street=:street, city=:city, state=:state, zip=:zip, phone=:phone WHERE lid=:lid");
				$stmt->bindValue(':lid',$location['lid'],PDO::PARAM_INT);
			}
			else
			{
				//location doesn't exist insert
				$stmt = $DB->prepare("INSERT INTO locations (pid,lat,lng,name,primaryLoco,street,city,state,zip,phone) VALUES(:pid, :lat, :lng, :name, :primaryLoco, :street, :city, :state, :zip, :phone);");
			}

			$stmt->bindValue(':pid',$_POST['bussin_id'],PDO::PARAM_INT);
			$stmt->bindValue(':lat',$position['lat'],PDO::PARAM_STR);
			$stmt->bindValue(':lng',$position['lng'],PDO::PARAM_STR);
			$stmt->bindValue(':name',$_POST['bussin_name'],PDO::PARAM_STR);
			$stmt->bindValue(':primaryLoco',($location['primaryLoco'])? $location['primaryLoco'] : 0,PDO::PARAM_INT);
			$stmt->bindValue(':street',$location['street'],PDO::PARAM_STR);
			$stmt->bindValue(':city',$location['city'],PDO::PARAM_STR);
			$stmt->bindValue(':street',$location['street'],PDO::PARAM_STR);
			$stmt->bindValue(':state',$location['state'],PDO::PARAM_STR);
			$stmt->bindValue(':zip',$location['zip'],PDO::PARAM_STR);
			$stmt->bindValue(':phone',$location['phone'],PDO::PARAM_STR);
			$stmt->execute();

			$locationIds[] = ($location['lid'])? $location['lid'] : $DB->lastInsertId();
		}

		echo implode(",", $locationIds);
		// //delete all locations not in the locationids
		$stmt = $DB->prepare("DELETE FROM locations WHERE lid NOT IN (".implode(",", $locationIds).") AND pid = :pid");
		$stmt->bindValue(':pid',$_POST['bussin_id'],PDO::PARAM_INT);
		$stmt->execute();

		//remove references from tie_table
		$stmt = $DB->prepare("DELETE FROM location_tie WHERE cid = :cid");
		$stmt->bindValue(':cid',$_POST['cid'],PDO::PARAM_INT);
		$stmt->execute();

		//add new references to the tie table
		$stmt = $DB->prepare("INSERT INTO location_tie (lid,cid) VALUES(:lid,:cid)");
		foreach($locationIds as $lid)
		{
			$stmt->bindValue(':lid',$lid,PDO::PARAM_INT);	
			$stmt->bindValue(':cid',$_POST['cid'],PDO::PARAM_INT);	
			$stmt->execute();
		}
	} 
	catch( Exception $e )
	{ 
	    echo "Error!: " . $e->getMessage() . "</br>"; 
	} 
	
	echo $jr->generateResponse();

}





?>