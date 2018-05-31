<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
?>
<h2><?= Html::encode($this->title) ?></h2>
<div class="bord">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => [
            'template' => "<div class=\"input-group input-group-lg\">{label}\n{input}\n</div>",
            'labelOptions' => [ 'class' => 'input-group-addon' ]
        ],
    ]); ?>

    <?= $form->field($model, 'login')->textInput(['autofocus' => true,'class'=>'form-control']) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="btn-group" role="group">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-default', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    Нет аккаунта? <?= Html::a("Зарегистрируйтесь!", "register") ?>
</div>


