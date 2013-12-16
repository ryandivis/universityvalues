<?php 
	include_once('../includes/main.php');

	include_once('../includes/recaptchalib.php');

	$privatekey = "6Le9uOsSAAAAAGLLDsyF-ljWEi96o_SUkZlRv5wf";
	$resp = recaptcha_check_answer (
		$privatekey,
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]
    );

	if (!$resp->is_valid) {
		// What happens when the CAPTCHA was entered incorrectly
		die('captcha');
	} else {
		if(isset($_POST['name']))
		{
			foreach($_POST as $k=>$v)
				$$k = $v;
			
			// these few lines filter out spam bots (they would have entered information into an invisible form field called "username")
			$spam = $username;
			if(strlen($spam) > 0) {
				die("Nice try");
			}
			
			$now = time();
			$insert = "INSERT INTO request_info 
		                                            (   name,
		                                                business,
		                                                email,
		                                                phone,
		                                                message,
		                                                datecreated,
		                                                viewed,
		                                                deleted) values 
		                                            (   '".mysql_real_escape_string($name)."',
		                                                '".mysql_real_escape_string($business)."',
		                                                '".mysql_real_escape_string($email)."',
		                                                '".mysql_real_escape_string($phone)."',
		                                                '".mysql_real_escape_string($message)."',
		                                                '".mysql_real_escape_string($now)."',
		                                                '0',
		                                                '0')";
			$result = mysql_query($insert);
			if($result)
			{
				$headers="From: University Values <support@universityvalues.com>\r\n";
				$message1="<div class='confrim' style='font-size:19px!important;'>Thank you for requesting advertising information from University Values.  A representative will contact you within one business day to provide more information and answer any questions you may have.</div>
				";
				$message=
		                    "Hi {$_POST['name']},<br><br>
		                    Thank you for requesting more information from University Values. A knowledgeable represenative will contact you within one business day to answer your questions and update you on our advertising options.<br><br>
		                    In the meantime, you can download the University Values App on Apple or Android <a href='http://universityvalues.com/mobile.php'>here.</a><br><br>
		                    Thank you,<br><br>
		                    <i>-You University Values Team</i>";
		                    //"Thank you for inquiring about the University Values advertising program. An Advertising Representative will contact you within one business day. We look forward to answering your questions and providing you with more information.<br><br>
		                    //-University Values&reg; Team";
				$header2="Student Advertising Information Request";
				sendmail('support@universityvalues.com', 'New Adveriser is Requesting Info', 'New Advertisor Info received. Details are on admin panel; please check there.');
				//sendmail($email, 'University Values Advertising', $message,$header,$header2);
				sendmail($email, 'Student Advertising Info Request', $message,$headers,$header2);

				echo "success";
			} 
		}
	}