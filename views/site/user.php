<?php

/* @var $this yii\web\View */

/* @var $user \app\models\Users */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = "Профиль ".$user->login;
?>
<h2><?= Html::encode("Профиль") ?></h2>
<div class="container profoto">
    <div class="col-md-6">
        <img src="/uploads/<?= Html::encode($user->image) ?>" alt="" class='prof'>
    </div>
    <div class="col-md-6">
        <h3><?= Html::encode($user->login) ?></h3>
        <hr>
        <p style="word-break: break-all;">
            <?= Html::encode($user->selfdescription) ?>
        </p>
    </div>
    <hr>
    <div class="col-md-12 profoto3">
        <p>Здесь может быть ваша заметка об этом пользователе. Ее увидете только вы.</p>
    </div>
</div>




