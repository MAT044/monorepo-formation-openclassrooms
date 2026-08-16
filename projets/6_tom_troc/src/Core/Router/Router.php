<?php

namespace TomTroc\Core\Router;

use TomTroc\Controller\HomeController;
use TomTroc\Core\Http\Method;
use TomTroc\Core\Http\Request;
use TomTroc\Core\Http\Response;

class Router {
    public function findRoute(Request $request): Route
    {
        return new Route('app_home', '', fn() => (new HomeController())->index(), Method::GET);
    }

    public function handleRequest(Request $request)
    {
        $route = $this->findRoute($request);
        $response = ($route->controller)($request);

        if(!$response instanceof Response){
            $response = new Response(200, (string) $response);
        }

        http_response_code($response->code);
        echo $response->body;
        die();
    }
}