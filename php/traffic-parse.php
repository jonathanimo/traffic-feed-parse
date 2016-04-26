<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	require __DIR__ . '/vendor/autoload.php';
	include "db-connection.php";
	date_default_timezone_set('America/New_York');
 ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
.trafficIncident{
	font-family:Arial, Helvetica, sans-serif;
	font-size:1em;
	}
h2.header{
	background-color:black;
	color:white;
	display:inline-block;
	padding: 4px 15px;
	font-size:2em;
	}
h2.header *{
	float:left;
	clear:left;
	}

h2.header .time{
	font-size:0.8em;
	}
h2.header .roadName .dir{
	font-size:1.2em;
}	

h2.header.HighImpact{
	background-color:darkred;
	}
h2.header.ModerateImpact{
	background-color:#FC0}

h2.header small {
	margin-left:4px;
	}
h2 span.dir{
	clear:none;
	margin-left:0.3em;
}
</style>
</head>

<body>
<div id="traffic">

	<?php 
		$getTheTweets= $db->prepare(
			'SELECT * 
			FROM INCIDENTS
			ORDER BY SEV DESC, END ASC
			'
		);

		$ret = $getTheTweets->execute();

	while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
		$endTime = $row['END'];
		$endTimeMoment = new \Moment\Moment("@" . $endTime, 'UTC');
		$endRel = $endTimeMoment->fromNow();
		$startTime = $row['START'];
		$startTimeMoment = new \Moment\Moment("@" . $startTime,'UTC');
		$startRel = $startTimeMoment->fromNow();
		$sevText = str_replace(' ', '', $row['SEVERITYTEXT']);

		$road = $row['ROADNAME'];

		echo '<div class="trafficIncident"><h2 class="header ' . $sevText . '"><span class="time until"> Reported: ' . $startRel->getRelative() . '</span><span class="roadName">' . $road . '</span><span class="dir"> ' . $row['DIRECTION'] . ' </span><span class="time since"> Expected clear: ' . $endRel->getRelative() . ' </span></h2> <p>' . $row['FULLDESC'] . '</p></div>';
	}
	?>	

</div>
<script src="https://code.jquery.com/jquery-2.1.4.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js" type="text/javascript"></script>
<script src="../js/libs/moment-timezone-with-data.js" type="text/javascript"></script>


<?php 
	$db->close();
	unset($db);
?>
</body>
</html>