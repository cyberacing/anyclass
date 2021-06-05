<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

use common\models\Invoice;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var yii\web\View $this */
/* @var common\models\Invoice $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="invoice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'product_id',
                'value' => function (Invoice $model) {
                    return $model->product->title;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'user_id',
                'value' => function (Invoice $model) {
                    return $model->user->username;
                },
                'format' => 'raw',
            ],
            'amount',
            'currency',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
