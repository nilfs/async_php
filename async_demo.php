<?php

require_once dirname(__FILE__).'/async.php';

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();

// request
$handles = array(
	async\http_get( "http://localhost:8888/async_test/wait.php?time=1&dummy=100#hogehoge" ),
	async\http_get( "http://localhost:8888/async_test/wait.php?time=2&dummy=100#hogehoge" )
);

// wait response
async\wait_response( $handles );

// get response
foreach($handles as $handle){
	echo async\get_response($handle) . "<br>";
}

$time_end = microtime_float();
echo "time=" . ( $time_end - $time_start );
