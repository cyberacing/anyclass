<?php
/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

/* @var yii\web\View $this */

use yii\widgets\Menu;

$this->title = 'AnyClass - тестовое задание';
$items = [
    [
        'label' => 'Купить товар',
        'url' => ['/buy-product/'],
        'matches' => ['/buy-product/*'],
    ],
    [
        'label' => 'Список чеков',
        'url' => ['/invoice/'],
        'matches' => ['/invoice/*'],
    ],
];

echo Menu::widget([
    'items' => $items,
    'encodeLabels' => false,
]);
