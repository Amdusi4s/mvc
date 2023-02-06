<?php

namespace app\core;

/**
 * Class Session
 */
class Session
{
    /**
     * The name key flash messages
     */
    private const FLASH_KEY = 'flash_messages';

    /**
     * Constructor
     */
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * Save flash session
     * @param $key
     * @param $message
     */
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    /**
     * Return flash session
     * @param $key
     * @return mixed
     */
    public function getFlash($key): mixed
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    /**
     * Save session
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Return session
     * @param $key
     * @return false|mixed
     */
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     * Delete session
     * @param $key
     */
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Delete flash messages
     */
    private function removeFlashMessages()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * Destruct
     */
    public function __destruct()
    {
        $this->removeFlashMessages();
    }
}