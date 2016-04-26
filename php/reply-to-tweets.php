<?php

require __DIR__ . '/vendor/autoload.php';
//require "twitteroauth/autoload.php";
require "oauth_vars.php";
require "db-connection.php";
use Abraham\TwitterOAuth\TwitterOAuth;
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);


$replies = $connection->get("statuses/mentions_timeline");

// var_dump($replies[0]);

foreach ($replies as $t) {
	$tagList = $t->entities->hashtags;
	$tweetText = $t->text;
	$user = $t->screen_name;
	$name = $t->name;
	$replyTweetId = $t->id_str;
	$created = $t->created_at;
	if(strpos($t->text, "#howsmydrive")){
		foreach ($tagList as $h) {
			echo "<br/>" . strtolower($h->text) . "<br/>" ;
		}
	}
}

// object(stdClass)#5 (23) { ["created_at"]=> string(30) "Mon Mar 21 20:41:14 +0000 2016" ["id"]=> int(712016238420037633) ["id_str"]=> string(18) "712016238420037633" ["text"]=> string(26) "@cbs46Traffic #howsmydrive" ["truncated"]=> bool(false) ["source"]=> string(66) "Twitter Web Client" ["in_reply_to_status_id"]=> NULL ["in_reply_to_status_id_str"]=> NULL ["in_reply_to_user_id"]=> int(180362622) ["in_reply_to_user_id_str"]=> string(9) "180362622" ["in_reply_to_screen_name"]=> string(12) "CBS46Traffic" ["user"]=> object(stdClass)#10 (40) { ["id"]=> int(1428654661) ["id_str"]=> string(10) "1428654661" ["name"]=> string(16) "Jonathan Andrews" ["screen_name"]=> string(15) "Jonathandrews89" ["location"]=> string(0) "" ["description"]=> string(143) "I work for @CBS46 News and help make it work for you. Music lover, gadget addict, news junkie, budding web designer. My opinions are just that." ["url"]=> string(22) "http://t.co/0HUFvLGDLI" ["entities"]=> object(stdClass)#11 (2) { ["url"]=> object(stdClass)#12 (1) { ["urls"]=> array(1) { [0]=> object(stdClass)#13 (4) { ["url"]=> string(22) "http://t.co/0HUFvLGDLI" ["expanded_url"]=> string(23) "http://jonathanandre.ws" ["display_url"]=> string(16) "jonathanandre.ws" ["indices"]=> array(2) { [0]=> int(0) [1]=> int(22) } } } } ["description"]=> object(stdClass)#14 (1) { ["urls"]=> array(0) { } } } ["protected"]=> bool(false) ["followers_count"]=> int(392) ["friends_count"]=> int(775) ["listed_count"]=> int(9) ["created_at"]=> string(30) "Tue May 14 19:15:56 +0000 2013" ["favourites_count"]=> int(1026) ["utc_offset"]=> int(-25200) ["time_zone"]=> string(26) "Pacific Time (US & Canada)" ["geo_enabled"]=> bool(true) ["verified"]=> bool(true) ["statuses_count"]=> int(1191) ["lang"]=> string(2) "en" ["contributors_enabled"]=> bool(false) ["is_translator"]=> bool(false) ["is_translation_enabled"]=> bool(false) ["profile_background_color"]=> string(6) "C0DEED" ["profile_background_image_url"]=> string(48) "http://abs.twimg.com/images/themes/theme1/bg.png" ["profile_background_image_url_https"]=> string(49) "https://abs.twimg.com/images/themes/theme1/bg.png" ["profile_background_tile"]=> bool(false) ["profile_image_url"]=> string(75) "http://pbs.twimg.com/profile_images/481257335403589633/wCD6u3Bu_normal.jpeg" ["profile_image_url_https"]=> string(76) "https://pbs.twimg.com/profile_images/481257335403589633/wCD6u3Bu_normal.jpeg" ["profile_link_color"]=> string(6) "0084B4" ["profile_sidebar_border_color"]=> string(6) "C0DEED" ["profile_sidebar_fill_color"]=> string(6) "DDEEF6" ["profile_text_color"]=> string(6) "333333" ["profile_use_background_image"]=> bool(true) ["has_extended_profile"]=> bool(false) ["default_profile"]=> bool(true) ["default_profile_image"]=> bool(false) ["following"]=> bool(false) ["follow_request_sent"]=> bool(false) ["notifications"]=> bool(false) } ["geo"]=> NULL ["coordinates"]=> NULL ["place"]=> NULL ["contributors"]=> NULL ["is_quote_status"]=> bool(false) ["retweet_count"]=> int(0) ["favorite_count"]=> int(0) ["entities"]=> object(stdClass)#15 (4) { ["hashtags"]=> array(1) { [0]=> object(stdClass)#16 (2) { ["text"]=> string(11) "howsmydrive" ["indices"]=> array(2) { [0]=> int(14) [1]=> int(26) } } } ["symbols"]=> array(0) { } ["user_mentions"]=> array(1) { [0]=> object(stdClass)#17 (5) { ["screen_name"]=> string(12) "CBS46Traffic" ["name"]=> string(13) "CBS46 Traffic" ["id"]=> int(180362622) ["id_str"]=> string(9) "180362622" ["indices"]=> array(2) { [0]=> int(0) [1]=> int(13) } } } ["urls"]=> array(0) { } } ["favorited"]=> bool(false) ["retweeted"]=> bool(false) ["lang"]=> string(3) "und" }


?>