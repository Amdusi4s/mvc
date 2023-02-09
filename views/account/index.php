<?php

use app\core\Html;

$this->title = $title;
?>

<div class="home h-100">
    <div class="content">
        <div class="content__block h-100">
            <img src="/assets/img/home.png" alt="#">
            <h1><?php echo $title ?></h1>
            <div class="account">
                <p>Имя: <b><?php echo Html::encode($user->name) ?></b></p>
                <p>Почта: <b><?php echo Html::encode($user->email) ?></p>
            </div>
            <div class="home__list">
                <a href="/account/edit" class="btn btn__green">Редактировать</a>
                <a href="/" class="btn">Главная</a>
            </div>
        </div>
    </div>
</div>
