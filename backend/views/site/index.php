<?php
/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

/* @var yii\web\View $this */

use yii\widgets\Menu;

$this->title = 'My Yii Application';

$items = [
    [
        'label' => 'Продукты',
        'url' => ['/product/'],
        'matches' => ['/product/*'],
    ],
    [
        'label' => 'Платежные системы',
        'url' => ['/payment-system/'],
        'matches' => ['/payment-system/*'],
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
