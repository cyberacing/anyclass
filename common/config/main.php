<?php
declare(strict_types=1);

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'name' => 'AnyClass - административная панель',
    'timeZone' => 'Europe/Moscow',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'datetimeFormat' => 'php:d-m-Y H:i:s',
            'dateFormat' => 'php:d-m-Y',
        ],
        'converter' => [
            'class' => 'common\components\Converter',
            'defaultCurrency' => 'RUB',
            'codes' => ['USD', 'EUR', 'CNY', 'INR'],
        ],
    ],
];
