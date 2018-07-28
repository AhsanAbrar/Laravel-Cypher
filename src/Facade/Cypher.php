<?php

namespace Ahsan\Cypher\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ahsan\Cypher
 */
class Cypher extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cypher';
    }

}
