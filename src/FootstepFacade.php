<?php

namespace Albofish\Footstep;

use Illuminate\Support\Facades\Facade;

class FootstepFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Footstep::class;
    }
}
