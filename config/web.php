<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id'         => 'basic',
    'name'       => 'Система учета расходов',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'language'   => 'ru-RU',
    'components' => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '5AFcAivGmihQkSScGB1jvPrX8DzD43xY',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => require(__DIR__ . '/db.php'),
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
            ],
        ],
        'category'     => [
            'class' => 'app\components\CategoryService',
            'model' => [
                'class' => 'app\models\Category',
            ],
        ],
        'formatter'    => [
            'class'             => 'yii\i18n\Formatter',
            'thousandSeparator' => '',
        ],
        'money'        => [
            'class' => 'app\components\Money',
        ],
        'expenseLimit' => [
            'class'        => 'app\components\expense_limit\ExpenseLimit',
            'model'        => [
                'class'         => 'app\models\Expense',
                'sumValueField' => 'value',
                'dateField'     => 'date',
            ],
            'settingModel' => [
                'class'               => 'app\models\Setting',
                'settingSumName'      => 'SUM_LIMIT',
                'settingScenarioName' => 'SCENARIO',
                'settingNameField'    => 'name',
                'valueField'          => 'value',
            ],
        ],
    ],
    'params'     => $params,
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
