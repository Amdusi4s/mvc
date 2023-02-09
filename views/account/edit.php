<?php

use app\core\form\Form;

$this->title = $title;
?>

<div class="home h-100">
    <div class="content">
        <div class="content__block h-100">
            <img src="/assets/img/home.png" alt="#">
            <h1><?php echo $title ?></h1>
            <div class="account">
                <?php $form = Form::begin('/account/edit', 'post') ?>
                <?php echo $form->field($model, 'name') ?>
                <?php echo $form->field($model, 'email')->emailField() ?>
                <button type="submit" class="btn btn-primary btn-block">Редактировать</button>
                <?php Form::end() ?>
            </div>
            <div class="home__list">
                <a href="/account" class="btn btn__green">Личный кабинет</a>
                <a href="/" class="btn">Главная</a>
            </div>
        </div>
    </div>
</div>
