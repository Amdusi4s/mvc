<?php

namespace app\core;

/**
 * Class Application
 */
class Application
{
    /**
     * Base url
     * @var string
     */
    public static string $rootDir;
    /**
     * Configs application
     * @var array
     */
    public static array $config;
    /**
     * Base layout
     * @var string
     */
    public string $layout = 'main';
    /**
     * Class Application
     * @var Application
     */
    public static Application $app;
    /**
     * Class Request
     * @var Request
     */
    public Request $request;
    /**
     * Class Response
     * @var Response
     */
    public Response $response;
    /**
     * Class Router
     * @var Router
     */
    public Router $router;
    /**
     * Class Controller
     * @var Controller
     */
    public ?Controller $controller = null;
    /**
     * Class View
     * @var View
     */
    public View $view;

    /**
     * Constructor
     * @param string $rootPath
     * @param array $config
     */
    public function __construct(string $rootPath, array $config)
    {
        self::$rootDir = $rootPath;
        self::$config = $config;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();
    }

    /**
     * Run application
     */
    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            echo $this->router->renderView('_error', [
                'exception' => $e,
                'title' => $e->getCode()
            ]);
        }
    }
}