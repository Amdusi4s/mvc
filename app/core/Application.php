<?php

namespace app\core;

use app\core\db\Database;

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
     * Object class Application
     * @var Application
     */
    public static Application $app;
    /**
     * Object class Request
     * @var Request
     */
    public Request $request;
    /**
     * Object class Response
     * @var Response
     */
    public Response $response;
    /**
     * Object class Router
     * @var Router
     */
    public Router $router;
    /**
     * Object class Controller
     * @var Controller
     */
    public ?Controller $controller = null;
    /**
     * Object class Database
     * @var Database
     */
    public Database $db;
    /**
     * Object class Session
     * @var Session
     */
    public Session $session;
    /**
     * Object class View
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
        $this->db = new Database($config['db']);
        $this->session = new Session();
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