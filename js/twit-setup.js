var Twit = require('twit')
 
var T = new Twit({
    consumer_key:         '8FS7scToNuDZQ83mSkmiFEAdz'
  , consumer_secret:      'CONSUMERSECRET'
  , access_token:         '180362622-UZb5Xsc534TVAg6d6WHCOyN7PjDuY7U608WrySOB'
  , access_token_secret:  'SECRETTOKEN'
})
 
// 
//  tweet 'hello world!' 
// 
//T.post('statuses/update', { status: 'hello world!' }, function(err, data, response) {
//  console.log(data)
//})
