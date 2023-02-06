<?php

namespace app\core;

use app\core\container\Container;

/**
 * Class Application
 */
class Application extends Container
{
    public static string $rootDir;
    public static array $config;
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
        $this->init($config['components']);

        $this->user = null;

        self::$rootDir = $rootPath;
        self::$config = $config;
        self::$app = $this;

        $this->userClass = self::$app->get('user');
        $this->request = self::$app->get('request');
        $this->response = self::$app->get('response');
        $this->router = self::$app->get('router');
        $this->db = self::$app->get('database');
        $this->session = self::$app->get('session');
        $this->view = self::$app->get('view');
        $this->secure = self::$app->get('secure');
        $this->csrf = self::$app->get('csrf');
        $this->email = self::$app->get('email');
        $this->cache = self::$app->get('cache');

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