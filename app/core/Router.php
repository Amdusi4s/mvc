<?php

namespace app\core;

use app\core\exception\NotFoundException;

/**
 * Class Router
 */
class Router
{
    /** @var Request $request object Request */
    public Request $request;
    /** @var Response object Response */
    public Response $response;
     /** @var array $routeMap map routes */
    private array $routeMap = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->request = Application::$app->request;
        $this->response = Application::$app->response;
    }

    /**
     * Returning routes created using the GET method
     * @param string $url
     * @param $callback
     */
    public function get(string $url, $callback)
    {
        $this->routeMap['get'][$url] = $callback;
    }

    /**
     * Returning routes created using the POST method
     * @param string $url
     * @param $callback
     */
    public function post(string $url, $callback)
    {
        $this->routeMap['post'][$url] = $callback;
    }

    /**
     * Return map the method
     * @param $method
     * @return array|mixed
     */
    public function getRouteMap($method)
    {
        return $this->routeMap[$method] ?? [];
    }

    /**
     * Return callback map routes
     * @return false|mixed
     */
    public function getCallback()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        $url = trim($url, '/');

        $routes = $this->getRouteMap($method);

        $routeParams = false;

        foreach ($routes as $route => $callback) {
            $route = trim($route, '/');
            $routeNames = [];

            if (!$route) {
                continue;
            }
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }

            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . "$@";

            if (preg_match_all($routeRegex, $url, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);

                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }

        return false;
    }

    /**
     * Run system routes
     */
    public function resolve()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        $callback = $this->routeMap[$method][$url] ?? false;
        if (!$callback) {

            $callback = $this->getCallback();

            if ($callback === false) {
                throw new NotFoundException();
            }
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            $controller = new $callback[0];
            $controller->action = $callback[1];
            Application::$app->controller = $controller;
            $middlewares = $controller->getMiddlewares();
            foreach ($middlewares as $middleware) {
                $middleware->execute();
            }
            $callback[0] = $controller;
        }
        return call_user_func($callback, $this->request, $this->response);
    }

    /**
     * Return view
     * @param string $view
     * @param array $params
     * @return string|string[]
     */
    public function renderView(string $view, array $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    /**
     * Return view only
     * @param $view
     * @param array $params
     * @return mixed
     */
    public function renderViewOnly($view, array $params = [])
    {
        return Application::$app->view->renderViewOnly($view, $params);
    }
}