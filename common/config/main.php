<?php
declare(strict_types=1);

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'name' => 'AnyClass - административная панель',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'converter' => [
            'class' => 'common\components\Converter',
            'currencies' => ['USD', 'EUR', 'CNY', 'INR'],
        ]
    ],
];
