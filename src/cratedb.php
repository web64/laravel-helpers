<?php

/**
 *  CrateDB Helpers
 */
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