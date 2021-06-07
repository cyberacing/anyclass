<?php
declare(strict_types=1);

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title Название
 * @property float|null $price Цена
 * @property string $currency Валюта
 * @property int $created_at Создано
 * @property int $updated_at Обновлено
 *
 * @property Invoice[] $invoices
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'currency'], 'required'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'price' => 'Цена',
            'currency' => 'Валюта',
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
     * Gets query for [[Invoices]].
     *
     * @return \yii\db\ActiveQuery|InvoiceQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['product_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find() : ProductQuery
    {
        return new ProductQuery(get_called_class());
    }
}
