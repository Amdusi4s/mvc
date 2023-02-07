<?php

namespace app\core\captcha;

/**
 * Interface ICaptcha
 */
interface ICaptcha
{
    public function init();
    public function show();
    public function check(string $value);
}