<?php

namespace Chibex;

use \Chibex\Ozioma\Helpers\Router;

class Ozioma
{
    public $access_key;
    public $use_guzzle = false;
    public static $fallback_to_file_get_contents = true;
    const VERSION="1.0.0";

    public function __construct($access_key)
    {
        if (!is_string($access_key) || !(substr($access_key, 0, 7)==='OZIACK-')) {
            throw new \InvalidArgumentException('A Valid Ozioma Access Key must start with \'OZIACK-\'.');
        }
        if (!is_string($access_key) || !(substr($access_key, strlen($access_key)-3)==='-CT')) {
            throw new \InvalidArgumentException('A Valid Ozioma Access Key must end with \'-CT\'.');
        }
        $this->access_key = $access_key;
    }

    public function useGuzzle()
    {
        $this->use_guzzle = true;
    }

    public static function disableFileGetContentsFallback()
    {
        Ozioma::$fallback_to_file_get_contents = false;
    }

    public static function enableFileGetContentsFallback()
    {
        Ozioma::$fallback_to_file_get_contents = true;
    }

    public function __call($method, $args)
    {
        if ($singular_form = Router::singularFor($method)) {
            return $this->handlePlural($singular_form, $method, $args);
        }
        return $this->handleSingular($method, $args);
    }

    private function handlePlural($singular_form, $method, $args)
    {
        if ((count($args) === 1 && is_array($args[0]))||(count($args) === 0)) {
            return $this->{$singular_form}->__call('getList', $args);
        }
        throw new \InvalidArgumentException(
            'Route "' . $method . '" can only accept an optional array of filters and '
            .'paging arguments (perPage, page).'
        );
    }

    private function handleSingular($method, $args)
    {
        if (count($args) === 1) {
            $args = [[], [ Router::ID_KEY => $args[0] ] ];
            return $this->{$method}->__call('fetch', $args);
        }
        throw new \InvalidArgumentException(
            'Route "' . $method . '" can only accept an id or code.'
        );
    }

    public function __get($name)
    {
        return new Router($name, $this);
    }
}
