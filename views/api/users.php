<?php

/* @var $this yii\web\View */
/* @var $users \app\models\User[]|\app\models\Users[]|array */

?>
<?php if (isset($users)): ?>
    <?php foreach ($users as $user): ?>
        <?php
        echo json_encode($user);
        echo "<br>";
        ?>
    <?php endforeach; ?>
<? endif; ?>
