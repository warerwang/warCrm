<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-4
 * Time: 下午11:52
 */

?>
<div class="loginColumns animated fadeInDown">
<div class="row">
    <div class="col-xs-6 col-xs-offset-3">
        <div>
            <h3>
            激活你的账号
            </h3>
        </div>
        <?php
        $form = \yii\bootstrap\ActiveForm::begin();
        echo $form->field($model, 'email')->input('string', ['readOnly' => 'readOnly']);
        echo $form->field($model, 'name');
        echo $form->field($model, 'password')->passwordInput();
        echo $form->field($model, 'title');
        echo $form->field($model, 'description')->textarea();
        echo \yii\bootstrap\Button::widget([
            'label' => '激活',
            'options' => ['class' => 'btn-primary pull-right'],
        ]);
        $form->end();
        ?>
    </div>
</div>
</div>