<?php

namespace app\core;

use app\core\db\Database;
use app\core\email\Email;
use app\core\secure\Secure;

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
     * UserClass
     * @var string|mixed
     */
    public string $userClass;
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
     * Object class UserModel
     * @var UserModel|null
     */
    public ?UserModel $user;
    /**
     * Object class Secure
     * @var Secure
     */
    public Secure $secure;
    /**
     * Object class Csrf
     * @var Csrf
     */
    public Csrf $csrf;
    /**
     * Object class Email
     * @var Email
     */
    public Email $email;

    /**
     * Constructor
     * @param string $rootPath
     * @param array $config
     */
    public function __construct(string $rootPath, array $config)
    {
        $this->user = null;
        $this->userClass = $config['userClass'];
        self::$rootDir = $rootPath;
        self::$config = $config;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->session = new Session();
        $this->view = new View();
        $this->secure = new Secure();
        $this->csrf = new Csrf($this->session, $config['csrf']);
        $this->email = new Email($config['email']);

        $userId = Application::$app->session->get('user');
        if ($userId) {
            $key = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$key => $userId]);
        }
    }

    /**
     * Checking fo guest
     * @return bool
     */
    public static function isGuest(): bool
    {
        return !self::$app->user;
    }

    /**
     * Login
     * @param UserModel $user
     * @return bool
     */
    public function login(UserModel $user): bool
    {
        $this->user = $user;
        $className = get_class($user);
        $primaryKey = $className::primaryKey();
        $value = $user->{$primaryKey};
        Application::$app->session->set('user', $value);

        return true;
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->user = null;
        Application::$app->session->setFlash('success', 'Вы успешно вышли из аккаунта');
        self::$app->session->remove('user');
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