<?php

$this->title = $title;
?>

<div class="home h-100">
    <div class="content">
        <div class="content__block h-100">
            <img src="/assets/img/home.png" alt="#">
            <h4>Привет, <?php echo $user->name ?></h4>
            <div class="home__list">
                <a href="/account" class="btn">Личный кабинет пользователя</a>
                <a href="/logout" class="btn btn__green">Выйти</a>
            </div>
        </div>
    </div>
</div>