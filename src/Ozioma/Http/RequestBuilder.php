<?php

namespace Chibex\Ozioma\Http;

use \Chibex\Ozioma\Contracts\RouteInterface;
use \Chibex\Ozioma\Helpers\Router;
use \Chibex\Ozioma;

class RequestBuilder
{
    protected $oziomaObj;
    protected $interface;
    protected $request;

    public $payload = [ ];
    public $sentargs = [ ];

    public function __construct(Ozioma $oziomaObj, $interface, array $payload = [ ], array $sentargs = [ ])
    {
        $this->request = new Request($oziomaObj);
        $this->oziomaObj = $oziomaObj;
        $this->interface = $interface;
        $this->payload = $payload;
        $this->sentargs = $sentargs;
    }

    public function build()
    {
        $this->request->headers["Access-Key"] = $this->oziomaObj->access_key;
        $this->request->headers["User-Agent"] = "Ozioma/v2 PhpBindings/" . Ozioma::VERSION;
        $this->request->endpoint = Router::OZIOMA_API_ROOT . $this->interface[RouteInterface::ENDPOINT_KEY];
        $this->request->method = $this->interface[RouteInterface::METHOD_KEY];
        $this->moveArgsToSentargs();
        $this->putArgsIntoEndpoint($this->request->endpoint);
        $this->packagePayload();
        return $this->request;
    }

    public function packagePayload()
    {
        if (is_array($this->payload) && count($this->payload)) {
            if ($this->request->method === RouteInterface::GET_METHOD) {
                $this->request->endpoint = $this->request->endpoint . '?' . http_build_query($this->payload);
            } else {
                $this->request->body = json_encode($this->payload);
            }
        }
    }

    public function putArgsIntoEndpoint(&$endpoint)
    {
        foreach ($this->sentargs as $key => $value) {
            $endpoint = str_replace('{' . $key . '}', $value, $endpoint);
        }
    }

    public function moveArgsToSentargs()
    {
        if (!array_key_exists(RouteInterface::ARGS_KEY, $this->interface)) {
            return;
        }
        $args = $this->interface[RouteInterface::ARGS_KEY];
        foreach ($this->payload as $key => $value) {
            if (in_array($key, $args)) {
                $this->sentargs[$key] = $value;
                unset($this->payload[$key]);
            }
        }
    }
}
