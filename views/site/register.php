<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\RegisterForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
?>


<h2><?= Html::encode($this->title) ?></h2>
<div class="bord">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "<div class=\"input-group input-group-lg\">{label}\n{input}\n</div>",
            'labelOptions' => [ 'class' => 'input-group-addon' ]
        ],
    ]); ?>

    <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <?= $form->field($model, 'file')->fileInput(['style'=>"margin: auto;padding-top: 2%;"]) ?>

    <?= $form->field($model, 'selfdescription')->textarea() ?>

    <div class="btn-group" role="group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-default', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    Есть аккаунт? <?=Html::a(" Войдите!","login")?>
</div>
