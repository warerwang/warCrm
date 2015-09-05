<?php
/**
 * Created by PhpStorm.
 * User: warerwang
 * Date: 15-9-4
 * Time: 下午10:33
 */

?>

<table class="main" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td class="alert alert-good">
            欢迎加入<?= Yii::$app->name; ?>
        </td>
    </tr>
    <tr>
        <td class="content-wrap">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="content-block">
                        你好, <?= $senderName ?>邀请你加入 <?= $teamName ?>, 点击下面的链接激活你的账号。请在一周之内激活账号。

                    </td>
                </tr>
                <tr>
                    <td class="content-block">
                        <a href="<?= $link; ?>" class="btn-primary">激活你的账号</a>
                    </td>
                </tr>
                <tr>
                    <td class="content-block">
                        谢谢你选择 <?= Yii::$app->name; ?>, <?= Yii::$app->name; ?>是一个集团队协作, 项目管理, 即使通讯于一体的工具.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
