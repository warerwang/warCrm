<?php
/**
 * Created by PhpStorm.
 * User: yadongwang
 * Date: 15/8/18
 * Time: 下午11:40
 */

?>
<div class="loginColumns animated fadeInDown">
    <div class="row">

        <div class="col-md-6">
            <h2 class="font-bold">欢迎加入团队协助</h2>
            <p>
                我们有完善的一对一聊天以及群聊。
            </p>
            <p>
                聊天记录，附件图片，云端存储，随时随地查看，再也不会找不到历史记录。
            </p>
            <p>
                超好用的敏捷开发管理工具， 项目管理，问题追踪，里程碑燃尽图。
            </p>
            <p>
                <small>良好的用户体验，快速，高效</small>
            </p>

        </div>
        <div class="col-md-6">
            <div class="ibox-content">
                <?php
                $form = \yii\bootstrap\ActiveForm::begin(['fieldConfig' => [
                    'template' => "{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                ]]);
                echo $form->field($model, 'domain')->input('string', ['placeholder' => $model->getAttributeLabel('domain')]);
                echo $form->field($model, 'name')->input('string', ['placeholder' => $model->getAttributeLabel('name')]);
                echo $form->field($model, 'adminEmail')->input('string', ['placeholder' => $model->getAttributeLabel('adminEmail')]);
                echo $form->field($model, 'adminPassword')->passwordInput(['placeholder' => $model->getAttributeLabel('adminPassword')]);
                echo $form->field($model, 'adminPasswordRepeat')->passwordInput(['placeholder' => $model->getAttributeLabel('adminPasswordRepeat')]);
                echo $form->field($model, 'description')->textarea(['placeholder' => $model->getAttributeLabel('description')]);

                echo \yii\bootstrap\Button::widget([
                    'label' => '提交',
                    'options' => ['class' => 'btn-primary pull-right'],
                ]);
                $form->end();
                ?>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6">
            Copyright gwork.cc Company
        </div>
        <div class="col-md-6 text-right">
            <small>© 2014-2015</small>
        </div>
    </div>
</div>