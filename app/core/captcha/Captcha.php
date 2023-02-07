<?php

namespace app\core\captcha;

use app\core\captcha\exception\CaptchaException;

/**
 * Class Captcha
 */
class Captcha
{
    /** @var $driver */
    private $driver;

    /**
     * Constructor
     * @param array $config
     * @throws CaptchaException
     */
    public function __construct(private array $config)
    {
        $this->setDriver();
    }

    /**
     * Set captcha
     * @return void
     * @throws CaptchaException
     */
    private function setDriver()
    {
        $class = '\app\core\captcha\\'.ucfirst($this->config['type']).'Captcha';

        if (!$this->config['enabled']) {
            throw new CaptchaException('Включите капчу настроив параметр: CAPTCHA_STATUS на true');
        } elseif (!in_array($this->config['type'], $this->config['types'])) {
            throw new CaptchaException('Не валидный тип капчи');
        } elseif (!class_exists($class)) {
            throw new CaptchaException('Драйвер '.$class.' не зарегистрирован');
        }

        $this->driver = new $class($this->config);
    }

    /**
     * Return captcha
     * @return void
     */
    public function getDriver()
    {
        return $this->driver;
    }
}