<?php

/* @var $this yii\web\View */

$this->title = 'WarCrm';
use yii\bootstrap\ActiveForm;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>企业协作工具</h1>

        <p class="lead">高效, 易用, 专业的企业协同工具</p>
        <?php
        $form = ActiveForm::begin([
              'layout' => 'inline',
              'validateOnSubmit' => false,
              'fieldConfig' => [
                  'template' => "{beginWrapper}\n{input}\n{button}\n{hint}\n{error}\n{endWrapper}",
                  'enableError' => true,
                  'inputOptions' => [
                      'style' => 'height:60px;font-size: 32px;'
                  ]
              ],
          ]);
        echo $form->field($model,
            'domain',
            [
                'parts' => [
                    '{button}' => '<button name="submit" class="btn btn-primary" value="1" type="submit">创建</button> <button name="submit" class="btn btn-default" value="2" type="submit">进入</button>',
                ],
                'inputOptions' => ['placeholder' => '']
            ]
        )->hint('请输入你团队的域名或者名称,5个以上的英文数字.');
        $form->end();
        ?>
    </div>
</div>
