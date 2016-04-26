<?php

include('db-connection.php');

$incidents =<<<EOF
   CREATE TABLE IF NOT EXISTS INCIDENTS
   (
      ID             INTEGER         PRIMARY KEY       NOT NULL UNIQUE,
      SHORTDESC      TEXT                                      	,
      FULLDESC       TEXT                                      	,
      START          TEXT                                      	,
      END            TEXT                                      	,
      SEV            INTEGER                                 	   ,
      TYPE           INTEGER                                   	,
      TWEETED        BOOLEAN									            ,
      LASTTWEET		TEXT		                                    ,
      SEVERITYTEXT   TEXT                                         ,
      ROADNAME       TEXT                                         ,
      DIRECTION      TEXT                                         
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