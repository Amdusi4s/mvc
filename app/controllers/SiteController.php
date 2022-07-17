<?php

namespace app\controllers;

use app\core\Controller;

/**
 * Class SiteController
 */
class SiteController extends Controller
{
    /**
     * Home page
     * @return string|string[]
     */
    public function home()
    {
        return $this->render('home');
    }
}