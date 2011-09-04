<?php

namespace async;

function http_get($url)
{	
	$parseUrl = parse_url($url);
	if(!isset($parseUrl['port'])){
		$parseUrl['port'] = 80;
	}
	$path = $parseUrl['path'];
	if(isset($parseUrl['query']))
		$path .= '?' . $parseUrl['query'];
	if(isset($parseUrl['fragment']))
		$path .= '#' . $parseUrl['fragment'];
	
	$fp = fsockopen ($parseUrl['host'], $parseUrl['port'], $errno, $errstr, 5);
	if (!$fp) {
	    echo "Error: $errstr ($errno)<br>\n";
	} else {
	    fputs ($fp, "GET ". $path ." HTTP/1.0\r\n\r\n");
	    socket_set_blocking($fp, false);
	}
	
	return $fp;
}

function wait_response( $_read ){
	$write  = NULL;
	$except = NULL;
	if( !is_array($_read) )
		$read = array( $_read );
	else
		$read = $_read;
		
	while(true){
		$copy = $read;
		$num = stream_select( $copy, $write, $except, 0 );
		if( count($read) == $num )
			break;
	}
}

function get_response( $fp ){
	return stream_get_contents( $fp );
}
