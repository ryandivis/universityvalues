<?php
include("includes/main.php");
$email = $_GET['email'];
$un_email="support@universityvalues.com";
if(isValidEmail($email))
{
	$insert = "INSERT INTO newsLetter (email, datemade) values ('$email','".time()."')";
	$result = mysql_query($insert);

	$select = "SELECT * FROM emailTemplates WHERE etID='1'";
	$result = mysql_query($select);
	$emailTemplate =mysql_fetch_array($result);		
	$subject=$emailTemplate['subjectLine'];		
	$msg_body="hello";	
	
	sendmail($email,$subject,$msg_body,$headers="From: University Values <support@universityvalues.com>\r\n");
	echo "yes";
	
 } else{
 	echo "error"; 
 }

function isValidEmail($email){
    return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
}
?>