<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?= Html::encode($this->title) ?></title>
    <style type="text/css">
        *{box-sizing:border-box;margin:0;padding:0;font-size:14px;font-family:Helvetica Neue,Helvetica,Arial,sans-serif}img{max-width:100%}body{width:100%!important;height:100%;line-height:1.6;-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none}table td{vertical-align:top}.body-wrap,body{background-color:#f6f6f6}.body-wrap{width:100%}.container{clear:both!important;display:block!important;margin:0 auto!important;max-width:600px!important}.content{display:block;margin:0 auto;padding:20px;max-width:600px}.main{border:1px solid #e9e9e9;border-radius:3px;background:#fff}.content-wrap{padding:20px}.content-block{padding:0 0 20px}.header{margin-bottom:20px;width:100%}.footer{clear:both;padding:20px;width:100%;color:#999}.footer a{color:#999}.footer a,.footer p,.footer td,.footer unsubscribe{font-size:9pt}h1,h2,h3{margin:40px 0 0;color:#000;font-weight:400;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;line-height:1.2}h1{font-weight:500;font-size:2pc}h2{font-size:24px}h3{font-size:18px}h4{font-weight:600;font-size:14px}ol,p,ul{margin-bottom:10px;font-weight:400}ol li,p li,ul li{margin-left:5px;list-style-position:inside}a{color:#1ab394;text-decoration:underline}.btn-primary{display:inline-block;border:solid #1ab394;border-width:5px 10px;border-radius:5px;background-color:#1ab394;color:#fff;text-align:center;text-decoration:none;text-transform:capitalize;font-weight:700;line-height:2;cursor:pointer}.last{margin-bottom:0}.first{margin-top:0}.aligncenter{text-align:center}.alignright{text-align:right}.alignleft{text-align:left}.clear{clear:both}.alert{padding:20px;border-radius:3px 3px 0 0;text-align:center}.alert,.alert a{color:#fff;font-weight:500;font-size:1pc}.alert a{text-decoration:none}.alert.alert-warning{background:#f8ac59}.alert.alert-bad{background:#ed5565}.alert.alert-good{background:#1ab394}.invoice{margin:40px auto;width:80%;text-align:left}.invoice td{padding:5px 0}.invoice .invoice-items{width:100%}.invoice .invoice-items td{border-top:#eee 1px solid}.invoice .invoice-items .total td{border-top:2px solid #333;border-bottom:2px solid #333;font-weight:700}@media only screen and (max-width:640px){h1,h2,h3,h4{margin:20px 0 5px!important;font-weight:600!important}h1{font-size:22px!important}h2{font-size:18px!important}h3{font-size:1pc!important}.container{width:100%!important}.content,.content-wrap{padding:10px!important}.invoice{width:100%!important}}
    </style>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <table class="body-wrap">
        <tr>
            <td></td>
            <td class="container" width="600">
                <?= $content ?>
                <div class="footer">
                    <table width="100%">
                        <tr>
                            <td class="aligncenter content-block"><a href="<?= Yii::$app->params['webUrl']; ?>"><?= Yii::$app->name ?></a> from these alerts.</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td></td>
        </tr>
    </table>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>