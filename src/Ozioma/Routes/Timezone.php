<?php

namespace Chibex\Ozioma\Routes;

use Chibex\Ozioma\Contracts\RouteInterface;

class Timezone implements RouteInterface
{

    public static function root()
    {
        return '/time-zones';
    }

    public static function getList()
    {
        return [
            RouteInterface::METHOD_KEY => RouteInterface::GET_METHOD,
            RouteInterface::ENDPOINT_KEY => Timezone::root(),
        ];
    }
}
