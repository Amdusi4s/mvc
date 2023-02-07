<?php

namespace app\core\captcha;

use app\core\captcha\exception\CaptchaException,
    Exception;

/**
 * Class RecaptchaCaptcha
 */
class RecaptchaCaptcha implements ICaptcha
{
    private string $url = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Constructor
     * @param array $config
     * @throws CaptchaException
     */
    public function __construct(public array $config)
    {
        $this->init();
    }

    /**
     * Initialization captcha
     * @return void
     * @throws CaptchaException
     */
    public function init()
    {
        if (empty($this->config['recaptcha']['site']) || empty($this->config['recaptcha']['private'])) {
            throw new CaptchaException('Установите публичный ключ');
        } elseif (empty($this->config['recaptcha']['private'])) {
            throw new CaptchaException('Установите приватный ключ');
        }
    }

    /**
     */
    public function show()
    {
        return '<div class="form-captcha"><div class="g-recaptcha" data-callback="correctCaptcha" data-sitekey="' . $this->config['recaptcha']['site'] . '"></div></div>';
    }

    /**
     * Check captcha
     * @param string $value
     * @return bool
     * @throws CaptchaException
     */
    public function check(string $value)
    {
        try {
            $data = [
                'secret'   => $this->config['recaptcha']['private'],
                'response' => $value,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];

            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                ]
            ];

            $context  = stream_context_create($options);
            $result = file_get_contents($this->url, false, $context);

            return json_decode($result)->success;
        } catch (Exception $e) {
            throw new CaptchaException('Произошла ошибка при валидации recaptcha: ' . $e->getMessage());
        }
    }
}