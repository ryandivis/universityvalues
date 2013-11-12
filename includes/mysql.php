<?

error_reporting(0);

if($_SERVER['HTTP_HOST']=='universityvalues.com' || $_SERVER['HTTP_HOST']=='www.universityvalues.com')
{
	$mysql = mysql_connect("localhost","onlinea6_uv","warner2009");

	mysql_select_db("onlinea6_uv");

	$DB = new PDO("mysql:host=localhost;dbname=onlinea6_uv;",'onlinea6_uv','warner2009');
}
else
{
	$mysql = mysql_connect("localhost","root","");

	mysql_select_db("uv", $mysql);

	$DB = new PDO("mysql:host=localhost;dbname=uv;",'root','');
	$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

?>