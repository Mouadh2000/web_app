<?php

namespace Core;

class Router
{
    private $routes = [];

    public function addRoute($method, $uri, $action)
    {
        // Convert route URI to a regex pattern to capture parameters
        $uriPattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_\-]+)', $uri);
        $uriPattern = '#^' . $uriPattern . '$#';

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'pattern' => $uriPattern,
            'action' => $action
        ];
    }

    public function get($uri, $action)
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post($uri, $action)
    {
        $this->addRoute('POST', $uri, $action);
    }

    public function put($uri, $action)
    {
        $this->addRoute('PUT', $uri, $action);
    }

    public function delete($uri, $action)
    {
        $this->addRoute('DELETE', $uri, $action);
    }

    public function dispatch()
    {
        $requestUri = strtok($_SERVER['REQUEST_URI'], '?');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && preg_match($route['pattern'], $requestUri, $matches)) {
                $action = $route['action'];
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY); // Extract named parameters

                if (is_callable($action)) {
                    call_user_func($action, $params);
                } else if (is_array($action)) {
                    $controller = new $action[0];
                    $method = $action[1];
                    call_user_func_array([$controller, $method], $params);
                }
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['message' => 'Not Found']);
    }
}
