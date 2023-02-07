<?php

namespace app\core\email;

use app\core\Application,
    app\core\exception\EmailException,
    PHPMailer\PHPMailer\PHPMailer;

/**
 * Class Email
 */
class Email
{
    /** @var array $config config email service */
    private array $config;

    /**
     * Constructor
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Send email
     */
    public function send(string $email, string $layout, string $view, string $subject, array $params = [])
    {
        $layout = $layout ?? 'main';
        $layout = file_get_contents(Application::$rootDir . '/email/layouts/' . $layout . '/html.php');
        $view = file_get_contents(Application::$rootDir . '/email/' . $view . '.php');

        if (count($params)) {
            foreach ($params as $key => $param) {
                $view = str_replace("%{$key}%", $param, $view);
            }
        }

        $content = str_replace('%content%', $view, $layout);

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

        $mail->Body = $content;

        try {
            if (!$mail->send()) {
                throw new EmailException('Произошла ошибка при отправке письма');
            }
        } catch (EmailException $e) {
            throw new EmailException('Произошла ошибка при отправке письма: ' . $e->getMessage());
        }
    }
}