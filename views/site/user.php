<?php

/* @var $this yii\web\View */

/* @var $user \app\models\Users */

/* @var $noteForm \app\models\NotesForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = "Профиль " . $user->login;
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
</div>
<?php if (!Yii::$app->user->isGuest): ?>
    <hr>
    <?php if (Yii::$app->session->hasFlash("result")): ?>
        <div class="alert alert-<?= Yii::$app->session->getFlash("result") ?>">
            <?= Yii::$app->session->getFlash("message") ?>
        </div>
    <?php endif; ?>
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "<div class=\"input-group input-group-lg\">{label}\n{input}\n</div>",
            'labelOptions' => ['class' => 'input-group-addon']
        ],
        'options' => [
            'style' => "text-align:center"
        ]]); ?>
    <span class="input">
                    <?= $form->field($noteForm, 'text')->textarea(); ?>
        </span>
    <div class="btn-group" role="group">
        <?= Html::submitButton('Оставить заметку', ['class' => 'btn btn-default',]); ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php endif; ?>




