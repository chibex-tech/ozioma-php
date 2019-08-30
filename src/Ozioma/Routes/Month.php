<?php

namespace Chibex\Ozioma\Routes;

use Chibex\Ozioma\Contracts\RouteInterface;

class Month implements RouteInterface
{

    public static function root()
    {
        return '/months';
    }

    public static function getList()
    {
        return [
            RouteInterface::METHOD_KEY => RouteInterface::GET_METHOD,
            RouteInterface::ENDPOINT_KEY => Month::root(),
        ];
    }
}
