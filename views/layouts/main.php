<?php

use app\core\Application,
    assets\AppAsset;
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $this->title ?></title>
    <?php AppAsset::registerAsset(); ?>
</head>
<body>
<?php if (Application::$app->session->getFlash('success')): ?>
    <div class="content alert alert-success">
        <p><?php echo Application::$app->session->getFlash('success') ?></p>
    </div>
<?php elseif (Application::$app->session->getFlash('error')): ?>
    <div class="content alert alert-error">
        <p><?php echo Application::$app->session->getFlash('error') ?></p>
    </div>
<?php endif; ?>
{{content}}
</body>
</html>