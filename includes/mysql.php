<?

error_reporting(0);

if($_SERVER['HTTP_HOST']=='universityvalues.com' || $_SERVER['HTTP_HOST']=='www.universityvalues.com')
{
	$mysql = mysql_connect("localhost","onlinea6_uv","warner2009");

	mysql_select_db("onlinea6_uv");

	$DB = new PDO("mysql:host=localhost;dbname=onlinea6_uv;",'onlinea6_uv','warner2009');
	$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
else
{
	$mysql = mysql_connect("localhost","root","");

	mysql_select_db("uv", $mysql);

	$DB = new PDO("mysql:host=localhost;dbname=uv;",'root','');
	$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}


function createPDO($env = 'live')
{
	$enviroments = array(
		'local' => array(
			'host' => 'localhost',
			'dbname' => 'uv',
			'user' => 'root',
			'pass' => ''
		),
		'live' => array(
			'host' => 'localhost',
			'dbname' => 'onlinea6_uv',
			'user' => 'onlinea6_uv',
			'pass' => 'warner2009'
		)
	);

	$dbVars = $enviroments[$env];

	$pdo = new PDO("mysql:host=". $dbVars['host'] .";dbname=". $dbVars['dbname'] .";",$dbVars['user'],$dbVars['pass']);
	if($env == 'local') $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $pdo;
}
?>