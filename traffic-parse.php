<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

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
	clear:left;}

h2.header .time{
	font-size:0.8em;
	}
h2.header .roadName{font-size:1.2em;}	

h2.header.HighImpact{
	background-color:darkred;
	}
h2.header.ModerateImpact{
	background-color:#FC0}

h2.header small {
	margin-left:4px;
	}
</style>
</head>

<body>

<div id="traffic"></div>
<script src="https://code.jquery.com/jquery-2.1.4.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js" type="text/javascript"></script>
<script src="js/libs/moment-timezone-with-data.js" type="text/javascript"></script>
<!-- <script src="traffic-parse-xml.js" type="text/javascript"></script> -->
<script src="js/traffic-parse.js" type="text/javascript"></script>
<script>
// parseRSSXml('http://data-services.wsi.com/201303/en-us/33408464/traffic.xml','#traffic');
parseRSSjson('http://data-services.wsi.com/201303/en-us/14367151/traffic.json','#traffic');
</script>
</body>
</html>