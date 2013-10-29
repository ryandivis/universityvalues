<?php
echo 'test';
include($_SERVER['DOCUMENT_ROOT'].'/includes/test2.php');	
die();	
echo 'test2';
$settings = array(
	'oauth_access_token' => "38427143-yvWh8Ap6kiYiN9l4r1S1F8gZP8tcEd0Y79PHi7Dyg",
	'oauth_access_token_secret' => "qVZbiUgkO1I50fANpiN6z5GJxDgBCNzooAxF2oM",
	'consumer_key' => "F8W9c0NI07KDONDs7zzInw",
	'consumer_secret' => "RpR4PFchuZBkiDAzxux7AtYFM0DX2kmoClsVVEwaKI"
);
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?username=univ_values';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$follow_count=$twitter->setGetfield($getfield)
						 ->buildOauth($url, $requestMethod)
						 ->performRequest();
$testCount = json_decode($follow_count, true);
print_r($testCount);
echo "<pre>";
echo $testCount[0]['user']['followers_count'];
echo "</pre>";
?>