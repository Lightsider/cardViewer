<?php

/* @var $this yii\web\View */
/* @var $product \app\models\Products */
/* @var $comments \app\models\Comments[]|array */

/* @var $commentForm \app\models\CommentForm */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

$this->title = $product->title;
?>
<div class="ism-slider" data-play_type="loop" id="my-slider">
    <ol>
        <?php
        foreach ($product->images as $value) {
            echo "<li><img src=\"" . Html::encode($value) . "\">
                <div class=\"ism-caption ism-caption-0\">Карты " . Html::encode($product->title) . "</div></li>";
        }
        ?>
    </ol>
</div>

<p><?= Html::encode($product->preview) ?></p>
<h2>Технические характеристики <?= Html::encode($this->title) ?></h2>
<?= $product->description ?>

<?php if (!empty($comments)): ?>
    <hr>
    <?php foreach ($comments as $comment): ?>
        <div class="profoto3">
            <div class="profoto41">
                <div class="profoto4min1"><a href="<?=Url::to(['site/user', 'id' => $comment->id_user]) ?>">
                        <img src="/uploads/<?php echo $comment->user->image ?>"></a></div>
                <div class="profoto4min2">
                    <strong><a href="<?=Url::to(['site/user', 'id' => $comment->id_user]) ?>">
                            <?php echo Html::encode($comment->user->login) ?>
                        </a></strong>
                    <p><?php echo Html::encode($comment->datetime) ?></p>
                </div>
                <hr>
                <div class="profoto4min3"><?php echo HtmlPurifier::process($comment->text); ?></div>
                <div style="clear: both"></div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if (!Yii::$app->user->isGuest): ?>
    <hr>
    <?php if (Yii::$app->session->hasFlash("result")): ?>
        <div class="alert alert-<?= Yii::$app->session->getFlash("result") ?>">
            <?= Yii::$app->session->getFlash("message") ?>
        </div>
    <?php endif; ?>
    <?= $this->render('../authorize/commentForm', [
        'model' => $commentForm,
    ]) ?>

<?php endif; ?>

