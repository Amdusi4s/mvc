<?php

use app\core\Html;

$this->title = $title;
?>

<div class="home h-100">
    <div class="content">
        <div class="content__block h-100">
            <img src="/assets/img/home.png" alt="#">
            <h4>Привет, <?php echo Html::encode($user->name) ?></h4>
            <div class="home__list">
                <a href="/account" class="btn">Мой аккаунт</a>
                <a href="/logout" class="btn btn__green">Выйти</a>
            </div>
        </div>
    </div>
</div>