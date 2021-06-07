<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

use backend\widgets\DatePicker;
use common\models\PaymentSystem;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Json;

/* @var yii\web\View $this */
/* @var backend\models\PaymentSystemSearch $searchModel */
/* @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Payment Systems';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-system-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Payment System', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'active:boolean',
            [
                'attribute' => 'currencies',
                'value' => function (PaymentSystem $row) {
                    return implode(',', Json::decode($row->currencies));
                },
                'format' => 'raw',
                'filter' => false,
            ],
            [
                'class' => DataColumn::class,
                'label' => 'Дата создания',
                'attribute' => 'created_at',
                'filterType' => DatePicker::class,
                'format' => 'datetime',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
