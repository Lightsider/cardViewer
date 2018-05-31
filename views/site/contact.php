<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Отзывы и пожелания';
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Html::encode($this->title) ?></h2>
<div id="contact">
    <div id="top">
        <h1>Напишите нам</h1>
    </div>
    <div id="center">
        <div id="contact_form">
            <?php $form = ActiveForm::begin(); ?>
            <span class="input">
                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                </span>

            <span class="input">
                    <?= $form->field($model, 'email') ?>
                </span>

            <span class="input">
                    <?= $form->field($model, 'message')->textarea(['rows' => 6, 'max-width' => "30vw",
                        'id'=>'message','class'=>'']) ?>
                </span>

            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'template' => '<br>{image}<br>{input}',
            ]) ?>

            <span id="submit" class="input">
                <?= Html::submitButton('Отправить письмо', ['id' => 'send', 'class' => 'input',]); ?>
            </span>

            <?php ActiveForm::end(); ?>

            <?php if (Yii::$app->session->hasFlash("message")){
                 echo Html::encode(Yii::$app->session->getFlash("message"));
            }
            ?>
        </div>
    </div>


</div>
