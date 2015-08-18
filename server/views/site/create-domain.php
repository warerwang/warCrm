<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/8/18
 * Time: 下午11:40
 */

?>
<div class="row">
    <div class="col-xs-6 col-xs-offset-3">
<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model, 'domain');
echo $form->field($model, 'name');
echo $form->field($model, 'adminEmail');
echo $form->field($model, 'adminPassword')->passwordInput();
echo $form->field($model, 'adminPasswordRepeat')->passwordInput();
echo $form->field($model, 'description')->textarea();

echo \yii\bootstrap\Button::widget([
      'label' => '提交',
      'options' => ['class' => 'btn-primary pull-right'],
 ]);
$form->end();
?>
    </div>
</div>