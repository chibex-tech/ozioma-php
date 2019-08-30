<?php

namespace Chibex\Ozioma\Routes;

use Chibex\Ozioma\Contracts\RouteInterface;

class Message implements RouteInterface
{

    public static function root()
    {
        return '/messages';
    }

    public static function send()
    {
        return [
            RouteInterface::METHOD_KEY => RouteInterface::POST_METHOD,
            RouteInterface::ENDPOINT_KEY => Message::root() . '/send',
            RouteInterface::PARAMS_KEY => [
                'sender',
                'message',
                'recipients',
                'use_corporate_route',
                'callback_url',
            ],
        ];
    }

    public static function schedule()
    {
        return [
            RouteInterface::METHOD_KEY => RouteInterface::POST_METHOD,
            RouteInterface::ENDPOINT_KEY => Message::root() . '/schedule',
            RouteInterface::PARAMS_KEY => [
                'sender',
                'message',
                'recipients',
                'use_corporate_route',
                'callback_url',
                'extras' => [
                    'deliver_at',
                    'time_zone_id',
                ],
            ],
        ];
    }
    
    public static function fetch()
    {
        return [
            RouteInterface::METHOD_KEY => RouteInterface::GET_METHOD,
            RouteInterface::ENDPOINT_KEY => Message::root() . '/{id}',
            RouteInterface::ARGS_KEY => ['id'],
        ];
    }

    public static function getExtras()
    {
        return [
            RouteInterface::METHOD_KEY => RouteInterface::GET_METHOD,
            RouteInterface::ENDPOINT_KEY => Message::root() . '/{id}/extras',
            RouteInterface::ARGS_KEY => ['id'],
        ];
    }
}
