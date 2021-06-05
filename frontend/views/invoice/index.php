<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

use common\models\Invoice;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var yii\web\View $this */
/* @var common\models\Invoice[] $invoices */

$this->title = 'Invoices';
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'models' => $invoices,
            'pagination' => false,
        ]),
        'summary' => false,
        'showOnEmpty' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'product_id',
                'value' => function (Invoice $row) {
                    return $row->product->title;
                },
                'format' => 'raw',
            ],
            'amount',
            'currency',
            'created_at',
        ],
    ]); ?>


</div>
