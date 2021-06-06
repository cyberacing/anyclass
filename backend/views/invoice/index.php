<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

use common\models\Invoice;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var yii\web\View $this */
/* @var backend\models\InvoiceSearch $searchModel */
/* @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Invoices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'product_id',
                'value' => function (Invoice $row) {
                    return $row->product->title;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'user_id',
                'value' => function (Invoice $row) {
                    return $row->user->username;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'amount',
                'value' => function (Invoice $row) {
                    return Yii::$app->formatter->asDecimal($row->amount, 2);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'currency',
                'value' => function (Invoice $row) {
                    return Yii::$app->converter->getData($row->currency)['Name'];
                },
                'format' => 'raw',
            ],
            'created_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>


</div>
