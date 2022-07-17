<?php

namespace app\core;

/**
 * Class Request
 */
class Request
{
    /**
     * Params route
     * @var array
     */
    private array $routeParams = [];

    /**
     * Returns the data transfer method
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Return url address
     * @return mixed
     */
    public function getUrl(): mixed
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    /**
     * Checking if the request is a GET method
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->getMethod() === 'get';
    }

    /**
     * Checking if the request is a POST method
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->getMethod() === 'post';
    }

    /**
     * Return body request
     * @return array
     */
    public function getBody(): array
    {
        $data = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }

    /**
     * Set params route
     * @param $params
     * @return self
     */
    public function setRouteParams($params)
    {
        $this->routeParams = $params;
        return $this;
    }

    /**
     * Return params route
     * @return mixed
     */
    public function getRouteParams(): mixed
    {
        return $this->routeParams;
    }

    /**
     * Return param route
     * @param $param
     * @param null $default
     * @return mixed
     */
    public function getRouteParam($param, $default = null): mixed
    {
        return $this->routeParams[$param] ?? $default;
    }
}
