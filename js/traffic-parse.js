var now = moment();
function compTime(time){
	var utcTime = moment.utc(time, "M/D/YYYY h:m:s a");
	return utcTime.fromNow();
	/*
	var utc = moment(time, "M/D/YYYY h:m:s a");
	utcTz = utc.tz('America/New_York');
	return utcTz.fromNow();
	*/
	};
console.log(now);

// 1/13/2016 9:28:37 PM
function parseRSSjson(url, container) {
  $.ajax({
    url: url,
    dataType: 'json',
    success: function(data) {
		console.log(data);
		//console.log(data.incidents);
		//console.log(data.drivetimes);
      
	  $.each(data.incidents, function(key, value){
		var timeSince = compTime(value.startTimeUtc);
		var timeUntil = compTime(value.endTimeUtc);

        var thehtml = '<div class="trafficIncident"><h2 class="header ';
			thehtml += value.severityText.replace(/\s+/g, ''); 
			thehtml += '"><span class="time until"> Reported: ';
			thehtml += timeSince ;
			thehtml += '</span><span class="roadName">';
			thehtml += value.roadName;
			thehtml += ' ';
			if (value.direction != 'None') {
				thehtml += value.direction;
			}
			thehtml +='</span><span class="time since"> Expected clear: '; 
			thehtml += timeUntil; 
			thehtml += '</span></small></h2> <p>';
			thehtml += value.fullDescription; 
			thehtml += '</p></div>';
        $(container).append(thehtml);
      });
	
	  /*$.each(data.drivetimes, function(key, value){
         var thehtml = '<h3>'+ value.pathName +'</h3><p>'+ value.roadNames +'</p><p>'+ value.roadDirection +'</p><p>'+ value.avgSpeedMph +'</p>';
        $(container).append(thehtml);
      });*/
    }
  });
}

//http://data-services.wsi.com/201303/en-us/33408464/traffic.json