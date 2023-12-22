var Twit = require('twit')
 
var T = new Twit({
    consumer_key:         'WHATTHE'
  , consumer_secret:      'CONSUMERSECRET'
  , access_token:         'NOWAY'
  , access_token_secret:  'SECRETTOKEN'
})
 
// 
//  tweet 'hello world!' 
// 
//T.post('statuses/update', { status: 'hello world!' }, function(err, data, response) {
//  console.log(data)
//})
