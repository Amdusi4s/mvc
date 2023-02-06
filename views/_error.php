<?php

/** @var $exception \Exception */

$this->title = $title;
?>

<div class="home h-100">
    <div class="content">
        <div class="content__block h-100">
            <h1><?php echo $exception->getCode() ?></h1>
            <p><?php echo $exception->getMessage() ?></p>
            <div class="home__list">
                <a href="/" class="btn btn__green">Главная</a>
            </div>
        </div>
    </div>
</div>