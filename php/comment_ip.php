<?php
//var_dump($error_text);
$currentTime = time();
$timeoutSeconds = 900*4*24;//15mins till autodelete with refresh()
$timeout = $currentTime - $timeoutSeconds;
$topic_query = pdo_query("SELECT ip FROM $table WHERE timestamp > $timeout");

while($topic = pdo_fetch_array($topic_query))
 {
	 if($topic['ip']==$getIP){
	 	$error_text[] = "Sorry, Guest can only post once every 24 hours!";
	 	return;
	 }
	 //var_dump($topic);

 }
?>
