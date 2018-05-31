<?php

/* @var $this yii\web\View */
/* @var $product \app\models\Products */

use yii\helpers\Html;

$this->title = $product->title;
?>
<div class="ism-slider" data-play_type="loop" id="my-slider">
    <ol>
        <?php
            foreach ($product->images as $value)
            {
                echo "<li><img src=\"\\".Html::encode($value)."\">
                <div class=\"ism-caption ism-caption-0\">Карты ".Html::encode($product->title)."</div></li>";
            }
        ?>
    </ol>
</div>

<p><?=Html::encode($product->preview)?></p>
    <h2>Технические характеристики <?=Html::encode($this->title)?></h2>
<?=$product->description?>