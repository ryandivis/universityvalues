<?
ob_start();	// this starts buffering so that output will not get jumbled if the timing is incorrect
// define items here
if($_SERVER['HTTP_HOST']=='universityvalues.com' || $_SERVER['HTTP_HOST']=='www.universityvalues.com')
	$siteurl='https://'.$_SERVER['HTTP_HOST']."/";
else
	$siteurl='https://'.$_SERVER['HTTP_HOST']."/UniversityValues/old/";
define("SITEURL",$siteurl);
define("SITEPATH",$siteurl);
$adminemail="andrewb@universityvalues.com";
$basename = basename($_SERVER['REQUEST_URI']);
if($_GET)
{
	foreach($_GET as $k=>$v)
		$$k = $v;

}
$homepageTitle = "University Values | Money in Your Pocket";
$stateOptions = ' <option value="AK">AK</option>
            <option value="AL">AL</option>
            <option value="AR">AR</option>
            <option value="AZ">AZ</option>
            <option value="CA">CA</option>
            <option value="CO">CO</option>
            <option value="CT">CT</option>
            <option value="DC">DC</option>
            <option value="DE">DE</option>
            <option value="FL">FL</option>
            <option value="GA">GA</option>
            <option value="HI">HI</option>
            <option value="IA">IA</option>
            <option value="ID">ID</option>
            <option value="IL">IL</option>
            <option value="IN">IN</option>
            <option value="KS">KS</option>
            <option value="KY">KY</option>
            <option value="LA">LA</option>
            <option value="MA">MA</option>
            <option value="MD">MD</option>
            <option value="ME">ME</option>
            <option value="MI">MI</option>
            <option value="MN">MN</option>
            <option value="MO">MO</option>
            <option value="MS">MS</option>
            <option value="MT">MT</option>
            <option value="NC">NC</option>
            <option value="ND">ND</option>
            <option value="NE">NE</option>
            <option value="NH">NH</option>
            <option value="NJ">NJ</option>
            <option value="NM">NM</option>
            <option value="NV">NV</option>
            <option value="NY">NY</option>
            <option value="OH">OH</option>
            <option value="OK">OK</option>
            <option value="OR">OR</option>
            <option value="PA">PA</option>
            <option value="RI">RI</option>
            <option value="SC">SC</option>
            <option value="SD">SD</option>
            <option value="TN">TN</option>
            <option value="TX">TX</option>
            <option value="UT">UT</option>
            <option value="VA">VA</option>
            <option value="VT">VT</option>
            <option value="WA">WA</option>
            <option value="WI">WI</option>
            <option value="WV">WV</option>
            <option value="WY">WY</option>';

include_once('mysql.php');

session_start();


	function format_phone($phone) {

	$phone = preg_replace("/[^0-9]/", "", $phone);

	if(strlen($phone) == 7)
		return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
	elseif(strlen($phone) == 10)
		return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
	else
		return $phone;
}

function sendmail($to,$subject,$message,$headers="From: University Values <support@universityvalues.com>\r\n",$header2="University Values")
{	
	$headers.= 'MIME-Version: 1.0' . "\r\n";
	$headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$formatmail='<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>'.$subject.'</title>
  </head>
  <body style="font-family: Arial,Helvetica,sans-serif; color: gray;">
		<div style="margin: 0 auto; width:762px;">
			<div style="background:url(\'https://www.universityvalues.com/emailhtml/emailpapertop.png\'); height: 122px;">				
				<center>
				<table width="100%" style="padding-top:31px;">
					<tr>
						<td align="center" style="width: 155px; height: 75px;"><img src="https://www.universityvalues.com/emailhtml/uvslogo.png" /></td>
						<td style="font-size: 28px; font-family: Arial,Helvetica,sans-serif;">'.$header2.'</td>
					</tr>
				</table>
				</center>
			</div>
			<div style="background:url(\'https://www.universityvalues.com/emailhtml/emailmiddlepaper.png\');">
				<table width="100%">
					<tr>
						<td style="width:155px;"></td>
						<td align="left">
							<div style="width: 545px;">
							<div style="clear: both;  padding-top:5px; padding-bottom: 10px;"><img width="550" src="https://www.universityvalues.com/emailhtml/horizontalline.png" /></div>
								'.$message.'
							<div style="clear: both;  padding-top:10px; padding-bottom: 10px;"><img width="550" src="https://www.universityvalues.com/emailhtml/horizontalline.png" /></div>
							<table width="100%" style="position: relative; font-size:10px;">
								<tr>
									<td width="360" valign="top">
										<div style="width: 350px;">
										<div><img src="https://www.universityvalues.com/emailhtml/referral_pro.png" /></div>
										<div style="padding-bottom: 15px;  font-size: 11px;">We appreciate your referrals and love giving cash and advertising discounts for them! If you know of anyone who might be a good fit for University Values advertising, please click here to let us know. Thanks!</div>
										</div>
									</td>
									<td valign="top"><div style="left: 352px; position: absolute;top: -24px;"><img height="270" src="https://www.universityvalues.com/emailhtml/vertical_line.png" /></div></td>
									<td style="padding-left: 10px;">
										<div><img src="https://www.universityvalues.com/emailhtml/contact_us.png" /></div>
										<div style="padding-bottom: 5px;  font-size: 11px;">University Values</div>
										<div style="padding-bottom: 5px;  font-size: 11px;">8831 S Redwood Rd Suite C</div>
										<div style="padding-bottom: 5px;  font-size: 11px;">West Jordan, UT 84065</div>
										<div style="padding-bottom: 5px;  font-size: 11px;">Phone: 801-878-7089</div>
										<div style="padding-bottom: 5px;  font-size: 11px;">Toll Free: 877-365-8762</div>
										<div style="padding-bottom: 5px;  font-size: 11px;">Fax: 801-384-0461</div>
										<div style="padding-bottom: 5px;  font-size: 11px;"><a href="http://www.universityvalues.com/">UniversityValues.com</a></div>
										<div><img src="https://www.universityvalues.com/emailhtml/follow_us.png" /></div>
										<div style="padding-bottom: 15px;"><a href=""><img src="https://www.universityvalues.com/emailhtml/emailblog.png" /></a><a href=""><img src="https://www.universityvalues.com/emailhtml/emailfacebook.png" /></a><a href=""><img src="https://www.universityvalues.com/emailhtml/emailtwitter.png" /></a><a href=""><img src="https://www.universityvalues.com/emailhtml/emailgplus.png" /></a><a href=""><img src="https://www.universityvalues.com/emailhtml/emailyoutube.png" /></a></div>
									<td>
								</tr>
							</table>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div style="background:url(\''.SITEPATH.'emailhtml/emailpaperbottom.png\'); height: 38px;">&nbsp;.</div>
		</div>
	</div>
</body>
</html>';
	mail($to, $subject, $formatmail, $headers);
}


function MaskCreditCard($cc){
	// Get the cc Length
	$cc_length = strlen($cc);
	// Replace all characters of credit card except the last four and dashes
	for($i=0; $i<$cc_length-4; $i++){
		if($cc[$i] == '-'){continue;}
		$cc[$i] = 'X';
	}
	// Return the masked Credit Card #
	return $cc;
}

function FormatCreditCard($cc)
{
	// Clean out extra data that might be in the cc
	$cc = str_replace(array('-',' '),'',$cc);
	// Get the CC Length
	$cc_length = strlen($cc);
	// Initialize the new credit card to contian the last four digits
	$newCreditCard = substr($cc,-4);
	// Walk backwards through the credit card number and add a dash after every fourth digit
	for($i=$cc_length-5;$i>=0;$i--){
		// If on the fourth character add a dash
		if((($i+1)-$cc_length)%4 == 0){
			$newCreditCard = '-'.$newCreditCard;
		}
		// Add the current character to the new credit card
		$newCreditCard = $cc[$i].$newCreditCard;
	}
	// Return the formatted credit card number
	return $newCreditCard;
}


function twitter_followers_counter($username) {
	
	$cache_file = CACHEDIR.'twitter_followers_counter_' . md5 ( $username );
	
	if (is_file ( $cache_file ) == false) {
		$cache_file_time = strtotime ( '1984-01-11 07:15' );
	} else {
		$cache_file_time = filemtime ( $cache_file );
	} 
	
	$now = strtotime ( date ( 'Y-m-d H:i:s' ) );
	$api_call = $cache_file_time;
	$difference = $now - $api_call;
	$api_time_seconds = 1800;
	
	if ($difference >= $api_time_seconds) {
		$api_page = 'http://twitter.com/users/show/' . $username;
		$xml = file_get_contents ( $api_page );
		
		$profile = new SimpleXMLElement ( $xml );
		$count = $profile->followers_count;
		if (is_file ( $cache_file ) == true) {
			unlink ( $cache_file );
		}
		touch ( $cache_file );
		file_put_contents ( $cache_file, strval ( $count ) );
		return strval ( $count );
	} else {
		$count = file_get_contents ( $cache_file );
		return strval ( $count );
	}
} 

function formate($n)
{
        $n = (0+str_replace(",","",$n));
        if(!is_numeric($n)) return false;
        if($n>1000000000000) return round(($n/1000000000000),1).' trillion';
        else if($n>1000000000) return round(($n/1000000000),1).' billion';
        else if($n>1000000) return round(($n/1000000),1).' m';
        else if($n>1000) return round(($n/1000),1).' k';
       
        return number_format($n);
}

function login($user,$pwd,$type='admin')
{
	if($type == 'admin')
	{
		$uname = md5($user);
	    $pwd = md5($pwd);
	    $result = mysql_query("SELECT * FROM admin WHERE admin_name = '$uname'");
	    $count = mysql_num_rows($result);
	    if ($count == 1) {
	    	$user = mysql_fetch_assoc($result);
	    	//check if the user is locked
	    	if($user['attempts'] > 4 || $user['locked']) return false;	
	    	// check to see if the passwords match
	    	if($user['pwd'] == $pwd)
	    	{
	    		$_SESSION['user_id'] = $user['id'];
		    	$_SESSION['username'] = $user['admin_name'];
		    	$_SESSION['login_string'] = hash('sha512',$pwd.$_SERVER['HTTP_USER_AGENT']);
		    	$result = mysql_query("UPDATE admin SET last_login = NOW(), attempts = 0 WHERE admin_name = '$uname'");	
		    	return true;
	    	}
	    	else
	    	{
	    		if($user['attempts'] == 4)
	    		{
	    			$result = mysql_query("UPDATE admin SET last_attempt = NOW(), attempts = attempts + 1, locked = 1 WHERE admin_name = '$uname'");
	    		}
	    		else
	    		{
	    			$result = mysql_query("UPDATE admin SET last_attempt = NOW(), attempts = attempts + 1 WHERE admin_name = '$uname'");	
	    		}
	    		return false;
	    	}
	    }	
	}
	
}

function login_check()
{
	if(isset($_SESSION['user_id'],$_SESSION['username'],$_SESSION['login_string']))
	{
		$DB = createPDO('local');
		$user_id = $_SESSION['user_id'];
		$username = $_SESSION['username'];
		$login_string = $_SESSION['login_string'];
		$browser = $_SERVER['HTTP_USER_AGENT'];
		try{
			$stmt = $DB->prepare("SELECT * FROM admin WHERE id=:id");
			$stmt->execute(array(':id' => $user_id));

			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if(hash('sha512',$result['pwd'].$browser) == $login_string)
			{
				return true;
			}
		}
		catch(Exception $e)
		{
			echo 'Message: ' .$e->getMessage();
			return false;
		}
	}
	else
	{
		return false;
	}
}

function getTwitterFollowers($screenName = 'codeforest')
{
    require_once('cache.php');
    require_once('TwitterAPIExchange.php');
    // this variables can be obtained in http://dev.twitter.com/apps
    // to create the app, follow former tutorial on http://www.codeforest.net/get-twitter-follower-count
    $settings = array(
        'oauth_access_token' => "30707898-i8EdROCyc1be8kSbG9w57jRzMVrTyxXaAIN7jRpw2",
        'oauth_access_token_secret' => "H8iLQz7EcE8VWeqpfNE67khbKoI68bkDlo84Kvnjp5LfK",
        'consumer_key' => "pWnCcgMx1dKvNIPKIU2Vxg",
        'consumer_secret' => "Uz9ewfUjsC9OWCT9X3PsEqtuWU3dHPVkOcNM7Ysu8o"
    );

    $cache = new Cache();
  
    // get follower count from cache
    $numberOfFollowers = $cache->read('cfTwitterFollowers.cache');

    // cache version does not exist or expired
    if (false == $numberOfFollowers || null == $numberOfFollowers) {
        // forming data for request
        $apiUrl = "https://api.twitter.com/1.1/users/show.json";
        $requestMethod = 'GET';
        $getField = '?screen_name=' . $screenName;
 
        $twitter = new TwitterAPIExchange($settings);
        $response = $twitter->setGetfield($getField)
             ->buildOauth($apiUrl, $requestMethod)
             ->performRequest();

        $followers = json_decode($response);
        $numberOfFollowers = $followers->followers_count;
  
        // cache for an hour
        $cache->write('cfTwitterFollowers.cache', $numberOfFollowers, 1*60*60);
    }
  
    return $numberOfFollowers;
}


function state_select($name,$selected=null,$id=null,$class=null)
{
	$states = array(
		"AL"=>"Alabama",
		"AK"=>"Alaska",
		"AZ"=>"Arizona",
		"AR"=>"Arkansas",
		"CA"=>"California",
		"CO"=>"Colorado",
		"CT"=>"Connecticut",
		"DE"=>"Delaware",
		"DC"=>"District Of Columbia",
		"FL"=>"Florida",
		"GA"=>"Georgia",
		"HI"=>"Hawaii",
		"ID"=>"Idaho",
		"IL"=>"Illinois",
		"IN"=>"Indiana",
		"IA"=>"Iowa",
		"KS"=>"Kansas",
		"KY"=>"Kentucky",
		"LA"=>"Louisiana",
		"ME"=>"Maine",
		"MD"=>"Maryland",
		"MA"=>"Massachusetts",
		"MI"=>"Michigan",
		"MN"=>"Minnesota",
		"MS"=>"Mississippi",
		"MO"=>"Missouri",
		"MT"=>"Montana",
		"NE"=>"Nebraska",
		"NV"=>"Nevada",
		"NH"=>"New Hampshire",
		"NJ"=>"New Jersey",
		"NM"=>"New Mexico",
		"NY"=>"New York",
		"NC"=>"North Carolina",
		"ND"=>"North Dakota",
		"OH"=>"Ohio",
		"OK"=>"Oklahoma",
		"OR"=>"Oregon",
		"PA"=>"Pennsylvania",
		"RI"=>"Rhode Island",
		"SC"=>"South Carolina",
		"SD"=>"South Dakota",
		"TN"=>"Tennessee",
		"TX"=>"Texas",
		"UT"=>"Utah",
		"VT"=>"Vermont",
		"VA"=>"Virginia",
		"WA"=>"Washington",
		"WV"=>"West Virginia",
		"WI"=>"Wisconsin",
		"WY"=>"Wyoming"
	);
	$html = "";
	$html .= "<select name='$name' id='$id' class='$class' >";
	$html .= "<option value=''>Select a State</option>";
	foreach($states as $key => $value)
	{
		if($selected == $key || $selected == $value)
		{
			$html .= "<option value='$key' selected='selected'>$value</option>";
		}
		else
		{
			$html .= "<option value='$key'>$value</option>";
		}
	}
	$html .= "</select>";

	return $html;
}

/*
* Returns all a list of all the businesses in the system.
* Can return as an array or as html options
*/
function getBusinessList($type = "array")
{
	$res = mysql_query("SELECT pid,business FROM businesses ORDER BY businesses.pid ASC");

	switch($type)
	{
		case 'array':
			$businesses = array();
			while($row = mysql_fetch_assoc($res))
			{
				$businesses[$row['pid']] = $row['business'];
			}
			return $businesses;
			break;
		case 'html':
			$businesses = "";
			while($row = mysql_fetch_assoc($res))
			{
				$businesses = "<option value='". $row['pid'] ."'>". $row['business'] ."</option>";
			}
			return $businesses;
			break;
	}
}

/**
* Functions for generating a json response
*/
class JsonResponse{

	var $success = true;
	var $error = false;
	var $messages = array();

	function __construct()
	{

	}

	function addResponse($msg,$error=false)
	{
		$this->messages[] = $msg;
		if($error) $this->error = true;
		print_r($this->messages);
	}

	function generateResponse()
	{
		$response = array();
		$response['error'] = $this->error;
		$response['success'] = !$this->error;
		$response['message'] = implode("\r\n", $this->messages);

		$response = json_encode($response);

		return $response;
	}

}

?>