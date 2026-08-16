<?php

namespace TomTroc\Core\Router;

use Exception;
use Throwable;
use TomTroc\Controller\HomeController;
use TomTroc\Core\Http\Method;
use TomTroc\Core\Http\Request;
use TomTroc\Core\Http\Response;

class Router {
    private array $routes = [
        'GET' => [],
        'POST' => []
    ];
    public function __construct()
    {
        $this->routes['GET'][] = new Route('app_home', '/', fn() => (new HomeController())->index(), Method::GET);
        $this->routes['GET'][] = new Route('app_home', '/home', fn() => (new HomeController())->index(), Method::GET);
    }

    public function findRoute(Request $request): Route
    {
        foreach($this->routes[$request->method->value] as $route) {
            $routePattern = '/^'. str_replace('/', '\/', trim($route->path, '/')) . '$/';
            $requestUri = str_replace('/', '\/', trim($request->uri, '/'));
            if(preg_match($routePattern, $requestUri)){
                return $route;
            }
        }
        throw new RouteNotFound();
    }

    public function handleRequest(Request $request)
    {
        try {
            $route = $this->findRoute($request);
            $response = ($route->controller)($request);
        } catch(RouteNotFound) {
            $response = new Response(404, '404 - Not found');
        } catch (Throwable) {
            $response = new Response(500, '500 - Unexpected error');
        }
        

        if(!$response instanceof Response){
            $response = new Response(200, (string) $response);
        }

        http_response_code($response->code);
        echo $response->body;
        die();
    }
}