<?php
/**
 *  Laravel helpers
 * 
 */
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


// Die and Dump Laravel builder/query SQL
function ddsql( $query )
{
    dd(
        laravel_sql( $query )
    );
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