<?php

use app\core\form\Form;

$this->title = $title;
?>

<div class="register h-100">
    <div class="content">
        <div class="content__block h-100">
            <img src="/assets/img/home.png" alt="#">
            <h4>Зарегистрируйтесь</h4>
            <div class="register__form">
                <?php $form = Form::begin('/register', 'post') ?>
                    <?php echo $form->field($model, 'name') ?>
                    <?php echo $form->field($model, 'password')->passwordField() ?>
                    <?php echo $form->field($model, 'email')->emailField() ?>
                    <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
                <?php Form::end() ?>
            </div>
            <p>Вы уже зарегистрированы? <a href="/login">Авторизуйтесь</a></p>
        </div>
    </div>
</div>