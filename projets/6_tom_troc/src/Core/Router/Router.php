<?php

namespace TomTroc\Core\Router;

use Closure;
use Throwable;
use TomTroc\Core\DependencyContainer\DependencyContainer;
use TomTroc\Core\Http\Method;
use TomTroc\Core\Http\Request;
use TomTroc\Core\Http\Response;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => []
    ];
    public function __construct(
        private readonly DependencyContainer $container
    )
    {
    }

    public function findRoute(Request $request): Route
    {
        foreach ($this->routes[$request->method->value] as $route) {
            $routePattern = '/^' . str_replace('/', '\/', trim($route->path, '/')) . '$/';
            $requestUri = str_replace('/', '\/', trim($request->uri, '/'));
            if (preg_match($routePattern, $requestUri)) {
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
        } catch (RouteNotFound) {
            $response = new Response(404, '404 - Not found');
        } catch (Throwable) {
            $response = new Response(500, '500 - Unexpected error');
        }


        if (!$response instanceof Response) {
            $response = new Response(200, (string) $response);
        }

        http_response_code($response->code);
        echo $response->body;
        die();
    }

    public function addRoute(string $name, string $path, Closure|array $controller, Method $method)
    {
        if(is_array($controller)){
            $controllerClassname = $controller[0];
            $controllerMethod = $controller[1] ?? "__invoke";
            $controller = fn(Request $request) => $this->container->resolve($controllerClassname)->$controllerMethod($request);
        }

        $this->routes[$method->value][] = new Route(
            $name,
            $path,
            $controller,
            $method
        );
    }
    public function get(string $name, string $path, Closure|array $controller)
    {
        $this->addRoute($name, $path, $controller, Method::GET);
    }

    public function post(string $name, string $path, Closure|array $controller)
    {
        $this->addRoute($name, $path, $controller, Method::POST);
    }

    public function all(string $name, string $path, Closure|array $controller)
    {
        $this->get($name, $path, $controller);
        $this->post($name, $path, $controller);
    }
}