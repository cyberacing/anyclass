<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

use common\models\PaymentSystem;
use yii\helpers\Html;
use yii\grid\GridView;

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
                    return implode(',', $row->currencies);
                },
                'format' => 'raw',
            ],
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
