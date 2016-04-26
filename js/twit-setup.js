var Twit = require('twit')
 
var T = new Twit({
    consumer_key:         '8FS7scToNuDZQ83mSkmiFEAdz'
  , consumer_secret:      'ilEBGWZ2VMGGyvAfSAVWbd87ebqpDj9RxDXQddND15SJ6Cgsq0'
  , access_token:         '180362622-UZb5Xsc534TVAg6d6WHCOyN7PjDuY7U608WrySOB'
  , access_token_secret:  'SXA1HXupJLY17tiwPv1BwfHbhQoF8sf6mBJ4gPnl2oMul'
})
 
// 
//  tweet 'hello world!' 
// 
//T.post('statuses/update', { status: 'hello world!' }, function(err, data, response) {
//  console.log(data)
//})