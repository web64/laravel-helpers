<?php

// Logging
// Debug
// Date
// CrateDB
// MySQL
// Neo4j
// Deprecated

if (! function_exists('helper64')) {
    function helper64()
    {
        echo "web64/laravel-helpers is installed!";
    }
}

function domain($url)
{
    return parse_url($url, PHP_URL_HOST);
}



if (! function_exists('sql'))
{
    function sql( $sql, $bindings = null)
    {
        if ( empty($bindings) ) return $sql;

        foreach( $bindings as $key => $value )
        {
            if (is_numeric($key))
            {
                // ? bindings
                $sql = preg_replace(
                    "#\?#", 
                    is_numeric($value) ? $value : "'" . $value . "'", 
                    $sql, 
                    1
                );
            }else{
                // :bindings 
                $sql = preg_replace(
                    "/(:{$key}\b)/", 
                    is_numeric($value) ? $value : "'" . $value . "'",
                    $sql,
                    1
                );
            }
            
        }
    
        return $sql;
    }
}

function neo4j_escape( $str )
{
    return str_replace("'", "\'", $str );
}

// not in use
function log64( $filename, $message = null, $type = null )
{
    return;

    if ( empty($message) ) return;

    if ( is_array($message) )
        $message = print_r($message, true);

    $date = date("Y-m-d H:i:s", time() );
    
    if ( $type == 'raw' )
    {
        $line = $message;
    }else{
        $line = "[$date] :" . $message;
    }

    $file_path = storage_path() . "/logs/{$filename}.log";

    $time_start = microtime_float();
    file_put_contents( 
        $file_path,
        $line . PHP_EOL,
        FILE_APPEND);
    
    $time_end = microtime_float();
    $time = $time_end - $time_start;
    
    echo "log64() - file_put_contents(/logs/{$filename}.log) -> ". number_format($time,2)." seconds\n";
}


function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}


function mysql_reldate( $timestamp, $date_format = 'M j' )
{
	if (!is_numeric($timestamp))
		$timestamp = strtotime($timestamp);
	
	$current_year 	= date("Y");
	$art_year 		= date("Y", $timestamp);
	
	if ( $art_year < $current_year)
		return date("j. M Y", $timestamp);
	
	$diff = time() - $timestamp;
	if ($diff < 60)
		return "just now";
		
	$min = 	floor($diff/60);
	
	if ($min < 60 )
		return "$min mins";
		
	$hour = 	floor($min/60);
	if ($hour < 2 )
		return "1h";
	
	
	if ($hour < 24 )
	{
		//return 'Yesterday';
		return "{$hour}h";
	}
	
	return date($date_format, $timestamp);
}

/**
 * 
 * It beeps!
 */
function beep()
{
    echo chr(7);
}


function clear()
{
    echo "\033[2J\033[;H";
}

/**
 * 
 * @param mixed $str timestamp or date to be converted to mysql format
 */
function mysql_date( $str = '' )
{
    if ( empty($str) )
        return date('Y-m-d H:i:s', time() );

    if ( is_numeric( $str ) )
        return date('Y-m-d H:i:s', $str );
    else
        return date('Y-m-d H:i:s', strtotime($str) );
}

// convert bytes to human readable format
if (! function_exists('formatSizeUnits')) {
    function formatSizeUnits($bytes, $decimals = 2)
    {
        if ($bytes >= 1073741824)
        {
            $str = number_format($bytes / 1073741824, $decimals) . 'gb';
        }
        elseif ($bytes >= 1048576)
        {
            $str = number_format($bytes / 1048576, $decimals) . 'mb';
        }
        elseif ($bytes >= 1024)
        {
            $str = number_format($bytes / 1024, 0) . 'kb';
        }
        elseif ($bytes > 0)
        {
            $str = number_format($bytes / 1024, 0) . 'kb';
        }
        else
        {
            $str = '0 bytes';
        }

        return $str;
    }
}
