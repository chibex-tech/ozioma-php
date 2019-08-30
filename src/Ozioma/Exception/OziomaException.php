<?php

namespace Chibex\Ozioma\Exception;

class OziomaException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
