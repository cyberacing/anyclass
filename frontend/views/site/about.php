<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Добро пожаловать!';
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Для использования сайта необходимо <?= Html::a('зарегистрироваться', Url::to(['/site/signup'])) ?> или <?= Html::a('авторизоваться', Url::to(['/site/login'])) ?></p>
</div>
