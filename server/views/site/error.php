<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="middle-box text-center animated fadeInDown">
    <h3 class="font-bold"><?= Html::encode($this->title) ?></h3>

    <div class="error-desc">
        <?= nl2br(Html::encode($message)) ?><br>
        你可以返回首页: <br><a href="/" class="btn btn-primary m-t">首页</a>
    </div>
</div>