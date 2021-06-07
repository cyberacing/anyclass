<?php
declare(strict_types=1);

namespace common\models;

use Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property int $product_id Продукт
 * @property int $user_id Пользователь
 * @property float|null $amount Сумма чека
 * @property string $currency Валюта чека
 * @property int $created_at Создано
 * @property int $updated_at Обновлено
 *
 * @property Product $product
 * @property User $user
 */
class Invoice extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'user_id', 'currency'], 'required'],
            [['product_id', 'user_id'], 'default', 'value' => null],
            [['product_id', 'user_id'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['currency'], 'string', 'max' => 3],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() : array
    {
        return [
            'id' => 'ID',
            'product_id' => 'Продукт',
            'user_id' => 'Пользователь',
            'amount' => 'Сумма чека',
            'currency' => 'Валюта чека',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return array
     */
    public function behaviors() : array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() : \yii\db\ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser() : \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return InvoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceQuery(get_called_class());
    }

    /**
     * @param User $user
     * @param bool $saveImmediate
     *
     * @throws Exception
     */
    public function handleUser(User $user, bool $saveImmediate = false) : void
    {
        $this->user_id = $user->id;
        $this->saveImmediate($saveImmediate);
    }

    /**
     * @param Product $product
     * @param bool $saveImmediate
     *
     * @throws Exception
     */
    public function handleProduct(Product $product, bool $saveImmediate = false) : void
    {
        $this->product_id = $product->id;
        $this->saveImmediate($saveImmediate);
    }

    /**
     * @param float $amount
     * @param string $currency
     * @param bool $saveImmediate
     *
     * @throws Exception
     */
    public function handleAmountCurrency(float $amount, string $currency, bool $saveImmediate = false) : void
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->saveImmediate($saveImmediate);
    }

    /**
     * @param bool $saveImmediate
     *
     * @throws Exception
     */
    protected function saveImmediate(bool $saveImmediate = false) : void
    {
        if ($saveImmediate === true) {
            if (!$this->save()) {
                throw new Exception($this, "Не удалось сохранить Invoice [user_id: {$this->user_id}]");
            }
        }
    }
}
