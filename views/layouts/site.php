<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://fortrader.org/informers/css?id=52777">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>


    <script>
        $(document).ready(function () {
            initMenu();
        });

        function initMenu() {

            $('#menu ul').hide();
            $('#menu ul:eq(3)').show();

            $('#menu li a').click(
                function () {
                    var iselemnt = $(this).next();
                    if ((iselemnt.is('ul')) && (iselemnt.is(':visible'))) {
                        return false;
                    }

                    if ((iselemnt.is('ul')) && (!iselemnt.is(':visible'))) {
                        $('#menu ul:visible').slideUp('normal');
                        iselemnt.slideDown('normal');
                        return false;
                    }
                }
            );

        }
    </script>

</head>

<body>
<?php $this->beginBody() ?>
<div class="container">
    <h1 align="center"
        >
        <b><?=Html::encode(Yii::$app->name)?></b></h1>
    <div class="container row2 " >
        <div class="col-md-4" >

            <ul id="menu">
                <li><a href="<?=Url::to(['site/index']);?>"><img src="" alt="">Главная</a>
                </li>
                <li>
                    <a href=""><img src="" alt=""> NVIDIA Graphics cards </a>
                    <ul name="vcards">
                        <?php foreach ($this->params['nvidia'] as $cart)
                        {
                            echo "<li><a href=\"".Url::toRoute(['site/product','id'=>$cart->id])."\">
                            <img src=\"\" alt=\"\">".Html::encode($cart->title)."</a></li>";
                        }?>
                    </ul>
                </li>
                <li>
                    <a href=""><img src="" alt=""> AMD Graphics cards </a>
                    <ul name="vcards">
                        <?php foreach ($this->params['amd'] as $cart)
                        {
                            echo "<li><a href=\"".Url::toRoute(['site/product','id'=>$cart->id])."\">
                            <img src=\"\" alt=\"\">".Html::encode($cart->title)."</a></li>";
                        }?>
                    </ul>
                </li>
                <li>
                    <a href="<?=Url::toRoute(['site/reviews']);?>"><img src="" alt=""> Отзывы и пожелания </a>
                </li>
                <?php if(Yii::$app->user->isGuest):?>
                <li>
                    <a href="<?=Url::to(['site/login']);?>"><img src="" alt="">  Войти </a>
                </li>
                <?php else:?>
                <li>
                    <a href=""><img src="" alt="">
                        <?=Html::encode(Yii::$app->user->identity->login)?></a>
                    <ul>
                        <li><a href="<?=Url::to(['authorize/account']);?>"> Личный кабинет </a></li>
                        <li><a href="<?=Url::toRoute(['user/'.Yii::$app->user->id.'']);?>"> Профиль </a></li>
                    </ul>
                </li>
                <?php endif;?>
            </ul>
            <hr>

            <iframe style="width:100%;border:0px;overflow:hidden;background-color:transparent;height:210px"
                    scrolling="no"
                    src="https://fortrader.org/informers/getInformer?st=4&cat=7&title=%D0%9A%D1%83%D1%80%D1%81%D1%8B%20%D0%B2%D0%B0%D0%BB%D1%8E%D1%82%20&texts=%7B%22toolTitle%22%3A%22%D0%92%D0%B0%D0%BB%D1%8E%D1%82%D0%B0%22%2C%22todayCourse%22%3A%22RUB%22%7D&mult=0.99&showGetBtn=0&hideHeader=0&hideDate=0&w=0&codes=1&colors=titleTextColor%3Dfff%2CtitleBackgroundColor%3D4d5159%2CthTextColor%3D454545%2CthBackgroundColor%3Df1f1f1%2CsymbolTextColor%3D454545%2CtableTextColor%3D454545%2CborderTdColor%3De8e8e8%2CtableBorderColor%3Db3b1b1%2CprofitTextColor%3D89bb50%2CprofitBackgroundColor%3Deaf7e1%2ClossTextColor%3Dff1616%2ClossBackgroundColor%3Df6e1e1%2CoddBackgroundTrColor%3Dfff%2CevenBackgroundTrColor%3Dfff%2CdataTextColor%3D787878%2CdataBackgroundColor%3Df1f1f1%2CinformerLinkTextColor%3Dfff%2CinformerLinkBackgroundColor%3Db3b1b1&items=2%2C21&columns=todayCourse&toCur=11111"></iframe>

        </div>
        <div class="col-md-8">
            <?= $content ?>
        </div>
    </div>
<?php $this->endBody() ?>
    <div style="clear: both"></div>
</body>

</html>
<?php $this->endPage() ?>
