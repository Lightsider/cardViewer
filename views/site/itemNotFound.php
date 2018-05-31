<?php

/* @var $this yii\web\View */
/* @var $item mixed */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = $item." не найден";
?>
<div class="site-about">
    <h2>Странно,</h2>
    <h2> но этот <?php echo Html::encode($this->title)?></h2>

    <p style="text-align: center"> Вы точно знаете, что вы ищите?</p>



</div>
