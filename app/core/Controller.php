<?php

namespace app\core;

/**
 * Class Controller
 */
class Controller
{
    /**
     * Layout
     * @var string
     */
    public string $layout = 'main';
    /**
     * Action
     * @var string
     */
    public string $action = '';

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
     * @return string|string[]
     */
    public function render($view, array $params = []): string
    {
        return Application::$app->router->renderView($view, $params);
    }
}