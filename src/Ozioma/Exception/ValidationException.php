<?php

namespace Chibex\Ozioma\Exception;

class BadMetaNameException extends OziomaException
{
    public $errors;
    public function __construct($message, array $errors = [])
    {
        parent::__construct($message);
        $this->errors = $errors;
    }
}
