<?php


function file_get_collection( $file )
{
    $lineCollection = collect();
    foreach(file( $file ) as $line)
    {
        if ( !empty(trim($line)) )
            $lineCollection[] = trim($line);
    }

    return $lineCollection;
}

// die and dump array - instead of dump( $twitterUser->toArray() );
function dda( $model )
{
    if ( method_exists ( $model , 'toArray' ) )
        dd( $model->toArray() );
    else
        dd( $model );
}

// dump array - instead of dump( $twitterUser->toArray() );
function da( $model )
{
    if ( method_exists ( $model , 'toArray' ) )
        dump( $model->toArray() );
    else
        dump($model);
}

function domain($url)
{
    return parse_url($url, PHP_URL_HOST);
}

// Show real SQL for query
function laravel_sql( $query )
{
    $sql = $query->toSql();

    foreach( $query->getBindings() as $binding )
    {
        $sql = preg_replace("#\?#", is_numeric($binding) ? $binding : "'" . $binding . "'", $sql, 1);
    }

    return $sql;
}

function sql( $sql, $bindings)
{
    foreach( $bindings as $binding )
    {
        $sql = preg_replace("#\?#", is_numeric($binding) ? $binding : "'" . $binding . "'", $sql, 1);
    }

    return $sql;
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

    // [2017-09-01 14:13:02] local.INFO: 
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


function create_reldate( $timestamp, $date_format = 'M j' )
{
    if (!is_numeric($timestamp))
        $timestamp = strtotime($timestamp);
    else
        $timestamp = $timestamp / 1000;

    return mysql_reldate( $timestamp, $date_format = 'M j' );
}


function crate_carbon( $ts_milliseconds )
{
    if ( !$ts_milliseconds )    return null;

    if (!is_numeric($ts_milliseconds))
        $timestamp = strtotime($ts_milliseconds);
    else
        $timestamp = $ts_milliseconds / 1000;

    return \Carbon\Carbon::createFromTimestamp( $timestamp );
    
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

/**
 * 
 * @param mixed $str timestamp or date to be converted to CrateDB format
 */
function crate_date( $str = '' )
{
    if ( empty($str) )
        return date('Y-m-d\TH:i:s', time() );

    if ( is_numeric( $str ) )
        return date('Y-m-d\TH:i:s', $str );
    else
        return date('Y-m-d\TH:i:s', strtotime($str) );
}

function crate_for_humans( $timestamp = '', $short = true )
{
    if ( ! $timestamp ) return '';

    // \Carbon\Carbon::setLocale('no');
    if ( $short)
        return \Carbon\Carbon::createFromTimestamp( $timestamp/1000 )->diffForHumans(null, false, true);
    else
        return \Carbon\Carbon::createFromTimestamp( $timestamp/1000 )->diffForHumans();
}

function crate_escape( $str )
{
    return str_replace("'", "''", $str );
}

/**
 * Convert DB results from array of array to Laravel default array of stdClass objects
 */
function crate2obj( $dbres )
{
    if ( empty($dbres) )    return $dbres;

    for( $x=0; $x < count($dbres); $x++ )
    {
        $dbres[$x] = (object) $dbres[$x];
    }

    return $dbres;
}

/* https://laracasts.com/discuss/channels/general-discussion/whats-the-cleanest-way-to-add-the-active-class-to-bootstrap-link-components
|--------------------------------------------------------------------------
| Detect Active Route - Blade
|--------------------------------------------------------------------------
|
| Compare given route with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function isActiveRoute($route, $output = "active")
{
    if (Route::currentRouteName() == $route) return $output;
}