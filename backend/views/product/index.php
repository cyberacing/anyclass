<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

use common\models\Product;
use yii\helpers\Html;
use yii\grid\GridView;

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
            ],
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
