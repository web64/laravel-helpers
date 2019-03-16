<?php

namespace Web64\LaravelHelpers;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Web64\LaravelHelpers\Skeleton\SkeletonClass
 */
class LaravelHelpersFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-helpers';
    }
}
