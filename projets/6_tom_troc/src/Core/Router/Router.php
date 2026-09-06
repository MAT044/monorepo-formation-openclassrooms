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
    ) {}

    public function findRoute(Request $request): array
    {
        foreach ($this->routes[$request->method->value] as $route) {
            $requestUri = trim($request->uri, '/');

            $routePath = $route->path;
            $routePattern = preg_replace(
                '/\{([^}]+)\}/',
                '(?<$1>[^/]+)',
                $routePath
            );
            $routePattern = '/^' . str_replace('/', '\/', trim($routePattern, '/')) . '$/';

            if (preg_match($routePattern, $requestUri, $matches)) {
                return [$route, $matches];
            }
        }
        throw new RouteNotFound();
    }

    public function handleRequest(Request $request)
    {
        try {
            list($route, $queryParams) = $this->findRoute($request);
            $request = $request->mergeQuery($queryParams);
            $response = ($route->controller)($request);
        } catch (RouteNotFound) {
            $response = new Response(404, '404 - Not found');
        } catch (Throwable $e) {
            $response = new Response(500, '500 - Unexpected error : ' . $e->getMessage());
        }


        if (!$response instanceof Response) {
            $response = new Response(200, (string) $response);
        }

        http_response_code($response->code);
        foreach ($response->headers as $header) {
            header($header);
        }
        echo $response->body;
        die();
    }

    public function addRoute(string $name, string $path, Closure|array $controller, Method $method)
    {
        if (is_array($controller)) {
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
