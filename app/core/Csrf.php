<?php

namespace app\core;

use app\core\exception\InvalidCsrfTokenException;

/**
 * Class Csrf
 */
class Csrf
{
    /** @var Session $session object Session */
    protected Session $session;
    /** @var string $session_prefix prefix session */
    protected string $session_prefix = 'csrf_';
    /** @var string $session_key key session */
    protected string $session_key;

    /**
     * Constructor
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->session = Application::$app->session;
        $this->session_key = $config['key'];
    }

    /**
     * Generate token
     * @return mixed
     * @throws \Exception
     */
    public function generate(): mixed
    {
        $key = $this->sanitizeKey($this->session_key);

        $token = $this->createToken();

        $this->session->set($this->session_prefix . $key, $token);

        return $token;
    }

    /**
     * Check the CSRF token is valid
     * @throws InvalidCsrfTokenException
     */
    public function check(string $token, int $timespan = null, bool $multiple = false)
    {
        $key = $this->sanitizeKey($this->session_key);

        if (!$token) {
            throw new InvalidCsrfTokenException('Невалидный CSRF токен');
        }

        $sessionToken = $this->session->get($this->session_prefix . $key);
        if (!$sessionToken) {
            throw new InvalidCsrfTokenException('Невалидный CSRF сессия токена');
        }

        if (!$multiple) {
            $this->session->set($this->session_prefix . $key, null);
        }

        if ($this->referralHash() !== substr(base64_decode($sessionToken), 10, 40)) {
            throw new InvalidCsrfTokenException('Невалидный CSRF токен');
        }

        if ($token !== $sessionToken) {
            throw new InvalidCsrfTokenException('Невалидный CSRF токен');
        }

        if (is_int($timespan) && (intval(substr(base64_decode($sessionToken), 0, 10)) + $timespan) < time()) {
            throw new InvalidCsrfTokenException('Срок действия CSRF токена истек');
        }
    }

    /**
     * Sanitize the session key
     * @param $key
     * @return array|string|null
     */
    protected function sanitizeKey($key): array|string|null
    {
        return preg_replace('/[^a-zA-Z0-9]+/', '', $key);
    }

    /**
     * Create a new token
     * @return string
     * @throws \Exception
     */
    protected function createToken(): string
    {
        return base64_encode(time() . $this->referralHash() . $this->randomString());
    }

    /**
     * Return a unique referral hash.
     * @return string
     */
    protected function referralHash(): string
    {
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            return sha1($_SERVER['REMOTE_ADDR']);
        }

        return sha1($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * Generate a random string.
     * @return string
     * @throws \Exception
     */
    protected function randomString(): string
    {
        return sha1(random_bytes(32));
    }
}