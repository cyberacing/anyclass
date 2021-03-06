<?php
declare(strict_types=1);

namespace frontend\models;

use common\models\Invoice;
use common\models\PaymentSystem;
use common\models\Product;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

/**
 * Class BuyProductForm
 *
 * @package app\models\reg\forms\common
 */
class BuyProductForm extends Model
{
    /** @var int|null $prodcutId */
    public ?int $productId = null;
    /** @var int|null $paymentSystemId */
    public ?int $paymentSystemId = null;

    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['productId', 'paymentSystemId'], 'required', 'message' => 'Заполните поле'],
            [['productId'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['productId' => 'id']],
            [['paymentSystemId'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentSystem::class, 'targetAttribute' => ['paymentSystemId' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels() : array
    {
        return [
            'productId' => Yii::t('app', 'Продукт'),
            'paymentSystemId' => Yii::t('app', 'Платежная система'),
        ];
    }

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \Exception
     */
    public function save()
    {
        $user = Yii::$app->user->identity;
        $product = Product::findOne(['id' => $this->productId]);
        $paymentSystem = PaymentSystem::findOne(['id' => $this->paymentSystemId]);

        /** @var Invoice $invoice */
        $invoice = Yii::createObject([
            'class' => Invoice::class,
        ]);
        $invoice->handleUser($user);
        $invoice->handleProduct($product);
        $amountCurrency = Yii::$app->converter->convert($product, $paymentSystem);
        $invoice->handleAmountCurrency($amountCurrency['amount'], $amountCurrency['currency'], true);

        return true;
    }

    /**
     * @return array
     * @throws ForbiddenHttpException
     */
    public function productsListData() : array
    {
        $productEmpty = ['' => ''];

        $products = Product::find()->asArray()->all();
        if (!$products) {
            Yii::error('Нет доступных товаров');
            throw new ForbiddenHttpException('Нет доступных товаров');
        }
        $productsById = ArrayHelper::map($products, 'id', 'title');

        return ArrayHelper::merge($productEmpty, $productsById);
    }

    /**
     * @return array
     * @throws ForbiddenHttpException
     */
    public function paymentSystemListData() : array
    {
        $paymentSystemEmpty = ['' => ''];

        $paymentSystems = PaymentSystem::find()->active(true)->asArray()->all();
        if (!$paymentSystems) {
            Yii::error('Нет доступных платежных систем');
            throw new ForbiddenHttpException('Нет доступных платежных систем');
        }
        $paymentSystemsById = ArrayHelper::map($paymentSystems, 'id', 'title');

        return ArrayHelper::merge($paymentSystemEmpty, $paymentSystemsById);
    }
}
