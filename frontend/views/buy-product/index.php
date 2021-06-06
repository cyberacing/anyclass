<?php /** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var yii\web\View $this */
/* @var frontend\models\BuyProductForm $buyProductForm */

$this->title = 'Купить товар';
?>
<div class="buy-product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form',
            'id' => 'buy-form',
        ],
    ]) ?>

    <?= $form->field($buyProductForm, 'productId')->dropDownList($buyProductForm->productsListData()) ?>

    <?= $form->field($buyProductForm, 'paymentSystemId')->dropDownList($buyProductForm->paymentSystemListData()) ?>

    <div class="form__submit">
        <?= Html::submitButton('Купить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php $form::end() ?>

</div>
