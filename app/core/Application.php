<?php

namespace app\core;

use app\core\db\Database,
    app\core\email\Email,
    app\core\secure\Secure;

/**
 * @property-read Request $request
 * @property-read Response $response
 * @property-read Router $router
 * @property-read Database $db
 * @property-read Session $session
 * @property-read View $view
 * @property-read Secure $secure
 * @property-read Csrf $csrf
 * @property-read Email $email
 * @property-read Cache $cache
 * Class Application
 */
class Application
{
    public static string $rootDir;
    public static array $config;
    public string $userClass;
    public string $layout = 'main';

    public static Application $app;
    public ?Controller $controller = null;
    public ?UserModel $user;

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
        $this->cache = new Cache($rootPath . '/tmp/cache');

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