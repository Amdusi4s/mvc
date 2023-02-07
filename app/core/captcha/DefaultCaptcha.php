<?php

namespace app\core\captcha;

use app\core\Application,
    app\core\captcha\exception\CaptchaException;

/**
 * Class DefaultCaptcha
 */
class DefaultCaptcha implements ICaptcha
{
    /** @var string $code code captcha */
    private string $code;

    /**
     * Constructor
     */
    public function __construct(public array $config)
    {
        $this->init();
    }

    /**
     * Initialization captcha
     * @return void
     * @throws \Exception
     */
    public function init()
    {
        if(!extension_loaded('gd')) {
            throw new CaptchaException('Не подключена GD библиотека');
        }
    }

    /**
     * Create code
     * @return void
     * @throws \Exception
     */
    private function createCode()
    {
        $number = md5(random_bytes(64));
        $this->code = substr($number, 0, 6);

        Application::$app->session->set('CAPTCHA_CODE', $this->code);
    }

    /**
     * Generate captcha
     * @return void
     * @throws \Exception
     */
    public function generate()
    {
        $this->createCode();

        $layer = imagecreatetruecolor($this->config['default']['size']['width'], $this->config['default']['size']['height']);
        $captcha_bg = imagecolorallocate($layer, $this->config['default']['bg'][0], $this->config['default']['bg'][1], $this->config['default']['bg'][2]);
        imagefill($layer, 0, 0, $captcha_bg);
        $captcha_text_color = imagecolorallocate($layer, $this->config['default']['color'][0], $this->config['default']['color'][1], $this->config['default']['color'][2]);
        imagestring($layer, 5, 55, 10, $this->code, $captcha_text_color);
        header("Content-type: image/jpeg");
        imagejpeg($layer);
    }

    /**
     * Show captcha
     * @return string
     */
    public function show()
    {
        return '<div class="form-captcha"><img src="/captcha" alt="#"></div>';
    }

    /**
     * Check captcha
     * @param string $value
     * @return bool
     */
    public function check(string $value)
    {
        if (Application::$app->session->get('CAPTCHA_CODE') != $value) {
            return false;
        }

        return true;
    }
}