<?php

function getContent($page)
{

$select = "SELECT post_content FROM wp_posts WHERE post_name='$page'";

$result = mysql_query($select) or die(mysql_error());

$HTML = str_replace("\n","\n<br/>\n",mysql_fetch_row($result));

echo $HTML[0];
}


function getQuestions($id)
{

$select = "SELECT popup FROM questions WHERE id='$id'";

$result = mysql_query($select) or die(mysql_error());

$HTML = str_replace("\n","\n<br/>\n",mysql_fetch_row($result));

echo $HTML[0];
}


function getImages($id,$pri=true)
{

$select = "SELECT url FROM imageTypes WHERE id='$id'";

$result = mysql_query($select) or die(mysql_error());

$HTML = mysql_fetch_row($result);
if($pri)
echo $HTML[0];
else return $HTML[0];
}


?>