<?php

namespace app\core;

/**
 * Class View
 */
class View
{
    /** @var string $title title */
    public string $title = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->title = Application::$config['app']['name'];
    }

    /**
     * Return view
     * @param $view
     * @param array $params
     * @return array|string
     */
    public function renderView($view, array $params): array|string
    {
        $layoutName = Application::$app->layout;
        if (Application::$app->controller) {
            $layoutName = Application::$app->controller->layout;
        }
        $viewContent = $this->renderViewOnly($view, $params);
        ob_start();
        include_once Application::$rootDir . "/views/layouts/$layoutName.php";
        $layoutContent = ob_get_clean();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Return view only
     * @param $view
     * @param array $params
     * @return bool|string
     */
    public function renderViewOnly($view, array $params): bool|string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$rootDir . "/views/$view.php";
        return ob_get_clean();
    }
}