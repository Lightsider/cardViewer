<?php

/* @var $this yii\web\View */
/* @var $model \app\models\AccountForm */
/* @var $user \app\models\User|null|\yii\web\IdentityInterface */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Аккаунт '.$user->login;
?>
<h2>Добро пожаловать в ваш личный кабинет!</h2>
<h2>Здесь вы можете изменить свои данные</h2>



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
<hr>


<?php if(Yii::$app->session->hasFlash("result")):?>
    <div class="alert alert-<?=Yii::$app->session->getFlash("result")?>">
        <?=Yii::$app->session->getFlash("message")?>
    </div>
<?php endif;?>

<div class="bord">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "<div class=\"input-group input-group-lg\">{label}\n{input}\n</div>",
            'labelOptions' => [ 'class' => 'input-group-addon' ]
        ],
    ]); ?>

    <?= $form->field($model, 'login')->textInput(['autofocus' => true,'value'=>$user->login]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <?= $form->field($model, 'file')->fileInput(['style'=>"margin: auto;padding-top: 2%;"]) ?>

    <?= $form->field($model, 'selfdescription')->textarea(['value'=>$user->selfdescription]) ?>

    <div class="btn-group" role="group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-default', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <h2>Если вы хотите выйти, то нажмите на эту кнопку:</h2>
    <?php echo Html::beginForm(['/site/logout'], 'post');
    echo "<div class=\"btn-group\" role=\"group\">";
    echo Html::submitButton('Выйти',['class'=>'btn btn-default']);
    echo "</div>";
    echo Html::endForm();
    ?>
</div>
