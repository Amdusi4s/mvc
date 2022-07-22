<?php

namespace app\core;

use app\core\exception\InvalidCsrfTokenException;

/**
 * Class Csrf
 */
class Csrf
{
    protected Session $session;

    /**
     * @var string
     */
    protected string $session_prefix = 'csrf_';

    /**
     * Constructor
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Generate token
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public function generate($key): mixed
    {
        $key = $this->sanitizeKey($key);

        $token = $this->createToken();

        $this->session->set($this->session_prefix . $key, $token);

        return $token;
    }

    /**
     * Check the CSRF token is valid
     * @throws InvalidCsrfTokenException
     */
    public function check(string $key, string $token, int $timespan = null, bool $multiple)
    {
        $key = $this->sanitizeKey($key);

        if (!$token) {
            throw new InvalidCsrfTokenException('Invalid CSRF token');
        }

        $sessionToken = $this->session->get($this->session_prefix . $key);
        if (!$sessionToken) {
            throw new InvalidCsrfTokenException('Invalid CSRF session token');
        }

        if (!$multiple) {
            $this->session->set($this->session_prefix . $key, null);
        }

        if ($this->referralHash() !== substr(base64_decode($sessionToken), 10, 40)) {
            throw new InvalidCsrfTokenException('Invalid CSRF token');
        }

        if ($token !== $sessionToken) {
            throw new InvalidCsrfTokenException('Invalid CSRF token');
        }

        // Check for token expiration
        if (is_int($timespan) && (intval(substr(base64_decode($sessionToken), 0, 10)) + $timespan) < time()) {
            throw new InvalidCsrfTokenException('CSRF token has expired');
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
    protected function createToken()
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