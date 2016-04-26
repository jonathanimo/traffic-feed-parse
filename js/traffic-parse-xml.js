function parseRSSXml(url, container) {
  $.ajax({
    url: url,
    dataType: 'xml',
    success: function(data) {
		/*test output*/
		console.log(data);
      //console.log(data.traffic.incidents);
	  //console.log(data.traffic.drivetimes);
	  /*test output end*/
      //$(container).html('<h2>'+data.driveTimes.feed.title+'</h2>');
	  
	  /*$.each(data.drivetimes, function(key, value){
		  var thehtml = '<p>'+ value.fullDescription +'</p>';
		 $(container).append(thehtml);
		});*/
 
	$.each(data.incidents, function(key, value){
		var thehtml = '<p>'+ value.fullDescription +'</p>';
		$(container).append(thehtml);
		});
    }
  });
}

//http://data-services.wsi.com/201303/en-us/33408464/traffic.xml