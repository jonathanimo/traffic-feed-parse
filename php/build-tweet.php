<?php
	require __DIR__ . '/vendor/autoload.php';
	include "db-connection.php";


	//URL for your traffic service goes here

	$json_url = "http://data-services.wsi.com/201303/en-us/33408464/traffic.json";

	$now = new \Moment\Moment();
	$nowToPut = $now->setTimezone('UTC');
	
	//get json files for log and max traffic and decode
	$json = file_get_contents($json_url);
	$obj = json_decode($json);
	$oldIncidents = [];

	//todo: add column to /createincidentstable.php to add fields for severity and type to mix up the latest tweets, also, should add tweet ID field to this to allow for replies.

	foreach($obj->incidents as $inc){
		$id = $inc->incidentId;
		$shortDesc = "'". $inc->shortDescription . "'";
		$txt = "'". $inc->fullDescription . "'";
		$sev = $inc->severity;
		$type = $inc->incidentType;
		$start = new \Moment\Moment($inc->startTimeUtc);
		$end = new \Moment\Moment($inc->endTimeUtc);
		// $startMoment = "'" . $start->subtractHours(4)->format('Y-m-d h:i A.') . "'";
		// $endMoment = "'" . $end->subtractHours(4)->format('Y-m-d h:i A.') . "'";
		$startMoment = "'" . date_timestamp_get($start) . "'";
		$endMoment = "'" .  date_timestamp_get($end) . "'";
		$tweeted = 0;
		$sevText = "'". $inc->severityText . "'";
		$roadName = "'". $inc->roadName . "'";
		$direction = "'". $inc->direction . "'";
		$insertUpdate =<<<EOF
			INSERT OR IGNORE INTO INCIDENTS (ID,SHORTDESC,FULLDESC,START,END,SEV,TYPE,TWEETED,SEVERITYTEXT,ROADNAME,DIRECTION)
			VALUES ($id, $shortDesc, $txt, $startMoment, $endMoment, $sev, $type,$tweeted,$sevText,$roadName,$direction);
EOF;
		$ret = $db->exec($insertUpdate);
		
		// echo '<br/>' . /*$db->changes() .*/ 'records created SEVERITY: ' . $sev . ' TYPE:' . $type . 'START TIME: ' . $startMoment .  '// END TIME: ' .  $endMoment . 'DESCRIPTION: ' . $shortDesc . '<br/>';

		if(!$ret){
		  echo $db->lastErrorMsg();
		} else {
		  echo '<br/>' . $db->changes() . 'records created <h3>' . $id .  '</h3> SEVERITY: ' . $sev . ' TYPE:' . $type . 'START TIME: ' . $startMoment .  '// END TIME: ' .  $endMoment . 'DESCRIPTION: ' . $shortDesc . '<br/> SEVERITY: ' . $sevText . '<br/> ROAD NAME: ' . $roadName . '<br/> direction: ' . $direction .'<br/><br/>' ;
		}
	}

	$selectOld = $db->prepare(
		'SELECT * 
		FROM INCIDENTS 
		WHERE END < :now '
	);

	//run selectOld function to select old items
	$selectOld->bindValue(':now', date_timestamp_get($nowToPut));
	$old = $selectOld->execute();




	//run selectOld function to select old items

	while($row = $old->fetchArray(SQLITE3_ASSOC)){
		$id = $row['ID'];
		$deleteOld = $db->Query( "DELETE FROM INCIDENTS WHERE ID =" . $id );
		if(!$deleteOld){
			echo $db->lastErrorMsg();
		} else {
			//delete images if item is being delete
			echo $id . 'deleted.';
			$filePath = "./assets/images/_" . $id . "_img.png";
			if(file_exists($filePath)){
				unlink($filePath);
				echo $filePath;
			}
		}
	}







	//loop over old items here, should delete photos here as well
	
	// while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
	// 	$id = $row['ID'];
	// 	//run function to delete old records from table
	// 	$deleteOld->bindValue(':id', $id);
	// 	$remove = $deleteOld->execute();
		


	// 	$remove = $deleteOld->execute();
	// 	if (!$remove) {
	// 		
	// 	}
	// 	else {
	// 	echo '<br/>' . $db->changes() . 'records deleted //' . $id . ' SEVERITY: ' . $sev . ' TYPE:' . $type . 'START TIME: ' . $startMoment .  '// END TIME: ' .  $endMoment . 'DESCRIPTION: ' . $shortDesc . '<br/> SEVERITY: ' . $sevText . '<br/> ROAD NAME: ' . $roadName . '<br/> direction: ' . $direction .'<br/><br/>' ;
	// 	}
	// }

	//close db and free resources
	$db->close();
	unset($db);
	
?>
