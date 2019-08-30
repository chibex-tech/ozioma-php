<?php
namespace Chibex\Ozioma\Helpers;

use \Chibex\Ozioma\Http\RequestBuilder;

class Caller
{
    private $oziomaObj;

    public function __construct($oziomaObj)
    {
        $this->oziomaObj = $oziomaObj;
    }

    public function callEndpoint($interface, $payload = [ ], $sentargs = [ ])
    {
        $builder = new RequestBuilder($this->oziomaObj, $interface, $payload, $sentargs);
        
        return $builder->build()->send()->wrapUp();
    }
}
