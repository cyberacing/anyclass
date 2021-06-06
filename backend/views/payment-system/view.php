<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

use common\models\PaymentSystem;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\DetailView;

/* @var yii\web\View $this */
/* @var common\models\PaymentSystem $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Payment Systems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="payment-system-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'active:boolean',
            [
                'attribute' => 'currencies',
                'value' => function (PaymentSystem $model) {
                    return implode(',', Json::decode($model->currencies));
                },
                'format' => 'raw',
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
