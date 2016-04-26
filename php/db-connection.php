<?php

class trafficDB extends SQLite3
{
   function __construct()
   {
      $this->open(__DIR__ . '/db/incidents.db');
      // $this->open('/home/jonand52/jonathanandre.ws/projects/traffic-tweet-php/db/incidents.db');

   }
	public function getTheTweets(){ $db->prepare(
		'SELECT * 
		from INCIDENTS 
		where TWEETED > 0 
		AND SEV >= 3
		ORDER BY TYPE DESC	
		LIMIT 4'
		);
	}
	public function updateTweeted() {
		$db->prepare(
		'UPDATE INCIDENTS 
		set TWEETED = TWEETED + 1,
		LASTTWEET = :now 
		where ID= :id'
		);
	}
}


$db = new trafficDB();
$db->busyTimeout(10000);

if(!$db){
   echo $db->lastErrorMsg();
} else {
   echo "Opened database successfully\n";
}

?>