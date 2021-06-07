<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

use common\models\Product;
use backend\widgets\DatePicker;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var yii\web\View $this */
/* @var backend\models\ProductSearch $searchModel */
/* @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
                'attribute' => 'price',
                'value' => function (Product $row) {
                    return Yii::$app->formatter->asDecimal($row->price, 2);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'currency',
                'value' => function (Product $row) {
                    return Yii::$app->converter->getData($row->currency)['Name'];
                },
                'format' => 'raw',
                'filter' => Yii::$app->converter->currencies(),
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
