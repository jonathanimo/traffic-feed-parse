<?php
require __DIR__ . '/vendor/autoload.php';
require "oauth_vars.php";
require "db-connection.php";
include "generate-image.php";
use Abraham\TwitterOAuth\TwitterOAuth;
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
date_default_timezone_set('America/New_York');

$now = new \Moment\Moment('now','America/New_York');




/*
function timeCheck($time){
	$convTime = DateTime::createFromFormat('n/j/Y g:i:u A',$time);
	date_timezone_set($convTime,new DateTimeZone('UTC'));
	$timeNow = new DateTime();
	$difference = $timeNow->diff($convTime);	
	// var_dump($timeNow);
	// var_dump($convTime);
	switch ($difference){
		case $difference->a == 1:
			return $difference->format('in %a day %h hours %i minutes.');
		break;
		case $difference->a > 1:
			return $difference->format('in %a days %h hours.');
		break;
		case $difference->h == 1:
			return $difference->format('in %h hour %i minutes.');
		break;
		case $difference->h > 0:
			return $difference->format('in %h hours %i minutes.');
		break;
		default:
			return $difference->format('%i minutes.');
		break;
	}
}
*/

$getTheTweets= $db->prepare(
	'SELECT * 
	FROM INCIDENTS
	WHERE TYPE = 4
	AND SEV >= 3
	ORDER BY TWEETED ASC
	LIMIT 4
	'
	);


$updateTweeted = $db->prepare(
	'UPDATE INCIDENTS 
	set TWEETED = TWEETED + 1,
	LASTTWEET = :now 
	where ID= :id'
	);


function sendTweet($item,$oAuth,$updateQuery){

	$rowId =$item['ID'];
	$end = $item['END'];
	$endTimeMoment = new \Moment\Moment("@" . $end, 'America/New_York');
	$now = new \Moment\Moment('now','America/New_York');
	$nowComp = $now->format('U');
	$fifteenAgo = $now->subtractMinutes(15);
	$fifteenAgoComp = $fifteenAgo->format('U');
	$lastTweet = $item['LASTTWEET'];
	$lastTweetedMoment = new \Moment\Moment($lastTweeted);
	$lastTweetComp = $lastTweetedMoment->format('U');
	$sev = $item['SEV'];
	$type = $item['TYPE'];
	$tweetString = "";

	if (
		$item['TWEETED'] == 0
		&& ($end > $nowComp)
		&& ($lastTweetComp > $fifteenAgoComp)
	) {
		//concatenate string for tweet
		$tweetString .= "NEW: ";
		$tweetString .= $item['SHORTDESC'];
		$tweetString .= '. Expected clear by ';
		$tweetString .= $endTimeMoment->format('h:i A.');
		$tweetString .= ' 	#ATLTraffic';

		//generate image, returns image file path 
		$imgPath = generateImage($sev,$item['FULLDESC'],$rowId);

		//test output, uncomment next line
		// echo '<br/>' . $rowId. ' -- ' . $tweetString . '<br/>SEV: ' . $sev . 'TYPE: ' . $type . '<br/><br/>' . $nowComp. 'vs' . $end . '<br/><br/>';
		// echo '<img style="width:512px" src= "./assets/images/_' . $rowId . '_img.png" />' ;

		
		//TODO: Does this return Tweet ID? If so, should check whether "latest" tweets can be in reply to "new" tweets
		if(file_exists($imgPath)){
			$trafficImage = $oAuth->upload(
				'media/upload', 
				['media' => $imgPath]
			);
			$parameters = array(
			    'status' => $tweetString,
			    'media_ids' => $trafficImage->media_id_string,
			);
			$tweeted = $oAuth->post('statuses/update', $parameters);
			if ($oAuth->getLastHttpCode() == 200) {
				echo "Tweet sent successfully. Text: " . $tweetString;  
				$updateQuery->bindValue(':id', $item['ID']);
				$updateQuery->bindValue(':now', $nowComp);
				$updateQuery->execute();
			} else {
				echo "<br/>something went wrong HTTP CODE". $oAuth->getLastHttpCode() . "<br/>";
			}
		}
	}
		
	elseif(
			($item['TWEETED'] > 0) 
			&& ($end < $nowComp) 
			&& ($lastTweetedMoment < $now->subtractMinutes(15))
	) {
		//concatenate string for tweet
		$tweetString .= "LATEST: ";
		$tweetString .= $item['SHORTDESC'];
		$tweetString .= '. Expected clear by ';
		$tweetString .= $endTimeMoment->format('h:i A.');
		$tweetString .= ' 	#ATLTraffic';

		//generate image, returns file path to image
		$imgPath = generateImage($sev,$item['FULLDESC'],$rowId);
		

		//test output, uncomment next line
		// echo '<br/>' . $rowId. ' -- ' . $tweetString . '<br/>';
		// echo '<img style="width:512px" src= "./assets/images/_' . $rowId . '_img.png" />' ;

		//TODO: Does this return Tweet ID? If so, should check whether "update" tweets can be in reply to "new" tweets
		if(file_exists($imgPath)){
			$trafficImage = $oAuth->upload('media/upload', ['media' => $imgPath]);
			$parameters = [
			    'status' => $tweetString,
			    'media_ids' => $trafficImage->media_id_string
			];
			$tweeted = $oAuth->post('statuses/update', $parameters);

			if ($oAuth->getLastHttpCode() == 200) {
				echo "Tweet sent successfully. Text: " . $tweetString;
				$updateQuery->bindValue(':id', $item['ID']);
				$updateQuery->bindValue(':now', $nowComp);
				$updateQuery->execute();  
			} else {
				echo "<br/> something went wrong HTTP CODE". $oAuth->getLastHttpCode() . "<br/>";
			}
		}
	}
}

$ret = $getTheTweets->execute();

$justHour = date('G');

if ( ( $justHour < 2 ) || ( $justHour > 5 ) ) {
	while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
		sendTweet($row,$connection,$updateTweeted);
		// $endTime = $row['END'];
		// $endTimeMoment = new \Moment\Moment($endTime);
		// echo '<br/>' . $row['ID']. ' -- ' . $row['SHORTDESC'] . 'SEV: ' . $row['SEV'] . 'TYPE: ' . $row['TYPE'] . ' END TIME: ' . $endTimeMoment->addHours(9)->format('h:i A.') .  '<br/>';
	}
} 
else {
	echo "It\'s too late or too early?";
 }

   echo "Operation done successfully\n";
   $db->close();
   unset($db);

?>