<?php
//todo: finish this table for incoming tweets
include('db-connection.php');

$incidents =<<<EOF
   CREATE TABLE IF NOT EXISTS INCTWEETS
   (
      ID             INTEGER         PRIMARY KEY       NOT NULL UNIQUE,
      TWEETTEXT      TEXT                                      	,
      HASHTAGS       TEXT                                      	,
      USERID         TEXT                                      	,
      USERNAME       TEXT                                      	,
      STREETNAMES    TEXT                                      
   );
EOF;


$ret = $db->exec($incidents);

if(!$ret){
   echo $db->lastErrorMsg();
} else {
   echo "Table created successfully or already exists\n";
}

$db->close();
unset($db);

?>