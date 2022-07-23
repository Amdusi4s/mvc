<?php

namespace app\core\email;

use app\core\Application;
use app\core\exception\EmailException;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class Email
 */
class Email
{
    protected array $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Send email
     */
    public function send($email, $view, string $subject, array $params = [])
    {
        $view = file_get_contents(Application::$rootDir . '/email/' . $view . '.php');

        if (count($params)) {
            foreach ($params as $key => $param) {
                $view = str_replace("%{$key}%", $param, $view);
            }
        }

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;

        foreach ($this->config as $key => $config) {
            if ($key !== 'setFrom') {
                $mail->$key = $config;
            }
        }

        $mail->setFrom($this->config['setFrom']);
        $mail->addAddress($email);
        $mail->Subject = $subject;

        $mail->isHTML(true);

        $mail->Body = $view;

        try {
            $mail->send();
        } catch (EmailException $e) {
            //
        }
    }
}