<?php

namespace app\core;

use app\core\middlewares\BaseMiddleware;

/**
 * Class Controller
 */
class Controller
{
    /** @var string $layout layout */
    public string $layout = 'main';
    /**  @var string $action action */
    public string $action = '';
    /** @var \app\core\middlewares\BaseMiddleware[] */
    protected array $middlewares = [];

    /**
     * Save layout
     * @param string $layout
     * @return void
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**
     * Show view
     * @param $view
     * @param array $params
     * @return string
     */
    public function render($view, array $params = []): string
    {
        return Application::$app->router->renderView($view, $params);
    }

    /**
     * Register middleware
     * @param BaseMiddleware $middleware
     */
    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Return middlewares
     * @return \app\core\middlewares\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}