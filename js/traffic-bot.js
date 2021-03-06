var _           = require('lodash');
var Client      = require('node-rest-client').Client;
var Twit        = require('twit');
var async       = require('async');

var t = new Twit({
  consumer_key       	: process.env.TRAFFICBOT_TWIT_CONSUMER_KEY,
  consumer_secret      	: process.env.TRAFFICBOT_TWIT_CONSUMER_SECRET,
  access_token          : process.env.TRAFFICBOT_TWIT_ACCESS_TOKEN,
  access_token_secret   : process.env.TRAFFICBOT_TWIT_ACCESS_TOKEN_SECRET
});
var wordnikKey          = process.env.WORDNIK_API_KEY;