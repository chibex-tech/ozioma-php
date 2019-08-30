<?php

namespace Chibex\Ozioma\Exception;

class ApiException extends OziomaException
{
    private $responseObject;
    private $requestObject;

    public function __construct($message, $responseObject, $requestObject)
    {
        parent::__construct($message);
        $this->responseObject = $responseObject;
        $this->requestObject = $requestObject;
    }

    public function getResponseObject()
    {
        return $this->responseObject;
    }

    public function getRequestObject()
    {
        return $this->requestObject;
    }
}
