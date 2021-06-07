<?php
declare(strict_types=1);

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "payment_system".
 *
 * @property int $id
 * @property string $title Название
 * @property bool|null $active Активность
 * @property string|null $currencies Список валют
 * @property int $created_at Создано
 * @property int $updated_at Обновлено
 */
class PaymentSystem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_system';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return [
            [['title'], 'required'],
            [['active'], 'boolean'],
            [['currencies', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() : array
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'active' => 'Активность',
            'currencies' => 'Список валют',
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
     * @inheritdoc
     * @return bool
     */
    public function load($data, $formName = null) : bool
    {
        if (parent::load($data, $formName)) {
            if (!empty($this->currencies)) {
                $this->currencies = Json::encode($this->currencies);
            }

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     * @return PaymentSystemQuery the active query used by this AR class.
     */
    public static function find() : PaymentSystemQuery
    {
        return new PaymentSystemQuery(get_called_class());
    }
}
