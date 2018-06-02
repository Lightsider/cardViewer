<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\CommentForm */

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>

<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'template' => "{label}\n{input}\n",
    ]]); ?>
    <span class="input">
                    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
                        'editorOptions' => [
                            'preset' => 'basic',
                            'inline' => false,
                        ],
                    ]); ?>
    </span>

<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
    'template' => '<br>{image}{input}<br>',
]) ?>
    <div style="clear: both"></div>
    <div class="btn-group" role="group" style="float:left;">
                <?= Html::submitButton('Отправить комментарий', [ 'class' => 'btn btn-default',]); ?>
    </div>

<?php ActiveForm::end(); ?>