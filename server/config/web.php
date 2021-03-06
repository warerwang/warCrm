<?php

if(is_file(__DIR__ . '/params_override.php')){
    $params = require(__DIR__ . '/params_override.php');
}else{
    $params = require(__DIR__ . '/params.php');
}
$config = [
    'id' => 'crm',
    'name' => 'War团队协助',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'x_uNTKNSDnyGSwsOfBuI3k_tJ6qFBm8G',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class'  => 'app\components\MailService',
            'apiKey' => 'key-ddd6f25977df282f3280186c5dd2c044',
            'from'   => $params['adminEmail']
//            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
//            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => YII_DEBUG ? ['error', 'warning', 'info'] : ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                [
                    'class' => \yii\rest\UrlRule::className(),
                    'controller'    => ['user' => 'user'],
                    'extraPatterns' => [
                        //todo 应该可以找到一个更好的方法。
                        'OPTIONS invite-user' => 'options',
                        'OPTIONS update-password' => 'options',
                        'OPTIONS update-avatar'   => 'options',
                        'POST update-password'    => 'update-password',
                        'POST update-avatar'      => 'update-avatar',
                        'POST invite-user'        => 'invite-user',
                        'GET current'             => 'current',
                    ],
//                    'tokens' => [
//                        '{id}'      => '<id:\d+>',
//                    ]
                ],
                [
                    'class' => \yii\rest\UrlRule::className(),
                    'controller' => [
                        'category' => 'category',
                        'article'  => 'article',
                        'chat'     => 'chat',
                        'group'    => 'group',
                        'project'  => 'project',
                        'comment'  => 'comment',
                        'sprint'   => 'sprint',
                        'task'     => 'task'
                    ]
                ],
                [
                    'class' => \yii\rest\UrlRule::className(),
                    'controller'    => ['config' => 'config'],
                    'patterns' => [
                        'GET {subDomain}'  => 'index',
                    ],
                    'tokens' => [
                        '{subDomain}'   => '<subDomain:[0-9a-zA-Z\-]+>'
                    ]
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'globalData' => [
            'class'  => 'app\components\GlobalData',
        ],
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
